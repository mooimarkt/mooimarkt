<?php

namespace App\Http\Controllers;

use App\City;
use App\Color;
use App\Condition;
use App\Country;
use App\Filter;
use App\SavedUsers;
use App\Size;
use App\Traits\FormatResponse;
use App\Traits\PaginationCollection;
use Carbon\Carbon;
use Illuminate\Routing\Route;
use Image;
use Illuminate\Http\Request;
use App\ForDisplay;
use App\Category;
use App\SubCategory;
use App\Ads;
use App\AdsImages;
use App\User;
use App\Chat;
use App\Inbox;
use App\FormField;
use App\FormFieldOption;
use App\Models;
use App\Make;
use App\SubCategoryField;
use App\AdsData;
use App\Pricing;
use App\AdsReport;
use App\AdsView;
use App\Tag;
use App\PackageTransaction;
use App\Voucher;
use App\Option;
use Illuminate\Support\Facades\Mail;
use App\Mail\PublishAdsMail;
use App\Mail\AdsRemindMail;
use App\Mail\ExpireMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Elavon\Tpv\Tpv;
use CardDetect\Detector;

// Elavon Payment Use
use com\realexpayments\remote\sdk\domain\Card;
use com\realexpayments\remote\sdk\domain\CardType;
use com\realexpayments\remote\sdk\domain\PresenceIndicator;
use com\realexpayments\remote\sdk\domain\payment\AutoSettle;
use com\realexpayments\remote\sdk\domain\payment\AutoSettleFlag;
use com\realexpayments\remote\sdk\domain\payment\PaymentRequest;
use com\realexpayments\remote\sdk\domain\payment\PaymentResponse;
use com\realexpayments\remote\sdk\domain\payment\PaymentType;
use com\realexpayments\remote\sdk\domain\payment\Mpi;
use com\realexpayments\remote\sdk\RealexClient;
use com\realexpayments\remote\sdk\RealexException;
use com\realexpayments\remote\sdk\RealexServerException;
use com\realexpayments\remote\sdk\http\HttpConfiguration;
use Symfony\Component\HttpFoundation\Response;
use function GuzzleHttp\Promise\all;

class AdsController extends Controller
{
    use PaginationCollection, FormatResponse;

    public function __construct()
    {
        ini_set('memory_limit', '-1');
    }

    public function CardDetectFunct(Request $request)
    {
        $detector = new \CardDetect\Detector();

        return response()->json(['status' => "success", 'type' => $detector->detect($request->input('card_name'))]);
    }

    public function pay_cc($summ, Request $request)
    {
        /*$fields = array(
           "ssl_merchant_id" => "internetShare",
           "ssl_user_id" => "beforemx",
           "ssl_pin" => "gjW2s8lWLe",
           "ssl_transaction_type" => 'ccsale',
           "ssl_show_form" => "false",
           "ssl_card_number" => '5425230000004415',
           "ssl_exp_date" => '1220',
           "ssl_cvv2cvc2" => '123',
            "ssl_amount" => 20
        );

        $url = "https://api.demo.convergepay.com/VirtualMerchantDemo/process.do";

        //initialize the post string variable
        $fields_string = '';
        //build the post string
        foreach($fields as $key=>$value) { $fields_string .=$key.'='.$value.'&'; }
        rtrim($fields_string, "&");

        //open curl session
        $ch = curl_init();
        //begin seting curl options
        //set URL
        curl_setopt($ch, CURLOPT_URL, $url); //set method
        curl_setopt($ch, CURLOPT_POST, 1);
        //set post data string
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        //these two options are frequently necessary to avoid SSL errors with PHP
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //perform the curl post and store the result
        $result = curl_exec($ch);
        //close the curl session
        curl_close($ch);

    var_dump($result);
        //a nice message to prevent people from seeing a blank screen
        //echo "Processing, please wait..."; */

        $res = $request->validate([
            'num'  => "required",
            'exp'  => "required",
            'cvv'  => "required",
            'type' => "required",
            'name' => "string",
        ]);

        /* $detector = new \CardDetect\Detector();

        return response()->json( [ 'status' => "error", 'message' => $detector->detect($res['num']) ] );*/


        $card = (new Card())
            ->addType((function () use (&$res) {
                $detector = new \CardDetect\Detector();
                switch ($detector->detect($res['num'])) {
                    case 'MasterCard':
                        return CardType::MASTERCARD;
                    case 'Amex':
                        return CardType::AMEX;
                    case 'Discover':
                        return CardType::CB;
                    case 'DinersClub':
                        return CardType::DINERS;
                    case 'JCB':
                        return CardType::JCB;
                    default:
                        return CardType::VISA;
                }
            })())
            ->addNumber($res['num'])
            ->addExpiryDate(str_replace("/", "", $res['exp']))
            ->addCvn($res['cvv'])
            ->addCvnPresenceIndicator(PresenceIndicator::CVN_PRESENT);

        if (isset($res['name'])) {
            $card = $card->addCardHolderName($res['name']);
        }

        $request = (new PaymentRequest())
            ->addType(PaymentType::AUTH)
            ->addMerchantId("beforemx")
            ->addAccount("internet");

        $detector = new \CardDetect\Detector();

        if ($detector->detect($res['num']) == 'DinersClub' or $detector->detect($res['num']) == 'JCB')
            $request->addAmount(round(floatval($summ) * Option::getSetting("opt_exchange_eur_usd") * 100))
                ->addCurrency("USD");
        else
            $request->addAmount(round(floatval($summ) * 100))
                ->addCurrency("EUR");

        $request->addCard($card)
            ->addAutoSettle((new AutoSettle())->addFlag(AutoSettleFlag::TRUE));


        $httpConfiguration = new HttpConfiguration();
        $httpConfiguration->setEndpoint("https://api.sandbox.elavonpaymentgateway.com/remote");
        $client = new RealexClient("gjW2s8lWLe", $httpConfiguration);
        //$paymentResponse = $client->send( $request );

        try {
            $paymentResponse   = $client->send($request);
            $paymentsReference = $paymentResponse->getPaymentsReference();
            $authCode          = $paymentResponse->getAuthCode();
            $orderId           = $paymentResponse->getorderId();
            $result_code       = $paymentResponse->getResult();

//        return response()->json( [ 'status' => "error", 'message' => 'ok' ] );
            if ($result_code == '00')
                return response()->json([
                    'status'  => "success",
                    'message' => $paymentResponse->getMessage(),
                    'result'  => $paymentResponse->getResult()
                ]);
            else {
                switch ((string)$result_code) {
                    case '101':
                        $error = 'Declined';
                        break;
                    case '102':
                        $error = 'Referral B';
                        break;
                    case '103':
                        $error = 'Referral A';
                        break;
                    case '200':
                        $error = 'Comms Error';
                        break;
                    default:
                        $error = 'Error';
                        break;
                }
                return response()->json(['status' => "error", 'message' => $error]);
            }

        } catch (RealexServerException $e) {
            return response()->json(['status' => "error", 'message' => $e->getMessage()]);
        } catch (RealexException $e) {
            return response()->json(['status' => "error", 'message' => $e->getMessage()]);
        }
    }

    public function cronSendCompleteAdsMail()
    {
        // Ads Reminder Mail
        $Allads = DB::table('ads')
            ->where('adsPlaceMethod', 'draft')
            ->where('adsStatus', 'available')
            ->get();

        foreach ($Allads as $ad) {
            $user  = User::find($ad->userId);
            $ads   = Ads::find($ad->id);
            $adsId = \Crypt::encryptString($ad->id);

            Mail::to($user->email)->send(new AdsRemindMail($ads, $user, $adsId));
        }
    }

    public function cronSendExpireMail()
    {
        //Expire 4 days remind
        $dueDate4days1 = date("Y-m-d 00:00:00", strtotime('+4 days'));
        $dueDate4days2 = date("Y-m-d 23:59:59", strtotime('+4 days'));

        $allExpireAds = DB::table('ads')
            ->where('dueDate', '>', $dueDate4days1)
            ->where('dueDate', '<', $dueDate4days2)
            ->where('adsPlaceMethod', 'draft')
            ->where('adsStatus', 'available')
            ->get();

        foreach ($allExpireAds as $ad) {
            $user = User::find($ad->userId);
            $ads  = Ads::find($ad->id);

            $adsId = \Crypt::encryptString($ads->id);

            Mail::to($user->email)->send(new ExpireMail($ads, $user, 4, $adsId));
        }

        $dueDate4days1 = date("Y-m-d 00:00:00", strtotime('+15 days'));
        $dueDate4days2 = date("Y-m-d 23:59:59", strtotime('+15 days'));

        $allExpireAds = DB::table('ads')
            ->where('dueDate', '>', $dueDate4days1)
            ->where('dueDate', '<', $dueDate4days2)
            ->where('adsPlaceMethod', 'draft')
            ->where('adsStatus', 'available')
            ->get();

        foreach ($allExpireAds as $ad) {
            $user = User::find($ad->userId);
            $ads  = Ads::find($ad->id);

            $adsId = \Crypt::encryptString($ad->id);

            Mail::to($user->email)->send(new ExpireMail($ads, $user, 15, $adsId));
        }
    }

    public function addNewAds(Request $request)
    {
        dd($request->all());
    }

    // public function addNewAds(Request $request){

    //     // $this->validate($request, [
    //     //     'ads_img_path' => 'required|mimes:jpeg,png',
    //     // ],
    //     // [
    //     //     'ads_img_path.mimes:jpeg,png' => 'Wrong file input',
    //     // ]
    //     // );

    //     $adsTitle = $request->input('txtAdsTitle');
    //     $oriPrice = $request->input('txtAdsPrice');
    //     $subCategoryId = $request->input('dropDownSubCategory');
    //     $adsPriceType = $request->input('dropDownCurrency');
    //     $adsDescription = $request->input('txtAdsDescription');
    //     $adsCountry = $request->input('geolocationCountry');
    //     $adsRegion = $request->input('geolocationRegion');
    //     $adsCity = $request->input('geolocationCity');
    //     $adsLongitude = $request->input('geolocationLongitude');
    //     $adsLatitude = $request->input('geolocationLatitude');
    //     $adsCallingCode = $request->input('dropDownCallingCode');
    //     $adsContactNo = $request->input('txtAdsContact');
    //     $jsonFormFieldData = $request->input('formFieldData');
    //     $adsSelectedType = $request->input('adsTypeHidden');
    //     $primaryImage = $request->input('primaryImageHidden');
    //     $tags = json_decode($request->input('tag'));
    //     $formTags = json_decode($request->input('formFieldTag'));
    //     $titleTags = explode(' ', $adsTitle);
    //     $descriptionTags = explode(' ', $adsDescription);
    //     $selectedPackageId = $request->input('selectedPackageId');
    //     $selectedAddOnId = $request->input('selectedAddOnId');

