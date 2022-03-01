<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charger;
use App\Models\ChargerHistory;
use App\Models\ChargerFilters;
use App\Models\DeviceToken;
use App\Models\User;
use Validator;
use DB;
use Exception;
use Log;

class ChargersController extends Controller
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

        if($search){
            $output['data'] = Charger::where(function ($query) use($search) {
                return $query->orWhere('operator', 'like', '%'.$search.'%')
                ->orWhere('location', 'like', '%'.$search.'%')
                ->orWhere('connector_type', 'like', '%'.$search.'%')
                ->orWhere('contact_number', 'like', '%'.$search.'%')
                ->orWhere('latitude', '=', $search)
                ->orWhere('longitude', '=', $search)
                ->orWhere('cost', '=', $search)
                ->orWhere('charger_id', '=', $search);
            })->skip($start)->orderBy($orderColumn,$orderDir)->get();

            $output['recordsFiltered'] = $output['recordsTotal'] = Charger::where(function ($query) use($search) {
                return $query->orWhere('operator', 'like', '%'.$search.'%')
                ->orWhere('location', 'like', '%'.$search.'%')
                ->orWhere('connector_type', 'like', '%'.$search.'%')
                ->orWhere('contact_number', 'like', '%'.$search.'%')
                ->orWhere('latitude', '=', $search)
                ->orWhere('longitude', '=', $search)
                ->orWhere('cost', '=', $search)
                ->orWhere('charger_id', '=', $search);
            })->count();
        }else{
            $output['data'] = Charger::skip($start)->orderBy($orderColumn,$orderDir)->get();
            $output['recordsFiltered'] = $output['recordsTotal'] = Charger::count();
        }
        
        return $this->success($output,'success');
    }

    public function history(Request $request)
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
            $output['data'] = ChargerHistory::where(function ($query) use($search) {
                return $query->orWhere('customer_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('cost', 'like', '%'.$search.'%')
                ->orWhere('charger_id', '=', $search);
            })->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();

            $output['recordsFiltered'] = $output['recordsTotal'] = ChargerHistory::where(function ($query) use($search) {
                return $query->orWhere('customer_name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('cost', 'like', '%'.$search.'%')
                ->orWhere('charger_id', '=', $search);
            })->count();
        }else{
            $output['data'] = ChargerHistory::limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
            $output['recordsFiltered'] = $output['recordsTotal'] = ChargerHistory::count();
        }
        
        return $this->success($output,'success');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'charger_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'usage_type' => 'required',
            'connector_type' => 'required',
            'operator' => 'required',
            'contact_number' => 'required',
            'cost' => 'required',
            'charging_level' => 'required',
            'access_level' => 'required',
            'status' => 'required',
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $data  = [
            'name' => $request->get('name'),
            'charger_id' => $request->get('charger_id'),
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
            'usage_type' => $request->get('usage_type'),
            'connector_type' => $request->get('connector_type'),
            'operator' => $request->get('operator'),
            'contact_number' => $request->get('contact_number'),
            'cost' => $request->get('cost'),
            'service_time' => $request->get('service_time'),
            'charging_level' => $request->get('charging_level'),
            'access_level' => $request->get('access_level'),
            'status' => $request->get('status'),
        ];

        $record = Charger::create($data);

        $address = $this->getAddressWithLatLong($request->get('latitude'), $request->get('longitude'));

        $title = '';
        $body = 'New charger added at ' . $address;

        $this->pushAllNotification($title, $body);

        return $this->success($record,'Charger record added successfully');
    }

    public function update(Request $request)
    {
        $id = $request->get('_id');
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'charger_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'usage_type' => 'required',
            'connector_type' => 'required',
            'operator' => 'required',
            'contact_number' => 'required',
            'cost' => 'required',
            'charging_level' => 'required',
            'access_level' => 'required',
            'status' => 'required',
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $data  = [
            'name' => $request->get('name'),
            'charger_id' => $request->get('charger_id'),
            'latitude' => $request->get('latitude'),
            'longitude' => $request->get('longitude'),
            'usage_type' => $request->get('usage_type'),
            'connector_type' => $request->get('connector_type'),
            'operator' => $request->get('operator'),
            'contact_number' => $request->get('contact_number'),
            'cost' => $request->get('cost'),
            'service_time' => $request->get('service_time'),
            'charging_level' => $request->get('charging_level'),
            'access_level' => $request->get('access_level'),
            'status' => $request->get('status'),
        ];

        $charger = Charger::where('_id',$id)->update($data);

        return $this->success($charger,'Charger updated successfully');
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
        $charger = Charger::find($id);

        if (!$charger) {
            return $this->error('Charger record does not exists', 404);
        }

        $charger->delete();

        return $this->success([],'Charger record deleted successfully');
    }

    public function deleteHistory(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $id = $request->get('id');
        $charger = ChargerHistory::find($id);

        if (!$charger) {
            return $this->error('Record does not exists', 404);
        }

        $charger->delete();

        return $this->success([],'Record deleted successfully');
    }

    public function deleteFilter(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        $id = $request->get('id');
        $charger = ChargerFilters::find($id);

        if (!$charger) {
            return $this->error('Filter record does not exists', 404);
        }

        $charger->delete();

        return $this->success([],'Filter record deleted successfully');
    }

    public function addFilter(Request $request)
    {
        $id = $request->get('_id');

        if($id)
        {
            $validator = Validator::make($request->all(),[
                'filter_name' => 'required|unique:charger_filters,filter_name,'.$id.'_id',
                'filter_type' => 'required',
            ]);
        }else{
            $validator = Validator::make($request->all(),[
                'filter_name' => 'required|unique:charger_filters',
                'filter_type' => 'required',
            ]);
        }
        

        if (!$validator->passes()) {
            return $this->error(implode(" ",$validator->errors()->all()), 422);
        }

        if($id){
            $charger = ChargerFilters::find($id)->update([
                'filter_name' => $request->get('filter_name'),
                'filter_type' => $request->get('filter_type'),
            ]);
        }else{
            $charger = ChargerFilters::create([
                'filter_name' => $request->get('filter_name'),
                'filter_type' => $request->get('filter_type'),
            ]);
        }

        return $this->success($charger,'Charger filter saved successfully!');
    }

    public function getFilter(Request $request)
    {
        $return = [
            'levels' => [],
            'access' => []
        ];

        $return['levels'] = ChargerFilters::where(['filter_type'=> 'level'])->get(['id','filter_name']);
        $return['access'] = ChargerFilters::where(['filter_type'=> 'access'])->get(['id','filter_name']);
        $return['usage'] = ChargerFilters::where(['filter_type'=> 'usage'])->get(['id','filter_name']);
        $return['connector'] = ChargerFilters::where(['filter_type'=> 'connector'])->get(['id','filter_name']);

        return $this->success($return,'Success');
    }

    public function filtersList(Request $request)
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

        $draw 		= 	intval($request->get("draw"));
        $output = [
            "draw" 				=> $draw,
            "recordsTotal" 		=> 0,
            "recordsFiltered" 	=> 0,
            "data" 				=> []
        ];

        $db = DB::connection('mongodb');

        if($search){
            $output['data'] = ChargerFilters::where(['filter_type' => $filter_type])->where(function ($query) use($search) {
                return $query->orWhere('filter_name', 'like', '%'.$search.'%');
            })->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();

            $output['recordsFiltered'] = $output['recordsTotal'] = ChargerFilters::where(['filter_type' => $filter_type])->where(function ($query) use($search) {
                return $query->orWhere('filter_name', 'like', '%'.$search.'%');
            })->count();
        }else{
            $output['data'] = ChargerFilters::where(['filter_type' => $filter_type])->limit($length)->skip($start)->orderBy($orderColumn,$orderDir)->get();
            $output['recordsFiltered'] = $output['recordsTotal'] = ChargerFilters::where(['filter_type' => $filter_type])->count();
        }
        
        return $this->success($output,'success');
    }

    public function pushAllNotification($title, $body)
    {
        try {
            $device_tokens = DeviceToken::with('user')->get()->toArray();
        
            foreach ($device_tokens as $device_token) {
                if (isset($device_token['user']['settings']['notifications']['push_notification'])) {
                    if ($device_token['user']['settings']['notifications']['push_notification'] == 1) {
                        $dataNotification = [
                            'to_token' => $device_token['token'],
                            'title' => $title,
                            'body' => $body
                        ];
            
                        $this->pushNotification($dataNotification);
                    }
                } else {
                    $dataNotification = [
                        'to_token' => $device_token['token'],
                        'title' => $title,
                        'body' => $body
                    ];
        
                    $this->pushNotification($dataNotification);
                }
            }

            return true;
        } catch (Exception $e) {
            Log::debug('pushAllNotification: ' . $e->getMessage());
        }
    }

    public function pushNotification($dataNotification)
    {
        try {
            $serverKey = config('app.firebase_server_key');

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "to": "' . $dataNotification['to_token'] . '",
                "notification": {
                    "Title": "' . $dataNotification['title'] . '",
                    "body": "' . $dataNotification['body'] . '",
                    "OrganizationId": "2",
                    "content_available": true,
                    "priority": "high",
                    "badge": 1,
                },
                "data": {
                    "priority": "high",
                    "sound": "app_sound.wav",
                    "content_available": true,
                    "bodyText": "' . $dataNotification['body'] . '",
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: key=' . $serverKey,
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;
        } catch (Exception $e) {
            Log::debug('pushNotification: ' . $e->getMessage());
        }
    }

    public function getAddressWithLatLong($lat, $long)
    {
        try {
            $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false&key=" . config('app.google_api_key');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $geocode);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($response);
            $dataarray = get_object_vars($output);
            if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
                if (isset($dataarray['results'][0]->formatted_address)) {

                    $address = $dataarray['results'][0]->formatted_address;

                } else {
                    $address = 'Not Found';

                }
            } else {
                $address = 'Not Found';
            }

            return $address;
        } catch (Exception $e) {
            Log::debug('getAddressWithLatLong: ' . $e->getMessage());
        }
    }
}
