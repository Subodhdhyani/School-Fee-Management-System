<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"><!--the second one is variable and the value comes inside this variable is from ajax-->
    <title>Ethereal Echoes School Fees Payment</title>
    <link rel="icon" type="image/png" href="{{url('logo/logo-color.png')}}">
    <link rel="stylesheet" type="text/css" href="{{url('Bootstrap/css/bootstrap.min.css')}}">  
  
</head>
<body>
<div class="container text-center mt-4">
    <a href="{{url('/')}}" style="display: inline-block;"><img src="{{url('logo/logo-color.png')}}" alt="Logo" style="height: 100px; width:300px;"></a>
    <h1 class="text-danger " style="display: inline-block;">Ethereal Echoes School Fees Payment</h1>
</div>
{{--Model Button--}}
<div class="container" style="text-align: right;">
 <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Get Receipt
</button>
</div>
    <div class="container bg-info">
    <form class="row g-3" autocomplete="off">
    <input type="hidden" value="16112323" name="just_for_test_not_pass"> {{--For pass primary id  through previous page to forwad --}}
<div class="col-md-6">
    <label for="student_name" class="form-label">Student Name</label>
    <input type="text" name="student_name" id = "student_name" class="form-control" value="{{old('student_name')}}" required> @error('student_name')<span class="text-danger">{{$message}}</span>@enderror
    <span class="error" id="student_name_error" style="color: black;"></span>
</div>
<div class="col-md-6">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" value="{{old('email')}}" class="form-control" id="email" required> @error('email')<span class="text-danger">{{$message}}</span>@enderror
    <span class="error" id="email_error" style="color: black;"></span>
</div>
<div class="col-md-6">
    <label for="mobile" class="form-label">Mobile</label>
    <input type="number" name="mobile" class="form-control" id="mobile" value="{{old('mobile')}}" required> @error('mobile')<span class="text-danger">{{$message}}</span>@enderror
    <span class="error" id="mobile_error" style="color: black"></span>
</div>
<div class="col-md-6">
    <label for="grade" class="form-label">Class</label>
    <input type="number" name="grade" class="form-control" id="grade" value="{{old('grade')}}" min="1" max="12" required> @error('grade')<span class="text-danger">{{$message}}</span>@enderror
    <span class="error" id="grade_error" style="color: black"></span>
</div>
<div class="col-md-6">
    <label for="fees" class="form-label">Fees Per Month</label>
    <input type="number" name="fees" class="form-control" id="fees" value="{{old('fees')}}" min="2000" max="10000" required> @error('fees')<span class="text-danger">{{$message}}</span>@enderror
    <span class="error" id="fees_error" style="color: black;"></span>
</div>

<div class="col-md-6">
   <label for="month" class="form-label">Total Months</label>
     <select id="month" class="form-select" name="month">
      <option value="1">1 Month Fees</option>
      <option value="2">2 Month Fees</option>
      <option value="3">3 Month Fees</option>
      <option value="4">4 Month Fees</option>
      <option value="5">5 Month Fees</option>
      <option value="6">6 Month Fees</option>
    </select> @error('month')<span class="text-danger">{{$message}}</span>@enderror
</div>

<div class="col-md-12">
    <label for="address" class="form-label">Address</label>
    <input type="text" name="address" class="form-control" id="address" value="{{old('address')}}" required> @error('address')<span class="text-danger">{{$message}}</span>@enderror
    <span class="error" id="address_error" style="color: black;"></span>
</div>
<div class="col-md-12 mb-4">
    <input type="submit" name="submit" class="form-control btn btn-success" id="submit_button" value="Pay Fees">
