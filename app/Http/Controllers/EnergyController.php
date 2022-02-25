<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnergyProviders;
use App\Models\EnergySettings;
use App\Models\Country;
use Validator;
use DB;

class EnergyController extends Controller
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

        $columns = ['country','company'];
        if($search){
            $output['data'] = EnergyProviders::where(function ($query) use($search) {
                return $query->orWhere('country', 'like', '%'.$search.'%')->orWhere('company', 'like', '%'.$search.'%');
            })->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get();

            $output['recordsFiltered'] = $output['recordsTotal'] = EnergyProviders::where(function ($query) use($search) {
                return $query->orWhere('country', 'like', '%'.$search.'%')->orWhere('company', 'like', '%'.$search.'%');
            })->count();
        }else{
            $output['data'] = EnergyProviders::skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get();
            $output['recordsFiltered'] = $output['recordsTotal'] = EnergyProviders::count();
        }
        
        return $this->success($output,'success');
    }

    public function settings(Request $request)
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

        $columns = ['customer_name','email','country','company','standard_cost','price_per_kwh','off_peak_cost','time_start','time_end','price'];
        if($search){
            $output['data'] = EnergySettings::where(function ($query) use($search) {
                return $query->orWhere('customer_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%');
            })->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get();

            $output['recordsFiltered'] = $output['recordsTotal'] = EnergySettings::where(function ($query) use($search) {
                return $query->orWhere('customer_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('country', 'like', '%'.$search.'%');
            })->count();
        }else{
            $output['data'] = EnergySettings::skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get();
            $output['recordsFiltered'] = $output['recordsTotal'] = EnergySettings::count();
        }
        
        return $this->success($output,'success');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'company' => 'required|unique:energy_providers',
            'country' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        // get country record
        $country = Country::where(['name'=>$request->get('country')])->first();
        if (!$country) {
            return $this->error('Invalid data provided', 422);
        }

        $data  = [
            "company"   =>  $request->get('company'),
            "country"   =>  $country->name,
            "country_code"  =>  $country->code,
            "country_id"  =>  $country->_id,
        ];

        $record = EnergyProviders::create($data);

        return $this->success($record,'Energy Provider added successfully');
    }

    public function update(Request $request)
    {
        $id = $request->get('_id');
        $validator = Validator::make($request->all(),[
            'company' => 'required|unique:energy_providers,company,'.$id.',_id',
            'country' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        // get country record
        $country = Country::where(['name'=>$request->get('country')])->first();

        if (!$country) {
            return $this->error('Invalid data provided', 422);
        }

        $data  = [
            "company"   =>  $request->get('company'),
            "country"   =>  $country->name,
            "country_code"  =>  $country->code,
            "country_id"  =>  $country->_id,
        ];

        $record = EnergyProviders::where('_id',$id)->update($data);

        return $this->success($record,'Energy Provider updated successfully');
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
        $record = EnergyProviders::find($id);

        if (!$record) {
            return $this->error('Energy Provider record does not exists', 404);
        }

        $record->delete();

        return $this->success([],'Energy Provider record deleted successfully');
    }

    public function deleteSettings(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $id = $request->get('id');
        $record = EnergySettings::find($id);

        if (!$record) {
            return $this->error('Record not found', 404);
        }

        $record->delete();

        return $this->success([],'Record deleted successfully');
    }
}