    //     $conversionRate = DB::table('currency')
    //                         ->where('currencyCode', $adsPriceType)
    //                         ->value('conversionRate');

    //     $adsPrice = $oriPrice * $conversionRate;

    //     if($request->input('placeType') == "saveAds"){

    //         $ads = new Ads;
    //         $ads->userId = Auth::user()->id;
    //         $ads->subCategoryId = $subCategoryId;
    //         $ads->adsName = $adsTitle;
    //         $ads->adsType = "sale";
    //         $ads->adsPriceType = $adsPriceType;
    //         $ads->adsPrice = $adsPrice;
    //         $ads->adsDescription = $adsDescription;
    //         $ads->adsCountry = $adsCountry;
    //         $ads->adsRegion = $adsRegion;
    //         $ads->adsCity = $adsCity;
    //         $ads->adsLongitude = $adsLongitude;
    //         $ads->adsLatitude = $adsLatitude;
    //         $ads->adsCallingCode = $adsCallingCode;
    //         $ads->adsContactNo = $adsContactNo;
    //         $ads->adsSelectedType = $adsSelectedType;
    //         $ads->adsPlaceMethod = "draft";
    //         $ads->adsStatus = 'available';
    //         $ads->save();

    //         $jsonFormImageData = $request->input('formImageData');
    //         $imageHiddenList = json_decode($jsonFormImageData);

    //         if(count($imageHiddenList) > 0){
    //             foreach($imageHiddenList as $imageHidden){

    //                 $img = Image::make($imageHidden->value);
    //                 $img -> stream();
    //                 $filename = md5(substr(str_replace(' ', '', microtime().microtime()),0,40).time()).'.jpeg';
    //                 $fullImagePath = 'storage/img/'.$filename;
    //                 \Storage::disk('public')->put('img/'.$filename, $img, 'public');

    //                 $adsImages = new AdsImages;
    //                 $adsImages->adsId = $ads->id;
    //                 $adsImages->imagePath = $fullImagePath;

    //                 if($primaryImage == $imageHidden->value){
    //                     $ads->adsImage = $fullImagePath;
    //                     $ads->save();
    //                 }

    //                 $adsImages->save();
    //             }
    //         }

    //         $formFieldData = json_decode($jsonFormFieldData);

    //         foreach($formFieldData as $formData){

    //             $adsData = new AdsData;

    //             $adsData->adsId = $ads->id;
    //             $adsData->formFieldId = $formData->id;
    //             $adsData->adsValue = $formData->value;

    //             $adsData->save();
    //         }

    //         //Tagging

    //         if(count($formTags) > 0){

    //             foreach($formTags as $formTag){

    //                 $saveTag = new Tag;

    //                 $saveTag->adsId = $ads->id;
    //                 $saveTag->type = 'form';
    //                 $saveTag->tagValue = $formTag;

    //                 $saveTag->save();
    //             }
    //         }

    //         if(count($tags) > 0){

    //             foreach($tags as $tag){

    //                 $saveTag = new Tag;

    //                 $saveTag->adsId = $ads->id;
    //                 $saveTag->type = 'etc';
    //                 $saveTag->tagValue = $tag;

    //                 $saveTag->save();
    //             }
    //         }

    //         if(count($titleTags) > 0){

    //             foreach($titleTags as $titleTag){

    //                 $saveTag = new Tag;

    //                 $saveTag->adsId =$ads->id;
    //                 $saveTag->tagValue = $titleTag;
    //                 $saveTag->type = "hidden";

    //                 $saveTag->save();
    //             }
    //         }

    //         if(count($descriptionTags) > 0){

    //             foreach($descriptionTags as $descTag){

    //                 $saveTag = new Tag;

    //                 $saveTag->adsId =$ads->id;
    //                 $saveTag->tagValue = $descTag;
    //                 $saveTag->type = "hidden";

    //                 $saveTag->save();
    //             }
    //         }

    //         return response()->json(['success' => "save"]);

    //     }
    //     else if($request->input('placeType') == "placeAds"){

    //         $adsId = $request->input('adsId');

    //         if($adsId == 0){

    //             $ads = new Ads;
    //             $ads->userId = Auth::user()->id;
    //             $ads->subCategoryId = $subCategoryId;
    //             $ads->adsName = $adsTitle;
    //             $ads->adsType = "sale";
    //             $ads->adsPriceType = $adsPriceType;
    //             $ads->adsPrice = $adsPrice;
    //             $ads->adsDescription = $adsDescription;
    //             $ads->adsCountry = $adsCountry;
    //             $ads->adsRegion = $adsRegion;
    //             $ads->adsCity = $adsCity;
    //             $ads->adsLongitude = $adsLongitude;
    //             $ads->adsLatitude = $adsLatitude;
    //             $ads->adsCallingCode = $adsCallingCode;
    //             $ads->adsContactNo = $adsContactNo;
    //             $ads->adsSelectedType = $adsSelectedType;
    //             $ads->adsPlaceMethod = "draft";
    //             $ads->adsStatus = 'pending for payment';
    //             $ads->save();

    //             $total_price = 0;
    //             // insert transaction record //
    //             $package = Pricing::find([$selectedPackageId,$selectedAddOnId]);
    //             $reference_id = md5(uniqid(rand()));
    //             foreach($package as $package_data){
    //               $transaction = new PackageTransaction();
    //               $transaction->adsId = $ads->id;
    //               $transaction->packageId = $package_data->id;
    //               $transaction->price = $package_data->price;
    //               $transaction->paymentStatus = "pending";
    //               $transaction->referenceId = $reference_id;
    //               $transaction->packageType = $package_data->type;
    //               $transaction->save();
    //               $total_price += $package_data->price;
    //             }
    //             if($total_price == 0){
    //               $ads->adsPlaceMethod = "publish";
    //               $ads->adsStatus = 'available';
    //               $ads->save();
    //             }

    //             $jsonFormImageData = $request->input('formImageData');
    //             $imageHiddenList = json_decode($jsonFormImageData);

    //             if(count($imageHiddenList) > 0){
    //                 foreach($imageHiddenList as $imageHidden){

    //                     $img = Image::make($imageHidden->value);
    //                     $img -> stream();
    //                     $filename = md5(substr(str_replace(' ', '', microtime().microtime()),0,40).time()).'.jpeg';
    //                     $fullImagePath = 'storage/img/'.$filename;
    //                     \Storage::disk('public')->put('img/'.$filename, $img, 'public');

    //                     $adsImages = new AdsImages;
    //                     $adsImages->adsId = $ads->id;
    //                     $adsImages->imagePath = $fullImagePath;

    //                     if($primaryImage == $imageHidden->value){
    //                         $ads->adsImage = $fullImagePath;
    //                         $ads->save();
    //                     }

    //                     $adsImages->save();
    //                 }
    //             }

    //             $formFieldData = json_decode($jsonFormFieldData);

    //             foreach($formFieldData as $formData){

    //                 $adsData = new AdsData;

    //                 $adsData->adsId = $ads->id;
    //                 $adsData->formFieldId = $formData->id;
    //                 $adsData->adsValue = $formData->value;

    //                 $adsData->save();
    //             }

    //             if(count($formTags) > 0){

    //                 foreach($formTags as $formTag){

    //                     $saveTag = new Tag;

    //                     $saveTag->adsId = $ads->id;
    //                     $saveTag->tagValue = $formTag;
    //                     $saveTag->type = 'form';

    //                     $saveTag->save();
    //                 }
    //             }

    //             if(count($tags) > 0){

    //                 foreach($tags as $tag){

    //                     $saveTag = new Tag;

    //                     $saveTag->adsId = $ads->id;
    //                     $saveTag->tagValue = $tag;
    //                     $saveTag->type = 'etc';

    //                     $saveTag->save();
    //                 }
    //             }

    //             if(count($titleTags) > 0){

    //                 foreach($titleTags as $titleTag){

    //                     $saveTag = new Tag;

    //                     $saveTag->adsId =$ads->id;
    //                     $saveTag->tagValue = $titleTag;
    //                     $saveTag->type = "hidden";

    //                     $saveTag->save();
    //                 }
    //             }

    //             if(count($descriptionTags) > 0){

    //                 foreach($descriptionTags as $descTag){

    //                     $saveTag = new Tag;

    //                     $saveTag->adsId =$ads->id;
    //                     $saveTag->tagValue = $descTag;
    //                     $saveTag->type = "hidden";

    //                     $saveTag->save();
    //                 }
    //             }

    //             //return array("success" => "place","total_price"=>$total_price);
    //             if($total_price == 0){
    //               return response()->json(["success" => "success","total_price"=>$total_price,"redirectLink"=>url("/getActiveAdsPage?btnMethod=publish&success=place")]);
    //             }else{
    //               return response()->json(["success" => "success","redirectLink"=>url("paymentPage?t_id=".$reference_id)]);
    //             }

    //         }
    //         else{

    //             $ads = Ads::find($adsId);
    //             $ads->userId = Auth::user()->id;
    //             $ads->subCategoryId = $subCategoryId;
    //             $ads->adsName = $adsTitle;
    //             $ads->adsType = 'sale';
    //             $ads->adsPriceType = $adsPriceType;
    //             $ads->adsPrice = $adsPrice;
    //             $ads->adsDescription = $adsDescription;
    //             $ads->adsCountry = $adsCountry;
    //             $ads->adsRegion = $adsRegion;
    //             $ads->adsCity = $adsCity;
    //             $ads->adsLongitude = $adsLongitude;
    //             $ads->adsLatitude = $adsLatitude;
    //             $ads->adsCallingCode = $adsCallingCode;
    //             $ads->adsContactNo = $adsContactNo;
    //             $ads->adsPlaceMethod = "publish";
    //             $ads->adsStatus = 'available';
    //             $ads->save();

    //             $formFieldData = json_decode($jsonFormFieldData);

    //             foreach($formFieldData as $formData){

    //                 $adsDataDelete = AdsData::where('adsId', $adsId)
    //                                     ->where('formFieldId', $formData->id)
    //                                     ->delete();

    //                 $adsData = new AdsData;

    //                 $adsData->adsId = $ads->id;
    //                 $adsData->formFieldId = $formData->id;
    //                 $adsData->adsValue = $formData->value;

    //                 $adsData->save();
    //             }

    //             $oldTag = DB::table('tag')->where('adsID', $adsId)->get();

    //             foreach($oldTag as $oldTagging){

