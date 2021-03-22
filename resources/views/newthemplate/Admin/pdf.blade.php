<!-- pdf.blade.php -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Ads ID{{ $ads->id }}</title>
    <!-- Theme style -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style>
  	    thead:before, thead:after,
  	    tbody:before, tbody:after,
  	    tfoot:before, tfoot:after
  	    {
  	        display: none;
  	    }
  	</style>
  </head>
  <body>
  	<h1><a href="{{ route('ads.add-details', ['ads' => $ads->id]) }}">{{ $ads->adsName }} ID{{ $ads->id }}</a></h1>
  	<table class="table table-inverse table-striped">
  		<thead>
  			<tr>
  				<th>Option</th>
  				<th>Value</th>
  			</tr>
  		</thead>
  		<tbody>
        <tr>
          <td>Category</td>
          <td>
            <ul class="list-inline">
              @if (!empty($ads->breadcrumb->where('type', 1)->first()))
              <li><a href="{{ route('home') }}">{{ $ads->breadcrumb->where('type', 1)->first()->content }}</a> ></li>
              @else
              <li><a href="{{ route('home') }}">Home</a> ></li>
              @endif

              <!-- <li><a href="#">Categories ></a></li> -->

              @if (!empty($ads->breadcrumb->where('type', 2)->first()))
              <li><a href="{{ route('ads.add-listing', ['categoryId' => $ads->subcategory->category->id]) }}">{{ $ads->breadcrumb->where('type', 2)->first()->content }}</a> ></li>
              @else
              @if (!empty($ads->subcategory->category))
              <li><a href="{{ route('ads.add-listing', ['categoryId' => $ads->subcategory->category->id]) }}">{{ $ads->subcategory->category->categoryName }}</a> ></li>
              @endif
              @endif

              @if (!empty($ads->breadcrumb->where('type', 3)->first()))
              <li><a href="{{ route('ads.add-listing', ['subCategoryId' => $ads->subcategory->id]) }}">{{ $ads->breadcrumb->where('type', 3)->first()->content }}</a> ></li>
              @else
              @if (!empty($ads->subcategory))
              <li><a href="{{ route('ads.add-listing', ['subCategoryId' => $ads->subcategory->id]) }}">{{ $ads->subcategory->subCategoryName }}</a> ></li>
              @endif
              @endif

              @if (!empty($ads->breadcrumb->where('type', 4)->first()))
              <li><a>{{ $ads->breadcrumb->where('type', 4)->first()->content }}</a></li>
              @else
              <li><a>{{ $ads->adsName }}</a></li>
              @endif

          </ul>
        </td>
        </tr>
        <tr>
          <td>User</td>
          <td><a href="{{ route('profile.show', ['profile' => $ads->userId ]) }}" class="view_profile">{{ $ads->UserAds->name or 'DELETED' }}</a></td>
        </tr>
        <tr>
          <td>Phone</td>
          <td><a href="tel:+{{ $ads->adsCallingCode }}{{ $ads->adsContactNo }}">+{{ $ads->adsCallingCode }} {{ $ads->adsContactNo }}</a></td>
        </tr>
        <tr>
          <td>Created</td>
          <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($ads->created_at))->diffForHumans() }} ({{ $ads->created_at }})</td>
        </tr>
        <tr>
          <td>{{ ($ads->adsViews > 1) ? 'Views' : 'View' }}</td>
          <td>{{ $ads->adsViews }} {{ ($ads->adsViews > 1) ? 'views' : 'view' }}</td>
        </tr>
        <tr>
          <td>Region</td>
          <td>{{ $ads->getCityRegionCountry() }}</td>
        </tr>
        <tr>
          <td>Status</td>
          <td>{{ $ads->adsStatus }}</td>
        </tr>
        <tr>
          <td>Payment Info</td>
          <td>@if ($ads->getBasePackage())
          {{ $ads->getBasePackage()->price }}EUR, {{ $ads->getBasePackage()->paymentStatus }}, {{ $ads->getBasePackage()->paymentChannel }}, {{ $ads->getBasePackage()->packageType }}
          @else
          -
          @endif
        </td>
        </tr>
        <tr>
          <td>Vocher</td>
          <td>{{ $ads->getBasePackage()->VoucherRedeem->Voucher->voucherCode or '-' }}</td>
        </tr>
        <tr>
          <td>Type</td>
          <td>{{ $ads->adsSelectedType }}</td>
        </tr>
        <tr>
  				<td>Description</td>
  				<td>{!! $ads->adsDescription !!}</td>
  			</tr>
        <tr>
          <td>Price</td>
          <td>{{ $ads->adsPriceWithType() }}</td>
        </tr>
  		</tbody>
  	</table>
  </body>
</html>