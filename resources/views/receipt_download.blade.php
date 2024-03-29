<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Echoes School Fees Receipt</title>
    <link rel="icon" type="image/png" href="{{url('logo/logo-color.png')}}">
    <link rel="stylesheet" type="text/css" href="{{url('Bootstrap/css/bootstrap.min.css')}}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3 mt-4" style="display: flex; justify-content: center; align-items: center;">
            <img src="{{url('logo/logo-color.png')}}" alt="Our Logo" class="img-fluid" style="max-height: 150px;">
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h1 class="text-success">Ethereal Echoes School Fees Receipt</h1>
            <p>Printed at {{ date('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <table class="table table-striped table-bordered mx-auto  table-hover">
                <tr>
                   <td>Receipt Number</td>
                   <td>{{$receipt}}</td>
               </tr>
               <tr>
                   <td>Student Name</td>
                   <td>{{$studentname}}</td>
               </tr>
               <tr>
                   <td>Email</td>
                   <td>{{$email}}</td>
               </tr>
               <tr>
                   <td>Contact No</td>
                   <td>{{$mobile}}</td>
               </tr>
               <tr>
                   <td>Class</td>
                   <td>{{$classes}}</td>
               </tr>
               <tr>
                   <td>Fees Per Month</td>
                   <td>Rs {{$fees}}</td>
               </tr>
               <tr>
                   <td>Total Month Fees</td>
                   <td>{{$month}} Months</td>
               </tr>
               <tr>
                   <td>Total Fees Paid</td>
                   <td>Rs {{$totalfees}}</td>
               </tr>
               <tr>
                   <td>Payment Status</td>
                   <td>{{$paymentstatus}}</td>
               </tr>
               <tr>
                   <td>Address</td>
                   <td>{{$address}}</td>
               </tr>
               <tr>
                   <td>Payment successful Time</td>
                   <td>{{$paytime}}</td>
               </tr>
                <tr>
               <td><button id="print" class="btn btn-success" >Download Receipt</button></td>
                 <td><a href="/" id="back" class="btn btn-success">Back</a></td>
               </tr>
            </table>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
               <strong><p class="font-weight-bold">&copy; {{ date('Y') }} Ethereal Echoes School. All rights reserved.</p></strong>
            </div>
        </div>
    </div>
</footer>


<script>
        document.getElementById("print").addEventListener("click", function() {
           // Hide the button after printing is triggered
            this.style.display = 'none';
            // Hide the back button
            document.getElementById('back').style.display = 'none';
            // Simulate Ctrl+P (Print) keyboard shortcut
            window.print();
           // Show the print button
            document.getElementById('print').style.display = 'block';
            // Show the back button
            document.getElementById('back').style.display = 'inline-block';
            });
    </script>
</body>
</head>