<?php

namespace App;
date_default_timezone_set("Europe/London");

use Illuminate\Support\Facades\DB;
use Mpdf;
use Mail;

class Invoice
{

	public static function createInvoice($data, $email) {
        $file_name = uniqid($data['prefix'].'_');

        $data['invoice_id'] = DB::table('invoices')->insertGetId([
            'user_id' => $data['user_id'],
            'invoice' => $file_name.'.pdf',
            'date' => $data['date'],
            'listing_id' => $data['listing_id'],
        ]);

        $mpdf = new \Mpdf\Mpdf();

        $html = file_get_contents(url('invoice.html'));

        foreach ($data as $key => $value)
            $html = str_replace('['.$key.']', $value, $html);

        $mpdf->WriteHTML($html);

        $mpdf->Output('/home/b4mx/public_html/b4mx.com/storage/app/invoices/'.$file_name.'.pdf','F');

        Mail::send('emails.invoice', $data, function ($message) use ($email, $file_name)  {
          $message->from('invoice@b4mx.com', 'Invoice b4mx');
          $message->to($email)->subject('Invoice');
          $message->attach('/home/b4mx/public_html/b4mx.com/storage/app/invoices/'.$file_name.'.pdf', [
            'as' => 'invoice.pdf',
            'mime' => 'application/pdf',
          ]);
        });

        return $file_name.".pdf";

	}

}
