@extends('layouts.email')

@section('content')
<div>
<table style="max-width: 600px; margin: 0 auto;">
<tbody><tr>
  <td>   
    <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
      <tbody><tr>
        <td class="header">
          <table style="width:100%;padding:18px 18px 0 18px;max-width:600px">
          <tbody>
          <tr>
          <td align="left" valign="top" class="m_2342644783441585776emailTextMain" style="background-color:#ffffff">
          <h2 style="font-family:'lato',Helvetica,Arial,'Sans Serif';font-weight:normal;font-size:24px;color:#444444">
          Welcome Aboard {{$user->name}}! </h2>
          <p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">
          You are now ready to show your motocross to over 500,000 awesome people!
          </p><p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">
          
          <a href="https://moto.cgp.systems/getLoginPage" style="color: #444444; font-size: 20pt; text-decoration: underline; font-family: sans-serif;">Login Now</a> to sell your motocross right away!</p>
          
          </td>
          </tr>
          </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
    </td>
  </tr>
</tbody></table>

</div>

@endsection