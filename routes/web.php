<?php

use App\Ads;
use App\Traits\SendMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

Auth::routes(['verify' => false]);

Route::get('/fast-login/{email}', function ($email) {
    $user = \App\User::where('email', $email)->first();
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect('/');
});

Route::get('/fast-login-id/{id}', function ($id) {
    $user = \App\User::find($id);
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect('/');
});

Route::get('/test', function () {
    //    auth()->user()->saveNotification('test message');

    SendMail::sendEmail(
        'New support request',
        'ivanenko.oleg.m@gmail.com',
        'contact@mooimarkt.nl',
        'mail.support',
        [
            'text' => 'test',
        ]
    );
});

Route::get("ajax_filter_country", "ListingController@ajax_filter_country");
Route::get("ajax_filter", "ListingController@ajax_filter");
Route::post("/card_detect", "AdsController@CardDetectFunct");

Route::get("/gtest", "GoogleSheetsController@Test");
Route::get("/ptest", "PaypalController@test");
Route::get("/vattest/{vat_number}", "UserController@verifyVat");

if (env('APP_ENV') === 'production') {
    URL::forceSchema('https');
}

Route::get('dialog/{id}', 'ChatController@dialog');
Route::get('dialog-list', 'ChatController@dialog_list');
Route::post("GetChat", "ChatController@GetChat");
Route::post("AddMessage", "ChatController@AddMessage");
Route::post("DeleteMessages", "ChatController@DeleteMessages");
Route::post("MarkMessagesRead", "ChatController@MarkMessagesRead");
Route::post("DeleteChat", "ChatController@DeleteChat");
Route::post("AddFile", "ChatController@AddFile");
Route::post("GetMessages", "ChatController@GetMessages");
Route::post("GetUnreadMessagesCount", "ChatController@GetUnreadMessagesCount");
Route::post("typing", "ChatController@typing");

Route::post('pay_cc/{summ}', 'AdsController@pay_cc');

//New Routes

//*********************************************
// Route::group(['middleware' => ['AllCheck']], function () {

//Policy Pages
Route::get('errorPage', function () {
    return view('user/errorPage');
});
//Policy Pages
Route::get('getTermsOfUse', function () {
    return view('user/termsofuse');
});

Route::get('getPrivacyPolicy', function () {
    return view('user/privacypolicy');
});

Route::get('getResetPasswordPage', array('as' => 'resetpassword', 'uses' => 'Auth\ResetPasswordController@getResetPasswordPage',));
Route::get('getForgetPasswordPage', array('as' => 'forgetpassword', 'uses' => 'Auth\ForgotPasswordController@getForgotPasswordPage',));
Route::post('getAdsDetailsPage', array('as' => 'adsdetails', 'uses' => 'AdsController@getAdsDetailsPage',));
Route::get('getEditAdsPage', array('as' => 'editads', 'uses' => 'AdsController@getEditAdsPage',));

//Pricing
Route::get('getPricingPage', array('as' => 'pricing', 'uses' => 'PricingController@getPricingPage',));
Route::get('PricingGetSubCategory', array('as' => 'subCategoryPricing', 'uses' => 'PricingController@PricingGetSubCategory',));
Route::get('getPricingBySubCategory', array('as' => 'pricingSubCategory', 'uses' => 'PricingController@getPricingBySubCategory',));

//login
Route::get('getLoginPage', 'User\LoginController@getLoginPage')->name('login');
Route::get('getRegisterPage', 'User\RegisterController@getRegisterPage')->name('register');
Route::post('userLogin', 'UserController@userLogin');
Route::post('registerUser', 'UserController@registerUser');
Route::post('registerUserAjax', 'UserController@registerUserAjax');
Route::post('ajaxlogin', 'UserController@userLoginAjax');
Route::post('forgetPassword', 'UserController@forgetPassword');
Route::post('forgetPasswordAjax', 'UserController@forgetPasswordAjax');
Route::get('changePassword/{email}/{token}', 'UserController@getChangePassword');
Route::post('changePassword/{email}/{token}', 'UserController@changePassword')->name('password.change');

