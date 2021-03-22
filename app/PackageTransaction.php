<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'package_transaction';
    protected $primaryKey = 'id';

    public function VoucherRedeem()
    {
    	return $this->hasOne("App\VoucherRedeem","transactionId","referenceId"); 
    }

}
