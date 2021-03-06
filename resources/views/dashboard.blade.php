@extends('main')

@section('title', 'Dashboard')

@section('extra_style')

@endsection

@section('ribbon')
<!-- RIBBON -->
<div id="ribbon">

	<span class="ribbon-button-alignment"> 
		<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
			<i class="fa fa-refresh"></i>
		</span> 
	</span>

	<!-- breadcrumb -->
	<ol class="breadcrumb">
		<li>Home</li><li>Dashboard</li>
	</ol>
	<!-- end breadcrumb -->

		<!-- You can also add more buttons to the
		ribbon for further usability

		Example below:

		<span class="ribbon-button-alignment pull-right">
		<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
		<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
		<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
	</span> -->

</div>
<!-- END RIBBON -->
@endsection


@section('main_content')

<!-- MAIN CONTENT -->
<div id="content">
@if(Access::checkAkses(33, 'read'))
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
			<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Dashboard <span>> My Dashboard</span></h1>
		</div>
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
			<ul id="sparks" class="">
				<li class="sparks-info">
					<h5> My Income <span class="txt-color-blue">$47,171</span></h5>
					<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
						1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
					</div>
				</li>
				<li class="sparks-info">
					<h5> Site Traffic <span class="txt-color-purple"><i class="fa fa-arrow-circle-up"></i>&nbsp;45%</span></h5>
					<div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">
						110,150,300,130,400,240,220,310,220,300, 270, 210
					</div>
				</li>
				<li class="sparks-info">
					<h5> Site Orders <span class="txt-color-greenDark"><i class="fa fa-shopping-cart"></i>&nbsp;2447</span></h5>
					<div class="sparkline txt-color-greenDark hidden-mobile hidden-md hidden-sm">
						110,150,300,130,400,240,220,310,220,300, 270, 210
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<article class="col-sm-12 sortable-grid ui-sortable">
			<!-- new widget -->
			<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" role="widget">
				<!-- widget options:
				usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

				data-widget-colorbutton="false"
				data-widget-editbutton="false"
				data-widget-togglebutton="false"
				data-widget-deletebutton="false"
				data-widget-fullscreenbutton="false"
				data-widget-custombutton="false"
				data-widget-collapsed="true"
				data-widget-sortable="false"

				-->
				<header role="heading">
					<span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
					<h2>Live Feeds </h2>

					<ul class="nav nav-tabs pull-right in" id="myTab">
						<li class="active">
							<a data-toggle="tab" href="#s1"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Live Stats</span></a>
						</li>

						<li>
							<a data-toggle="tab" href="#s2"><i class="fa fa-facebook"></i> <span class="hidden-mobile hidden-tablet">Social Network</span></a>
						</li>

						<li>
							<a data-toggle="tab" href="#s3"><i class="fa fa-dollar"></i> <span class="hidden-mobile hidden-tablet">Revenue</span></a>
						</li>
					</ul>

				<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

				<!-- widget div-->
				<div class="no-padding" role="content">
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">

						test
					</div>
					<!-- end widget edit box -->

					<div class="widget-body">
						<!-- content -->
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
								<div class="row no-space">
									<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
										<span class="demo-liveupdate-1"> <span class="onoffswitch-title">Live switch</span> <span class="onoffswitch">
												<input type="checkbox" name="start_interval" class="onoffswitch-checkbox" id="start_interval">
												<label class="onoffswitch-label" for="start_interval"> 
													<span class="onoffswitch-inner" data-swchon-text="ON" data-swchoff-text="OFF"></span> 
													<span class="onoffswitch-switch"></span> </label> </span> </span>
										<div id="updating-chart" class="chart-large txt-color-blue" style="padding: 0px; position: relative;"><canvas class="flot-base" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 721px; height: 235px;" width="721" height="235"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; max-width: 65px; top: 220px; left: 25px; text-align: center;" class="flot-tick-label tickLabel">0</div><div style="position: absolute; max-width: 65px; top: 220px; left: 90px; text-align: center;" class="flot-tick-label tickLabel">10</div><div style="position: absolute; max-width: 65px; top: 220px; left: 159px; text-align: center;" class="flot-tick-label tickLabel">20</div><div style="position: absolute; max-width: 65px; top: 220px; left: 227px; text-align: center;" class="flot-tick-label tickLabel">30</div><div style="position: absolute; max-width: 65px; top: 220px; left: 295px; text-align: center;" class="flot-tick-label tickLabel">40</div><div style="position: absolute; max-width: 65px; top: 220px; left: 364px; text-align: center;" class="flot-tick-label tickLabel">50</div><div style="position: absolute; max-width: 65px; top: 220px; left: 432px; text-align: center;" class="flot-tick-label tickLabel">60</div><div style="position: absolute; max-width: 65px; top: 220px; left: 500px; text-align: center;" class="flot-tick-label tickLabel">70</div><div style="position: absolute; max-width: 65px; top: 220px; left: 568px; text-align: center;" class="flot-tick-label tickLabel">80</div><div style="position: absolute; max-width: 65px; top: 220px; left: 637px; text-align: center;" class="flot-tick-label tickLabel">90</div><div style="position: absolute; max-width: 65px; top: 220px; left: 702px; text-align: center;" class="flot-tick-label tickLabel">100</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; top: 203px; left: 12px; text-align: right;" class="flot-tick-label tickLabel">0</div><div style="position: absolute; top: 163px; left: 6px; text-align: right;" class="flot-tick-label tickLabel">20</div><div style="position: absolute; top: 123px; left: 6px; text-align: right;" class="flot-tick-label tickLabel">40</div><div style="position: absolute; top: 83px; left: 6px; text-align: right;" class="flot-tick-label tickLabel">60</div><div style="position: absolute; top: 43px; left: 6px; text-align: right;" class="flot-tick-label tickLabel">80</div><div style="position: absolute; top: 3px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">100</div></div></div><canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 721px; height: 235px;" width="721" height="235"></canvas></div>

									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">

										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> My Tasks <span class="pull-right">130/200</span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-blueDark" style="width: 65%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Transfered <span class="pull-right">440 GB</span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-blue" style="width: 34%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Bugs Squashed<span class="pull-right">77%</span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-blue" style="width: 77%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> User Testing <span class="pull-right">7 Days</span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-greenLight" style="width: 84%;"></div>
												</div> </div>

											<span class="show-stat-buttons"> <span class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="javascript:void(0);" class="btn btn-default btn-block hidden-xs">Generate PDF</a> </span> <span class="col-xs-12 col-sm-6 col-md-6 col-lg-6"> <a href="javascript:void(0);" class="btn btn-default btn-block hidden-xs">Report a bug</a> </span> </span>

										</div>

									</div>
								</div>

								<div class="show-stat-microcharts">
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

										<div class="easy-pie-chart txt-color-orangeDark" data-percent="33" data-pie-size="50">
											<span class="percent percent-sign">33</span>
										<canvas height="50" width="50"></canvas></div>
										<span class="easy-pie-title"> Server Load <i class="fa fa-caret-up icon-color-bad"></i> </span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-greenLight"><i class="fa fa-caret-up"></i> 97%</span>
											</li>
											<li>
												<span class="label bg-color-blueLight"><i class="fa fa-caret-down"></i> 44%</span>
											</li>
										</ul>
										<div class="sparkline txt-color-greenLight hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent"><canvas style="display: inline-block; width: 70px; height: 33px; vertical-align: top;" width="70" height="33"></canvas></div>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<div class="easy-pie-chart txt-color-greenLight" data-percent="78.9" data-pie-size="50">
											<span class="percent percent-sign">79</span>
										<canvas height="50" width="50"></canvas></div>
										<span class="easy-pie-title"> Disk Space <i class="fa fa-caret-down icon-color-good"></i></span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-blueDark"><i class="fa fa-caret-up"></i> 76%</span>
											</li>
											<li>
												<span class="label bg-color-blue"><i class="fa fa-caret-down"></i> 3%</span>
											</li>
										</ul>
										<div class="sparkline txt-color-blue hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent"><canvas style="display: inline-block; width: 70px; height: 33px; vertical-align: top;" width="70" height="33"></canvas></div>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<div class="easy-pie-chart txt-color-blue" data-percent="23" data-pie-size="50">
											<span class="percent percent-sign">23</span>
										<canvas height="50" width="50"></canvas></div>
										<span class="easy-pie-title"> Transfered <i class="fa fa-caret-up icon-color-good"></i></span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-darken">10GB</span>
											</li>
											<li>
												<span class="label bg-color-blueDark"><i class="fa fa-caret-up"></i> 10%</span>
											</li>
										</ul>
										<div class="sparkline txt-color-darken hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent"><canvas style="display: inline-block; width: 70px; height: 33px; vertical-align: top;" width="70" height="33"></canvas></div>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<div class="easy-pie-chart txt-color-darken" data-percent="36" data-pie-size="50">
											<span class="percent degree-sign">36</span>
										<canvas height="50" width="50"></canvas></div>
										<span class="easy-pie-title"> Temperature <i class="fa fa-caret-down icon-color-good"></i></span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-red"><i class="fa fa-caret-up"></i> 124</span>
											</li>
											<li>
												<span class="label bg-color-blue"><i class="fa fa-caret-down"></i> 40 F</span>
											</li>
										</ul>
										<div class="sparkline txt-color-red hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent"><canvas style="display: inline-block; width: 70px; height: 33px; vertical-align: top;" width="70" height="33"></canvas></div>
									</div>
								</div>

							</div>
							<!-- end s1 tab pane -->

							<div class="tab-pane fade" id="s2">
								<div class="widget-body-toolbar bg-color-white">

									<form class="form-inline" role="form">

										<div class="form-group">
											<label class="sr-only" for="s123">Show From</label>
											<input type="email" class="form-control input-sm" id="s123" placeholder="Show From">
										</div>
										<div class="form-group">
											<input type="email" class="form-control input-sm" id="s124" placeholder="To">
										</div>

										<div class="btn-group hidden-phone pull-right">
											<a class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> More <span class="caret"> </span> </a>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="javascript:void(0);"><i class="fa fa-file-text-alt"></i> Export to PDF</a>
												</li>
												<li>
													<a href="javascript:void(0);"><i class="fa fa-question-sign"></i> Help</a>
												</li>
											</ul>
										</div>

									</form>

								</div>
								<div class="padding-10">
									<div id="statsChart" class="chart-large has-legend-unique" style="padding: 0px; position: relative;"><canvas class="flot-base" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 235px;" width="100" height="235"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; max-width: 7px; top: 235px; left: 10px; text-align: center;" class="flot-tick-label tickLabel">JAN</div><div style="position: absolute; max-width: 7px; top: 235px; left: 17px; text-align: center;" class="flot-tick-label tickLabel">FEB</div><div style="position: absolute; max-width: 7px; top: 235px; left: 23px; text-align: center;" class="flot-tick-label tickLabel">MAR</div><div style="position: absolute; max-width: 7px; top: 235px; left: 30px; text-align: center;" class="flot-tick-label tickLabel">APR</div><div style="position: absolute; max-width: 7px; top: 235px; left: 37px; text-align: center;" class="flot-tick-label tickLabel">MAY</div><div style="position: absolute; max-width: 7px; top: 235px; left: 43px; text-align: center;" class="flot-tick-label tickLabel">JUN</div><div style="position: absolute; max-width: 7px; top: 235px; left: 50px; text-align: center;" class="flot-tick-label tickLabel">JUL</div><div style="position: absolute; max-width: 7px; top: 235px; left: 57px; text-align: center;" class="flot-tick-label tickLabel">AUG</div><div style="position: absolute; max-width: 7px; top: 235px; left: 63px; text-align: center;" class="flot-tick-label tickLabel">SEP</div><div style="position: absolute; max-width: 7px; top: 235px; left: 70px; text-align: center;" class="flot-tick-label tickLabel">OCT</div><div style="position: absolute; max-width: 7px; top: 235px; left: 77px; text-align: center;" class="flot-tick-label tickLabel">NOV</div><div style="position: absolute; max-width: 7px; top: 235px; left: 83px; text-align: center;" class="flot-tick-label tickLabel">DEC</div><div style="position: absolute; max-width: 7px; top: 235px; left: 90px; text-align: center;" class="flot-tick-label tickLabel">JAN+1</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; top: 225px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">0</div><div style="position: absolute; top: 171px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">20</div><div style="position: absolute; top: 118px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">40</div><div style="position: absolute; top: 64px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">60</div><div style="position: absolute; top: 10px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">80</div></div></div><canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 235px;" width="100" height="235"></canvas><div class="legend"><div style="position: absolute; width: 0px; height: 0px; top: -22px; right: 5px; opacity: 1;"> </div><table style="position:absolute;top:-22px;right:5px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style=""><div style="border:2px solid rgb(86,138,137);overflow:hidden"></div></div></td><td class="legendLabel"><span>Twitter</span></td><td class="legendColorBox"><div style=""><div style="border:2px solid rgb(50,118,177);overflow:hidden"></div></div></td><td class="legendLabel"><span>Facebook</span></td></tr></tbody></table></div></div>
								</div>

							</div>
							<!-- end s2 tab pane -->

							<div class="tab-pane fade" id="s3">

								<div class="widget-body-toolbar bg-color-white smart-form" id="rev-toggles">

									<div class="inline-group">

										<label for="gra-0" class="checkbox">
											<input type="checkbox" name="gra-0" id="gra-0" checked="checked">
											<i></i> Target </label>
										<label for="gra-1" class="checkbox">
											<input type="checkbox" name="gra-1" id="gra-1" checked="checked">
											<i></i> Actual </label>
										<label for="gra-2" class="checkbox">
											<input type="checkbox" name="gra-2" id="gra-2" checked="checked">
											<i></i> Signups </label>
									</div>

									<div class="btn-group hidden-phone pull-right">
										<a class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown"><i class="fa fa-cog"></i> More <span class="caret"> </span> </a>
										<ul class="dropdown-menu pull-right">
											<li>
												<a href="javascript:void(0);"><i class="fa fa-file-text-alt"></i> Export to PDF</a>
											</li>
											<li>
												<a href="javascript:void(0);"><i class="fa fa-question-sign"></i> Help</a>
											</li>
										</ul>
									</div>

								</div>

								<div class="padding-10">
									<div id="flotcontainer" class="chart-large has-legend-unique" style="padding: 0px; position: relative;"><canvas class="flot-base" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 235px;" width="100" height="235"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; max-width: 16px; top: 235px; left: 13px; text-align: center;" class="flot-tick-label tickLabel">2013</div><div style="position: absolute; max-width: 16px; top: 235px; left: 35px; text-align: center;" class="flot-tick-label tickLabel">2014</div><div style="position: absolute; max-width: 16px; top: 235px; left: 57px; text-align: center;" class="flot-tick-label tickLabel">2015</div><div style="position: absolute; max-width: 16px; top: 235px; left: 79px; text-align: center;" class="flot-tick-label tickLabel">2016</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; top: 225px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">0</div><div style="position: absolute; top: 182px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">250</div><div style="position: absolute; top: 139px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">500</div><div style="position: absolute; top: 96px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">750</div><div style="position: absolute; top: 53px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">1000</div><div style="position: absolute; top: 10px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">1250</div></div></div><canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 100px; height: 235px;" width="100" height="235"></canvas><div class="legend"><div style="position: absolute; width: 0px; height: 0px; top: -22px; right: 5px; opacity: 1;"> </div><table style="position:absolute;top:-22px;right:5px;;font-size:smaller;color:#545454"><tbody><tr><td class="legendColorBox"><div style=""><div style="border:2px solid rgb(147,19,19);overflow:hidden"></div></div></td><td class="legendLabel"><span>Target Profit</span></td><td class="legendColorBox"><div style=""><div style="border:2px solid #3276B1;overflow:hidden"></div></div></td><td class="legendLabel"><span>Actual Profit</span></td><td class="legendColorBox"><div style=""><div style="border:2px solid #71843F;overflow:hidden"></div></div></td><td class="legendLabel"><span>Actual Signups</span></td></tr></tbody></table></div></div>
								</div>
							</div>
							<!-- end s3 tab pane -->
						</div>

						<!-- end content -->
					</div>

				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->

		</article>
	</div>

	<!-- widget grid -->
	<section id="widget-grid" class="">

		<!-- row -->
		<div class="row">

		</div>

		<!-- end row -->

		<!-- row -->

		<div class="row">

		</div>

		<!-- end row -->
	</section>
	<!-- end widget grid -->
