<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Customers;
use App\Models\Charger;
use App\Models\Vehicle;
use App\Models\EnergyProviders;
use App\Models\ChargerFilters;
use Validator;
use PDF;
use Excel;

class ExportController extends Controller
{
    public function exportPDF(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'export_type' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        switch($request->get('export_type'))
        {
            case 'chargers':
                    // prepare pdf html and store 
                    $download_link = $this->exportChargers($request,'pdf');
                    return $this->success(['download_link' => $download_link],'success');
                break;
            case 'vehicles':
                    // prepare pdf html and store 
                    $download_link = $this->exportVehicles($request,'pdf');
                    return $this->success(['download_link' => $download_link],'success');
                break;
            case 'energy':
                    // prepare pdf html and store 
                    $download_link = $this->exportEnergy($request,'pdf');
                    return $this->success(['download_link' => $download_link],'success');
                break;
            case 'filters':
                    // prepare pdf html and store 
                    $download_link = $this->exportFilters($request,'pdf');
                    return $this->success(['download_link' => $download_link],'success');
                break;
            default:
                    return $this->error([],'Invalid request');
                break;
                
        }
    }

    public function exportExcel(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'export_type' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        switch($request->get('export_type'))
        {
            case 'chargers':
                    // prepare pdf html and store 
                    $download_link = $this->exportChargers($request,'excel');
                    return $this->success(['download_link' => $download_link],'success');
                break;
            case 'vehicles':
                    // prepare pdf html and store 
                    $download_link = $this->exportVehicles($request,'excel');
                    return $this->success(['download_link' => $download_link],'success');
                break;
            case 'energy':
                    // prepare pdf html and store 
                    $download_link = $this->exportEnergy($request,'excel');
                    return $this->success(['download_link' => $download_link],'success');
                break;
            case 'filters':
                    // prepare pdf html and store 
                    $download_link = $this->exportFilters($request,'excel');
                    return $this->success(['download_link' => $download_link],'success');
                break;
            default:
                    return $this->error([],'Invalid request');
                break;
                
        }
    }

    protected function exportChargers($request,$type)
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
        $filename = 'chargers_'.time().'.pdf';
        if($search){
            $data['items'] = Charger::where(function ($query) use($search) {
                return $query->orWhere('operator', 'like', '%'.$search.'%')
                ->orWhere('charger_id', 'like', '%'.$search.'%')
                ->orWhere('location', 'like', '%'.$search.'%');
            })->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
        }else{
            $data['items'] = Charger::limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
        }

        if($type == 'pdf'){
            $pdf = PDF::loadView('chargers.pdf', $data);

            $filename = 'chargers_'.time().'.pdf';
            $pdf->save(storage_path('app/public/pdf/'.$filename));
    
            $url = url('api/download-pdf/'.$filename);
        }else{
            $filename = 'chargers_'.time().'.xlsx';
            Excel::store(new \App\Exports\Chargers($data['items']), $filename, 'excel_upload');
            $customer_array = $data['items'];
            

            $url = url('api/download-excel/'.$filename);
        }

        
        return $url;
    }

    protected function exportVehicles($request,$type)
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

        $columns = ['model','type','year','created_at'];
        if($search){
            $data['items'] = Vehicle::where(function ($query) use($search) {
                return $query->orWhere('model', 'like', '%'.$search.'%')->orWhere('type', '=', $search);
            })->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get($columns);
        }else{
            $data['items'] = Vehicle::skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get($columns);
        }

        if($type == 'pdf'){
            $pdf = PDF::loadView('vehicles.pdf', $data);

            $filename = 'vehicles_'.time().'.pdf';
            $pdf->save(storage_path('app/public/pdf/'.$filename));
    
            $url = url('api/download-pdf/'.$filename);
        }else{
            $filename = 'vehicles_'.time().'.xlsx';
            Excel::store(new \App\Exports\Vehicles($data['items']), $filename, 'excel_upload');
            $customer_array = $data['items'];
            

            $url = url('api/download-excel/'.$filename);
        }
        return $url;
    }

    protected function exportEnergy($request,$type)
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
            $data['items'] = EnergyProviders::where(function ($query) use($search) {
                return $query->orWhere('country', 'like', '%'.$search.'%')->orWhere('company', 'like', '%'.$search.'%');
            })->skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get();
        }else{
            $data['items'] = EnergyProviders::skip($start)->take($length)->orderBy($orderColumn,$orderDir)->get();
        }

        if($type == 'pdf'){
            $pdf = PDF::loadView('energy.pdf', $data);

            $filename = 'energy_'.time().'.pdf';
            $pdf->save(storage_path('app/public/pdf/'.$filename));
    
            $url = url('api/download-pdf/'.$filename);
        }else{
            $filename = 'energy_'.time().'.xlsx';
            Excel::store(new \App\Exports\Energy($data['items']), $filename, 'excel_upload');
            $customer_array = $data['items'];
            

            $url = url('api/download-excel/'.$filename);
        }

        
        return $url;
    }

    protected function exportFilters($request,$type)
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
        
        $filter_type = $request->get('filter_type');

        if($search){
            $data['items'] = ChargerFilters::where(['filter_type' => $filter_type])->where(function ($query) use($search) {
                return $query->orWhere('filter_name', 'like', '%'.$search.'%');
            })->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
        }else{
            $data['items'] = ChargerFilters::where(['filter_type' => $filter_type])->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
        }

        if($type == 'pdf'){
            $pdf = PDF::loadView('filters.pdf', $data);

            $filename = 'filters_'.time().'.pdf';
            $pdf->save(storage_path('app/public/pdf/'.$filename));
    
            $url = url('api/download-pdf/'.$filename);
        }else{
            $filename = 'filters_'.time().'.xlsx';
            Excel::store(new \App\Exports\Filters($data['items']), $filename, 'excel_upload');
            $customer_array = $data['items'];
            $url = url('api/download-excel/'.$filename);
        }
        return $url;
    }

    public function downloadPDF($filename)
    {
        // check if file exists
        if(!file_exists(storage_path('app/public/pdf/'.$filename)))
        {
            return $this->error('File not found', 404);
        }

        return response()->download(storage_path('app/public/pdf/'.$filename));
    }

    public function downloadExcel($filename)
    {
        // check if file exists
        if(!file_exists(storage_path('app/public/excel/'.$filename)))
        {
            return $this->error('File not found', 404);
        }

        return response()->download(storage_path('app/public/excel/'.$filename));
    }
}
