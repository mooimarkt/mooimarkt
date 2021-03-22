@extends('layouts.email')

@section('content')
<div>
<table style="max-width: 600px; margin: 0 auto;">
<tbody><tr>
  <td>   
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tbody><tr>
        <td class="header">
          <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">  
            <tbody><tr>
              <td height="70">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                  <tr>
                    <td class="h1" style="text-align: center; #444444; font-family: arial;">
                      Verify Your Email
                    </td>
                  </tr>
                </tbody></table>
              </td>
            </tr>
          </tbody></table>
        </td>
      </tr>
      <tr>
        <td class="innerpadding borderbottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
              <td class="bodycopy" style="text-align: center;">
                <br/><br/><br/>
                <a href="https://moto.cgp.systems/verifyEmail/{{$encryptedUserId}}" style="color: #444444; font-size: 20pt; text-decoration: underline; font-family: sans-serif;">Confirm Now</a>
                <br/><br/><br/><br/>
              </td>
            </tr>
            <tr>
              <td class="h4" style="font-family: 'Helvetica',sans-serif;">
                Hello!
              </td>
            </tr>
            <tr>
              <td class="bodycopy" style="font-family: 'Helvetica',sans-serif;">
                <br/>
                Thanks for signing up to B4MX. Click the button above to confirm your email address. Verifying is the easiest way for you to build trust in the B4MX community.
              </td>
            </tr>
          </tbody></table>
        </td>
      </tr>
    </tbody></table>
    </td>
  </tr>
</tbody></table>

</div>

@endsection