    //                 $singleOldTag = Tag::find($oldTagging->id);
    //                 $singleOldTag->delete();
    //             }

    //             if(count($formTags) > 0){

    //                 foreach($formTags as $formTag){

    //                     $saveTag = new Tag;

    //                     $saveTag->adsId = $ads->id;
    //                     $saveTag->tagValue = $formTag;
    //                     $saveTag->type = 'form';

    //                     $saveTag->save();
    //                 }
    //             }

    //             if(count($tags) > 0){

    //                 foreach($tags as $tag){

    //                     $saveTag = new Tag;

    //                     $saveTag->adsId = $ads->id;
    //                     $saveTag->tagValue = $tag;
    //                     $saveTag->type = 'etc';

    //                     $saveTag->save();
    //                 }
    //             }

    //             if(count($titleTags) > 0){

    //                 foreach($titleTags as $titleTag){

    //                     $saveTag = new Tag;

    //                     $saveTag->adsId =$ads->id;
    //                     $saveTag->tagValue = $titleTag;
    //                     $saveTag->type = "hidden";

    //                     $saveTag->save();
    //                 }
    //             }

    //             if(count($descriptionTags) > 0){

    //                 foreach($descriptionTags as $descTag){

    //                     $saveTag = new Tag;

    //                     $saveTag->adsId =$ads->id;
    //                     $saveTag->tagValue = $descTag;
    //                     $saveTag->type = "hidden";

    //                     $saveTag->save();
    //                 }
    //             }

    //             Mail::to(Auth::user()->email)->send(new PublishAdsMail( $ads ));

    //             return response()->json(["success" => "place"]);

    //         }
    //     }
    //     else if($request->input('placeType') == "editAds"){

    //         $adsId = $request->input('adsId');
    //         $ads = Ads::find($adsId);

    //         $ads->userId = Auth::user()->id;
    //         $ads->subCategoryId = $subCategoryId;
    //         $ads->adsName = $adsTitle;
    //         $ads->adsType = 'sale';
    //         $ads->adsPriceType = $adsPriceType;
    //         $ads->adsPrice = $adsPrice;
    //         $ads->adsDescription = $adsDescription;
    //         $ads->adsCountry = $adsCountry;
    //         $ads->adsRegion = $adsRegion;
    //         $ads->adsCity = $adsCity;
    //         $ads->adsLongitude = $adsLongitude;
    //         $ads->adsLatitude = $adsLatitude;
    //         $ads->adsContactNo = $adsContactNo;
    //         $ads->adsStatus = 'available';

    //         $oldAdsImage = DB::table('adsImages')
    //                         ->where('adsId', $adsId)
    //                         ->delete();

    //         $jsonFormImageData = $request->input('formImageData');
    //         $imageHiddenList = json_decode($jsonFormImageData);

    //         if(count($imageHiddenList) > 0){
    //             foreach($imageHiddenList as $imageHidden){

    //                 $img = Image::make($imageHidden->value);
    //                 $img -> stream();
    //                 $filename = md5(substr(str_replace(' ', '', microtime().microtime()),0,40).time()).'.jpeg';
    //                 $fullImagePath = 'storage/img/'.$filename;
    //                 \Storage::disk('public')->put('img/'.$filename, $img, 'public');

    //                 $adsImages = new AdsImages;
    //                 $adsImages->adsId = $ads->id;
    //                 $adsImages->imagePath = $fullImagePath;

    //                 if($primaryImage == $imageHidden->value){
    //                     $ads->adsImage = $fullImagePath;
    //                     $ads->save();
    //                 }

    //                 $adsImages->save();
    //             }
    //         }

    //         $formFieldData = json_decode($jsonFormFieldData);

    //         foreach($formFieldData as $formData){

    //             $adsDataDelete = AdsData::where('adsId', $adsId)
    //                                 ->where('formFieldId', $formData->id)
    //                                 ->delete();

    //             $adsData = new AdsData;

    //             $adsData->adsId = $ads->id;
    //             $adsData->formFieldId = $formData->id;
    //             $adsData->adsValue = $formData->value;

    //             $adsData->save();
    //         }

    //         $oldTag = DB::table('tag')->where('adsID', $adsId)->get();

    //         foreach($oldTag as $oldTagging){

    //             $singleOldTag = Tag::find($oldTagging->id);
    //             $singleOldTag->delete();
    //         }

    //         if(count($formTags) > 0){

    //             foreach($formTags as $formTag){

    //                 $saveTag = new Tag;

    //                 $saveTag->adsId = $ads->id;
    //                 $saveTag->tagValue = $formTag;
    //                 $saveTag->type = 'form';

    //                 $saveTag->save();
    //             }
    //         }

    //         if(count($tags) > 0){

    //             foreach($tags as $tag){

    //                 $saveTag = new Tag;

    //                 $saveTag->adsId = $ads->id;
    //                 $saveTag->tagValue = $tag;
    //                 $saveTag->type = 'etc';

    //                 $saveTag->save();
    //             }
    //         }

    //         if(count($titleTags) > 0){

    //             foreach($titleTags as $titleTag){

    //                 $saveTag = new Tag;

    //                 $saveTag->adsId =$ads->id;
    //                 $saveTag->tagValue = $titleTag;
    //                 $saveTag->type = "hidden";

    //                 $saveTag->save();
    //             }
    //         }

    //         if(count($descriptionTags) > 0){

    //             foreach($descriptionTags as $descTag){

    //                 $saveTag = new Tag;

    //                 $saveTag->adsId =$ads->id;
    //                 $saveTag->tagValue = $descTag;
    //                 $saveTag->type = "hidden";

    //                 $saveTag->save();
    //             }
    //         }

    //         return response()->json(["success" => "edit"]);

    //     }
    //     else{
    //         echo "3";
    //     }
    // }

    public function getPlaceAdsPage(Request $request)
    {
        $latitude  = 0;
        $longitude = 0;

        $displayData = new ForDisplay;

        $originalWord              = "<h6 class='tnc-agree-message'>" . trans('place-ads.Read about our #pricing* information.') . "</h4>";
        $fromWord                  = array("#", "*");
        $toWord                    = array("<a href='getPricingPage'>", "</a>");
        $displayData->linksPayment = str_replace($fromWord, $toWord, $originalWord);

        $adsId = $request->input('emptyAdsId');

        $ads = Ads::where('id', $adsId)
            ->where('adsStatus', '!=', 'unavailable')
            ->get();

        $category = Category::orderBy('categoryStatus', 'desc')
            ->where('categoryStatus', '!=', 0)
            ->whereNull('deleted_at')
            ->get();


        if (Auth::check()) {
            $userId = Auth::user()->id;
            $user   = User::find($userId);

            $socialAcounts = DB::table('social_accounts')
                ->where('social_accounts.user_id', '=', $userId)
                ->get();

            $countriesList   = DB::table('world_countries')->pluck('name');
            $callingCodeList = DB::table('world_countries')->orderBy('name', 'asc')->get();

            if ($user->country == null) {
                $states = 'none';
            } else {

                if ($user->region == "none") {

                    $states = "none";
                } else {

                    try {
                        $states = DB::table('world_countries')
                            ->join('states', 'states.country_id', 'world_countries.id')
                            ->whereRaw('LOWER(world_countries.name) like LOWER("%' . $user->country . '%")')
                            ->orderBy('states.name', 'asc')
                            ->pluck('states.name');
                    } catch (\Exception $e) {
                        $states = 'nostate';
                    }
                }
            }
        } else {
            $user = new User;

            $countries = app('pragmarx.countries');

            $countriesList = $countries->all()->sortBy('name')->pluck('name.common');
            $states        = 'none';
        }

        $currency = DB::table('currency')
            ->whereNull('deleted_at')
            ->get();

        return view('user/placeads', [
            "user"            => $user,
            "callingCodeList" => $callingCodeList,
            "countriesList"   => $countriesList,
            "data"            => $displayData,
            'states'          => $states,
            'latitude'        => $latitude,
            'longitude'       => $longitude,
            "category"        => $category,
            'ads'             => $ads,
            'currency'        => $currency
        ]);
    }

    // public function getSubCategory(Request $request){

    //     $categoryId = $request->input('categoryId');
    //     $adsId = $request->input('adsId');

    //     $subCategory = DB::table('translator_translations')
    //                         ->join('sub_categories', 'sub_categories.subCategoryName', 'translator_translations.item')
    //                         ->where('categoryId', $categoryId)
    //                         ->where('locale', session()->get('locale'))
    //                         ->where('group', 'subcategories')
    //                         ->orderBy('sort', 'desc')
    //                         ->get();

    //     $ads = Ads::where('id', $adsId)
    //                 ->where('ads.adsStatus', '!=',   'unavailable')
    //                 ->get();

    //     return response()->json([ 'subCategory' => $subCategory ]);
    // }

