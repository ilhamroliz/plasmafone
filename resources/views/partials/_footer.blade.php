<div class="page-footer">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<span class="txt-color-white">Sistem Informasi Plasmafone <span class="hidden-xs"></span> © {{ Carbon\Carbon::now('Asia/Jakarta')->format('Y') }}</span>
		</div>

		<div class="col-xs-6 col-sm-6 text-right hidden-xs">
			<div class="txt-color-white inline-block">
				<i class="txt-color-blueLight hidden-mobile">Last account activity <i class="fa fa-clock-o"></i> <strong>{{-- 52 mins ago &nbsp; --}}{{ App\Http\Controllers\PlasmafoneController::getActivity() }}</strong> </i>
				<div class="btn-group dropup">
					<button class="btn btn-xs dropdown-toggle bg-color-blue txt-color-white" data-toggle="dropdown">
						<i class="fa fa-link"></i> <span class="caret"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>