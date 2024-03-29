<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $table ="payments";
    protected $primarykey ="id";
    protected $fillable=['order_id','payment_id','receipt_no','student_name','email','mobile','class','fees','total_fees_paid','currency','payment_status','month','address'];
}
