<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waybill extends Model
{
    //
    protected $fillable = ['user_id', 'stock_no', 'comp_name', 'comp_add', 'comp_contact', 'drv_name', 'drv_contact', 'vno', 'bill_no', 'weight', 'nop', 'tot_qty', 'del_date', 'status'];

}
