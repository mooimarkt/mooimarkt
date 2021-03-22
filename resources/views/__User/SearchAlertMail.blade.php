@extends('layouts.email')

@section('content')

<div>
	<table style="max-width: 600px; margin: 0 auto;">
		<tr>
			<td align="center" valign="top" style="border-collapse:collapse;text-align:left;font-size:15px;padding:10px">
				<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="m_2342644783441585776backgroundTable" style="margin:0;padding:10px;background-color:#ffffff;max-width:600px">
					<tbody>
						<tr>
							<td align="left" valign="top">
								<table width="100%" style="max-width:1000px">
									<tbody>
										<tr>
											<td>
												<h2 style="font-family:'lato',Helvetica,Arial,'Sans Serif';font-weight:normal;margin:10px 0 0;color:#444444">
												Hi {{ $users->name }}!</h2>
											</td>
										</tr>
										<tr>
											<td>We've found {{count($allAds)}}&nbsp;new ad for your saved search. </td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>

				<br/>

				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0;padding:10px;background-color:#ffffff">
					<tbody>
						<tr>
							<td align="left" valign="top"><a href="https://www.b4mx.com/search/alert/358894?emailalert=true#xtor=EPR-4-[searchAlert]-20170919-[viewAlert]-2403972@1" title="Cars" style="color:#444444;text-decoration:none" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=https://www.b4mx.com/search/alert/358894?emailalert%3Dtrue%23xtor%3DEPR-4-%5BsearchAlert%5D-20170919-%5BviewAlert%5D-2403972@1&amp;source=gmail&amp;ust=1522320314322000&amp;usg=AFQjCNGnfvkQhIBZGWor2FI0Vcu8SSeOeg">
								<table width="100%">
									<tbody>
										<tr>
											<td style="font-family:'lato',Helvetica,Arial,'Sans Serif';font-weight:normal;background-color:#f2f2f2;padding:13px">
												<table width="100%">
													<tbody>
														<tr>
															<td style="width:65%;font-family:'lato',Helvetica,Arial,'Sans Serif';font-weight:bold;color:#444444">
																<table>
																	<tbody>
																		<tr>
																			<td>{{$searchCriteria->searchTitle}}</td>
																		</tr>
																	</tbody>
																</table>
															</td>
															<td rowspan="2" style="width:35%;text-align:right;vertical-align:top;padding-top:4px">
																<a href="https://b4mx.com/getAllAdsWithMailSearchAlert/{{$encryptedId}}" title="See new ad" style="font-family:'lato',Helvetica,Arial,'Sans Serif';color:#00aaff;text-decoration:none;font-size:13px">See
				 new ads »</a>
															 </td>
														</tr>
														
														<tr>
															<td colspan="2" style="width:100%;font-family:'lato',Helvetica,Arial,'Sans Serif';color:#999999;font-size:12px">
															{{$searchCriteria->searchString}}
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>
									</tbody>
								</table>
							</a></td>
						</tr>
					</tbody>
				</table>

				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0;padding:10px">
				<tbody>
				<tr>
				<td align="left" valign="top">
				<table width="100%">
				<tbody>
				<tr>
				<td style="font-family:'lato',Helvetica,Arial,'Sans Serif';font-weight:normal;background-color:#fff;padding:0">
				<a href="https://www.b4mx.com/view/16691578#xtor=EPR-4-[searchAlert]-20170919-[viewMatchingAd]-2403972@1" title="06 bmw 3 series" style="text-decoration:none" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=https://www.b4mx.com/view/16691578%23xtor%3DEPR-4-%5BsearchAlert%5D-20170919-%5BviewMatchingAd%5D-2403972@1&amp;source=gmail&amp;ust=1522320314322000&amp;usg=AFQjCNGxG-GNUxxQlV-dq1mWlYfhswCeMw">
				</a></td>
				</tr>

				<tr>
				<td colspan="3" style="padding-top:3px">

				@foreach($allAds as $ad)
				<table width="100%" style="font-style:normal;font-variant-ligatures:normal;font-variant-caps:normal;font-weight:400;font-size:15px;font-family:&quot;Segoe UI Web (West European)&quot;,&quot;Segoe UI&quot;,-apple-system,BlinkMacSystemFont,Roboto,&quot;Helvetica Neue&quot;,sans-serif">
				<tbody>
				<tr>
				<td style="font-family:lato,Helvetica,Arial,&quot;Sans Serif&quot;;padding:0px"><a href="#">
				<table width="100%">
				<tbody>
				<tr>
				<td rowspan="4" valign="top" style="width:130px;padding-top:5px"><img width="120" height="90" src="https://b4mx.com/{{ $ad->adsImage }}" class="CToWUd"></td>
				<td valign="top" style="font-weight:bold;padding:4px 0px 0px;font-size:14px;color:rgb(68,68,68);line-height:18px">
				{{ $ad->adsName }}</td>
				</tr>
				<tr>
				<td>
				<table>
				<tbody>
				<tr>
				<td width="8" style="padding-left:0px"></td>
				<td style="color:rgb(153,153,153);font-size:12px">{{ $ad->adsRegion }}, {{ $ad->adsCountry }}</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				<tr>
				<td valign="top" style="color:rgb(68,68,68);font-weight:bold;font-size:12px;padding-top:4px">
				<span style="padding:2px;background-color:rgb(250,226,127);display:inline-block">EUR {{ $ad->adsPrice }}</span></td>
				</tr>
				<tr>
				<td style="height:12px">&nbsp;</td>
				</tr>
				</tbody>
				</table>
				</a></td>
				</tr>
				<tr>
				</tr>
				</tbody>
				</table>
				@endforeach

				<!-- End Loop Part -->

				<a href="https://b4mx.com/getAllAdsWithMailSearchAlert/{{$encryptedId}}" title="See new ad" style="font-family:'lato',Helvetica,Arial,'Sans Serif';color:#00aaff;text-decoration:none;font-size:13px">See
				 new ads »</a> </td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
				</tbody>
				</table>
				<table width="100%" style="max-width:600px">
				<tbody>
				<tr>
				<td style="width:100%;height:30px;line-height:24px;text-align:center;font-family:'lato',Helvetica,Arial,'Sans Serif';padding-bottom:16px;color:#444444">
				<strong>Getting too many emails?</strong> <br>
				<span style="display:block;font-size:13px;color:#444444">If you'd like to stop getting emails, you can update your
				<a href="https://b4mx.com/getSearchAlertPage" title="Change your alert settings" style="font-family:'lato',Helvetica,Arial,'Sans Serif';color:#00aaff;text-decoration:none;font-size:13px">
				alert settings here</a>.</span> </td>
				</tr>
				</tbody>
				</table>
			</td>
		</tr>
	</table>
</div>

@endsection