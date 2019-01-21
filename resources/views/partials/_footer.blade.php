<div class="page-footer">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<span class="txt-color-white">Powered by Alamraya Sebar Barokah <span class="hidden-xs"></span> <span id="logoFooter"> <img src="{{ asset('template_asset/img/alamraya.png') }}" alt="AlamrayaLogo" height="15"></span> {{ Carbon\Carbon::now('Asia/Jakarta')->format('Y') }}</span>
		</div>

		<div class="col-xs-6 col-sm-6 text-right hidden-xs">
			<div class="txt-color-white inline-block">
				{{-- <i class="txt-color-blueLight hidden-mobile">Last account activity <i class="fa fa-clock-o"></i> 
					<strong>{{ App\Http\Controllers\PlasmafoneController::getActivity() }}</strong> 
				</i> --}}
				<span id="logoFooter"> <img src="{{ asset('template_asset/img/logo_small.png') }}" alt="PlasmafoneLogo" height="15"> Plasmafone </span>
			</div>
		</div>
	</div>
</div>