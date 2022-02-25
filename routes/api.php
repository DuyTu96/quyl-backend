<?php

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers,Authorization,withcredentials');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [App\Http\Controllers\AuthController::class, 'register']);


Route::post('/auth/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::post('/auth/reset-email', [App\Http\Controllers\AuthController::class, 'sendResetEmail']);




Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::prefix('staff')->group(function(){
        Route::post('/list',[App\Http\Controllers\StaffController::class, 'index']);
        Route::post('/save',[App\Http\Controllers\StaffController::class, 'create']);
        Route::post('/update',[App\Http\Controllers\StaffController::class, 'update']);
        Route::post('/delete',[App\Http\Controllers\StaffController::class, 'delete']);
    });

    Route::prefix('customers')->group(function(){
        Route::post('/list',[App\Http\Controllers\CustomersController::class, 'index']);
        Route::post('/create',[App\Http\Controllers\CustomersController::class, 'create']);
        Route::post('/settings',[App\Http\Controllers\CustomersController::class, 'delete']);
        Route::post('/delete',[App\Http\Controllers\CustomersController::class, 'delete']);
    });

    Route::prefix('chargers')->group(function(){
        Route::post('/list',[App\Http\Controllers\ChargersController::class, 'index']);
        Route::post('/history-list',[App\Http\Controllers\ChargersController::class, 'history']);
        Route::post('/add',[App\Http\Controllers\ChargersController::class, 'create']);
        Route::post('/delete',[App\Http\Controllers\ChargersController::class, 'delete']);
        Route::post('/update',[App\Http\Controllers\ChargersController::class, 'update']);
        Route::post('/filters-list',[App\Http\Controllers\ChargersController::class, 'filtersList']);
        Route::post('/delete-filter',[App\Http\Controllers\ChargersController::class, 'deleteFilter']);
        Route::post('/filters',[App\Http\Controllers\ChargersController::class, 'addFilter']);
        Route::get('/filters',[App\Http\Controllers\ChargersController::class, 'getFilter']);
        Route::post('/delete-history',[App\Http\Controllers\ChargersController::class, 'deleteHistory']);
    });

    Route::prefix('payments')->group(function(){
        Route::post('/list',[App\Http\Controllers\PaymentsController::class, 'index']);
        Route::post('/delete',[App\Http\Controllers\PaymentsController::class, 'delete']);
    });

    Route::prefix('vehicles')->group(function(){
        Route::post('/list',[App\Http\Controllers\VehicleController::class, 'index']);
        Route::post('/registered-list',[App\Http\Controllers\VehicleController::class, 'registeredVehicles']);
        Route::post('/add',[App\Http\Controllers\VehicleController::class, 'create']);
        Route::post('/delete',[App\Http\Controllers\VehicleController::class, 'delete']);
        Route::post('/update',[App\Http\Controllers\VehicleController::class, 'update']);
        Route::post('/delete-registered',[App\Http\Controllers\VehicleController::class, 'deleteRegistered']);
    });

    Route::prefix('energy')->group(function(){
        Route::post('/list',[App\Http\Controllers\EnergyController::class, 'index']);
        Route::post('/settings-list',[App\Http\Controllers\EnergyController::class, 'settings']);
        Route::post('/add',[App\Http\Controllers\EnergyController::class, 'create']);
        Route::post('/delete',[App\Http\Controllers\EnergyController::class, 'delete']);
        Route::post('/update',[App\Http\Controllers\EnergyController::class, 'update']);
        Route::post('/delete-settings',[App\Http\Controllers\EnergyController::class, 'deleteSettings']);
    });

    

    Route::get('/me', function(Request $request) {
        $data = auth()->user();
        if(empty($data['profile_pic'])){
            $data['profile_pic'] = url('img/customers/default.png');
        }else{
            $data['profile_pic'] = url('img/customers/'.$data['profile_pic']);
        }
        return response()->json(['status' => 'success','message' => 'profile details','data' => $data],200);
    });

    Route::post("/me",[App\Http\Controllers\AuthController::class, 'update']);
    
    Route::post("/upload-avatar",[App\Http\Controllers\AuthController::class, 'uploadProfilePic']);

    Route::post('/auth/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    Route::post('/export-pdf',[App\Http\Controllers\ExportController::class,'exportPDF']);
    Route::post('/export-excel',[App\Http\Controllers\ExportController::class,'exportExcel']);
    
    Route::post("/update-password",[App\Http\Controllers\AuthController::class, 'updatePassword']);
    
});

Route::get('/img/{folder}/{image}',function($folder,$image){
    return image_link($folder,$image);
});
Route::post("/reset-password",[App\Http\Controllers\AuthController::class, 'resetPassword']);
Route::get('/download-pdf/{filename}',[App\Http\Controllers\ExportController::class,'downloadPDF']);
Route::get('/download-excel/{filename}',[App\Http\Controllers\ExportController::class,'downloadExcel']);

Route::get('/country-list',[App\Http\Controllers\AppController::class, 'country']);
Route::get('/charger-filters',[App\Http\Controllers\AppController::class, 'chargerFilters']);
Route::get('/dumy_data',[App\Http\Controllers\AppController::class, 'dumy_data']);
Route::get('/update_password',[App\Http\Controllers\AppController::class, 'update_password']);

Route::get('/testmail',function(){
    Mail::raw('Hello World!', function($msg) {$msg->to('manoj.thakur.programmer@gmail.com')->subject('Test Email'); });
});
