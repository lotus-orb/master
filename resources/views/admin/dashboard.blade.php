@extends('layouts.admin')

@section('content')
	<div class="content">
		<div class="panel-header bg-primary-gradient">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h2 class="text-white pb-2 fw-bold">Dashboard</h2>
						<h5 class="text-white op-7 mb-2">Free Bootstrap 4 Admin Dashboard</h5>
					</div>
					<div class="ml-md-auto py-2 py-md-0">
						<a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
						<a href="#" class="btn btn-secondary btn-round">Add Customer</a>
					</div>
				</div>
			</div>
		</div>
		<div class="page-inner mt--5">
			<div class="row mt--2">
				<div class="col-md-6">
					<div class="card full-height">
						<div class="card-body">
							<div class="card-title">Overall statistics</div>
							<div class="card-category">Daily information about statistics in system</div>
							<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
								<div class="px-2 pb-2 pb-md-0 text-center">
									<div id="circles-1"></div>
									<h6 class="fw-bold mt-3 mb-0">New Users</h6>
								</div>
								<div class="px-2 pb-2 pb-md-0 text-center">
									<div id="circles-2"></div>
									<h6 class="fw-bold mt-3 mb-0">Sales</h6>
								</div>
								<div class="px-2 pb-2 pb-md-0 text-center">
									<div id="circles-3"></div>
									<h6 class="fw-bold mt-3 mb-0">Subscribers</h6>
								</div>
							</div><hr/>
							<div class="card-title">Overall statistics</div>
							<div class="row py-3">
								<div class="col-md-4 d-flex flex-column justify-content-around">
									<div>
										<h6 class="fw-bold text-uppercase text-success op-8">Total Income</h6>
										<h3 class="fw-bold">$9.782</h3>
									</div>
									<div>
										<h6 class="fw-bold text-uppercase text-danger op-8">Total Spend</h6>
										<h3 class="fw-bold">$1,248</h3>
									</div>
								</div>
								<div class="col-md-8">
									<div id="chart-container">
										<canvas id="totalIncomeChart"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card full-height">
						<div class="card-header">
							<div class="card-title">Feed Activity</div>
						</div>
						<div class="card-body">
							<ol class="activity-feed">
								<li class="feed-item feed-item-secondary">
									<time class="date" datetime="9-25">Sep 25</time>
									<span class="text">Responded to need <a href="#">"Volunteer opportunity"</a></span>
								</li>
								<li class="feed-item feed-item-success">
									<time class="date" datetime="9-24">Sep 24</time>
									<span class="text">Added an interest <a href="#">"Volunteer Activities"</a></span>
								</li>
								<li class="feed-item feed-item-info">
									<time class="date" datetime="9-23">Sep 23</time>
									<span class="text">Joined the group <a href="single-group.php">"Boardsmanship Forum"</a></span>
								</li>
								<li class="feed-item feed-item-warning">
									<time class="date" datetime="9-21">Sep 21</time>
									<span class="text">Responded to need <a href="#">"In-Kind Opportunity"</a></span>
								</li>
								<li class="feed-item feed-item-danger">
									<time class="date" datetime="9-18">Sep 18</time>
									<span class="text">Created need <a href="#">"Volunteer Opportunity"</a></span>
								</li>
								<li class="feed-item">
									<time class="date" datetime="9-17">Sep 17</time>
									<span class="text">Attending the event <a href="single-event.php">"Some New Event"</a></span>
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')

<!-- Chart JS -->
<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>



<!-- Atlantis DEMO methods, don't include it in your project! -->
<script src="{{ asset('assets/js/setting-demo.js') }}"></script>
{{-- <script src="{{ asset('assets/js/demo.js') }}"></script> --}}
<script>
	Circles.create({
		id:'circles-1',
		radius:45,
		value:60,
		maxValue:100,
		width:7,
		text: 5,
		colors:['#f1f1f1', '#FF9E27'],
		duration:400,
		wrpClass:'circles-wrp',
		textClass:'circles-text',
		styleWrapper:true,
		styleText:true
	})

	Circles.create({
		id:'circles-2',
		radius:45,
		value:70,
		maxValue:100,
		width:7,
		text: 36,
		colors:['#f1f1f1', '#2BB930'],
		duration:400,
		wrpClass:'circles-wrp',
		textClass:'circles-text',
		styleWrapper:true,
		styleText:true
	})

	Circles.create({
		id:'circles-3',
		radius:45,
		value:40,
		maxValue:100,
		width:7,
		text: 12,
		colors:['#f1f1f1', '#F25961'],
		duration:400,
		wrpClass:'circles-wrp',
		textClass:'circles-text',
		styleWrapper:true,
		styleText:true
	})

	var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

	var mytotalIncomeChart = new Chart(totalIncomeChart, {
		type: 'bar',
		data: {
			labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
			datasets : [{
				label: "Total Income",
				backgroundColor: '#ff9e27',
				borderColor: 'rgb(23, 125, 255)',
				data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
			}],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				display: false,
			},
			scales: {
				yAxes: [{
					ticks: {
						display: false //this will remove only the label
					},
					gridLines : {
						drawBorder: false,
						display : false
					}
				}],
				xAxes : [ {
					gridLines : {
						drawBorder: false,
						display : false
					}
				}]
			},
		}
	});

	$('#lineChart').sparkline([105,103,123,100,95,105,115], {
		type: 'line',
		height: '70',
		width: '100%',
		lineWidth: '2',
		lineColor: '#ffa534',
		fillColor: 'rgba(255, 165, 52, .14)'
	});
</script>
@endsection