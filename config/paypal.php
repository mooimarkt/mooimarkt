<?php

return array(
/** set your paypal credential **/
'client_id' =>'AaPJyKvNnWGaBkH2gnSSgJ36zswR75XU4-Fup-uIr5Y4kEUg_wuTPAhUknZ-Avdkron36AWh5A1pGlM2',
'secret' => 'EJGc8Qb-m9MHsIOVf_PEcU5DuNHvmT0Up5wVTu9_N57gtqxAyKLEIZ7mACz6clJQMCDCHk-CDlkZpw4D',
/**
* SDK configuration 
*/
'settings' => array(
/**
* Available option 'sandbox' or 'live'
*/
'mode' => 'live',
/**
* Specify the max request time in seconds
*/
'http.ConnectionTimeOut' => 1000,
/**
* Whether want to log to a file
*/
'log.LogEnabled' => true,
/**
* Specify the file that want to write on
*/
'log.FileName' => storage_path() . '/logs/paypal.log',
/**
* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
*
* Logging is most verbose in the 'FINE' level and decreases as you
* proceed towards ERROR
*/
'log.LogLevel' => 'FINE'
),
);