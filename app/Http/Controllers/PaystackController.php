<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
class PaystackController extends Controller
{
    public function callback(Request $request)
    {
        //dd($request->all());
        $reference = $request->reference; //payment id
        $secret_key = env('PAYSTACK_SECRET_KEY');
        //dd($reference,$secret_key);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  //this hide ssl certificate in localhost remove in live
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer $secret_key",
            "Cache-Control: no-cache",
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        //dd($response,$err);
        curl_close($curl);
        $response = json_decode($response);
        //dd($response);
       //dd($meta_data_outside = $response->data->metadata->quantity); //because this is outside custom field
        $meta_data = $response->data->metadata->custom_fields;
       // dd($meta_data);
        if($response->data->status == 'success')
        {
            $obj = new Payment;
            $obj->payment_id = $reference;
            $obj->receipt_no = 'PayStack_' . mt_rand(1000, 9999);
            $obj->product_id = $response->data->metadata->product_id; 
            $obj->product_name = $response->data->metadata->product_name;
            $obj->quantity = $response->data->metadata->quantity;
            $obj->amount = $response->data->amount / 100;  //because in online we * by 100
            $obj->currency = $response->data->currency;
            $obj->user_name = $meta_data[0]->value;
            $obj->user_email = $response->data->customer->email;
            $obj->phone = $meta_data[1]->value;
            $obj->payment_status = "Completed";
            $obj->payment_method = "Paystack";
            $obj->save();
            return redirect('/')->with('success', 'Payment Successfully');
             //return redirect()->route('success');
        } else
        {
            return redirect('/')->with('error', 'Payment Failed');
            //return redirect()->route('cancel');
        }
    }
    function success()
    {
        return "Payment is successful";
    }
    function cancel()
    {
        return "Payment is cancelled";
    }


    function refund($id){
        $secret_key = env('PAYSTACK_SECRET_KEY');
        $url = "https://api.paystack.co/refund";
        $fields = [
          'transaction' => $id,   //id contain unique payment id
        ];
      
        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //this hide ssl certificate in localhost remove in live
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Authorization: Bearer $secret_key",
          "Cache-Control: no-cache",
        ));
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        //execute post
        $result = curl_exec($ch);
        //dd($result);
        //check response of server
        $response = json_decode($result, true);
        //dd($response);
        if(isset($response['status']) && $response['status'] === true) {
                //Change status inside db
                $change_status_db = Payment::where('payment_id',$id)->first();
                $change_status_db->payment_status = "Refunded";
                $change_status_db->save();
// Refund was successful
            return redirect()->route('display')->with('success','Successfully Refunded');
        } elseif(isset($response['status']) && $response['status'] === false) {
            // Check if refund failed due to already refunded/or other issue
            if(isset($response['message']) && $response['message'] !== "") {           
    
                return redirect()->route('display')->with('error', $response['message']);
                
            }
        } else {
            // Handle other scenarios or unexpected response
            return redirect()->route('display')->with('error','Soory Somrthing Unexpected.Please try again Later');
        }
    }



}