    public function getAllSubCategoryData(Request $request)
    {

        $subCategoryId = $request->input('subCategoryId');
        $adsId         = $request->input('adsId');

        $form = DB::table('subCategory_fields')
            ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
            ->where('subCategory_fields.subCategoryId', $subCategoryId)
            ->whereNull('subCategory_fields.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->orderBy('form_fields.sort', 'desc')
            ->orderBy('form_fields.fieldTitle', 'asc')
            ->get();

        $value = DB::table('subCategory_fields')
            ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
            ->join('form_field_options', 'form_field_options.formFieldId', '=', 'form_fields.id')
            ->where('subCategory_fields.subCategoryId', $subCategoryId)
            ->where('form_field_options.parentFieldId', 0)
            ->whereNull('subCategory_fields.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->whereNull('form_field_options.deleted_at')
            ->orderBy('form_field_options.sort', 'desc')
            ->orderBy('form_field_options.value', 'asc')
            ->get();

        $view = \View::make('user/PlaceAdsForm', ['form' => $form, 'value' => $value])->render();


        return response()->json(['formView' => $view]);
    }

    public function getAdsDetailsPage(Request $request)
    {

        $btnType = $request->input('btnSubmitActiveAds');

        $adsId = $request->input('adsId');

        if ($btnType == "btnView") {

            $adsName         = Ads::where('id', $adsId)
                ->value('adsName');
            $subCategoryId   = Ads::where('id', $adsId)
                ->value('subCategoryId');
            $subCategoryName = Subcategory::where('id', $subCategoryId)
                ->value('subCategoryName');
            $categoryId      = Subcategory::where('id', $subCategoryId)
                ->value('categoryId');
            $categoryName    = Category::where('id', $categoryId)
                ->value('categoryName');

            $request->session()->put('adsNameForBreadcrumb', $adsName);
            $request->session()->put('subCategoryIdForBreadcrumb', $subCategoryId);
            $request->session()->put('subCategoryNameForBreadcrumb', $subCategoryName);
            $request->session()->put('categoryIdForBreadcrumb', $categoryId);
            $request->session()->put('categoryNameForBreadcrumb', $categoryName);

            $images = DB::table('adsImages')
                ->where('adsId', $adsId)
                ->get();

            $ads = DB::table('ads')
                ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
                ->join('users', 'users.id', '=', 'ads.userId')
                ->where('ads.id', $adsId)
                ->where('ads.adsStatus', '!=', 'unavailable')
                ->whereNull('sub_categories.deleted_at')
                ->whereNull('ads.deleted_at')
                ->whereNull('users.deleted_at')
                ->select('ads.id', 'ads.adsName', 'ads.sortingDate', 'ads.spotLightDate', 'ads.userId', 'ads.adsRegion', 'ads.adsCountry', 'ads.adsContactNo', 'ads.adsImage', 'ads.adsPriceType', 'ads.adsPrice', 'ads.adsCallingCode', 'ads.adsDescription', 'sub_categories.subCategoryName', 'users.name', 'users.email', 'users.phoneContactType', 'users.emailContactType')
                ->get();

            $adsDatas = DB::table('ads')
                ->join('ads_datas', 'ads_datas.adsId', '=', 'ads.id')
                ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
                ->join('form_fields', 'form_fields.id', 'ads_datas.formFieldId')
                ->where('locale', session()->get('locale'))
                ->where('group', 'options')
                ->whereNull('ads.deleted_at')
                ->whereNull('ads_datas.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->orderBy('form_fields.sort', 'asc')
                ->where('ads_datas.adsId', $adsId)
                ->get();

            $adsQuery = Ads::find($adsId);
            $check    = "";

            if ($adsQuery->userId == Auth::user()->id) {

                $check = "true";
            } else {

                $check = "false";
            }

            $ip = $request->ip();

            $checkNullAdsView = AdsView::where('adsId', $adsId)
                ->where('ipAddress', $ip)
                ->where('viewAfter', 'true')
                ->get();

            $currentAdsViewId = AdsView::where('adsId', $adsId)
                ->where('ipAddress', $ip)
                ->where('viewAfter', 'true')
                ->value('id');

            if (count($checkNullAdsView) < 1) {

                $adsView            = new AdsView;
                $adsView->adsId     = $adsId;
                $adsView->ipAddress = $ip;
                $adsView->viewAfter = 'true';
                $adsView->save();

            } else if (count($checkNullAdsView) > 0) {

                $today = date("Y-m-d H:i:s", strtotime('-1 days'));

                $adsViewCreatedAt = AdsView::where('adsId', $adsId)
                    ->where('ipAddress', $ip)
                    ->where('created_at', '>=', $today)
                    ->get();

                if (count($adsViewCreatedAt) <= 0) {

                    $currentAdsView            = AdsView::find($currentAdsViewId);
                    $currentAdsView->viewAfter = "false";
                    $currentAdsView->save();

                    $adsView            = new AdsView;
                    $adsView->adsId     = $adsId;
                    $adsView->ipAddress = $ip;
                    $adsView->viewAfter = 'true';
                    $adsView->save();
                }

            }

            $countriesList   = DB::table('world_countries')->pluck('name');
            $callingCodeList = DB::table('world_countries')->orderBy('name', 'asc')->get();
            $adsCount        = AdsView::where('adsId', $adsId)->count();

            $summaryString    = "";
            $summaryStringAry = [];
            foreach ($adsDatas as $adsData) {
                $summaryStringAry[] = $adsData->adsValue;
            }
            $summaryString = implode(" | ", $summaryStringAry);

            return view('user/adsdetails', [
                "images"          => $images,
                "ads"             => $ads,
                "adsDatas"        => $adsDatas,
                "check"           => $check,
                "adsCount"        => $adsCount,
                'callingCodeList' => $callingCodeList,
                'countriesList'   => $countriesList,
                'summaryString'   => $summaryString
            ]);
        } else if ($btnType == "btnEdit") {

            $latitude  = 0;
            $longitude = 0;

            $ads = Ads::where('id', $adsId)
                ->where('adsStatus', '!=', 'unavailable')
                ->get();

            $adsQuery         = Ads::find($adsId);
            $subCategoryQuery = SubCategory::find($adsQuery->subCategoryId);
            $categoryId       = $subCategoryQuery->categoryId;
            $subCategory      = SubCategory::where('categoryId', $subCategoryQuery->categoryId)->get();

            $category = Category::all();

            $imagesPaths = DB::table('adsImages')
                ->where('adsId', '=', $adsId)
                ->get();

            $imagesBase64 = array();

            foreach ($imagesPaths as $imagePath) {
                $path           = $imagePath->imagePath;
                $type           = pathinfo($path, PATHINFO_EXTENSION);
                $data           = file_get_contents($path);
                $base64         = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $imagesBase64[] = $base64;
            }

            $path                = $ads[0]->adsImage;
            $type                = pathinfo($path, PATHINFO_EXTENSION);
            $data                = file_get_contents($path);
            $base64              = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $primaryImagesBase64 = $base64;

            if (Auth::check()) {
                $userId = Auth::user()->id;
                $user   = User::find($userId);

                $socialAcounts = DB::table('social_accounts')
                    ->where('social_accounts.user_id', '=', $userId)
                    ->get();

                $countriesList   = DB::table('world_countries')->pluck('name');
                $callingCodeList = DB::table('world_countries')->orderBy('name', 'asc')->get();

                if ($user->country == null) {
                    $states = 'none';
                } else {

                    if ($user->region == "none") {

                        $states = "none";
                    } else {

                        try {
                            $states = DB::table('world_countries')
                                ->join('states', 'states.country_id', 'world_countries.id')
                                ->whereRaw('LOWER(world_countries.name) like LOWER("%' . $user->country . '%")')
                                ->orderBy('states.name', 'asc')
                                ->pluck('states.name');
                        } catch (\Exception $e) {
                            $states = 'nostate';
                        }
                    }
                }
            } else {
                $user = new User;

                $countriesList   = DB::table('world_countries')->pluck('name');
                $callingCodeList = DB::table('world_countries')->orderBy('name', 'asc')->get();
                $states          = 'none';
            }

            $currency = DB::table('currency')
                ->whereNull('deleted_at')
                ->get();

            $adsDatas = DB::table('ads')
                ->join('ads_datas', 'ads_datas.adsId', '=', 'ads.id')
                ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
                ->join('form_fields', 'form_fields.id', 'ads_datas.formFieldId')
                ->where('locale', session()->get('locale'))
                ->where('group', 'options')
                ->whereNull('ads.deleted_at')
                ->whereNull('ads_datas.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->orderBy('form_fields.sort', 'asc')
                ->where('ads_datas.adsId', $adsId)
                ->get();

            $summaryString = "";

            foreach ($adsDatas as $adsData) {
                $summaryString .= $adsData->adsValue;
            }

            $tags = DB::table('tag')->where('adsId', $adsId)->get();

            return view('user/placeads', [
                "user"            => $user,
                "category"        => $category,
                'categoryId'      => $categoryId,
                'ads'             => $ads,
                'callingCodeList' => $callingCodeList,
                'countriesList'   => $countriesList,
                'states'          => $states,
                'latitude'        => $latitude,
                'longitude'       => $longitude,
                'subCategory'     => $subCategory,
                'currency'        => $currency,
                'galleryImages'   => $imagesBase64,
                'primaryImage'    => $primaryImagesBase64,
                'summaryString'   => $summaryString,
                'tags'            => $tags
            ]);
        } else if ($btnType == 'btnDelete') {

            $ads = Ads::find($adsId);

            $ads->adsStatus = 'unavailable';

            $ads->save();

            return redirect()->back()->with('success', 'Ads Delete Successful !');

        }
    }

    public function getEditAdsPage()
    {

        $googleMapKey = 'AIzaSyA1Z4RwIqzCGTFXhyRveLMCI7Yiau4AAeQ';
        $category     = Category::all();
        $subCategory  = SubCategory::all();

        return view('user/editads', [
            "googleMapKey" => $googleMapKey,
            "category"     => $category,
            'subCategory'  => $subCategory
        ]);
    }

    public function placeAdsGotData(Request $request)
    {

        $adsId = $request->input('adsId');

        // $adsQuery = Ads::find($adsId);

        // $ads = Ads::where('id', $adsId)->get();

        // $subCategoryId = $adsQuery->subCategoryId;

        // $category = DB::table('categories')
        //             ->join('sub_categories', 'sub_categories.categoryId', '=', 'categories.id')
        //             ->where('sub_categories.id', $subCategoryId)
        //             ->get();

        // $categoryQuery = SubCategory::find($subCategoryId);

        // $categoryId = $categoryQuery->categoryId;

        // $fieldForm = FormField::where('categoryId', $categoryId)->get();

        $form = DB::table('ads')
            ->join('ads_datas', 'ads_datas.adsId', '=', 'ads.id')
            ->join('form_fields', 'form_fields.id', 'ads_datas.formFieldId')
            ->where('ads_datas.adsId', $adsId)
            ->whereNull('ads.deleted_at')
            ->whereNull('ads_datas.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->orderBy('form_fields.sort', 'desc')
            ->orderBy('form_fields.fieldTitle', 'asc')
            ->get();

        $adsQuery = Ads::find($adsId);


        $adsDatas = DB::table('ads')
            ->join('ads_datas', 'ads_datas.adsId', '=', 'ads.id')
            ->join('form_fields', 'form_fields.id', 'ads_datas.formFieldId')
            ->whereNull('ads.deleted_at')
            ->whereNull('ads_datas.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->orderBy('form_fields.sort', 'desc')
            ->where('ads.id', $adsId)
            ->where('form_fields.fieldType', 'dropdown')
            ->where('ads_datas.adsValue', '!=', 'none')
            ->select('ads_datas.adsValue', 'ads_datas.formFieldId')
            ->get();

        $allFormFields = DB::table('subCategory_fields')
            ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
            ->where('subCategory_fields.subCategoryId', $adsQuery->subCategoryId)
            ->whereNull('subCategory_fields.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->orderBy('form_fields.sort', 'desc')
            ->orderBy('form_fields.fieldTitle', 'asc')
            ->select('form_fields.id', 'form_fields.fieldTitle', 'form_fields.parentFieldId')
            ->get();

        $final = array();

        foreach ($allFormFields as $formField) {
            if ($formField->parentFieldId == 0) {

                $data = FormFieldOption::where('formFieldId', $formField->id)
                    ->get();
            } else {
                $parentFormFieldId   = $formField->parentFieldId;
                $selectedOptionValue = 'none';

                foreach ($adsDatas as $ads) {
                    if ($ads->formFieldId == $parentFormFieldId) {
                        $selectedOptionValue = FormFieldOption::where('formFieldId', $ads->formFieldId)
                            ->where('value', $ads->adsValue)
                            ->value('id');
                        break;
                    }
                }

                $data = FormFieldOption::where('parentFieldId', $selectedOptionValue)
                    ->where('formFieldId', $formField->id)
                    ->get();
            }

            if (count($data) > 0) {
                $final[$formField->fieldTitle] = $data;
            }
        }

        $view = \View::make('user/PlaceAdsFormWithData', ['form' => $form, 'adsDatas' => $final])->render();

        //$subCategory = SubCategory::where('categoryId', $categoryId)->get();

        return response()->json(['formView' => $view, 'form' => $form]);
    }

    public function deleteEditPageAds(Request $request)
    {

        $adsId = $request->input('adsId');

        $ads = Ads::find($adsId);

        $ads->adsStatus = 'unavailable';

        $ads->save();

        //return redirect()->back()->with('success', 'Ads Delete Successful !');
    }

    public function paymentPage(Request $request)
    {

        $voucherCode = \Session::get('voucherCode');
        if ($voucherCode) {
            $voucher = Voucher::WHERE("voucherCode", "=", $voucherCode)->where("status", "=", "1")->first();
        }
        $totalDiscount  = 0;
        $transaction_id = $request->input("t_id");
        $title_ary      = [
            "basic"                     => "Basic",
            "spotlight"                 => "Spotlight",
            "auto-bump"                 => "Auto-Bump",
            "spotlight-spotlight-addOn" => "Spotlight Add-ons",
            "ab-spotlight-addOn"        => "Spotlight Add-ons",
            "basic-spotlight-addOn"     => "Spotlight Add-ons",
            "basic-bump-addOn"          => "Auto-Bump Add-ons",
            "ab-bump-addOn"             => "Auto-Bump Add-ons",
            "spotlight-bump-addOn"      => "Auto-Bump Add-ons"
        ];
        $data           = [];
        $total_price    = 0;
        $transaction    = PackageTransaction::WHERE("referenceId", "=", $transaction_id)->get();
        if ($transaction->count()) {
            $ads_id           = $transaction[0]->adsId;
            $adsQuery         = Ads::find($ads_id);
            $subCategoryQuery = SubCategory::find($adsQuery->subCategoryId);
            if (count(explode(".", trans('subcategories.' . $subCategoryQuery->subCategoryName))) > 1) {
                $sub_cat_name = explode(".", trans('subcategories.' . $subCategoryQuery->subCategoryName))[1];
            } else {
                $sub_cat_name = trans('subcategories.' . $subCategoryQuery->subCategoryName);
            }
        }
        foreach ($transaction as $transaction_data) {
            $temp              = [];
            $package_data      = Pricing::find($transaction_data->packageId);
            $package_data_info = json_decode($package_data->data, 1);
            if (in_array($package_data->type, array("basic", "auto-bump", "spotlight"))) {
                $temp["title"] = "1x " . $title_ary[$package_data->type] . " in " . $sub_cat_name;

                //." for ".$package_data_info["listed"]." days
            } else {
                $temp["title"] = "1x " . $title_ary[$package_data->type];

            }

            $temp["description"] = "<ul>";
            if ($package_data_info["listed"] != "0") {
                $temp["description"] .= "<li>Add " . $package_data_info["listed"] . " Days Listing Time.</li>";
            }
            if ($package_data_info["auto-bump"] != "0") {
                $auto_bump_day = explode(",", $package_data_info["auto-bump"]);
                foreach ($auto_bump_day as $day) {
                    $temp["description"] .= '<li>';
                    $temp["description"] .= 'Auto Bump at ' . $day;
                    if ($day == "1") {
                        $temp["description"] .= 'st day.</h6>';
                    } else if ($day == "2") {
                        $temp["description"] .= 'nd day.</h6>';
                    } else if ($day == "3") {
                        $temp["description"] .= 'rd day.</h6>';
                    } else {
                        $temp["description"] .= 'th day.</h6>';
                    }
                    $temp["description"] .= "</li>";
                }

                //code += "Auto-bump "+add_ons_data["auto-bump"]+" Day.<br>";
            }
            if ($package_data_info["spotlight"] != "0") {
                $temp["description"] .= '<li>Spotlight the ad for ' . ($package_data_info["spotlight"] * 24) . ' hours.</li>';
                //code += "Spotlight "+add_ons_data.spotlight+" Days<br>";
            }
            $temp["description"] .= "</ul>";
            $temp["price"]       = $package_data->price;
            $total_price         += $package_data->price;
            $transaction_array[] = $temp;


        }
        if (isset($voucher)) {
            if ($voucher->discountType == "percentage") {
                $totalDiscount = floor($total_price * ($voucher->discountValue)) / 100;
            } else {
                $totalDiscount = $total_price - $voucher->discountValue;
            }
        }
        $data["transactionId"] = $transaction_id;
        //$data["transactionData"] = $transaction_array;
        $data["totalDiscount"] = $totalDiscount;
        $data["voucherCode"]   = $voucherCode;
        $data["totalPrice"]    = $total_price - $totalDiscount;

        return view("User.paymentPage", $data);

    }

    function purchaseAddOn(Request $request)
    {
        $adsID     = $request->input('purchaseAddOnAdsID');
        $packageID = $request->input('purchaseAddOnPackageID');

        $ads = Ads::find($adsID);

        $package      = Pricing::where("id", $packageID)->get();
        $reference_id = md5(uniqid(rand()));
        foreach ($package as $package_data) {
            $transaction                = new PackageTransaction();
            $transaction->adsId         = $ads->id;
            $transaction->packageId     = $package_data->id;
            $transaction->price         = $package_data->price;
            $transaction->paymentStatus = "pending";
            $transaction->referenceId   = $reference_id;
            $transaction->packageType   = $package_data->type;
            $transaction->save();
        }

        return response()->json(["status" => "ok", "redirectLink" => url("paymentPage?t_id=" . $reference_id)]);

    }

    /**
     * Display a listing of the resource.
     *
     * @param null $categoryId
     * @param null $subCategoryId
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId = null, $subCategoryId = null, Request $request)
    {
        $request->validate([
            'subCategoryId' => 'numeric',
            'categoryId'    => 'numeric',
            //'search'        => 'string',
            'tags'          => 'array',
        ]);

        $curCategory    = Category::with(['subCategories', 'subCategories.adsFilters'])->find($categoryId);
        $curSubCategory = $subCategoryId !== null
            ? SubCategory::with([
                'adsFilters',
                'adsFilters.children',
                'adsFilters.children.filterSize'
            ])->find($subCategoryId)
            : null;

        $filters = $subCategoryId !== null ? $curSubCategory->adsFilters : null;

        $filters_data  = json_decode(isset($request->filters) ? $request->filters : '[]', true);
        $exceptFilters = collect();

        if (isset($request->filters)) {
            $filterType = $filters->where('name', 'Type')->first();

            $exceptFilters = $filterType->children->pluck('filterSize.size_id')->unique()->filter(function ($item) {
                return $item;
            })->values();
        }

        return view('site.category', compact('curCategory', 'curSubCategory', 'filters', 'filters_data', 'exceptFilters'));
    }

    public function checkSearchType(Request $request)
    {
        $search = $request->search;
        if ($search !== null) {
            $countAds = Ads::where(function ($query) use ($search) {
                $query->where('adsName', 'like', "%{$search}%");
                $query->where('adsStatus', '=', 'payed');
            })->get()->count();

            $countUsers = User::where('id', '<>', auth()->user()->id)
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%")->where('name', 'like', "%$search%");
                })->get()->each(function ($item) {
                    $item->activitiesSeller = $item->getActivity('seller');
                    $item->activitiesBuyer  = $item->getActivity('buyer');
                    $item->savedUsers       = SavedUsers::where('saved_userId', Auth::id())->where('userId', $item->id)->get()->isEmpty();

                    return $item;
                })->count();

            $response = $this->formatResponse('success', null, [
                'typeSearch' => $countAds >= $countUsers ? 'ads' : 'users'
            ]);
        } else {
            $response = $this->formatResponse('error', null);
        }

        return response($response, 200);
    }

    public function search(Request $request)
    {
        $search = $request->search ?? '';
        $result = User::where('id', '<>', auth()->user()->id)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })->get()->each(function ($item) {
                $item->activitiesSeller = $item->getActivity('seller');
                $item->activitiesBuyer  = $item->getActivity('buyer');
                $item->savedUsers       = SavedUsers::where('saved_userId', Auth::id())->where('userId', $item->id)->get()->isEmpty();

                return $item;
            });

        return view('site.search', compact('result'));
    }

    public function getProductsFilters(Request $request)
    {
        $ads = Ads::with(["tag", "subcategory", "sizes", "colors", "conditions"])
            ->where('parent_id', '=', null) // hide child ads
            ->where('adsStatus', '=', 'payed')
            ->where('expired_at', '>', Carbon::now());
        $ads->join("sub_categories", "sub_categories.id", "=", "ads.subCategoryId")
            ->select("sub_categories.*", "ads.*");
        /*$ads->join("ads_filter", "ads_filter.ads_id", "=", "ads.id")
            ->select("ads_filter.*", "ads.*");*/

        $category    = isset($request->categoryId) ? $request->categoryId : 0;
        $subCategory = isset($request->subCategoryId) ? $request->subCategoryId : ($request->sub_category ?? 0);
        if (isset($request->search)) {
            $where = "where";
            $s     = $request->search;
            $ads->$where(function ($query) use ($s, $category, $subCategory) {
                $query->where('adsName', 'like', "%{$s}%");
                $query->where('adsStatus', '=', 'payed')
                    ->where('expired_at', '>', Carbon::now());
                if ($category != 0) {
                    $query->where('sub_categories.categoryId', $category);
                }
                if ($subCategory != 0) {
                    $query->where('sub_categories.id', $subCategory);
                }
            });

            $s_s = explode(' ', $s);
            if (is_array($s_s) and count($s_s) > 1) {
                foreach ($s_s as $k)
                    $ads->orWhere(function ($query) use ($k, $category, $subCategory) {
                        $query->where('adsName', 'like', "%{$k}%");
                        $query->where('adsStatus', '=', 'payed')
                            ->where('expired_at', '>', Carbon::now());
                        if ($category != 0) {
                            $query->where('sub_categories.categoryId', $category);
                        }
                        if ($subCategory != 0) {
                            $query->where('sub_categories.id', $subCategory);
                        }
                    });
            }
        } else {
            if ($category != 0) {
                $ads->where('sub_categories.categoryId', $category);
            }
            if ($subCategory != 0) {
                $ads->where('sub_categories.id', $subCategory);
            }
        }

        if ($request->filters !== null) {
            $filters = [];
            foreach ($request->filters as $filter) {
                if (isset($filter['type'])) {
                    switch ($filter['type']) {
                        case 'price-from':
                            if ($filter['value'] !== null && (float)str_replace(',', '.', $filter['value']) >= 0) {
                                $ads->where('adsPrice', '>=', (float)str_replace(',', '.', $filter['value']));
                            }
                            break;
                        case 'price-to':
                            if ($filter['value'] !== null && (float)str_replace(',', '.', $filter['value']) >= 0) {
                                $ads->where('adsPrice', '<=', (float)str_replace(',', '.', $filter['value']));
                            }
                            break;
                        case 'location':
                            if ($filter['value'] !== null) {
                                $ads->where('location', '<=', $filter['value']);
                            }
                            break;
                        case 'other-brand':
                            if ($filter['value'] !== null) {
                                $otherBrandFilter = Filter::where('name', $filter['value'])
                                    ->where('parent_id', $filter['id_filter'])
                                    ->first();
                                if ($otherBrandFilter !== null) {
                                    if (array_key_exists($otherBrandFilter->parent_id, $filters)) {
                                        $filters[$otherBrandFilter->parent_id][] = $otherBrandFilter->id;
                                    } else {
                                        $filters[$otherBrandFilter->parent_id] = [$otherBrandFilter->id];
                                    }
                                }
                            }
                            break;
                        default :
                            $filterId  = $filter['value'];
                            $adsFilter = Filter::find($filterId);
                            if (array_key_exists($adsFilter->parent_id, $filters)) {
                                $filters[$adsFilter->parent_id][] = $adsFilter->id;
                            } else {
                                $filters[$adsFilter->parent_id] = [$adsFilter->id];
                            }
                            break;
                    }
                } else {
                    $filterId  = ($filter['value'] == 'all') ?
                        $filter['id_filter'] :
                        $filter['value'];
                    $adsFilter = Filter::find($filterId);
                    if ($adsFilter !== null) {
                        if (array_key_exists($adsFilter->parent_id, $filters)) {
                            $filters[$adsFilter->parent_id][] = $adsFilter->id;
                        } else {
                            $filters[$adsFilter->parent_id] = [$adsFilter->id];
                        }
                    }
                }
            }

            foreach ($filters as $filter) {
                if (count($filter) == 1) {
                    $ads->whereHas('filters', function ($q) use ($filter) {
                        $q->where('filters.id', $filter);
                    });
                } else {
                    $ads->whereHas('filters', function ($q) use ($filter) {
                        $q->whereIn('filters.id', $filter);
                    });
                }
            }
        }

        $ads = $ads->get();

        if ($request->sort !== null && strlen($request->sort) > 0) {
            switch ($request->sort) {
                case 'new':
                    $ads = $ads->sortByDesc('created_at');
                    break;
                case 'most_liked':
                    $ads = $ads->sortByDesc(function ($ad) {
                        return $ad->favorites->count();
                    });
                    break;
                case 'price_low_to_high':
                    $ads = $ads->sortBy('adsPrice');
                    break;
                case 'price_high_to_low':
                    $ads = $ads->sortByDesc('adsPrice');
                    break;
                default:
                    break;
            }
        }

        $ads      = $this->paginate_collection($ads, $request->per_page);
        $response = $this->formatResponse('success', null, [
            'ads'       => view('site.inc.ads-list', ['ads' => $ads])->render(),
            'last_page' => $ads->lastPage() <= $request->page,
            'countAds'  => $ads->count()
        ]);

        return response($response, 200);
    }

    public function catalogsFilter(Request $request)
    {
        if ($request->has('filter')) {
            $filter = Filter::find($request->filter);

            if ($filter !== null) {
                $subFilters = $filter->children()->get()->map(function ($item) {
                    return ['id' => $item->id, 'name' => $item->name];
                })->toArray();

                if ($filter->parent !== null && $filter->parent->name == "Brand" && $filter->name == "Other") {
                    $response = $this->formatResponse('success', null, 'Other brand');
                    return response($response, 200);
                }
                if ($filter->parent->name == "Brand") {
                    $response = $this->formatResponse('success', null, 'Brand');
                    return response($response, 200);
                }
            }


        }
        if (isset($subFilters)) {
            $response = $this->formatResponse('success', null, $subFilters);
            return response($response, 200);
        } else {
            $response = $this->formatResponse('error', 'No filters');
            return response($response, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $categories    = \App\Category::orderBy('categoryStatus', 'desc')->get();
        $subCategories = \App\SubCategory::orderBy('sort', 'desc')->where('categoryId', $categories[0]->id)->get();
        $Page          = "place_add";
        $Phones        = '[{"name":"Aruba","code":"AW","callingCode":"297"},{"name":"Afghanistan","code":"AF","callingCode":"93"},{"name":"Angola","code":"AO","callingCode":"244"},{"name":"Anguilla","code":"AI","callingCode":"1264"},{"name":"Ãland Islands","code":"AX","callingCode":"358"},{"name":"Albania","code":"AL","callingCode":"355"},{"name":"Andorra","code":"AD","callingCode":"376"},{"name":"United Arab Emirates","code":"AE","callingCode":"971"},{"name":"Argentina","code":"AR","callingCode":"54"},{"name":"Armenia","code":"AM","callingCode":"374"},{"name":"American Samoa","code":"AS","callingCode":"1684"},{"name":"Antigua and Barbuda","code":"AG","callingCode":"1268"},{"name":"Australia","code":"AU","callingCode":"61"},{"name":"Austria","code":"AT","callingCode":"43"},{"name":"Azerbaijan","code":"AZ","callingCode":"994"},{"name":"Burundi","code":"BI","callingCode":"257"},{"name":"Belgium","code":"BE","callingCode":"32"},{"name":"Benin","code":"BJ","callingCode":"229"},{"name":"Burkina Faso","code":"BF","callingCode":"226"},{"name":"Bangladesh","code":"BD","callingCode":"880"},{"name":"Bulgaria","code":"BG","callingCode":"359"},{"name":"Bahrain","code":"BH","callingCode":"973"},{"name":"Bahamas","code":"BS","callingCode":"1242"},{"name":"Bosnia and Herzegovina","code":"BA","callingCode":"387"},{"name":"Saint BarthÃ©lemy","code":"BL","callingCode":"590"},{"name":"Belarus","code":"BY","callingCode":"375"},{"name":"Belize","code":"BZ","callingCode":"501"},{"name":"Bermuda","code":"BM","callingCode":"1441"},{"name":"Bolivia","code":"BO","callingCode":"591"},{"name":"Brazil","code":"BR","callingCode":"55"},{"name":"Barbados","code":"BB","callingCode":"1246"},{"name":"Brunei","code":"BN","callingCode":"673"},{"name":"Bhutan","code":"BT","callingCode":"975"},{"name":"Botswana","code":"BW","callingCode":"267"},{"name":"Central African Republic","code":"CF","callingCode":"236"},{"name":"Canada","code":"CA","callingCode":"1"},{"name":"Cocos (Keeling) Islands","code":"CC","callingCode":"61"},{"name":"Switzerland","code":"CH","callingCode":"41"},{"name":"Chile","code":"CL","callingCode":"56"},{"name":"China","code":"CN","callingCode":"86"},{"name":"Ivory Coast","code":"CI","callingCode":"225"},{"name":"Cameroon","code":"CM","callingCode":"237"},{"name":"DR Congo","code":"CD","callingCode":"243"},{"name":"Republic of the Congo","code":"CG","callingCode":"242"},{"name":"Cook Islands","code":"CK","callingCode":"682"},{"name":"Colombia","code":"CO","callingCode":"57"},{"name":"Comoros","code":"KM","callingCode":"269"},{"name":"Cape Verde","code":"CV","callingCode":"238"},{"name":"Costa Rica","code":"CR","callingCode":"506"},{"name":"Cuba","code":"CU","callingCode":"53"},{"name":"CuraÃ§ao","code":"CW","callingCode":"5999"},{"name":"Christmas Island","code":"CX","callingCode":"61"},{"name":"Cayman Islands","code":"KY","callingCode":"1345"},{"name":"Cyprus","code":"CY","callingCode":"357"},{"name":"Czechia","code":"CZ","callingCode":"420"},{"name":"Germany","code":"DE","callingCode":"49"},{"name":"Djibouti","code":"DJ","callingCode":"253"},{"name":"Dominica","code":"DM","callingCode":"1767"},{"name":"Denmark","code":"DK","callingCode":"45"},{"name":"Dominican Republic","code":"DO","callingCode":"1809"},{"name":"Dominican Republic","code":"DO","callingCode":"1829"},{"name":"Dominican Republic","code":"DO","callingCode":"1849"},{"name":"Algeria","code":"DZ","callingCode":"213"},{"name":"Ecuador","code":"EC","callingCode":"593"},{"name":"Egypt","code":"EG","callingCode":"20"},{"name":"Eritrea","code":"ER","callingCode":"291"},{"name":"Western Sahara","code":"EH","callingCode":"212"},{"name":"Spain","code":"ES","callingCode":"34"},{"name":"Estonia","code":"EE","callingCode":"372"},{"name":"Ethiopia","code":"ET","callingCode":"251"},{"name":"Finland","code":"FI","callingCode":"358"},{"name":"Fiji","code":"FJ","callingCode":"679"},{"name":"Falkland Islands","code":"FK","callingCode":"500"},{"name":"France","code":"FR","callingCode":"33"},{"name":"Faroe Islands","code":"FO","callingCode":"298"},{"name":"Micronesia","code":"FM","callingCode":"691"},{"name":"Gabon","code":"GA","callingCode":"241"},{"name":"United Kingdom","code":"GB","callingCode":"44"},{"name":"Georgia","code":"GE","callingCode":"995"},{"name":"Guernsey","code":"GG","callingCode":"44"},{"name":"Ghana","code":"GH","callingCode":"233"},{"name":"Gibraltar","code":"GI","callingCode":"350"},{"name":"Guinea","code":"GN","callingCode":"224"},{"name":"Guadeloupe","code":"GP","callingCode":"590"},{"name":"Gambia","code":"GM","callingCode":"220"},{"name":"Guinea-Bissau","code":"GW","callingCode":"245"},{"name":"Equatorial Guinea","code":"GQ","callingCode":"240"},{"name":"Greece","code":"GR","callingCode":"30"},{"name":"Grenada","code":"GD","callingCode":"1473"},{"name":"Greenland","code":"GL","callingCode":"299"},{"name":"Guatemala","code":"GT","callingCode":"502"},{"name":"French Guiana","code":"GF","callingCode":"594"},{"name":"Guam","code":"GU","callingCode":"1671"},{"name":"Guyana","code":"GY","callingCode":"592"},{"name":"Hong Kong","code":"HK","callingCode":"852"},{"name":"Honduras","code":"HN","callingCode":"504"},{"name":"Croatia","code":"HR","callingCode":"385"},{"name":"Haiti","code":"HT","callingCode":"509"},{"name":"Hungary","code":"HU","callingCode":"36"},{"name":"Indonesia","code":"ID","callingCode":"62"},{"name":"Isle of Man","code":"IM","callingCode":"44"},{"name":"India","code":"IN","callingCode":"91"},{"name":"British Indian Ocean Territory","code":"IO","callingCode":"246"},{"name":"Ireland","code":"IE","callingCode":"353"},{"name":"Iran","code":"IR","callingCode":"98"},{"name":"Iraq","code":"IQ","callingCode":"964"},{"name":"Iceland","code":"IS","callingCode":"354"},{"name":"Israel","code":"IL","callingCode":"972"},{"name":"Italy","code":"IT","callingCode":"39"},{"name":"Jamaica","code":"JM","callingCode":"1876"},{"name":"Jersey","code":"JE","callingCode":"44"},{"name":"Jordan","code":"JO","callingCode":"962"},{"name":"Japan","code":"JP","callingCode":"81"},{"name":"Kazakhstan","code":"KZ","callingCode":"76"},{"name":"Kazakhstan","code":"KZ","callingCode":"77"},{"name":"Kenya","code":"KE","callingCode":"254"},{"name":"Kyrgyzstan","code":"KG","callingCode":"996"},{"name":"Cambodia","code":"KH","callingCode":"855"},{"name":"Kiribati","code":"KI","callingCode":"686"},{"name":"Saint Kitts and Nevis","code":"KN","callingCode":"1869"},{"name":"South Korea","code":"KR","callingCode":"82"},{"name":"Kosovo","code":"XK","callingCode":"383"},{"name":"Kuwait","code":"KW","callingCode":"965"},{"name":"Laos","code":"LA","callingCode":"856"},{"name":"Lebanon","code":"LB","callingCode":"961"},{"name":"Liberia","code":"LR","callingCode":"231"},{"name":"Libya","code":"LY","callingCode":"218"},{"name":"Saint Lucia","code":"LC","callingCode":"1758"},{"name":"Liechtenstein","code":"LI","callingCode":"423"},{"name":"Sri Lanka","code":"LK","callingCode":"94"},{"name":"Lesotho","code":"LS","callingCode":"266"},{"name":"Lithuania","code":"LT","callingCode":"370"},{"name":"Luxembourg","code":"LU","callingCode":"352"},{"name":"Latvia","code":"LV","callingCode":"371"},{"name":"Macau","code":"MO","callingCode":"853"},{"name":"Saint Martin","code":"MF","callingCode":"590"},{"name":"Morocco","code":"MA","callingCode":"212"},{"name":"Monaco","code":"MC","callingCode":"377"},{"name":"Moldova","code":"MD","callingCode":"373"},{"name":"Madagascar","code":"MG","callingCode":"261"},{"name":"Maldives","code":"MV","callingCode":"960"},{"name":"Mexico","code":"MX","callingCode":"52"},{"name":"Marshall Islands","code":"MH","callingCode":"692"},{"name":"Macedonia","code":"MK","callingCode":"389"},{"name":"Mali","code":"ML","callingCode":"223"},{"name":"Malta","code":"MT","callingCode":"356"},{"name":"Myanmar","code":"MM","callingCode":"95"},{"name":"Montenegro","code":"ME","callingCode":"382"},{"name":"Mongolia","code":"MN","callingCode":"976"},{"name":"Northern Mariana Islands","code":"MP","callingCode":"1670"},{"name":"Mozambique","code":"MZ","callingCode":"258"},{"name":"Mauritania","code":"MR","callingCode":"222"},{"name":"Montserrat","code":"MS","callingCode":"1664"},{"name":"Martinique","code":"MQ","callingCode":"596"},{"name":"Mauritius","code":"MU","callingCode":"230"},{"name":"Malawi","code":"MW","callingCode":"265"},{"name":"Malaysia","code":"MY","callingCode":"60"},{"name":"Mayotte","code":"YT","callingCode":"262"},{"name":"Namibia","code":"NA","callingCode":"264"},{"name":"New Caledonia","code":"NC","callingCode":"687"},{"name":"Niger","code":"NE","callingCode":"227"},{"name":"Norfolk Island","code":"NF","callingCode":"672"},{"name":"Nigeria","code":"NG","callingCode":"234"},{"name":"Nicaragua","code":"NI","callingCode":"505"},{"name":"Niue","code":"NU","callingCode":"683"},{"name":"Netherlands","code":"NL","callingCode":"31"},{"name":"Norway","code":"NO","callingCode":"47"},{"name":"Nepal","code":"NP","callingCode":"977"},{"name":"Nauru","code":"NR","callingCode":"674"},{"name":"New Zealand","code":"NZ","callingCode":"64"},{"name":"Oman","code":"OM","callingCode":"968"},{"name":"Pakistan","code":"PK","callingCode":"92"},{"name":"Panama","code":"PA","callingCode":"507"},{"name":"Pitcairn Islands","code":"PN","callingCode":"64"},{"name":"Peru","code":"PE","callingCode":"51"},{"name":"Philippines","code":"PH","callingCode":"63"},{"name":"Palau","code":"PW","callingCode":"680"},{"name":"Papua New Guinea","code":"PG","callingCode":"675"},{"name":"Poland","code":"PL","callingCode":"48"},{"name":"Puerto Rico","code":"PR","callingCode":"1787"},{"name":"Puerto Rico","code":"PR","callingCode":"1939"},{"name":"North Korea","code":"KP","callingCode":"850"},{"name":"Portugal","code":"PT","callingCode":"351"},{"name":"Paraguay","code":"PY","callingCode":"595"},{"name":"Palestine","code":"PS","callingCode":"970"},{"name":"French Polynesia","code":"PF","callingCode":"689"},{"name":"Qatar","code":"QA","callingCode":"974"},{"name":"RÃ©union","code":"RE","callingCode":"262"},{"name":"Romania","code":"RO","callingCode":"40"},{"name":"Russia","code":"RU","callingCode":"7"},{"name":"Rwanda","code":"RW","callingCode":"250"},{"name":"Saudi Arabia","code":"SA","callingCode":"966"},{"name":"Sudan","code":"SD","callingCode":"249"},{"name":"Senegal","code":"SN","callingCode":"221"},{"name":"Singapore","code":"SG","callingCode":"65"},{"name":"South Georgia","code":"GS","callingCode":"500"},{"name":"Svalbard and Jan Mayen","code":"SJ","callingCode":"4779"},{"name":"Solomon Islands","code":"SB","callingCode":"677"},{"name":"Sierra Leone","code":"SL","callingCode":"232"},{"name":"El Salvador","code":"SV","callingCode":"503"},{"name":"San Marino","code":"SM","callingCode":"378"},{"name":"Somalia","code":"SO","callingCode":"252"},{"name":"Saint Pierre and Miquelon","code":"PM","callingCode":"508"},{"name":"Serbia","code":"RS","callingCode":"381"},{"name":"South Sudan","code":"SS","callingCode":"211"},{"name":"SÃ£o TomÃ© and PrÃ­ncipe","code":"ST","callingCode":"239"},{"name":"Suriname","code":"SR","callingCode":"597"},{"name":"Slovakia","code":"SK","callingCode":"421"},{"name":"Slovenia","code":"SI","callingCode":"386"},{"name":"Sweden","code":"SE","callingCode":"46"},{"name":"Swaziland","code":"SZ","callingCode":"268"},{"name":"Sint Maarten","code":"SX","callingCode":"1721"},{"name":"Seychelles","code":"SC","callingCode":"248"},{"name":"Syria","code":"SY","callingCode":"963"},{"name":"Turks and Caicos Islands","code":"TC","callingCode":"1649"},{"name":"Chad","code":"TD","callingCode":"235"},{"name":"Togo","code":"TG","callingCode":"228"},{"name":"Thailand","code":"TH","callingCode":"66"},{"name":"Tajikistan","code":"TJ","callingCode":"992"},{"name":"Tokelau","code":"TK","callingCode":"690"},{"name":"Turkmenistan","code":"TM","callingCode":"993"},{"name":"Timor-Leste","code":"TL","callingCode":"670"},{"name":"Tonga","code":"TO","callingCode":"676"},{"name":"Trinidad and Tobago","code":"TT","callingCode":"1868"},{"name":"Tunisia","code":"TN","callingCode":"216"},{"name":"Turkey","code":"TR","callingCode":"90"},{"name":"Tuvalu","code":"TV","callingCode":"688"},{"name":"Taiwan","code":"TW","callingCode":"886"},{"name":"Tanzania","code":"TZ","callingCode":"255"},{"name":"Uganda","code":"UG","callingCode":"256"},{"name":"Ukraine","code":"UA","callingCode":"380"},{"name":"Uruguay","code":"UY","callingCode":"598"},{"name":"United States","code":"US","callingCode":"1"},{"name":"Uzbekistan","code":"UZ","callingCode":"998"},{"name":"Vatican City","code":"VA","callingCode":"3906698"},{"name":"Vatican City","code":"VA","callingCode":"379"},{"name":"Saint Vincent and the Grenadines","code":"VC","callingCode":"1784"},{"name":"Venezuela","code":"VE","callingCode":"58"},{"name":"British Virgin Islands","code":"VG","callingCode":"1284"},{"name":"United States Virgin Islands","code":"VI","callingCode":"1340"},{"name":"Vietnam","code":"VN","callingCode":"84"},{"name":"Vanuatu","code":"VU","callingCode":"678"},{"name":"Wallis and Futuna","code":"WF","callingCode":"681"},{"name":"Samoa","code":"WS","callingCode":"685"},{"name":"Yemen","code":"YE","callingCode":"967"},{"name":"South Africa","code":"ZA","callingCode":"27"},{"name":"Zambia","code":"ZM","callingCode":"260"},{"name":"Zimbabwe","code":"ZW","callingCode":"263"}]';
        $Phones        = json_decode($Phones, true);
        $Ad            = $request->exists('ad') ? json_decode($request->ad) : null;

        return view('newthemplate.place_add', compact(['categories', 'subCategories', 'Page', 'Phones', 'Ad']));
    }

    public function get_title_ads(Request $request)
    {
        $q     = $request->input('phrase');
        $brand = $request->input('brand');
        $type  = $request->input('type');
        $model = $request->input('model');

        $Tags = DB::table('ads')
            ->select('adsName')
            ->where('adsName', 'like', $q . '%')
            ->where('adsStatus', '=', 'payed')
            ->where('parent_id', '=', null) // hide child ads
            ->WhereNull('deleted_at');

        if ($brand != NULL)
            $Tags->where('brand', $brand);

        if ($type != NULL)
            $Tags->where('type', $type);

        if ($model != NULL)
            $Tags->where('model', $model);

        $Tags = $Tags->get();

        $tags     = [];
        $tags_val = [];

        if (count($Tags) > 0) {
            foreach ($Tags as $Tag) {
                if (!in_array($Tag->adsName, $tags_val)) {
                    $tags_val[] = $Tag->adsName;
                    $tags[]     = (object)["name" => $Tag->adsName];
                }
            }
        }

        return response()->json($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'adsName'      => 'required|min:3|max:255',
            'adsPriceType' => 'required',
            'adsPrice'     => 'required|between:0,999999.99',
            'adsCountry'   => 'required',
            'adsRegion'    => 'required',
            'adsCity'      => 'required'
        ]);

        $adsImages = $request->adsImages;
        $adsTags   = $request->adsTags;
        $adParts   = $request->ad_parts;

        $request->offsetUnset('adsImages');
        $request->offsetUnset('adsTags');

        // admin creation from another user
        if (isset($request->userId) && Auth::user()->userRole == 'admin') {
            $request->merge(['userId' => $request->userId]);
        } else {
            $request->merge(['userId' => Auth::id()]);
        }

        // Resize preview
        if (!empty($request->adsImage)) {
            $preview  = Image::make(public_path($request->adsImage))->fit(317, 196);
            $filename = md5(substr(str_replace(' ', '', microtime() . microtime()), 0, 40) . time()) . '.' . pathinfo(public_path($request->adsImage), PATHINFO_EXTENSION); // file "uniqname.ext"
            $folder   = config('image.folder') . str_random(2) . '/' . str_random(2) . '/'; // save to folder
            $path     = public_path($folder); // full path for saving
            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            } // create dir if not exist
            $preview->save($path . $filename); // save resized image
            $request->merge(['adsImage' => $folder . $filename]); // change adsImage to preview
        }

        // Create ads
        $ads_data              = $request->all();
        $ads_data['adsStatus'] = 'pending for payment';
        unset($ads_data['number_card']);
        unset($ads_data['date_card']);
        unset($ads_data['cvv_card']);
        unset($ads_data['pay_type']);
        unset($ads_data['pay_token']);

        unset($ads_data['ad_parts']);

        if ($ads_data['adsPriceType'] == 'USD') {
            $ads_data['price_eur'] = $ads_data['adsPrice'] / Option::getSetting("opt_exchange_eur_usd");
        }

        if ($ads_data['adsPriceType'] == 'GBP') {
            $ads_data['price_eur'] = $ads_data['adsPrice'] / Option::getSetting("opt_exchange_eur_gbp");
        }

        if ($ads_data['adsPriceType'] == 'EUR') {
            $ads_data['price_eur'] = $ads_data['adsPrice'];
        }

        if ($ads_data['mileage_type'] == 'mi') {
            $ads_data['mileage_km'] = $ads_data['mileage'] / 0.62137;
        } else {
            $ads_data['mileage_km'] = $ads_data['mileage'];
        }

        if (!empty($request->pay_type) && !empty($request->pay_token)) {

            $ads_data['adsStatus'] = 'payed';


        }

        $ads_data['engine_size']     = floatval($ads_data['engine_size']);
        $ads_data['doors']           = intval($ads_data['doors']);
        $ads_data['previous_owners'] = intval($ads_data['previous_owners']);

        $id = 0;

        if (isset($ads_data['ad_id'])) {

            $ad = Ads::find($ads_data['ad_id']);

            if (!is_null($ad)) {

                $id = $ads_data['ad_id'];

                unset($ads_data['ad_id']);

                $ad->update($ads_data);

                Tag::where([
                    'adsId' => $id,
                    'type'  => 'form'
                ])->delete();

                AdsImages::where('adsId', '=', $id)
                    ->whereNotIn("id", $adsImages)
                    ->delete();

                if ($ads_data['adsStatus'] == 'payed') {

                    $this->mailSimpleSave($ad, $adsTags);

                }

            } else {

                return redirect("/place_add");

            }

        } else {

            $ad = Ads::create($ads_data);

            $id = $ad->id;

            if ($ads_data['adsStatus'] == 'payed') {

                $this->mailSimpleSave($ad, $adsTags);

            }

        }

        // Update child ads parent_id
        $update = array('parent_id' => $id);
        if ($ads_data['adsStatus'] == 'payed') {
            $update['adsStatus'] = 'payed';
        }
        if (!empty($adParts)) {
            Ads::whereIn('id', $adParts)
                ->where('parent_id', '=', null)
                ->update($update);
        }

        // Update uploaded images
        if (!empty($adsImages)) {
            AdsImages::whereIn('id', $adsImages)
                ->where('adsId', '=', null)
                ->update(['adsId' => $id]);
        }

        // Create tags
        $tags = array();
        if (!empty($adsTags)) {
            foreach ($adsTags as $adsTag) {
                $tags[] = array('adsId' => $id, 'type' => 'form', 'tagValue' => $adsTag);
            }
            Tag::insert($tags);
        }

        // Flash message
        $request->session()->flash('status', 'Ads added!');

        // Redirect to show page
        return redirect()->route('ads.add-details', ['ads' => $id]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ads $Ad)
    {
        $Ad->increment('adsViews');
        $images = \App\AdsImages::where('adsId', $Ad->id)->get();
        $AdHead = true;

        return view('newthemplate.add-details', compact(['Ad', 'images', 'AdHead']));
    }

    /**
     * Preview the specified resource.
     *
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function preview(Request $request)
    {

        return view('newthemplate.add-details-preview', [
            'Request' => $request->all()
        ]);

    }

    /**
     * Report the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        AdsReport::create($request->all());
        return response()->json(['success' => 'Ads reported']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Ads $ads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ads $ads)
    {
        $user = Auth::user();
        if ($user->id != $ads->userId) {
            return response()->json([
                'success' => false,
                'message' => 'Access Denied',
            ], Response::HTTP_FORBIDDEN);
        }
        $updatedData = $request->request->all();
        if (array_key_exists('reserved_user_id', $updatedData)) {
            $url     = route('product', [
                $ads->id,
            ]);
            $picture = [
                'src'  => $ads->images()->first()->thumb ?? '/mooimarkt/img/logo.svg',
                'link' => $url,
            ];
            if (isset($updatedData['reserved_user_id'])) {
                $notifierUser = User::find($updatedData['reserved_user_id']);
                $message      = '<a href="' . $url . '">' . $ads->adsName . '</a> ' . trans('reserved for you!');
                $notifierUser->saveNotification($message, $picture);
            } else {
                $notifierUser = User::find($ads->reserved_user_id);
                $message      = '<a href="' . $url . '">' . $ads->adsName . '</a> ' . trans('unreserved.');
                $notifierUser->saveNotification($message, $picture);
            }
        }
        $ads->update($updatedData);

        return response()->json([
            'success' => true,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Ads $ads
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ads $ads)
    {

        if ($ads->adsStatus == 'payed') {

            $adsTags = array_column($ads->tag->toArray(), 'tagValue');
            $this->mailSimpleSave($ads, $adsTags, false);

        }

        // delete images, tags etc before delete ads
        // $ads->delete();
    }

    public function mailSimpleSave(Ads $ads, $tags = array('Tag 1', 'x'), $created = true)
    {
        // return \App\SimpleSave::where('notify', true)
        $simpleSaves = \App\SimpleSave::where('notify', true)
            ->where(function ($query) use ($ads, $tags) {
                $query->where('s', 'LIKE', '%' . $ads->adsName . '%') // 'LIKE', '%'.$ads->adsName.'%'
                ->orWhere(function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhereRaw('JSON_CONTAINS(search->"$.tags", \'["' . $tag . '"]\')');
                    }
                });
            })
            ->where(function ($query) use ($ads) {
                $query->orWhere(function ($query) use ($ads) {
                    $query->where('cid', 0)
                        ->where('sid', 0);
                })
                    ->orWhere(function ($query) use ($ads) {
                        $query->orWhere('cid', $ads->subcategory->category->id)
                            ->orWhere('sid', $ads->subcategory->id);
                    });
            })
            ->get();

        foreach ($simpleSaves as $simpleSave) {
            if ($created) {
                Mail::to($simpleSave->user->email)->send(new \App\Mail\SimpleSaveAdsCreated($simpleSave, $ads));
            } else {
                Mail::to($simpleSave->user->email)->send(new \App\Mail\SimpleSaveAdsDeleted($simpleSave, $ads));
            }
        }

        return true;
    }

    public function adsLazyLoad(Request $request)
    {
        $ads = Ads::with(["tag", "subcategory", "favorites", "images"])
            ->where('parent_id', '=', null) // hide child ads
            ->where('adsStatus', '=', 'payed');

        $ads->join("sub_categories", "sub_categories.id", "=", "ads.subCategoryId")
            ->select("sub_categories.*", "ads.*");

        $cat    = $request->category ?? 0;
        $subcat = $request->sub_category ?? 0;

        if ($cat != 0) {
            $ads->where('sub_categories.categoryId', $cat);
        }

        if ($subcat != 0) {
            $ads->where('sub_categories.id', $subcat);
        }

        $sort_by = $request->input('type');

        $ads = $ads->get();

        if ($sort_by != null && strlen($sort_by) > 0) {
            switch ($sort_by) {
                case 'most_liked':
                    $ads = $ads->sortByDesc(function ($ad) {
                        return $ad->favorites->count();
                    });
                    break;
                case 'new':
                    $ads = $ads->sortByDesc('first_listed_at')->sortByDesc('created_at');
                    break;
            }
        }

        $ads = $this->paginate_collection($ads, $request->per_page);

        $response = $this->formatResponse('success', null, [
            'ads'       => view('site.inc.ads-list', ['ads' => $ads])->render(),
            'last_page' => $ads->lastPage() <= $request->page
        ]);
        return response($response, 200);
    }
}
