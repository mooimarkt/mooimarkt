@extends('layouts.email')

@section('content')

<div>
	<table style="max-width: 600px; margin: 0 auto;">
		<tr>
			<td align="center" valign="top" style="border-collapse:collapse;text-align:left;font-size:15px;padding:10px">
			<table style="width:100%;padding:18px 18px 0 18px;max-width:600px;font-family:'lato',Helvetica,Arial,sans-serif">
			<tbody>
			<tr>
			<td align="left" valign="top">
			<div style="padding:0;width:100%;height:auto">
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%;height:auto;background-color:#fafafa;text-align:center;max-width:600px">
			<tbody>
			<tr>
			<td align="left" valign="top">
			<div style="padding:0;width:100%;height:auto">
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%;height:auto;background-color:#fafafa;text-align:center;max-width:600px">
			<tbody>
			<tr>
			<td align="center" valign="top" class="m_2342644783441585776emailTextIntro" style="color:#656565;padding:20px 0 0;font-weight:bold">
			Psst </td>
			</tr>
			<tr>
			<td style="color:#444444;font-size:22px;padding-top:5px;font-weight:bold">Almost there
			</td>
			</tr>
			</tbody>
			</table>
			</div>
			</td>
			</tr>
			<tr>
			<td valign="top">
				<div style="padding:0;width:100%;height:auto">

					<div class="item">

						<div class="recently-ads-item">
							<div data-id="{{ $adsId }}" class="adsClick" style="border-bottom: 1px solid #e0e0e0;">
								<img src="https://b4mx.com/{{ $ads->adsImage }}" style="width: 100%; height: auto;"/>
								<div class="row">
									<div style="padding-left: 20px;">
										<h6 class="recently-ads-title">{{ $ads->adsName }}</h6>
									</div>
								</div>
								<div class="row">
									<div style="padding-left: 20px;">
										<h6 class="recently-ads-details">{{ $ads->adsRegion }}, {{ $ads->adsCountry }}</h6>
									</div>
								</div>
								<div class="row">
									<div style="padding-left: 20px;">
										<br/>
									</div>
								</div>
								<br/>			
							</div>
						</div>
					</div>

				</div>
			</td>
			</tr>
			<tr>
			<td align="left" valign="top">
			<div style="padding:0;width:100%;height:auto">
			<table border="0" cellpadding="0" cellspacing="0" style="width:100%;height:auto;background-color:#fafafa;text-align:center;max-width:600px">
			<tbody>
			<tr>
			<td>&nbsp;</td>
			<td style="width:270px;color:#444444;font-size:18px;padding-top:5px;padding-bottom:12px;font-weight:bold">
			<div style="width:270px;margin:0;display:block"><a href="https://b4mx.com/getMailEditAdsPage/{{$adsId}}" style="margin-bottom:12px;height:44px;width:270px;line-height:43px;border-radius:4px;font-size:18px;border:1px solid #3b5998;background-color:#3b5998;display:inline-block;vertical-align:middle;font-weight:normal;text-decoration:none;text-align:center;color:#ffffff">Pay & Publish Now</a>
			<br>
			</div>
			</td>
			<td>&nbsp;</td>
			</tr>
			<tr>
			<td colspan="3" style="height:auto"><a href="{{ url('getActiveAdsPage') }}" title="Manage your ads" style="text-decoration:none;color:#0ae;font-size:16px;display:block">Manage
			 your ads</a> <br>
			<br>
			</td>
			</tr>
			</tbody>
			</table>
			</div>
			</td>
			</tr>
			</tbody>
			</table>
			</div>
			</td>
			</tr>
			</tbody>
			</table>
			<table style="width:100%;padding:18px 18px 0 18px;max-width:600px">
			<tbody>
			<tr>
			<td align="left" valign="top" class="m_2342644783441585776emailTextMain" style="background-color:#ffffff">
			<h2 style="font-family:'lato',Helvetica,Arial,'Sans Serif';font-weight:normal;font-size:24px;color:#444444">
			Hi {{$user->name}}! </h2><p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">
			We noticed that you didn't get around to completing your ad
			"<a href="{{ url('getActiveAdsPage') }}"><span style="color:blue;">{{ $ads->adsName }}</span></a>"
			
			</p><p style="color:#444444;font-family:'lato',Helvetica,Arial,'Sans Serif';font-size:18px">
			
			<a href="https://b4mx.com/getMailEditAdsPage/{{$adsId}}"><span style="color:blue;">Complete your ad</span></a> now to get it live and seen by over 500,000 awesome people.</p>
			
			</td>
			</tr>
			</tbody>
			</table>
			</td>
			</tr>
	</table>
</div>

@endsection