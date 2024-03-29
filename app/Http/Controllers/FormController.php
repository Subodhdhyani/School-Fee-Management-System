<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payment;
use Faker\Provider\ar_EG\Payment as Ar_EGPayment;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Validator;
class FormController extends Controller
{
    function order(REQUEST $request){
       /* In Ajax its not validate
       $request->validate([
            'student_name'=>'required|string|max:150',
            'email'=>'required|email|max:150',
            'mobile'=>'required|string|max:10',
            'grade'=>'required|integer|between:1,12',  //take 1,2,3 etc not take 1.2,1.6 etc
            'fees'=>'required|numeric|min:2000',  //take both whole and decimal number
            'month'=>'required|integer',
            'address'=>'required|string|max:255'
         ]);*/
         $validator = Validator::make($request->all(), [
        'student_name' => 'required|string|regex:/^[a-zA-Z]+$/',
        'email' => 'required|email',
        'mobile' => 'required|numeric|digits:10',
        'grade' => 'required|integer|between:1,12',
        'fees' => 'required|numeric|between:2000,9000',
        'month' => 'required',
        'address' => 'required|string',
          
      ]);
      if ($validator->fails()) {
        // Return the validation errors as JSON response
        return response()->json(['status' => 'error','errors' => $validator->errors(),]);
    }
    
  //Initially store the form record then the rest record store when it completed
         $a = new Payment;
         $receipt = 'Fees_' . mt_rand(10000, 99999);  //in place of receipt pass id or any dat like mobile etc not important
         $a->receipt_no= $receipt;
         $a->student_name = $request->student_name;
         $a->email = $request->email;
         $a->mobile = $request->mobile;
         $a->class = $request->grade;
         $a->fees = $request->fees;
         $a->total_fees_paid = $request->fees*$request->month;
         $a->month = $request->month;
         $a->address = $request->address;
         $a->save();
                  
         $amount = $request->fees*100; //because razorpay take as paise i.e amount*100
         $total_fees_month = $amount*$request->month;
         $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
         //Create Order id
         $razororder=$api->order->create(array('receipt' => $receipt, 'amount' =>$total_fees_month, 'currency' => 'INR',));
         //dd($razororder); //by this we see all the  order create
         $order_id= $razororder->id; //received order id
         $currency = $razororder->currency;
         //dd($order_id);
         //store order_id in db after creating
         $upd = Payment::find($a->id);   //find by primary key of form storing value autocreated
         $upd->order_id= $order_id;
         $upd->currency= $currency;
         $upd->update();
//pass required field to frontend for checkout page
         return response()->json(["status" => "success","order_id" => $order_id, "amount"=>$amount, "student_name"=>$request->student_name,"email"=>$request->email,"mobile"=>$request->mobile]);

  }

    function paymentstore(REQUEST $request){
        //dd($request->all());
      $orderid = $request->razorpay_order_id;
      $paymentid = $request->razorpay_payment_id;
      $a = Payment::where('order_id',$orderid)->first();
      if($a){
        $a->payment_status="Successful";
        $a->payment_id = $paymentid;
        $a->update();

        return redirect('/')->with('success','Payment Sucessfully Completed');
      }else{
        return redirect('/')->with('error','Payment Failed');
      }


    }


}


