<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"><!--the second one is variable and the value comes inside this variable is from ajax-->
    <title>Ethereal Echoes School Fees Dashboard</title>
    <link rel="icon" type="image/png" href="{{url('logo/logo-color.png')}}">
    <link rel="stylesheet" type="text/css" href="{{url('Bootstrap/css/bootstrap.min.css')}}"> 
    {{--Bootstarp icon Library--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
<style>
     .center-container {
            display: flex;
            justify-content: center;
        }
</style> 
</head>
<body>
<div class="container text-center mt-4 mb-4">
    <a href="#" style="display: inline-block;"><img src="{{url('logo/logo-color.png')}}" alt="Logo" style="height: 100px; width:300px;"></a>
    <h1 class="text-danger " style="display: inline-block;">Ethereal Echoes School Fees Dashboard</h1>
</div>


<div class="container center-container">
<form class="row row-cols-lg-auto g-3 align-items-center" autocomplete="off">
 <div class="col-12">
    <div class="input-group">
      <div class="input-group-text"><label for="selectdate">Select Date</label></div>
      <input type="date" class="form-control" id="selectdate" name="selectdate" value="{{old('selectdate')}}">
    </div>
  </div>
<div class="col-12">
   <div class="input-group">
     <div class="input-group-text"><label for="selectclass">Select Class</label></div>
       <select class="form-select" id="selectclass" name="selectclass">
           <option selected value="">Select Class</option>
           <option value="1">1</option>
           <option value="2">2</option>
           <option value="3">3</option>
           <option value="4">4</option>
           <option value="5">5</option>
           <option value="6">6</option>
           <option value="7">7</option>
           <option value="8">8</option>
           <option value="9">9</option>
           <option value="10">10</option>
           <option value="11">11</option>
           <option value="12">12</option>
      </select>
  </div>
</div>
<div class="col-12">
    <input type="submit" class="btn btn-info" id="formsubmit" value="Get Fees Detail">
  </div>
</form>
</div>


<div class="container mt-4">
    <a href="{{route('signout')}}" class="btn btn-danger mb-2" style="float: right;">Logout</a>
<table class="table  table-striped table-bordered">
             <thead>
                 <tr>
                   <th scope="col" class="d-none d-sm-table-cell">Receipt No</th>
                   <th scope="col">Student Name</th>
                   <th scope="col">Class</th>
                   <th scope="col" class="d-none d-sm-table-cell">Mobile</th>
                   <th scope="col" class="d-none d-sm-table-cell">Fees Per Month</th>
                   <th scope="col" class="d-none d-sm-table-cell">Total Month Fees</th>
                   <th scope="col" class="d-none d-sm-table-cell">Total Fees Paid</th>
                   <th scope="col" >Fees Status</th>
                   <th scope="col">Operation</th>
                </tr>
             </thead> 
<tbody id="data-body">
</tbody>
 </table>
        </div>


{{--Bootstrap js and jquery--}}
<script src="{{url('Bootstrap/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script> 
 <script src="{{url('js/jquery-3.7.1.min.js')}}" type="text/javascript"></script> 
 <script>
    $(document).ready(function() {
// Function to fetch and display all data whe refresh the function load
function fetchData() {
        // Perform AJAX call to fetch data
        $.ajax({
            url: "{{route('allrecord')}}",
            type: 'GET',
            success: function(response) {
                // Clear the existing table body
                $('#data-body').empty();
                // Parse the received data and append it to tbody
                if (response.length === 0 ) {
                 $('#data-body').append('<tr><td colspan="9" class ="text-center text-danger" style="font-size: 50px;">No Updated Record found</td></tr>');
                }else{
                response.forEach(function(record) {
                        $('#data-body').append(
                            '<tr>' +
                            '<td class="d-none d-sm-table-cell">' + record.receipt_no + '</td>' +
                                '<td>' + record.student_name + '</td>' +
                                '<td>' + record.class + '</td>' +
                                '<td class="d-none d-sm-table-cell">' + record.mobile + '</td>' +
                                '<td class="d-none d-sm-table-cell">' + record.fees + '</td>' +
                                '<td class="d-none d-sm-table-cell">' + record.month + '</td>' +
                                '<td class="d-none d-sm-table-cell">' + record.total_fees_paid + '</td>' +
                                '<td>' + record.payment_status + '</td>' +
                                '<td>' +
                                '<a href="" class="refund-record text-info" data-id="' + record.id+ '" data-bs-toggle="tooltip" title="Refund"><i class="bi bi-skip-backward-circle-fill"></i></a>&ensp;' +
                                '<a href="" class="delete-record text-info" data-id="' + record.id+ '" data-bs-toggle="tooltip" title="Delete"><i class="bi bi-archive-fill"></i></a>&ensp;' +
                                '<a href="/admin/print/' + record.id + '" class="text-info" data-bs-toggle="tooltip" title="Print"><i class="bi bi-printer-fill"></i></a>' +
                                '</td>' +
                            '</tr>'
                        );
                    });
    //Delete for all displayed record
    $('.delete-record').click(function(e) {
    e.preventDefault();
    var recordId = $(this).data('id');
    var confirmDelete = confirm("Are you Confirming  to delete this record?");
    if(confirmDelete) {
       ajaxcommondelete(recordId, $(this));
    }
});


//Refund for all displayed Record
$('.refund-record').click(function(e) {
    e.preventDefault();
    var recordId = $(this).data('id');
    var confirmDelete = confirm("Are you Confirming to Refund this Payment?");
    if(confirmDelete) {
       ajaxcommonrefund(recordId, $(this));
    }
});


                }
            }
        });
    }
// Call the fetchData function 
  fetchData();



//form data send and display record
$('#formsubmit').click(function(event) {
    event.preventDefault();
        var selectdate = $('#selectdate').val();
        var selectclass = $('#selectclass').val();
       
$.ajax({
            url: "{{route('specificrecord')}}",
            type: 'POST',
            data:   {selectdate: selectdate,
                selectclass: selectclass,
                   
                    },
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            success: function(response) {
                // Clear the existing table body
                $('#data-body').empty();
                // Parse the received data and append it to tbody
                if (response.length === 0 ) {
                    $('#data-body').append('<tr><td colspan="9" class ="text-center text-danger" style="font-size: 50px;">No records found</td></tr>');
                } else {
                response.forEach(function(record) {
                   // var url="{{ url('admin/delete')}}"+'/'+record.id ;
                   // var url2="{{ route('delete')}}/" +record.id ;
                        $('#data-body').append(
                            '<tr>' +
                                '<td class="d-none d-sm-table-cell">' + record.receipt_no + '</td>' +
                                '<td>' + record.student_name + '</td>' +
                                '<td>' + record.class + '</td>' +
                                '<td class="d-none d-sm-table-cell">' + record.mobile + '</td>' +
                                '<td class="d-none d-sm-table-cell">' + record.fees + '</td>' +
                                '<td class="d-none d-sm-table-cell">' + record.month + '</td>' +
                                '<td class="d-none d-sm-table-cell">' + record.total_fees_paid + '</td>' +
                                '<td>' + record.payment_status + '</td>' +
                                 
/* ALl there way work Similar
'<td><a href="' + '{{ ("/admin/delete/") }}' +record.id + '" class="btn btn-success">Pass 1</a></td>' +
 '<td><a href="' + '{{ route("delete") }}/' + record.id + '" class="btn btn-success">Pass 2</a></td>'+
 '<td><a href="' + url+ '" class="btn btn-success">Pass 3</a></td>'+*/
                                '<td>' +
                                //'<a href="/admin/refund/' + record.id + '" class="text-info" data-bs-toggle="tooltip" title="Refund"><i class="bi bi-skip-backward-circle-fill"></i></a>&ensp;' +
                                '<a href="" class="refund-record text-info" data-id="' + record.id+ '" data-bs-toggle="tooltip" title="Refund"><i class="bi bi-skip-backward-circle-fill"></i></a>&ensp;' +
                               // '<a href="/admin/delete/' + record.id + '" class="text-info" data-bs-toggle="tooltip" title="Delete"><i class="bi bi-archive-fill"></i></a>&ensp;' +
                               '<a href="" class="delete-record text-info" data-id="' + record.id+ '" data-bs-toggle="tooltip" title="Delete"><i class="bi bi-archive-fill"></i></a>&ensp;' +

                                '<a href="/admin/print/' + record.id + '" class="text-info" data-bs-toggle="tooltip" title="Print"><i class="bi bi-printer-fill"></i></a>' +
                                '</td>' +
                                            '</tr>'
                                 );
                    });
//Delete Ajax CAll for searched record


$('.delete-record').click(function(e) {
    e.preventDefault();
    var recordId = $(this).data('id');
    var confirmDelete = confirm("Are you sure you want to delete this record?");
    if(confirmDelete) {
       ajaxcommondelete(recordId, $(this));
    }
});




                   /* Normal Function since the same used two time so create commno function and used by function up function call
                    $('.delete-record').click(function(e) {
                        e.preventDefault();
                        var recordId = $(this).data('id');
                        //var row = $(this).closest('tr'); // for relaod the success deleted record inside response >>row.hide()
                        var confirmDelete = confirm("Are you sure you want to delete this record?");
                        if(confirmDelete){
                        $.ajax({
                            url: '/admin/delete/' + recordId,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Handle success response
                                alert(response.message);
                               // location.reload();
                               $(this).closest('tr').hide(); // Hide the row containing the delete button
                               
                            }.bind(this) // Binding 'this' to the success callback function for closet hidr
                        });
                    }
                    });*/



//Refund for searched Record
$('.refund-record').click(function(e) {
    e.preventDefault();
    var recordId = $(this).data('id');
    var confirmDelete = confirm("Are you sure you want to Refund this Payment?");
    if(confirmDelete) {
       ajaxcommonrefund(recordId, $(this));
    }
});
 /*Refund Ajax Call for searched record tje up is common function pass value
                   $('.refund-record').click(function(e) {
                        e.preventDefault();
                        var recordId = $(this).data('id');
                        
                        var confirmDelete = confirm("Are you sure you want to Refund this Payment?");
                        if(confirmDelete){
                        $.ajax({
                            url: '/admin/refund/' + recordId,
                            type: 'Get',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Handle success response
                                alert(response.refund);
                              //here again apply ajax for status update shown on view and after get append the new satus with old one
                            }
                        });
                    }
                    });


*/


                 }
            }
        });

    
});

//Common Delete Record 
function ajaxcommondelete(recordId, button) {
    $.ajax({
        url: '/admin/delete/' + recordId,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Handle success response
            alert(response.message);
            button.closest('tr').hide(); // Hide the row containing the delete button
        }
    });
}

function ajaxcommonrefund(recordId, button){
    $.ajax({
        url: '/admin/refund/' + recordId,
        type: 'Get',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
     // Handle success response
     alert(response.refund);
     //here again apply ajax for status update shown on view and after get append the new satus with old one
        }
    });

}

});

 </script>
</body>
</html>