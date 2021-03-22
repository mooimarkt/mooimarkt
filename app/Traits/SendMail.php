<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;

trait SendMail
{
    public static function sendEmail($subject, $to, $from, $view, $data, $file_url = null)
    {
        Mail::send($view, $data, function ($message) use ($subject, $to, $from, $file_url) {
            $message->from($from)
                ->to($to)
                ->subject($subject);

            if ($file_url !== null) {
                if (is_array($file_url)) {
                    foreach ($file_url as $url) {
                        $message->attach($url);
                    }
                } else {
                    $message->attach($file_url);
                }
            }
        });
    }
}