Route::post('new-ajax-login', 'UserController@newLoginAjax');
Route::post('new-ajax-signup', 'UserController@newSignUpAjax');
Route::get('verifyEmail/{userId}', 'UserController@verifyEmail');

//browse Ads
Route::get('getAllAds', array('as' => 'allads', 'uses' => 'User\HomeController@getAllAds',));
Route::get('getAdsBySubCategory/{id}', array('as' => 'adsBySubCategory', 'uses' => 'User\HomeController@getAdsBySubCategory',));
Route::get('getAdsDetails/{id}', array('as' => 'adsdetailsid', 'uses' => 'User\HomeController@getAdsDetails',));
Route::get('getAdsByName/{title}', array('as' => 'adsByName', 'uses' => 'User\HomeController@getAdsByName',));
Route::get('filterData', 'User\HomeController@filterData');
Route::get('getFilterForm', 'User\HomeController@getFilterForm');
Route::get('getParentValue', 'User\HomeController@getParentValue');
Route::get('getParentValueWithAds', 'User\HomeController@getParentValueWithAds');
Route::get('filterDropDownCategory', 'User\HomeController@filterDropDownCategory');
Route::get('getSearchSuggestion', 'User\HomeController@getSearchSuggestion');
// Route::post('reportAds', 'User\HomeController@reportAds');


//Feedback
Route::post('sendFeedbackEmail', 'User\FeedbackController@sendFeedbackEmail');
Route::get('getFeedbackPage', array('as' => 'feedback', 'uses' => 'User\FeedbackController@getFeedbackPage',));

// Support
Route::post('/send-contact-email', 'UserController@sendContactEmail')->name('send_contact_email');


//test

Route::get('getIp', array('as' => 'ipaddress', 'uses' => 'TestController@getIp',));
Route::post('postIp', array('as' => 'postIp', 'uses' => 'TestController@postIp',));

Route::get('b4mxHome', 'HomeController@index');

//Route::get('test', 'User\HomeController@test');

//Social Login
Route::get('FacebookRedirect', 'SocialAuthFacebookController@redirect');
Route::get('b4mxFacebookCallback', 'SocialAuthFacebookController@callback');

Route::get('GoogleRedirect', 'SocialAuthGoogleController@redirect');
Route::get('b4mxGoogleCallback', 'SocialAuthGoogleController@callback');

Auth::routes();

Route::get('changeLocale', 'TranslationController@changeLocale');
Route::get('currency', 'CurrencyController@currency');

// });

// Route::group(['middleware' => ['ProfileCheck']], function () {

//Kelvin Added
Route::get('getActiveAdsPage', array('as' => 'activeads', 'uses' => 'User\ActiveAdsController@getActiveAdsPage',));
Route::get('getChatPage', array('as' => 'chat', 'uses' => 'User\ChatController@getChatPage',));
// Route::get('getFavouritesPage', array('as' => 'favouriteads', 'uses' => 'User\FavouritesController@getFavouritesPage',));
Route::get('getInboxPage', array('as' => 'inbox', 'uses' => 'User\InboxController@getInboxPage',));
Route::get('getPlaceAdsPage', array('as' => 'placeads', 'uses' => 'AdsController@getPlaceAdsPage',));
Route::get('getSearchAlertPage', array('as' => 'searchalert', 'uses' => 'User\SearchAlertController@getSearchAlertPage',));
Route::get('getReplyPage', array('as' => 'reply', 'uses' => 'User\ReplyController@getReplyPage',));

Route::get('paymentPage', array('as' => 'paymentPage', 'uses' => 'AdsController@paymentPage'));
Route::post('purchaseAddOn', 'AdsController@purchaseAddOn');
Route::post('applyVoucherCode', 'VoucherController@applyVoucherCode');


//Mail Templates
Route::get('getFeedbackMail', function () {
    return view('user/XXFeedbackMailTemplate');
});

//Get Country/State
Route::get('changeState', 'GeolocationController@changeState');

//Paypal
Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal', 'uses' => 'PaypalController@payWithPaypal',));
Route::post('paypal', array('as' => 'addmoney.paypal', 'uses' => 'PaypalController@postPaymentWithpaypal',));
Route::get('paypal', array('as' => 'payment.status', 'uses' => 'PaypalController@getPaymentStatus',));


