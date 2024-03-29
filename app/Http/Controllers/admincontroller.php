<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\payment;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class admincontroller extends Controller
{

    function signin(){
        return view('admin.signin');
    }
    function signinreq(REQUEST $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return response()->json(['success' => 'Login successful']);
        } else {
            // Authentication failed
            return response()->json(['error' => 'Please check your Credentials.The Email and Password you entered do not match']);
        }
    }

    function dashboard(){
        return view('admin.dashboard');
    }
    function allrecord(){
        $all = Payment::orderBy('created_at', 'desc')->get();  // $all = payment::all();
        return response()->json($all);
    }
    
    function specificrecord(Request $request) {
     // Retrieve form data
        $date = $request->selectdate;
        $class = $request->selectclass;
     // Query construction or Query Builder we also  used Eloquent ORM method
        $query = Payment::query();
     // Check if date filter is provided
     // Check if both date and class filters are provided
         if ($date && $class) {
     //where fetch the complete record from timestamps including time but whereDate only fetch Date
            $query->whereDate('created_at', $date)->where('class', $class);
        } elseif ($date) {
            $query->whereDate('created_at', $date);
        } elseif ($class) {
            $query->where('class', $class);
        }
    //dd($query->toSql(), $query->getBindings());
    // Fetch filtered data
        $filteredData = $query->get();
    // Return the filtered data as JSON response
        return response()->json($filteredData);
    }

 function delete($id){
    $delete = payment::find($id);
    if ($delete) {
        $delete->delete();
        return response()->json(['message' => 'Item deleted successfully']);
    } else {
        return response()->json(['message' => 'Item not found']);
    }
}

 function print($id){
    $dis= payment::find($id);
    return view('admin.print',['data'=>$dis]);
  }

function refund($id){
    $record = payment::findOrFail($id); 
    $paymentId = $record->payment_id;
    $amount = $record->total_fees_paid;
    $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
 //$api->payment->fetch($paymentId)->refund(array("amount"=> "100", "speed"=>"normal", "notes"=>array("notes_key_1"=>"Beam me up Scotty.", "notes_key_2"=>"Engage"), "receipt"=>"Receipt No. 11"));
 //check first already refund or not on server by  fetch the payment detail the below line code by doc/github repo
    $payment = $api->payment->fetch($paymentId);
 //dd($payment);
    if ($payment->status == 'refunded') {
       return response()->json(['refund' => 'This payment has already been refunded.']);
    }
 //make refund the below code doc/github repo 
    $refund = $api->payment->fetch($paymentId)->refund([
    'amount' => $amount*100, 
    'speed' => 'normal', 
    'notes' => [
        'reason' => 'Refund for order cancellation'
     ]
    ]);

    if ($refund){  //if refunded successfully on razorpay server than also modified in db
      $change_status_db = Payment::where('payment_id',$paymentId)->first();
      $change_status_db->payment_status = "Refunded";
      $change_status_db->save();
        
          return response()->json(['refund' => 'Refund successful']);
      } else {
          return response()->json(['refund' => 'Refund failed']);
      }
}
function signout(){
    Auth::logout();
    return redirect()->route('login');
}


}
