<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller {

	public function invoices() {
		$Invoices = DB::table( 'invoices' )
			               ->orderBy( 'id', 'desc' )
                            ->paginate( 10 );

		return view( 'newthemplate.Admin.invoices', [
			'Page' => 'invoices',
			'Invoices'  => $Invoices,
		] );
	}

}