//User
Route::post('ResetPassword', 'UserController@ResetPassword');


//Ads
Route::get('place_add', 'AdsController@create')->name('ads.place_add');
Route::get('add-listing', 'AdsController@index')->name('ads.add-listing');
Route::get('add-details/{Ad}', 'AdsController@show')->name('ads.add-details');
Route::post('ads/report', 'AdsController@report')->name('ads.report');
Route::post('add-details-preview', 'AdsController@preview')->name('ads.preview');
Route::post('update-add/{ads}', 'AdsController@update');
/*Route::resource('ads', 'AdsController');*/
Route::post('voucher/check', 'VoucherController@check');
Route::post('voucher-trader/check', 'VoucherTraderController@check');
Route::resource('activity', 'ActivityController');
Route::get('activity/{activity}', 'ActivityController@show');


// Favorite
Route::get('my-favorite', 'User\FavouritesController@favorite')->name('favorite.index');
Route::get('my-ads-listing', 'User\HomeController@myAds')->name('myAds.index');
Route::post('favorite/add/{id}/{type}', 'User\FavouritesController@add')->name('favorite.add');
Route::post('favorite/remove/{id}/{type}', 'User\FavouritesController@delete')->name('favorite.delete');

//Cart
Route::any('cart/add', 'CartController@add')->name('cart.add');

Route::get('placeAdsGotData', 'AdsController@placeAdsGotData');

Route::get('subCategories', 'CategoryController@subCategories');
Route::get('getSubCategory', 'AdsController@getSubCategory');
Route::get('getAllSubCategoryData', 'AdsController@getAllSubCategoryData');
Route::post('addNewAds', 'AdsController@addNewAds');
Route::post('deleteEditPageAds', 'AdsController@deleteEditPageAds');

//Translation
Route::get('flush', 'TranslationController@flush');

//ReplyMessage
Route::post('replyMessage', 'User\ReplyController@replyMessage');


//Inbox
Route::get('createNewInbox', array('as' => 'ads', 'uses' => 'User\InboxController@createNewInbox',));
Route::post('deleteInbox', 'User\InboxController@deleteInbox');
Route::post('archiveInbox', 'User\InboxController@archiveInbox');
Route::get('getInboxPageByName/{name}/{checkMethod}', array('as' => 'inboxes', 'uses' => 'User\InboxController@getInboxPageByName',));

//Favourite
// Route::post('deleteFavourite', 'User\FavouritesController@deleteFavourite');
// Route::post('addFavourite', 'User\FavouritesController@addFavourite');

//Form

//Search Criteria
Route::post('addSearchAlert', 'User\SearchAlertController@addSearchAlert');
Route::post('updateAlertActivated', 'User\SearchAlertController@updateAlertActivated');
Route::post('deleteSearchAlert', 'User\SearchAlertController@deleteSearchAlert');
Route::get('loadSearchCriteria', 'User\SearchAlertController@loadSearchCriteria');
Route::post('/searches/api', 'User\SearchAlertController@SaveSearchApi');
Route::get('/my_seved_searches', 'User\SearchAlertController@MySavedSearches');


//GeoLocation
Route::get('getGeolocation', 'GeolocationController@getGeolocation');

// });

