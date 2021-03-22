<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherTrader extends Model
{
    use SoftDeletes;

    protected $table = 'voucher_trader';
    protected $primaryKey = 'id';
    protected $guarded = [];

}
