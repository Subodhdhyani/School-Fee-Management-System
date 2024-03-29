<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payment;
use Illuminate\Support\Facades\Validator;

class displayController extends Controller
{   
    function receipt(REQUEST $request){
          $validator = Validator::make($request->all(), [
            'fetch_name' => 'required|string|regex:/^[a-zA-Z]+$/',
            'fetch_email' => 'required|email',
            'fetch_mobile' => 'required|numeric|digits:10',
            ]);
            if ($validator->fails()) {
                return response()->json(['error'=>'validateerror','message' => $validator->errors(),]);
            }


    $name= $request->fetch_name;
    $email= $request->fetch_email;
    $mobile= $request->fetch_mobile;

                //fetch record from db
                $record = payment::where('student_name', $name)
                ->where('email', $email)
                ->where('mobile', $mobile)
                ->first();
               
                if ($record) {
                    return response()->json($record);
                   } else {
                   return response()->json(['error'=>'recorderror','message'=>'Sorry, the record was not found. Please try again later']);
                  }
}

    function receipt_download(REQUEST $request){
    // Retrieve data from the request
    $receipt = $request->query('receipt');
    $studentname = $request->query('studentname');
    $email = $request->query('email');
    $mobile = $request->query('mobile');
    $fees = $request->query('fees');
    $month = $request->query('month');
    $totalfees = $request->query('totalfees');
    $address = $request->query('address');
    $classes = $request->query('classes');
    $paymentstatus = $request->query('paymentstatus');
    $paytime = $request->query('paytime');
// Pass the data to the view
  return view('receipt_download', compact('receipt', 'studentname', 'email', 'mobile', 'classes','fees', 'month', 'totalfees', 'paymentstatus','address','paytime'));
    
}


}