Route::group(['middleware' => ['AdminCheck']], function () {

    //Dashboard
    Route::get('getDashBoardPage', 'ListingController@getDashBoardPage');

    //Package
    Route::get('getPackagePage', 'PackageController@getPackagePage');
    Route::get('getPackageSubCategory', 'PackageController@getPackageSubCategory');
    Route::get('getSubCategoryPackage', 'PackageController@getSubCategoryPackage');
    Route::post('save_package', 'PackageController@save_package');

    //User Admin
    Route::get('getUserPage', 'UserController@getUser');
    Route::post('addUser', 'UserController@addUser');
    Route::post('updateUser', 'UserController@updateUser');
    Route::post('deleteUser', 'UserController@deleteUser');
    Route::get('getUserTable', 'UserController@getUserTable');

    //Ads
    Route::get('getAdsPage', 'ListingController@getAdsPage');
    Route::get('getAdsTable', 'ListingController@getAdsTable');
    Route::post('deleteAds', 'ListingController@deleteAds');

    //Route::post('voucher/check', 'VoucherController@check');

    // Route::get('getVoucherPage', 'VoucherController@getVoucherPage');
    // Route::post('save_voucher', 'VoucherController@save_voucher');
    // //Route::get('getCategoryTable', 'CategoryController@getCategoryTable');
    // Route::get('getVoucherTable', 'VoucherController@getVoucherTable');
    // Route::post('updateVoucher', 'VoucherController@updateVoucher');
    // Route::post('deleteVoucher', 'VoucherController@deleteVoucher');

    //Form
    Route::get('getFormFieldTable', 'FormController@getFormFieldTable');
    Route::get('getFormFieldPage', 'FormController@getFormFieldPage');
    Route::post('addFormField', 'FormController@addFormField');
    Route::get('getParentField', 'FormController@getParentField');
    Route::post('updateFormField', 'FormController@updateFormField');
    Route::post('deleteFormField', 'FormController@deleteFormField');
    Route::post('updateFormFieldOption', 'FormController@updateFormFieldOption');
    Route::post('deleteFormFieldOption', 'FormController@deleteFormFieldOption');
    Route::get('toShareGetFormField', 'FormController@toShareGetFormField');

    Route::get('TestForAddParentName', 'FormController@TestForAddParentName');
    Route::get('TestForAddParentName2', 'FormController@TestForAddParentName2');

    //Form Option
    Route::get('getFormFieldOptionPage', 'FormController@getFormFieldOptionPage');
    Route::get('getFormFieldOptionTable', 'FormController@getFormFieldOptionTable');
    Route::post('addFormFieldOption', 'FormController@addFormFieldOption');
    Route::get('getFormOptionValue', 'FormController@getFormOptionValue');

    //Share Form
    Route::get('getShareFormFieldPage', 'FormController@getShareFormFieldPage');
    Route::get('getShareFormFieldTable', 'FormController@getShareFormFieldTable');
    Route::post('addShareFormField', 'FormController@addShareFormField');
    Route::post('deleteShareFormField', 'FormController@deleteShareFormField');

    //Translation
    Route::get('getTranslationPage', 'TranslationController@getTranslationPage');
    Route::get('getTranslationTable', 'TranslationController@getTranslationTable');
    Route::get('addForChinese', 'TranslationController@addForChinese');
    Route::post('updateTranslation', 'TranslationController@updateTranslation');

    //Category
    // Route::get('getCategoryPage', 'CategoryController@getCategory');
    // Route::get('getCategoryTable', 'CategoryController@getCategoryTable');
    // Route::post('addCategory', 'CategoryController@addCategory');
    // Route::post('updateCategory', 'CategoryController@updateCategory');
    // Route::post('deleteCategory', 'CategoryController@deleteCategory');

    //SubCategory
    // Route::get('getSubCategoryPage', 'SubCategoryController@getSubCategory');
    // Route::get('getSubCategoryTable', 'SubCategoryController@getSubCategoryTable');
    // Route::post('addSubCategory', 'SubCategoryController@addSubCategory');
    // Route::post('updateSubCategory', 'SubCategoryController@updateSubCategory');
    // Route::post('deleteSubCategory', 'SubCategoryController@deleteSubCategory');

    //Currency
    // Route::get('getCurrencyPage', 'CurrencyController@getCurrencyPage');
    // Route::get('getCurrencyTable', 'CurrencyController@getCurrencyTable');
    // Route::post('addCurrency', 'CurrencyController@addCurrency');
    // Route::post('updateCurrency', 'CurrencyController@updateCurrency');
    // Route::post('deleteCurrency', 'CurrencyController@deleteCurrency');

});

//No Check

Route::post('store-media', 'MediaController@storeMedia')->name('store_media');
Route::post('upload-image', 'MediaController@uploadImage')->name('uploadImage')->middleware('optimizeImages');
Route::post('delete-image', 'MediaController@deleteImage')->name('deleteImage');
Route::post('/get-cities/{country}', 'SiteController@get_cities')->name('get_cities');

