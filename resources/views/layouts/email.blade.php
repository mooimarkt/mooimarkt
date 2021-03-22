<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master1.css') }}" rel="stylesheet">
</head>
<body style="background-color: #f2f2f2;">
	<div class="container" style="background-color: #fff;">
        <div class="row">
            <div style="width:100%; background-color:#ffffff;border-bottom:5px solid #fad746;">
                <a href="https://www.b4mx.com/" style="text-decoration:none" target="_blank">
                    <img alt="b4mx" style="width:150px; height:50px; margin:10px; position: relative; top: 10px;" src="https://b4mx.com/img/logo/logo.png"></a>
            </div>
        </div>
        <div class="row">
            @yield('content')
        </div>
        <div class="row">
            <table style="max-width:600px; width: 100%; margin: 0 auto;">
                <tr>
                    <td style="height:1px">&nbsp;</td>
                </tr>
                <tr>
                    <td style="padding-left:10px">
                        <div style="font-size:17px;text-align:left;color:#555;font-family:'lato',Helvetica,Arial,sans-serif;line-height:normal">
                            <span><i>Kind regards,</i></span> <br>
                            <span>The 
                                <img alt="b4mx" style="width:90px; height:30px; position: relative; top: 10px;" src="https://b4mx.com/img/logo/logo.png"> Crew</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="height:1px">&nbsp;</td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div style="width:100%; background-color:#ffffff;border-bottom:5px solid #3b5998;">
                <table style="width:100%;background-color:#2b2b2b;text-align:center;margin-left:auto;margin-right:auto">
                    <tbody>
                        <tr>
                            <td style="text-align:center;width:100%;padding-top:10px">
                                <a href="https://www.b4mx.com/" style="text-decoration:none" target="_blank">
                                    <img alt="b4mx" style="width:150px; height:50px;" src="https://b4mx.com/img/logo/logo.png"></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center">
                                <table style="width:100%;font-size:13px;font-weight:200">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;width:25%">
                                                <a href="https://www.b4mx.com" style="color:#fff;text-decoration:underline">Home</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="https://b4mx.com/getTermsOfUse" style="color:#fff;text-decoration:underline">Terms of Use</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="https://b4mx.com/getPricingPage" style="color:#fff;text-decoration:underline">Pricing</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="https://b4mx.com/getFeedbackPage" style="color:#fff;text-decoration:underline">Contact Us</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <br>
                                                <p style="text-align:center;color:#fafafa;line-height:14px">B4MX Ltd., Ireland
                                                <br>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
