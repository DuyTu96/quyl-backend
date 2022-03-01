<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceToken;
use Exception;
use Validator;
use Auth;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'token' => 'required|string',
        ]);

        if (!$validator->passes()) return $this->error(implode(" ",$validator->errors()->all()), 422);

        try {
    
            $token = $request->token;
    
            $dt = DeviceToken::where("token", $token)->first();
    
            if ($dt) {
                $dt->update([
                    'user_id' => Auth::user()->id,
                ]);
            } else {
                DeviceToken::create([
                    'user_id' => Auth::user()->id,
                    'token' => $token,
                ]);
            }
    
            return $this->success([],'Add device token successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'token' => 'required|string',
        ]);

        if (!$validator->passes()) return $this->error(implode(" ",$validator->errors()->all()), 422);

        try {
            $token = $request->token;

            $dt = DeviceToken::where("token", $token)->first();

            if ($dt) $dt->delete();

            return $this->success([],'Delete device token successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 404);
        }
    }
}
