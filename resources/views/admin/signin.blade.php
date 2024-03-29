<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"><!--the second one is variable and the value comes inside this variable is from ajax-->
    <link rel="icon" type="image/png" href="{{url('logo/logo-color.png')}}">
    <link rel="stylesheet" type="text/css" href="{{url('Bootstrap/css/bootstrap.min.css')}}">  
    <title>Signin</title>
</head>
<body>
<section>
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
          Ethereal Echoes School <br>
            <span class="text-info"> Admin Dashboard</span>
          </h1>
          <p>
          Ethereal Echoes School is a leading educational institution committed to fostering academic excellence and holistic development. Our mission is to empower students with knowledge, skills, and values essential for success in an ever-evolving world.
          </p>
        </div>

        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
            <div class="card-body py-5 px-md-5">
              <form id="loginForm" autocomplete="off">

              {{--Display error if credentials not matched--}}
              <div class="form-outline mb-4 text-danger" id="errordisplay"></div>
                <div class="form-outline mb-4">
                  <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}" required/>
                  <label class="form-label" for="email">Email address</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="password" name="password" class="form-control" value="{{old('password')}}" required />
                  <label class="form-label" for="password">Password</label>
                </div>

                <button type="submit" class="btn btn-info btn-block mb-4">
                Sign in
                </button>

               </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

 {{--Bootstrap js and jquery--}}
 <script src="{{url('Bootstrap/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script> 
 <script src="{{url('js/jquery-3.7.1.min.js')}}" type="text/javascript"></script> 
 <script>
$(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{route('signinreq')}}",
                type: "POST",
                data: $(this).serialize(),
                headers: {                  //for csf token also add meta tag at head tag
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success: function(response) {
                    if(response.success){
                      window.location.href = "{{ route('dashboard') }}"; 
                     }else if(response.error){
                      //alert(response.error);
                      var error = response.error;
                      $('#errordisplay').html(error);
                     }
                 }
            });
        });
    });
 </script>
</body>
</html>