Route::get('getAllAdsWithMailSearchAlert/{searchId}', array('as' => 'allads', 'uses' => 'User\HomeController@getAllAdsWithMailSearchAlert',));
Route::get('admin', 'ListingController@getAdminLoginPage');
Route::get('getProfilePage', array('as' => 'profile', 'uses' => 'User\ProfileController@getProfilePage',));
Route::post('updateUserProfile', 'UserController@updateUserProfile');
Route::get('updateUserProfile', 'UserController@updateUserProfile');
Route::get('getBlockedPage', 'UserController@getBlockedPage');
Route::post('adminLogin', 'ListingController@adminLogin');
Route::get('getMailEditAdsPage/{adsId}', 'User\ActiveAdsController@getMailEditAdsPage');
Route::get('cronSendCompleteAdsMail', 'AdsController@cronSendCompleteAdsMail');
Route::get('cronSendExpireMail', 'AdsController@cronSendExpireMail');
Route::get('cronSendSearchAlertMail', 'User\SearchAlertController@cronSendSearchAlertMail');


//New Routes
Route::get("logout", "ListingController@LogOut");

//Admin New Routes

Route::group(['prefix' => 'admin', 'middleware' => ['AdminCheck']], function () {

    Route::group(['prefix' => 'listings'], function () {
        Route::get('/', 'Admin\ListingsController@listings')->name('admin.listings.index');
        Route::get('/user/{user}', 'Admin\ListingsController@user')->name('admin.listings.show');
    });

    Route::group(['prefix' => 'tickets'], function () {
        Route::get('/', 'Admin\ListingsController@tickets');
        Route::get('/{tid}', 'Admin\ListingsController@ticket');
        Route::post('/api', 'Admin\ListingsController@ticket_api');
    });

    Route::get('listing-management/{ads}', 'Admin\ListingsController@show')->name('admin.ads.show');
    Route::get('listing-management/{ads}/pdf', 'Admin\ListingsController@pdf')->name('admin.ads.pdf');
    Route::get('edit-page/{ads}', 'Admin\ListingsController@edit')->name('admin.ads.edit');
    Route::patch('edit-page/{ads}', 'Admin\ListingsController@update')->name('admin.ads.update');
    Route::patch('edit-page/{ads}/breadcrumb', 'Admin\ListingsController@breadcrumb')->name('admin.ads.breadcrumb');
    Route::post('edit-page/{aid}/changestatus', 'Admin\ListingsController@ChaneAdsStatus')->name('admin.ads.changestatus');
    Route::get('edit-page/{ads}/destroy', 'Admin\ListingsController@destroy')->name('admin.ads.destroy');
    Route::post('edit-page/{ads}/storeimage', 'Admin\ListingsController@storeImage')->name('admin.ads.storeimage');
    Route::delete('edit-page/{adsimages}/destroyimage', 'Admin\ListingsController@destroyImage')->name('admin.ads.destroyimage');
    Route::get('payments', 'Admin\ListingsController@payments')->name('admin.ads.payments');

    // Route::post('ajaxlogin', 'ListingController@adminLoginAjax');

    Route::group(['prefix' => 'users'], function () {

        Route::get("/{page}", "Admin\UsersController@Pages");
        Route::post("place_add", "Admin\UsersController@Place_add");
        Route::post("remove/{uid}", "Admin\UsersController@RemoveUser");
        Route::post("confirm/{uid}", "Admin\UsersController@ConfirmUser");
        Route::post("type/{uid}", "Admin\UsersController@ChaneUserType");
        Route::post("retailer/{uid}", "Admin\UsersController@ChaneUserRetailer");
        Route::post("user", "Admin\UsersController@User");
        Route::post("upload_image", "Admin\UsersController@UploadImage");

    });

    Route::group(['prefix' => 'options'], function () {

        Route::post("/save", "Admin\OptionsController@save");
        Route::post("/upload", "Admin\OptionsController@upload");

    });

    Route::resource('voucher', 'VoucherController');
    Route::resource('voucher-trader', 'VoucherTraderController');
    Route::resource('category', 'Admin\CategoryController')->except(['show']);
    Route::resource('subcategory', 'Admin\SubCategoryController')->except(['show']);
    Route::get('filters/{subCategoryId}', 'Admin\FiltersController@allFilters')->name('admin.filters.show');
    Route::post('filters-sort-ajax/{subCategoryId}', 'Admin\FiltersController@sortAjax')->name('admin.filters.sortAjax');
    Route::get('filters/create/{subCategoryId}', 'Admin\FiltersController@create')->name('admin.filters.create');
    Route::post('filters/store/{subCategoryId}', 'Admin\FiltersController@store')->name('admin.filters.store');
    Route::post('filters/delete/{filterId}', 'Admin\FiltersController@delete')->name('admin.filters.delete');
    Route::get('filters/edit/{subCategoryId}/{filterId}', 'Admin\FiltersController@edit')->name('admin.filters.edit');
    Route::post('filters/update/{subCategoryId}/{filterId}', 'Admin\FiltersController@update')->name('admin.filters.update');

    Route::group(['prefix' => 'meetings'], function () {

        Route::get('/', 'Admin\ListingsController@meetings');
        Route::post("remove/{activity}", "ActivityController@destroy");

    });

    Route::resource('pages', 'PageController')->except(['show', 'create']);
    Route::get('add-page', 'PageController@create')->name('admin.pages.add-page');

    // Route::get('sitemap','Admin\SitemapController@setting')->name('admin.sitemap.setting');
    Route::post('sitemap/generate', 'Admin\SitemapController@generate')->name('admin.sitemap.generate');

    Route::get('admin-profile', 'Admin\UsersController@adminProfile')->name('admin_profile');
    Route::post('update-profile', 'Admin\UsersController@updateProfile')->name('update-profile');

    Route::get('{page}', 'ListingController@AdminPages');


    Route::prefix('languages')->as('languages.')->group(function () {
        Route::get('/list', 'Admin\LanguagesController@list')->name('list');
        Route::get('/create', 'Admin\LanguagesController@create')->name('create');
        Route::post('/store', 'Admin\LanguagesController@store')->name('store');
        Route::get('/edit/{language}', 'Admin\LanguagesController@edit')->name('edit');
        Route::post('/update/{language}', 'Admin\LanguagesController@update')->name('update');
        Route::get('/delete/{language}', 'Admin\LanguagesController@delete')->name('delete');
    });

    Route::prefix('words')->as('words.')->group(function () {
        Route::get('/list', 'Admin\WordsController@index')->name('list');
        Route::post('/create', 'Admin\WordsController@create')->name('create');
        Route::post('/update', 'Admin\WordsController@update')->name('update');

        Route::any('edit/{word}', 'Admin\WordsController@edit')->name('edit');
        Route::post('delete', 'Admin\WordsController@delete')->name('delete');

        Route::any('import', 'Admin\WordsController@import')->name('import');
        Route::any('export', 'Admin\WordsController@export')->name('export');

        Route::get('replace', 'Admin\WordsController@replace')->name('replace');
    });

    Route::prefix('qa')->as('qa.')->group(function () {
        Route::get('/categories', 'Admin\QAController@categoriesList')->name('categories.list');
        Route::get('/category/edit/{id}', 'Admin\QAController@categoryEdit')->name('category.edit');
        Route::post('/category/update/{id}', 'Admin\QAController@categoryUpdate')->name('category.update');
        Route::get('/category/create', 'Admin\QAController@categoryCreate')->name('category.create');
        Route::post('/category/store', 'Admin\QAController@categoryStore')->name('category.store');
        Route::delete('/category/delete/{id}', 'Admin\QAController@categoryDestroy')->name('category.destroy');

        Route::get('/items/{categoryID}', 'Admin\QAController@ItemsList')->name('items.list');
        Route::get('/item/edit/{id}', 'Admin\QAController@itemEdit')->name('item.edit');
        Route::post('/item/update/{id}', 'Admin\QAController@itemUpdate')->name('item.update');
        Route::get('/item/create', 'Admin\QAController@itemCreate')->name('item.create');
        Route::post('/item/store', 'Admin\QAController@itemStore')->name('item.store');
        Route::delete('/item/delete/{id}', 'Admin\QAController@itemDestroy')->name('itemDestroy.destroy');
    });

    Route::prefix('howWorks')->as('howWorks.')->group(function () {
        Route::get('/categories', 'Admin\HowWorksController@categoriesList')->name('categories.list');
        Route::get('/category/edit/{id}', 'Admin\HowWorksController@categoryEdit')->name('category.edit');
        Route::post('/category/update/{id}', 'Admin\HowWorksController@categoryUpdate')->name('category.update');
        Route::get('/category/create', 'Admin\HowWorksController@categoryCreate')->name('category.create');
        Route::post('/category/store', 'Admin\HowWorksController@categoryStore')->name('category.store');
        Route::delete('/category/delete/{id}', 'Admin\HowWorksController@categoryDestroy')->name('category.destroy');

        Route::get('/items/{categoryID}', 'Admin\HowWorksController@ItemsList')->name('items.list');
        Route::get('/item/edit/{id}', 'Admin\HowWorksController@itemEdit')->name('item.edit');
        Route::post('/item/update/{id}', 'Admin\HowWorksController@itemUpdate')->name('item.update');
        Route::get('/item/create', 'Admin\HowWorksController@itemCreate')->name('item.create');
        Route::post('/item/store', 'Admin\HowWorksController@itemStore')->name('item.store');
        Route::delete('/item/delete/{id}', 'Admin\HowWorksController@itemDestroy')->name('itemDestroy.destroy');
    });


});

