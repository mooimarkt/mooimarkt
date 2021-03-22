<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherRedeem extends Model
{
    use SoftDeletes;

    protected $table = 'voucher_redeem';
    protected $primaryKey = 'id';

    public function Voucher()
    {
    	return $this->belongsTo('App\Voucher', 'voucherId');
    }

}
