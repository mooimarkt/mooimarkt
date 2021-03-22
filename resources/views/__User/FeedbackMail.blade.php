<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml"><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>A Simple Responsive HTML Email</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master1.css') }}" rel="stylesheet">
  <style type="text/css">
  body {margin: 0; padding: 0; min-width: 100%!important;}
  img {height: auto;}
  .content {width: 100%; max-width: 600px;}
  .header {padding: 40px 30px 20px 30px;}
  .innerpadding {padding: 30px 30px 30px 30px;}
  .borderbottom {border-bottom: 1px solid #f2eeed;}
  .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
  .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
  .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
  .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
  .bodycopy {font-size: 16px; line-height: 22px;}
  .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
  .button a {color: #ffffff; text-decoration: none;}
  .footer {padding: 20px 30px 15px 30px;}
  .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
  .footercopy a {color: #ffffff; text-decoration: underline;}

  @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
  body[yahoo] .hide {display: none!important;}
  body[yahoo] .buttonwrapper {background-color: transparent!important;}
  body[yahoo] .button {padding: 0px!important;}
  body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
  body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
  }

  {{ $timeStamp }}

  /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/

  </style>
</head>

<body yahoo="" bgcolor="#f6f8f1" style="">
<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
  <td>
    <!--[if (gte mso 9)|(IE)]>
      <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
    <![endif]-->     
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tbody><tr>
        <td bgcolor="#002450" class="header">
          <!--[if (gte mso 9)|(IE)]>
            <table width="425" align="left" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
          <![endif]-->
          <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 425px;">  
            <tbody><tr>
              <td height="70">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                  <tr>
                    <td class="h1" style="padding: 5px 0 0 0; color: white;">
                      Customer Feedback
                    </td>
                  </tr>
                </tbody></table>
              </td>
            </tr>
          </tbody></table>
          <!--[if (gte mso 9)|(IE)]>
                </td>
              </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
      <tr>
        <td class="innerpadding borderbottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td style="text-align:center;"><img class="fix" src="https://b4mx.com/img/logo/logo.png" width="100" height="100" border="0" alt=""></td>
            </tr>
            <tr>
              <td class="h4">
                Subject: <br/><span style="color: grey;">{{ $feedback->feedbackSubject }}</span>
              </td>
            </tr>
            <tr>
              <td class="bodycopy">
              <hr/>
                    <h4 style="color: black;"><span style="color: black;">Name: {{ $feedback->feedbackName }}</span></h4>
                    <h4 style="color: black;"><span style="color: black;">E-mail: {{ $feedback->feedbackEmail }}</span></h4>
                    <h4 style="color: black;"><span style="color: black;">Phone: {{ $feedback->feedbackPhone }}</span></h4>
                    <h4 style="color: black;"><span style="color: black;">{{ date('Y-m-d H:i:s') }}</span></h4>
                <hr/>
                    <h4 style="color: grey;"><span style="color: black;">Description</span></h4>
                    {{ $feedback->feedbackDescription }}
              </td>
            </tr>
          </tbody></table>
        </td>
      </tr>
      <tr>
        <td class="footer" bgcolor="#44525f">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
              <td align="center" class="footercopy">
                <span class="hide"> {{date('Y')}} B4MX. ALL RIGHTS RESERVED.</span>
              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 20px 0 0 0;">
                <table border="0" cellspacing="0" cellpadding="0">
                  <tbody><tr>
                    <td style="text-align: center; padding: 0 10px 0 10px;">
                      <a href="https://www.b4mx.com" style="color: #fff; text-decoration: none; font-family: sans-serif;">b4mx.com</a>
                    </td>
                  </tr>
                </tbody></table>
              </td>
            </tr>
          </tbody></table>
        </td>
      </tr>
    </tbody></table>
    <!--[if (gte mso 9)|(IE)]>
          </td>
        </tr>
    </table>
    <![endif]-->
    </td>
  </tr>
</tbody></table>



</body></html>