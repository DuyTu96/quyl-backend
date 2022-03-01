<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Validator;
use DB;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class PaymentsController extends Controller
{
    private $authorizenet_login_id = '';
    private $authorizenet_trans_key = ''; 

    public function __construct()
    {
        $this->authorizenet_login_id = env('MERCHANT_LOGIN_ID');
        $this->authorizenet_trans_key = env('MERCHANT_TRANSACTION_KEY');
    }

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

    public function amount(Request $request) {
        try {
            $validator = Validator::make($request->all(),[
                'cardNumber' => 'required',
                'CVV' => 'required',
                'expirationDate' => 'required',
                'amount' => 'required',
            ]);
    
            if (!$validator->passes()) {
                return $this->error(implode(" ",$validator->errors()->all()), 422);
            }

            $cardNumber = $request->cardNumber;
            $CVV = $request->CVV;
            $expirationDate = $request->expirationDate;
            $amount = $request->amount;

        
            /* Create a merchantAuthenticationType object with authentication details
            retrieved from the constants file */
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName($this->authorizenet_login_id);
            $merchantAuthentication->setTransactionKey($this->authorizenet_trans_key);

            // Set the transaction's refId
            $refId = 'ref' . time();
            $cardNumber = preg_replace('/\s+/', '', $cardNumber);
            
            // Create the payment data for a credit card
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($cardNumber);
            $creditCard->setExpirationDate($expirationDate);
            $creditCard->setCardCode($CVV);

            // Add the payment data to a paymentType object
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);

            // Create a TransactionRequestType object and add the previous objects to it
            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction");
            $transactionRequestType->setAmount($amount);
            $transactionRequestType->setPayment($paymentOne);

            // Assemble the complete transaction request
            $requests = new AnetAPI\CreateTransactionRequest();
            $requests->setMerchantAuthentication($merchantAuthentication);
            $requests->setRefId($refId);
            $requests->setTransactionRequest($transactionRequestType);

            // Create the controller and get the response
            $controller = new AnetController\CreateTransactionController($requests);
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

            if ($response != null) {
                // Check to see if the API request was successfully received and acted upon
                if ($response->getMessages()->getResultCode() == "Ok") {
                    // Since the API request was successful, look for a transaction response
                    // and parse it to display the results of authorizing the card
                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getMessages() != null) {
    //                    echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
    //                    echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
    //                    echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
    //                    echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
    //                    echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";
                        $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                        $msg_type = "success_msg";   

                        return $this->success([], $message_text);
                    } else {
                        $message_text = 'There were some issue with the payment. Please try again later.';
                        $msg_type = "error_msg";                                    

                        if ($tresponse->getErrors() != null) {
                            $message_text = $tresponse->getErrors()[0]->getErrorText();
                            $msg_type = "error_msg";                                    
                        }
                    }
                    // Or, print errors if the API request wasn't successful
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";                                    

                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";                    
                    } else {
                        $message_text = $response->getMessages()->getMessage()[0]->getText();
                        $msg_type = "error_msg";
                    }                
                }
            } else {
                $message_text = "No response returned";
                $msg_type = "error_msg";
            }

            return $this->error($message_text, 404);
        } catch (Exeption $e) {
            return $this->error($e->getMessage(), 404);
        }
    }
}
