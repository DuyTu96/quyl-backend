<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Customers;
use Validator;
use DB;

class CustomersController extends Controller
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

        $db = DB::connection('mongodb');

        $columns = ['id', 'email', 'name', 'profile_pic', 'settings', 'created_at', 'contact_number'];
        if($search){
            $output['data'] = Customers::where('account_type','customers')->where(function ($query) use($search) {
                return $query->orWhere('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
            })->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get($columns);

            $output['recordsFiltered'] = $output['recordsTotal'] = Customers::where('account_type','customers')->where(function ($query) use($search) {
                return $query->orWhere('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
            })->count();
        }else{
            $output['data'] = Customers::where('account_type','customers')->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get($columns);
            $output['recordsFiltered'] = $output['recordsTotal'] = Customers::where('account_type','customers')->count();
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'contact_number' => 'required|min:10|max:10|unique:users,contact_number'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $postdata = $request->all();

        $customer = [
            'name' => $postdata['name'],
            'email' => $postdata['email'],
            'password' => Hash::make($postdata['password']),
            'contact_number' => $postdata['contact_number'],
            'biography' => '',
            'profile_pic' => '',
            'website_url' => isset($postdata['website_url']) ? $postdata['website_url']: '',
            'account_type' => 'customers',
        ];

        $customer = Customers::create($customer);

        return $this->success($customer,'Customer account created successfully!');
    }

    public function saveSettings(Request $request)
    {
        $customer_id = $request->get('customer_id');

        $customer = Customers::find($customer_id);

        if(!$customer)
        {
            return $this->error('Invalid request',404);
        }

        $settings = [
            'notifications' => [
                'push_notification' => (int)$request->get('push_notification'),
                'email' => (int)$request->get('email'),
                'text_message' => (int)$request->get('text_message'),
                'low_balance' => (int)$request->get('low_balance'),
                'new_charger_added' => (int)$request->get('new_charger_added'),
                'fully_charged' => (int)$request->get('fully_charged'),
                'charging_intrupted' => (int)$request->get('charging_intrupted'),
            ],
            'request_card' =>  [
                'ship_to_address' => $request->get('ship_to_address'),
                'address_1' => $request->get('address_1'),
                'address_2' => $request->get('address_2'),
                'city' => $request->get('city'),
                'postalcode' => $request->get('postalcode'),
                'state' => $request->get('state'),
                'country' => $request->get('country'),
            ],
            'filter_settings' => [
                'charging_level' => $request->get('charging_level'),
                'access_level' => $request->get('access_level')
            ]
        ];

        $customer->update(['settings' => $settings]);

        return $this->success($settings,'Settings saved successfully!');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $id = $request->get('id');
        $vehicle = Customers::find($id);

        if (!$vehicle) {
            return $this->error('Record not found', 404);
        }

        $vehicle->delete();

        return $this->success([],'Record deleted successfully');
    }
}
