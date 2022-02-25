<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Validator;
use DB;

class PaymentsController extends Controller
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

        $columns = ['customer_name','email','total_amount','payment_method','created_at','charger_id'];
        if($search){
            $output['data'] = Payment::where(function ($query) use($search) {
                return $query->orWhere('customer_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
            })->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get($columns);

            $output['recordsFiltered'] = $output['recordsTotal'] = Payment::where(function ($query) use($search) {
                return $query->orWhere('customer_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
            })->count();
        }else{
            $output['data'] = Payment::skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get($columns);
            $output['recordsFiltered'] = $output['recordsTotal'] = Payment::count();
        }
        
        return $this->success($output,'success');
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
        $item = Payment::find($id);

        if (!$item) {
            return $this->error('Payment record does not exists', 404);
        }

        $item->delete();

        return $this->success([],'Payment record deleted successfully');
    }
}
