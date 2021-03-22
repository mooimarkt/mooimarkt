@extends('layouts.admin')

@section('content')

<div class="container-fluid dashboard-container">
	<div class="col-lg-12 col-md-12" style="margin-top: 25px">
		<h4 class="dashboard-h4">Reporting Dashboard</h4>
	</div>

	<div class="col-lg-4 col-md-4">
		<div class="dashboard-box">
			<label>Total Ads</label>
			<h6 class="dashboard-numbers">{{ $adsCount }}</h6>
		</div>
	</div>

	<div class="col-lg-4 col-md-4">
		<div class="dashboard-box">
			<label>Total Users</label>
			<h6 class="dashboard-numbers">{{ $userCount }}</h6>
		</div>
	</div>

	<div class="col-lg-4 col-md-4">
		<div class="dashboard-box">
			<label>Total Inbox</label>
			<h6 class="dashboard-numbers">{{ $inboxCount }}</h6>
		</div>
	</div>

	<div class="col-lg-4 col-md-4">
		<div class="dashboard-box">
			<label>Total Ads Views</label>
			<h6 class="dashboard-numbers">{{ $adsViewCount }}</h6>
		</div>
	</div>

	<div class="col-lg-4 col-md-4">
		<div class="dashboard-box">
			<label>Total Ads Reports</label>
			<h6 class="dashboard-numbers">{{ $adsReportCount }}</h6>
		</div>
	</div>

	<div class="col-lg-4 col-md-4">
		<div class="dashboard-box">
			<label>Total Transactions</label>
			<h6 class="dashboard-numbers">{{ $totalTransaction }}</h6>
		</div>
	</div>
</div>

@endsection