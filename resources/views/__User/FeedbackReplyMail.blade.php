@extends('layouts.email')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">
  <table style="max-width: 600px;" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="center" valign="top" style="border-collapse:collapse;text-align:left;font-size:15px;padding:10px"> 
        <table style="width:100%;padding:18px 18px 0 18px;max-width:600px">
          <tbody><tr>
              <td align="left" valign="top" class="m_2342644783441585776m_1496718629191498406emailTextMain" style="background-color:#ffffff">
                  <h2 style="font-family:'lato',Helvetica,Arial,'Sans Serif';font-weight:normal;font-size:24px;color:#444444">
            
                              <div class="gmail_default" style="font-family:verdana,sans-serif;font-size:small;display:inline">​​</div>Hi There!
             
                  </h2><br/><p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">Thanks for getting in touch. Your request (<span style="color:blue;">{{$timeStamp}}</span>) has been received.</p>
          <p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">We want to let you know that we'll strive to respond to you as quickly as possible.</p>
          <br/>
                  <p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">
                      </p><p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">In the meantime, please check out our Help Centre. We've really helpful tips and guides so you might even find the answer to your question already waiting for you.</p><br/>
                      <p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">Thanks for your patience, speak to you soon.</p>
                      <div><br class="m_2342644783441585776webkit-block-placeholder"></div></td>
          </tr>
          </tbody>
        </table>
          </td>
      </tr>
    </tbody>
  </table>
</div>


@endsection