Route::group(['prefix' => 'query'], function () {
    Route::get("ads", "User\HomeController@QueryAds");
});

Route::post("get_title_ads", "AdsController@get_title_ads");
Route::get("share/{type}", "HomeController@sharePage");

Route::resource('images', 'ImageController');

Route::get('mailSimpleSave/{ads}', 'AdsController@mailSimpleSave');

Route::group(['prefix' => 'settings'], function () {
    Route::get("general", "User\HomeController@QueryAds");
});
Route::get("/notification", "PageController@notification")->name('pages.notification');


//Route::get('messages','ChatController@messages')->name("myMessage")->Middleware('\App\Http\Middleware\CommonVariables');
Route::get('messages', 'ChatController@messages')->name("myMessage")->middleware(['commonVariables', 'lang']);

Route::get('new-message', function () {
    return view('site.profile.newMessage');
})->name("newMessage")->middleware(['commonVariables']);

Route::get('purchase', function () {
    return view('site.purchase');
});


Route::post('deleteProduct', 'User\SellsController@deleteProduct')->name('deleteProduct');
Route::post('/options/delete-slider', 'Admin\OptionsController@deleteSlider')->name('deleteSlider');

Route::post('/get-categories/{category}', 'User\SellsController@getCategories')->name('getCategories');
Route::post('/get-filters/{subCategory}/{locale}', 'User\SellsController@getFilters')->name('getFilters');
Route::post('/get-sub-filters/{filter}', 'User\SellsController@getSubFilters')->name('getSubFilters');
Route::post('/get-sub-filters-brand/{currentFilter}/{filter}', 'User\SellsController@getSubFiltersBrand')->name('getSubFiltersBrand');
Route::get("/google/back", "GoogleSheetsController@saveAuth");
Route::get("/google/import", "GoogleSheetsController@import");
Route::patch("/google/export", "GoogleSheetsController@export");
Route::get("/paypal/back/agreement", "PaypalController@agrementExecute");
Route::get("/paypal/renew/agreement", "PaypalController@agrementRenew");

