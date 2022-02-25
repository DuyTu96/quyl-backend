<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Customers;
use App\Models\Charger;
use App\Models\ChargerHistory;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Models\VehicleRegistered;
use App\Models\EnergyProviders;
use App\Models\EnergySettings;
use App\Models\ChargerFilters;

class AppController extends Controller
{
    public function country()
    {
        $list = Country::get();

        return $this->success($list,'success');
    }

    public function chargerFilters()
    {
        $return = [
            'levels' => [],
            'access' => []
        ];

        $return['levels'] = ChargerFilters::where(['filter_type'=> 'level'])->get(['id','filter_name']);
        $return['access'] = ChargerFilters::where(['filter_type'=> 'access'])->get(['id','filter_name']);
        $return['usage'] = ChargerFilters::where(['filter_type'=> 'usage'])->get(['id','filter_name']);
        $return['connector'] = ChargerFilters::where(['filter_type'=> 'connector'])->get(['id','filter_name']);
        $return['status'] = ChargerFilters::where(['filter_type'=> 'status'])->get(['id','filter_name']);

        return $this->success($return,'Success');
    }

    public function dumy_data(){
        Charger::where('_id','!=','')->update(['status' => 'xxxx','charging_level'=>'','access_level'=>'','latitude'=>'','longitude'=>'']);
    }

    public function dumy_datal()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Faker\Provider\Fakecar($faker));

        for ($i = 0; $i < 100; $i++) {
            /*
            Customers::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => Hash::make('12345678'),
                'contact_number' => $faker->phoneNumber,
                'biography' => $faker->text(),
                'profile_pic' => '',
                'website_url' => $faker->url(),
                'account_type' => 'customers',
            ]);
            */

            Charger::create([
                "charger_id" => $faker->lexify('charger-????'),
                "location" => $faker->address(),
                "usage_type" => $faker->address(),
                "connector_type" => $faker->jobTitle(),
                "operator" => $faker->company(),
                "contact_number" => $faker->phoneNumber(),
                "cost" => $faker->numberBetween(0, 500),
                "service_time" => $faker->date(),
                'status' => 'xxxx'
            ]);

            
            ChargerHistory::create([
                "customer_name" => $faker->name,
                "email" => $faker->unique()->email,
                "charger_id" => $faker->lexify('charger-????'),
                "cost" => $faker->numberBetween(0, 500)
            ]);
            

            Payment::create([
                "customer_name" => $faker->name,
                "email" => $faker->unique()->email,
                "charger_id" => $faker->lexify('charger-????'),
                "payment_method" => $faker->creditCardType(),
                "total_amount" => $faker->numberBetween(0, 500)
            ]);

            
            Vehicle::create([
                "model" => $faker->vehicleModel,
                "type" => $faker->vehicleType,
                "year" => $faker->numberBetween(1900, date('Y'))
            ]);

            VehicleRegistered::create([
                "customer_name" => $faker->name,
                "email" => $faker->unique()->email,
                "model" => $faker->vehicleModel,
                "type" => $faker->vehicleType,
                "year" => $faker->numberBetween(1900, date('Y'))
            ]);
            EnergyProviders::create([
                "country" => $faker->country(),
                "company" => $faker->company()
            ]);
            
            
            EnergySettings::create([
                "customer_name" => $faker->name,
                "email" => $faker->unique()->email,
                "country" => $faker->country(),
                "company" => $faker->company(),
                "standard_cost" => $faker->numberBetween(0, 500),
                "price_per_kwh" => $faker->numberBetween(1, 50),
                "off_peak_cost" => $faker->numberBetween(1, 50),
                "start_time" => $faker->time(),
                "end_time" => $faker->time(),
                "price" => $faker->numberBetween(1, 500),
            ]);
            

            Customers::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => Hash::make('12345678'),
                'contact_number' => $faker->phoneNumber,
                'biography' => $faker->text(),
                'profile_pic' => '',
                'website_url' => $faker->url(),
                'account_type' => 'customers',
                'settings' => [
                    'notifications' => [
                        'push_notification' => 0,
                        'email' => 0,
                        'text_message' => 0,
                        'low_balance' => 0,
                        'new_charger_added' => 0,
                        'fully_charged' => 0,
                        'charging_intrupted' => 0,
                    ],
                    'request_card' =>  [
                        'ship_to_address' => '',
                        'address_1' => '',
                        'address_2' => '',
                        'city' => '',
                        'postalcode' => '',
                        'state' => '',
                        'country' => '',
                    ],
                    'filter_settings' => [
                        'charging_level' => [],
                        'access_level' => []
                    ]
                ]
            ]);

           // Charger::where('_id','!=','')->update(['status' => 'xxxx']);

        }
    }

    public function update_password()
    {
        Customers::where('account_type','admin')->update('password',Hash::make('12345678'));
    }
}
