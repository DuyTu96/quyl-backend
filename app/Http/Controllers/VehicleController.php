<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VehicleRegistered;
use Validator;
use DB;

class VehicleController extends Controller
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

        $columns = ['model','type','year','created_at'];
        if($search){
            $output['data'] = Vehicle::where(function ($query) use($search) {
                return $query->orWhere('model', 'like', '%'.$search.'%')->orWhere('type', '=', $search);
            })->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get($columns);

            $output['recordsFiltered'] = $output['recordsTotal'] = Vehicle::where(function ($query) use($search) {
                return $query->orWhere('customer_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
            })->count();
        }else{
            $output['data'] = Vehicle::skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get($columns);
            $output['recordsFiltered'] = $output['recordsTotal'] = Vehicle::count();
        }
        
        return $this->success($output,'success');
    }

    public function registeredVehicles(Request $request)
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

        $columns = ['model','type','year','created_at'];
        if($search){
            $output['data'] = VehicleRegistered::where(function ($query) use($search) {
                return $query->orWhere('model', 'like', '%'.$search.'%')
                ->orWhere('type', '=', $search)
                ->orWhere('customer_name', 'like', '%'.$search.'%');
            })->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get();

            $output['recordsFiltered'] = $output['recordsTotal'] = VehicleRegistered::where(function ($query) use($search) {
                return $query->orWhere('model', 'like', '%'.$search.'%')
                ->orWhere('type', '=', $search)
                ->orWhere('customer_name', 'like', '%'.$search.'%');
            })->count();
        }else{
            $output['data'] = VehicleRegistered::skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get();
            $output['recordsFiltered'] = $output['recordsTotal'] = VehicleRegistered::count();
        }
        
        return $this->success($output,'success');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'model' => 'required|unique:vehicles,model',
            'type' => 'required',
            'year' => 'required',
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $data  = [
            "model" =>  $request->get('model'),
            "type"  =>  $request->get('type'),
            "year"  =>  $request->get('year')
        ];

        $vehicle = Vehicle::create($data);

        return $this->success($vehicle,'Vehicle added successfully');
    }

    public function update(Request $request)
    {
        $id = $request->get('_id');
        $validator = Validator::make($request->all(),[
            'model' => 'required|unique:vehicles,model,'.$id.',_id',
            'type' => 'required',
            'year' => 'required',
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $data  = [
            "model" =>  $request->get('model'),
            "type"  =>  $request->get('type'),
            "year"  =>  $request->get('year')
        ];

        $vehicle = Vehicle::where('_id',$id)->update($data);

        return $this->success($vehicle,'Vehicle updated successfully');
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
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return $this->error('Vehicle record does not exists', 404);
        }

        $vehicle->delete();

        return $this->success([],'Vehicle record deleted successfully');
    }

    public function deleteRegistered(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $id = $request->get('id');
        $vehicle = VehicleRegistered::find($id);

        if (!$vehicle) {
            return $this->error('Record not found', 404);
        }

        $vehicle->delete();

        return $this->success([],'Record deleted successfully');
    }
}