Route::post("/ads-load", "AdsController@adsLazyLoad");
Route::post('/translate', 'SiteController@translate')->name('translate');
Route::post("/delete-notification", "User\ProfileController@deleteNotification");
Route::post("/read-notifications", "User\ProfileController@readNotifications");

Route::group(['middleware' => ['commonVariables', 'lang']], function () {
    Route::get('/set-language', 'User\HomeController@set_language')->name('set_language');
    Route::get('/', 'User\HomeController@index')->name('home');
    Route::get('/catalog/{categoryId?}/{subCategoryId?}', ['as' => 'adsByCategory', 'uses' => 'AdsController@index']);
    Route::get('/catalogs-filter', 'AdsController@catalogsFilter');
    Route::get('/search', 'AdsController@search')->name('search');
    Route::get("/how-it-works", "PageController@howItWorks")->name('pages.howItWorks');
    Route::get("/qa", "PageController@qaCategories")->name('pages.qaCategories');
    Route::get("/qa/{qaCategory}", "PageController@qaCategory")->name('pages.qaCategory');
    Route::get('product/{id}', 'User\SellsController@product')->name('product');
    Route::post('/get-products-filters', 'AdsController@getProductsFilters');
    Route::post('/check-search-type', 'AdsController@checkSearchType');

    Route::group(['middleware' => ['ProfileCheck']], function () {
        Route::prefix('notifications')->as('notifications.')->group(function () {
            Route::get('/', 'NotificationController@index')->name('index');
            Route::post('/get-new-notifications', 'NotificationController@getNewNotifications')->name('get-new-notifications');
        });

        Route::get("/notification", "PageController@notification")->name('pages.notification');
        Route::post('favorite/toggle/{id}', 'User\FavouritesController@toggle')->name('favorite.toggle');

        Route::prefix('profile')->as('profile.')->namespace('User')->group(function () {
            Route::prefix('settings')->as('settings.')->group(function () {
                Route::any('/', 'ProfileController@generalSettings')->name('general_settings');
                Route::any('/photo', 'ProfileController@profilePhoto')->name('profile_photo');
                Route::any('/email', 'ProfileController@profileEmail')->name('profile_email');
                Route::any('/password', 'ProfileController@password')->name('password');
                Route::get('/blocked-users', 'ProfileController@blockedUsers')->name('blocked_users');
                Route::post('/update-blocked-users', 'ProfileController@updateBlockedUsers')->name('update_blocked_users');
            });

            Route::get('/', 'ProfileController@index')->name('index');
            Route::post('/follower/{userId}', 'ProfileController@follower')->name('follower');
            Route::get('/get-followers/{userId}', 'ProfileController@getFollowers')->name('getFollowers');
            Route::get('/delete-account', 'ProfileController@deleteAccount')->name('deleteAccount');
            Route::get('/{user}/followers-list', 'ProfileController@followersList')->name('followers-list');
            Route::get('/{user}/{activity?}', 'ProfileController@show')->name('show');
        });

        Route::get('ads/{filter}', 'User\SellsController@ads')->name('ads');
        Route::post('/first-listed', 'User\SellsController@firstListed')->name('firstListed');
        Route::get('sell-now', 'User\SellsController@sellNow')->name('sellNow');
        Route::post('add-sell', 'User\SellsController@addSell')->name('addSell');
        Route::get('edit-sell/{sell}', 'User\SellsController@editSell')->name('editSell');
        Route::post('update-sell/{sell}', 'User\SellsController@updateSell')->name('updateSell');
        Route::get('favorites', 'User\SellsController@favorites')->name('favorites');
        Route::post('/extend-product', 'User\SellsController@extendProduct')->name('extendProduct');

        Route::get('wallet', 'User\WalletController@walletUp')->name('wallet_up');

        Route::post('payment-card', 'User\WalletController@paymentCard')->name('payment_card');
        Route::post('payment-pay-pal', 'User\WalletController@paymentPayPal')->name('payment_pay_pal');
        Route::get('payment-status-pay-pal', 'User\WalletController@paymentStatusPayPal')->name('payment_status_pay_pal');

        Route::post('payment_mollie', 'User\MollieAPI@preparePayment')->name('payment_mollie');
        Route::any('payment_mollie_success', 'User\MollieAPI@handleWebhookNotification')->name('payment_mollie_success');


        Route::post('payout-card', 'User\WalletController@payoutCard')->name('payout_card');
        Route::post('payout-pay-pal', 'User\WalletController@payoutPayPal')->name('payout_pay_pal');

        // Ads
        Route::post('pauseAds', 'ListingController@pauseAds');
        Route::post('resumeAds', 'ListingController@resumeAds');
    });

    Route::post('favorite/toggle/{id}', 'User\FavouritesController@toggle')->name('favorite.toggle');
    Route::get("/{page}", "PageController@show")->name('pages.show');
});