@endif
</div>
<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')
<!-- PAGE RELATED PLUGIN(S) -->

<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
<script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.cust.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.time.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.tooltip.min.js') }}"></script>

<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
<script src="{{ asset('template_asset/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

<!-- Full Calendar -->
<script src="{{ asset('template_asset/js/plugin/moment/moment.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/fullcalendar/jquery.fullcalendar.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {

				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				/*
				 * PAGE RELATED SCRIPTS
				 */

				$(".js-status-update a").click(function() {
					var selText = $(this).text();
					var $this = $(this);
					$this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
					$this.parents('.dropdown-menu').find('li').removeClass('active');
					$this.parent().addClass('active');
				});

				/*
				* TODO: add a way to add more todo's to list
				*/

				// initialize sortable
				$(function() {
					$("#sortable1, #sortable2").sortable({
						handle : '.handle',
						connectWith : ".todo",
						update : countTasks
					}).disableSelection();
				});

				// check and uncheck
				$('.todo .checkbox > input[type="checkbox"]').click(function() {
					var $this = $(this).parent().parent().parent();

					if ($(this).prop('checked')) {
						$this.addClass("complete");

						// remove this if you want to undo a check list once checked
						//$(this).attr("disabled", true);
						$(this).parent().hide();

						// once clicked - add class, copy to memory then remove and add to sortable3
						$this.slideUp(500, function() {
							$this.clone().prependTo("#sortable3").effect("highlight", {}, 800);
							$this.remove();
							countTasks();
						});
					} else {
						// insert undo code here...
					}

				})
				// count tasks
				function countTasks() {

					$('.todo-group-title').each(function() {
						var $this = $(this);
						$this.find(".num-of-tasks").text($this.next().find("li").size());
					});

				}

				/*
				* RUN PAGE GRAPHS
				*/

				/* TAB 1: UPDATING CHART */
				// For the demo we use generated data, but normally it would be coming from the server

				var data = [], totalPoints = 200, $UpdatingChartColors = $("#updating-chart").css('color');

				function getRandomData() {
					if (data.length > 0)
						data = data.slice(1);

					// do a random walk
					while (data.length < totalPoints) {
						var prev = data.length > 0 ? data[data.length - 1] : 50;
						var y = prev + Math.random() * 10 - 5;
						if (y < 0)
							y = 0;
						if (y > 100)
							y = 100;
						data.push(y);
					}

					// zip the generated y values with the x values
					var res = [];
					for (var i = 0; i < data.length; ++i)
						res.push([i, data[i]])
					return res;
				}

				// setup control widget
				var updateInterval = 1500;
				$("#updating-chart").val(updateInterval).change(function() {

					var v = $(this).val();
					if (v && !isNaN(+v)) {
						updateInterval = +v;
						$(this).val("" + updateInterval);
					}

				});

				// setup plot
				var options = {
					yaxis : {
						min : 0,
						max : 100
					},
					xaxis : {
						min : 0,
						max : 100
					},
					colors : [$UpdatingChartColors],
					series : {
						lines : {
							lineWidth : 1,
							fill : true,
							fillColor : {
								colors : [{
									opacity : 0.4
								}, {
									opacity : 0
								}]
							},
							steps : false

						}
					}
				};

				var plot = $.plot($("#updating-chart"), [getRandomData()], options);

				/* live switch */
				$('input[type="checkbox"]#start_interval').click(function() {
					if ($(this).prop('checked')) {
						$on = true;
						updateInterval = 1500;
						update();
					} else {
						clearInterval(updateInterval);
						$on = false;
					}
				});

				function update() {
					if ($on == true) {
						plot.setData([getRandomData()]);
						plot.draw();
						setTimeout(update, updateInterval);

					} else {
						clearInterval(updateInterval)
					}

				}

				var $on = false;

				/*end updating chart*/

				/* TAB 2: Social Network  */

				$(function() {
					// jQuery Flot Chart
					var twitter = [[1, 27], [2, 34], [3, 51], [4, 48], [5, 55], [6, 65], [7, 61], [8, 70], [9, 65], [10, 75], [11, 57], [12, 59], [13, 62]], facebook = [[1, 25], [2, 31], [3, 45], [4, 37], [5, 38], [6, 40], [7, 47], [8, 55], [9, 43], [10, 50], [11, 47], [12, 39], [13, 47]], data = [{
						label : "Twitter",
						data : twitter,
						lines : {
							show : true,
							lineWidth : 1,
							fill : true,
							fillColor : {
								colors : [{
									opacity : 0.1
								}, {
									opacity : 0.13
								}]
							}
						},
						points : {
							show : true
						}
					}, {
						label : "Facebook",
						data : facebook,
						lines : {
							show : true,
							lineWidth : 1,
							fill : true,
							fillColor : {
								colors : [{
									opacity : 0.1
								}, {
									opacity : 0.13
								}]
							}
						},
						points : {
							show : true
						}
					}];

					var options = {
						grid : {
							hoverable : true
						},
						colors : ["#568A89", "#3276B1"],
						tooltip : true,
						tooltipOpts : {
							//content : "Value <b>$x</b> Value <span>$y</span>",
							defaultTheme : false
						},
						xaxis : {
							ticks : [[1, "JAN"], [2, "FEB"], [3, "MAR"], [4, "APR"], [5, "MAY"], [6, "JUN"], [7, "JUL"], [8, "AUG"], [9, "SEP"], [10, "OCT"], [11, "NOV"], [12, "DEC"], [13, "JAN+1"]]
						},
						yaxes : {

						}
					};

					var plot3 = $.plot($("#statsChart"), data, options);
				});

				// END TAB 2

				// TAB THREE GRAPH //
				/* TAB 3: Revenew  */

				$(function() {

					var trgt = [[1354586000000, 153], [1364587000000, 658], [1374588000000, 198], [1384589000000, 663], [1394590000000, 801], [1404591000000, 1080], [1414592000000, 353], [1424593000000, 749], [1434594000000, 523], [1444595000000, 258], [1454596000000, 688], [1464597000000, 364]], prft = [[1354586000000, 53], [1364587000000, 65], [1374588000000, 98], [1384589000000, 83], [1394590000000, 980], [1404591000000, 808], [1414592000000, 720], [1424593000000, 674], [1434594000000, 23], [1444595000000, 79], [1454596000000, 88], [1464597000000, 36]], sgnups = [[1354586000000, 647], [1364587000000, 435], [1374588000000, 784], [1384589000000, 346], [1394590000000, 487], [1404591000000, 463], [1414592000000, 479], [1424593000000, 236], [1434594000000, 843], [1444595000000, 657], [1454596000000, 241], [1464597000000, 341]], toggles = $("#rev-toggles"), target = $("#flotcontainer");

					var data = [{
						label : "Target Profit",
						data : trgt,
						bars : {
							show : true,
							align : "center",
							barWidth : 30 * 30 * 60 * 1000 * 80
						}
					}, {
						label : "Actual Profit",
						data : prft,
						color : '#3276B1',
						lines : {
							show : true,
							lineWidth : 3
						},
						points : {
							show : true
						}
					}, {
						label : "Actual Signups",
						data : sgnups,
						color : '#71843F',
						lines : {
							show : true,
							lineWidth : 1
						},
						points : {
							show : true
						}
					}]

					var options = {
						grid : {
							hoverable : true
						},
						tooltip : true,
						tooltipOpts : {
							//content: '%x - %y',
							//dateFormat: '%b %y',
							defaultTheme : false
						},
						xaxis : {
							mode : "time"
						},
						yaxes : {
							tickFormatter : function(val, axis) {
								return "$" + val;
							},
							max : 1200
						}

					};

					plot2 = null;

					function plotNow() {
						var d = [];
						toggles.find(':checkbox').each(function() {
							if ($(this).is(':checked')) {
								d.push(data[$(this).attr("name").substr(4, 1)]);
							}
						});
						if (d.length > 0) {
							if (plot2) {
								plot2.setData(d);
								plot2.draw();
							} else {
								plot2 = $.plot(target, d, options);
							}
						}

					};

					toggles.find(':checkbox').on('change', function() {
						plotNow();
					});
					plotNow()

				});

				/*
				 * VECTOR MAP
				 */

				data_array = {
					"US" : 4977,
					"AU" : 4873,
					"IN" : 3671,
					"BR" : 2476,
					"TR" : 1476,
					"CN" : 146,
					"CA" : 134,
					"BD" : 100
				};

				$('#vector-map').vectorMap({
					map : 'world_mill_en',
					backgroundColor : '#fff',
					regionStyle : {
						initial : {
							fill : '#c4c4c4'
						},
						hover : {
							"fill-opacity" : 1
						}
					},
					series : {
						regions : [{
							values : data_array,
							scale : ['#85a8b6', '#4d7686'],
							normalizeFunction : 'polynomial'
						}]
					},
					onRegionLabelShow : function(e, el, code) {
						if ( typeof data_array[code] == 'undefined') {
							e.preventDefault();
						} else {
							var countrylbl = data_array[code];
							el.html(el.html() + ': ' + countrylbl + ' visits');
						}
					}
				});

				/*
				 * FULL CALENDAR JS
				 */

				if ($("#calendar").length) {
					var date = new Date();
					var d = date.getDate();
					var m = date.getMonth();
					var y = date.getFullYear();

					var calendar = $('#calendar').fullCalendar({

						editable : true,
						draggable : true,
						selectable : false,
						selectHelper : true,
						unselectAuto : false,
						disableResizing : false,

						header : {
							left : 'title', //,today
							center : 'prev, next, today',
							right : 'month, agendaWeek, agenDay' //month, agendaDay,
						},

						select : function(start, end, allDay) {
							var title = prompt('Event Title:');
							if (title) {
								calendar.fullCalendar('renderEvent', {
									title : title,
									start : start,
									end : end,
									allDay : allDay
								}, true // make the event "stick"
								);
							}
							calendar.fullCalendar('unselect');
						},

						events : [{
							title : 'All Day Event',
							start : new Date(y, m, 1),
							description : 'long description',
							className : ["event", "bg-color-greenLight"],
							icon : 'fa-check'
						}, {
							title : 'Long Event',
							start : new Date(y, m, d - 5),
							end : new Date(y, m, d - 2),
							className : ["event", "bg-color-red"],
							icon : 'fa-lock'
						}, {
							id : 999,
							title : 'Repeating Event',
							start : new Date(y, m, d - 3, 16, 0),
							allDay : false,
							className : ["event", "bg-color-blue"],
							icon : 'fa-clock-o'
						}, {
							id : 999,
							title : 'Repeating Event',
							start : new Date(y, m, d + 4, 16, 0),
							allDay : false,
							className : ["event", "bg-color-blue"],
							icon : 'fa-clock-o'
						}, {
							title : 'Meeting',
							start : new Date(y, m, d, 10, 30),
							allDay : false,
							className : ["event", "bg-color-darken"]
						}, {
							title : 'Lunch',
							start : new Date(y, m, d, 12, 0),
							end : new Date(y, m, d, 14, 0),
							allDay : false,
							className : ["event", "bg-color-darken"]
						}, {
							title : 'Birthday Party',
							start : new Date(y, m, d + 1, 19, 0),
							end : new Date(y, m, d + 1, 22, 30),
							allDay : false,
							className : ["event", "bg-color-darken"]
						}, {
							title : 'Smartadmin Open Day',
							start : new Date(y, m, 28),
							end : new Date(y, m, 29),
							className : ["event", "bg-color-darken"]
						}],

						eventRender : function(event, element, icon) {
							if (!event.description == "") {
								element.find('.fc-event-title').append("<br/><span class='ultra-light'>" + event.description + "</span>");
							}
							if (!event.icon == "") {
								element.find('.fc-event-title').append("<i class='air air-top-right fa " + event.icon + " '></i>");
							}
						}
					});

				};

				/* hide default buttons */
				$('.fc-header-right, .fc-header-center').hide();

				// calendar prev
				$('#calendar-buttons #btn-prev').click(function() {
					$('.fc-button-prev').click();
					return false;
				});

				// calendar next
				$('#calendar-buttons #btn-next').click(function() {
					$('.fc-button-next').click();
					return false;
				});

				// calendar today
				$('#calendar-buttons #btn-today').click(function() {
					$('.fc-button-today').click();
					return false;
				});

				// calendar month
				$('#mt').click(function() {
					$('#calendar').fullCalendar('changeView', 'month');
				});

				// calendar agenda week
				$('#ag').click(function() {
					$('#calendar').fullCalendar('changeView', 'agendaWeek');
				});

				// calendar agenda day
				$('#td').click(function() {
					$('#calendar').fullCalendar('changeView', 'agendaDay');
				});

				/*
				 * CHAT
				 */

				$.filter_input = $('#filter-chat-list');
				$.chat_users_container = $('#chat-container > .chat-list-body')
				$.chat_users = $('#chat-users')
				$.chat_list_btn = $('#chat-container > .chat-list-open-close');
				$.chat_body = $('#chat-body');

				/*
				* LIST FILTER (CHAT)
				*/

				// custom css expression for a case-insensitive contains()
				jQuery.expr[':'].Contains = function(a, i, m) {
					return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
				};

				function listFilter(list) {// header is any element, list is an unordered list
					// create and add the filter form to the header

					$.filter_input.change(function() {
						var filter = $(this).val();
						if (filter) {
							// this finds all links in a list that contain the input,
							// and hide the ones not containing the input while showing the ones that do
							$.chat_users.find("a:not(:Contains(" + filter + "))").parent().slideUp();
							$.chat_users.find("a:Contains(" + filter + ")").parent().slideDown();
						} else {
							$.chat_users.find("li").slideDown();
						}
						return false;
					}).keyup(function() {
						// fire the above change event after every letter
						$(this).change();

					});

				}

				// on dom ready
				listFilter($.chat_users);

				// open chat list
				$.chat_list_btn.click(function() {
					$(this).parent('#chat-container').toggleClass('open');
				})

			});

		</script>

		<!-- Your GOOGLE ANALYTICS CODE Below -->
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	})();
</script>
@endsection