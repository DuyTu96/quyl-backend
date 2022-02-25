<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiResponder;
use Validator;
use App\Models\User;
use Auth;
use Image;
use Log;

class AuthController extends Controller
{
    /**
     * @OA\Info(
     *   title="My first API",
     *   version="1.0.0",
     *   @OA\Contact(
     *     email="support@example.com"
     *   )
     * )
     */

    use ApiResponder;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'contact_number' => 'required|min:10|max:10'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $body = $request->all();
        $user = User::create([
            'first_name' => $body['first_name'],
            'last_name' => $request->get('last_name'),
            'contact_number' => $request->get('contact_number'),
            'password' => Hash::make($body['password']),
            'email' => $body['email'],
            'profile_pic' => '',
            'account_type' => 'customers'
        ]);

        return $this->success([
            'token' => $user->createToken(env('API_SECRETE'))->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => Auth::user()->createToken(env('API_SECRETE'))->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'contact_number' => 'required|min:10|max:10',
            'contact_number' => 'required|string|unique:users,contact_number,'.Auth::user()->id.',_id',
            'email' => 'required|string|unique:users,email,'.Auth::user()->id.',_id',
            'website_url' => 'nullable|url'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $data = [
            "first_name" => $request->get('first_name'),
            "last_name" => $request->get('last_name'),
            "contact_number" => $request->get('contact_number'),
            "biography" => $request->get('biography'),
            "website_url" => $request->get('website_url')
        ];

        Auth::user()->fill($data)->save();

        return $this->success($data,'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }
        
        Auth::user()->fill(['password' => Hash::make($request->get('password'))])->save();

        return $this->success([],'Password updated successfully');
    }


    public function uploadProfilePic(Request $request)
    {
        if(!$request->hasFile('profile_pic'))
        {
            return $this->error('Profile picture is required',422);
        }
        $file = $request->file('profile_pic');

        $name = $file->getClientOriginalName();
        $filename = pathinfo($name, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = time().'.'.$extension;

        $path = $file->storeAs('public/customers',$filename);

        $file_directory = storage_path('app/'.$path);

        Image::make($file_directory)->resize(100, 100);

        
        Auth::user()->fill(['profile_pic' => $filename])->save();

        return $this->success(['profile_pic' => url('img/customer/'.$filename)],'Profile image uploaded successfully');
    }

    public function sendResetEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if($status === Password::RESET_LINK_SENT)
        {
            return $this->success([],'An email has been sent yo reset your password');
        }else{
            return $this->error(__($status),200);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $status = Password::reset(
            $request->only('email','password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        if($status === Password::PASSWORD_RESET)
        {
            return $this->success([],'Password updated successfully!');
        }else{
            return $this->error(__($status),200);
        }
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
    
}