<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $start = (int)$request->get('start');
        $length = (int)$request->get('length');

        $length = $length ? $length : 10;
        $search = $request->get('search');
        if($search){
            $search = $search['value'];
        }

        $order = $request->get('order');
        if($order){
            $columns = $request->get('columns');
            $orderColumn = $columns[$order[0]['column']]['data'];
            $orderDir = $order[0]['dir'];
        }else{
            $orderColumn = '_id';
            $orderDir = 'desc';
        }

        $draw 		= 	intval($request->get("draw"));
        $output = [
            "draw" 				=> $draw,
            "recordsTotal" 		=> 0,
            "recordsFiltered" 	=> 0,
            "data" 				=> []
        ];

        if(Auth::user()->account_type == 'admin')
        {
            if($search){
                $output['data'] = User::whereIn('account_type',['staff','manager'])->where(function ($query) use($search) {
                    return $query->orWhere('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
                })->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
    
                $output['recordsFiltered'] = $output['recordsTotal'] = User::whereIn('account_type',['staff','manager'])->where(function ($query) use($search) {
                    return $query->orWhere('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
                })->count();
            }else{
                $output['data'] = User::whereIn('account_type',['staff','manager'])->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
                $output['recordsFiltered'] = $output['recordsTotal'] = User::whereIn('account_type',['staff','manager'])->count();
            }
        }else{
            if($search){
                $output['data'] = User::whereIn('account_type',['staff'])->where(function ($query) use($search) {
                    return $query->orWhere('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
                })->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
    
                $output['recordsFiltered'] = $output['recordsTotal'] = User::whereIn('account_type',['staff'])->where(function ($query) use($search) {
                    return $query->orWhere('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
                })->count();
            }else{
                $output['data'] = User::whereIn('account_type',['staff'])->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
                $output['recordsFiltered'] = $output['recordsTotal'] = User::whereIn('account_type',['staff'])->count();
            }
        }

        

        if(count($output['data']) > 0)
        {
            foreach($output['data'] as $key => &$item)
            {
                if(empty($item['profile_pic'])){
                    $item['profile_pic'] = url('img/customers/default.png');
                }else{
                    $item['profile_pic'] = url('img/customers/'.$item['profile_pic']);
                }
            }
        }
        
        return $this->success($output,'success');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $record = User::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => $request->get('password') ? Hash::make($request->get('password')):Hash::make('12345678'),
            'contact_number' => $request->get('contact_number'),
            'biography' => $request->get('biography'),
            'profile_pic' => '',
            'website_url' => $request->get('website_url'),
            'account_type' => $request->get('account_type')
        ]);

        return $this->success($record,'User account added successfully');
    }

    public function update(Request $request)
    {
        $id = $request->get('_id');
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,'.$id.',_id',
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $item = User::find($id);

        $data = [
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'contact_number' => $request->get('contact_number'),
            'account_type' => $request->get('account_type'),
            'biography' => $request->get('biography'),
            'profile_pic' => '',
            'website_url' => $request->get('website_url')
        ];

        if($request->get('password')){
            $data['password'] = Hash::make($request->get('password'));
        }

        $item->fill($data)->save();
        
        return $this->success($data,'User account updated successfully');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $item = User::find($request->get('id'));

        if(!$item)
        {
            return $this->error('Invalid request');
        }

        $item->delete();

        return $this->success([],'User account deleted successfully');
    }
}
