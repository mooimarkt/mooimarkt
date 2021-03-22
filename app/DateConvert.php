<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DateConvert extends Model
{
    public static function Convert($date, $dialog = false, $activity = false)
    {
        $time = strtotime($date);

        if ($time >= time() - 60*3 and $activity == true) {
            $date = \App\Language::GetTextSearch('now');
        } elseif ($time >= time() - 60*59) {
            if (round((time() - $time)/60) > 0 or $activity == true)
                $date = round((time() - $time)/60).' '.\App\Language::GetTextSearch('min ago');
            else
                $date = \App\Language::GetTextSearch('now');
        } elseif (date('Y-m-d', $time) == date('Y-m-d')) {
            $date = date('H:i', $time);
        } elseif (date('Y', $time) == date('Y')) {
            $date = date('d M', $time);
            if ($dialog)
                $date .= date(' H:i', $time);
        } else {
            $date = date('d M Y', $time);
            if ($dialog)
                $date .= date(' H:i', $time);
        }

        if ($activity == true)
            $date = \App\Language::GetTextSearch('Active').' '.$date;

        return $date;
    }

    public static function ConvertAgo($date)
    {
        $time = strtotime($date);

        if ($time >= time() - 60*59) {
            if (round((time() - $time)/60) > 0)
                $date = round((time() - $time)/60).' '.\App\Language::GetTextSearch('min ago');
            else
                $date = \App\Language::GetTextSearch('now');
        } elseif ($time >= time() - 60*60*24) {
            $date = round((time() - $time)/(60*60));

            if ($date > 1)
                $date .= ' '.\App\Language::GetTextSearch('hours ago');
            else
                $date .= ' '.\App\Language::GetTextSearch('hour ago');
        } else {
            $date = round((time() - $time)/(60*60*24));

            if ($date > 1)
                $date .= ' '.\App\Language::GetTextSearch('days ago');
            else
                $date .= ' '.\App\Language::GetTextSearch('day ago');
        }

        return $date;
    }
}