<?php
namespace App\Http\Controllers;
ini_set("display_errors",1);
error_reporting(E_ALL);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Option;
use Google_Client;
use Google_Service_Sheets;
use Storage;

class GoogleAuth extends Controller {

   public function logout() {
      $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
      $credentialsPath = $storagePath.'google/client_credentials.json';
      if (file_exists($credentialsPath))
         unlink($credentialsPath);
      return redirect(url('/admin/google-sheets'));
   }

	public function Auth(Request $request) {
      $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

      $client = new Google_Client();
      $client->setAuthConfig($storagePath.'google/client_secret_566407281280-t6gs18qakado4097hfgnh89rqpim5rbk.apps.googleusercontent.com.json');
      $client->addScope(Google_Service_Sheets::SPREADSHEETS);
      $client->setAccessType('offline');
      $client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/google_auth');

      $credentialsPath = $storagePath.'google/client_credentials.json';
      if (file_exists($credentialsPath)) {
         $accessToken = json_decode(file_get_contents($credentialsPath), true);
      } else {
         if ($request->input('code')) {
            $authCode = $request->input('code');

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
               throw new Exception(join(', ', $accessToken));
            }

            // Store the credentials to disk.
            if (!file_exists(dirname($credentialsPath))) {
               mkdir(dirname($credentialsPath), 0700, true);
            }

			   //Option::setSetting("opt_google_sheets_token",json_encode( $accessToken ));
            file_put_contents($credentialsPath, json_encode($accessToken));
         } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();

            return redirect($authUrl);
         }
      }

      $client->setAccessToken($accessToken);

      // Refresh the token if it's expired.
      if ($client->isAccessTokenExpired()) {
         $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
			//Option::setSetting("opt_google_sheets_token",json_encode( $client->getAccessToken() ));
         file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
      }

      return redirect(url('/admin/google-sheets'));

	}

}

