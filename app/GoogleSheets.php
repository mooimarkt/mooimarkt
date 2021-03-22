<?php

namespace App;

use App\Option;
use App\GoogleSheet;
use Google_Client;
use Google_Service_Sheets;

class GoogleSheets
{

	public function getSpreadSheet($id){

		try{

			$client = $this->Client();
			$this->Auth($client);

			return new GoogleSheet($id,$client);

		}catch (\Exception $e){

			return $e->getMessage();

		}

	}

	public function Auth(Google_Client &$client){

		$token = Option::getSetting("opt_google_sheets_token",false);

		if($token !== false){

			try{

				$client->setAccessToken( json_decode($token,true) );

				if ( $client->isAccessTokenExpired() ) {

					$client->fetchAccessTokenWithRefreshToken( $client->getRefreshToken() );

					Option::setSetting("opt_google_sheets_token",json_encode( $client->getAccessToken() ));

				}

				return $client;

			}catch (\Exception $e){

				return $e->getMessage();

			}

		}

		return false;

	}

	public function Client(){

		try{

			$client = new Google_Client();
			$client->setApplicationName( 'Google Sheets API PHP Quickstart' );
			$client->setScopes( Google_Service_Sheets::SPREADSHEETS );
			$client->setAuthConfig(json_decode(Option::getSetting("opt_google_sheets_service_account"),true));
			// $client->setAuthConfig(json_decode(Option::getSetting("opt_google_sheets"),true));
			$client->setAccessType( 'offline' );
			$client->setRedirectUri(  url('/').'/google/back' );

			return $client;

		}catch (\Exception $e){

			return $e->getMessage();

		}



	}

}