</div>
    </form>
    </div>
{{--Razorpay Payment Page open after order id receive by ajax Order id receive after form post then from controller we get --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
{{--Bootstrap js and jquery--}}
 <script src="{{url('Bootstrap/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script> 
 <script src="{{url('js/jquery-3.7.1.min.js')}}" type="text/javascript"></script> 
<script>
    //Send form data to backend for creating an order id and then return/fetch this order id here back again
$(document).ready(function(){
    $('#submit_button').click(function(e) {      
        e.preventDefault(); 
        var student_name = $('#student_name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var grade = $('#grade').val();
        var fees = $('#fees').val();
        var month = $('#month').val();
        var address = $('#address').val();
                $.ajax({
                    url: "{{route('order')}}", // the backend url to store data
                    type: 'POST', // data send method
                    data: {student_name: student_name,
                           email: email,
                           mobile: mobile,
                           grade: grade,
                           fees: fees,
                           month: month,
                           address: address},
                    headers: {                  //for csf token also add meta tag at head tag
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        /* first convert the object into sting then alert
                        var responseString = "Order ID: " + response.order_id + ", Amount: " + response.amount;
                        alert(responseString);*/
                        //pass data receive from backend to function and call function
                        if (response.status === 'success') {
                         paynow(response.amount,response.order_id,response.student_name,response.email,response.mobile);
                        }
                        else if (response.status === 'error') {
                             $('.error').text(''); // Clear any previous error messages
                             var errors = response.errors;
                             $.each(errors, function(key, value) {
                             $('#'+key+'_error').text(value[0]); // Update error message next to the field  //0 optional if miltille error inside same field then 0,1 etc used else for single error inside same field not required
                               });
                        }
       
                    }
                });
            });
    
        });

//function for pass detail to checkout page
function paynow(amount,razororderid,name,email,contact){
    var options = {
    "key": "{{env('RAZORPAY_KEY_ID')}}", // Enter the Key ID generated from the Dashboard
    "amount": amount, //pass through backend order id created controller
    "currency": "INR",
    "name": "Ethereal Echoes School", //your business name
    "description": "School Fees Payment",
    "image": "https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/razorpay-icon.png",
    "order_id": razororderid, //pass through backend
    "callback_url": " {{route('paymentstore')}} ",
    "prefill": { 
        "name": name, //"double_curly_bracket Auth::user->name() double_curly_bracket"if login in php inside pass then not reuired to pass from backend
        "email": email,
        "contact": contact //If given here so pass from backend order id created 
    },
    "notes": {
        "address": "Ethereal Echoes School "
    },
    "theme": {
        "color": "#0dcaf0"
    }
};
var rzp1 = new Razorpay(options);
rzp1.open();

}
</script>
{{--Sweet Alert after payment success of failed at last when return from paymentstore function--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>        
@if(Session::has('success'))
        <script>
        swal("Status","{!!Session::get ('success')!!}","success");
       </script>
@endif
@if(Session::has('error'))
        <script>
        swal("Status","{!!Session::get ('error')!!}","success");
       </script>
@endif


{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content" style="background-color:whitesmoke">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel"><strong>Ethereal Echoes School Fees Receipt</strong></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
     
      <form autocomplete="off">
          <div class="mb-3">
            <label for="fetch_name" class="col-form-label">Student Name</label>
            <input type="text" class="form-control" id="fetch_name" name="fetch_name" value="{{old('fetch_name')}}" required>
            <span class="error_fetch" id="fetch_name_error" style="color: red;"></span>  
        </div>
          <div class="mb-3">
            <label for="fetch_email" class="col-form-label">Email</label>
            <input type="email" class="form-control" id="fetch_email" name="fetch_email" value="{{old('fetch_email')}}" required>
            <span class="error_fetch" id="fetch_email_error" style="color: red;"></span>  
        </div>
          <div class="mb-3">
            <label for="fetch_mobile" class="col-form-label">Mobile</label>
            <input type="number" class="form-control" id="fetch_mobile" name="fetch_mobile" value="{{old('fetch_mobile')}}" required>
            <span class="error_fetch" id="fetch_mobile_error" style="color: red;"></span>  
        </div>
          <p class="text-danger">*Make sure the Payment is Completed</p>
          <hr>
             <button type="button"id="fetchbutton" class="btn btn-warning d-block mx-auto">Get Receipt</button>
          </form>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
    $('#fetchbutton').click(function(e) {      
        e.preventDefault(); 
        var fetch_name = $('#fetch_name').val();
        var fetch_email = $('#fetch_email').val();
        var fetch_mobile = $('#fetch_mobile').val();
                $.ajax({
                    url: "{{route('receipt')}}", // the backend url to fetch data
                    type: 'POST', // data send method
                    data: {fetch_name: fetch_name,
                           fetch_email: fetch_email,
                           fetch_mobile: fetch_mobile
                           },
                    headers: {        //for csf token also add meta tag at head tag
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.error){
                            if(response.error === 'validateerror'){
                             $('.error_fetch').text(''); // Clear any previous error messages
                             var error = response.message;
                             $.each(error, function(key, value) {
                             $('#'+key+'_error').text(value[0]); // Update error message next to the field  //0 optional if miltille error inside same field then 0,1 etc used else for single error inside same field not required
                               });
                            }else if(response.error === 'recorderror'){
                                alert(response.message);
                            }
                        }else{
                        //after successfully it fetch from db and send this data to different view
                        //here location of that view where data displayed
                        var receipt = response.receipt_no;
                        var studentname = response.student_name;
                        var email = response.email;
                        var mobile = response.mobile;
                        var fees = response.fees;
                        var month = response.month;
                        var totalfees = response.total_fees_paid;
                        var address = response.address;
                        var classes = response.class;
                        var paymentstatus = response.payment_status;
                        var paytime = response.updated_at;

// Createt the URL with parameters passing
var url = "/receipt_download?receipt=" + encodeURIComponent(receipt) +
              "&studentname=" + encodeURIComponent(studentname) +
              "&email=" + encodeURIComponent(email) +
              "&mobile=" + encodeURIComponent(mobile) +
              "&fees=" + encodeURIComponent(fees) +
              "&month=" + encodeURIComponent(month) +
              "&totalfees=" + encodeURIComponent(totalfees) +
              "&address=" + encodeURIComponent(address) +
              "&classes=" + encodeURIComponent(classes) +
              "&paymentstatus=" + encodeURIComponent(paymentstatus) +
              "&paytime=" + encodeURIComponent(paytime);

    // Redirect to the receipt_download route
    window.location.href = url;

//So in here we pass data to route through url/get method but if we want to pass through post then we use again ajax inside success
                    }
                }
                });
            });
    
        });

</script>
</body>
</html>