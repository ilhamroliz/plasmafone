<?php 
	use App\Http\Controllers\PlasmafoneController as Access;
?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		
		@include('partials._head')
        @yield('extra_style')

	</head>
	
	<!--

	TABLE OF CONTENTS.
	
	Use search to find needed section.
	
	===================================================================
	
	|  01. #CSS Links                |  all CSS links and file paths  |
	|  02. #FAVICONS                 |  Favicon links and file paths  |
	|  03. #GOOGLE FONT              |  Google font link              |
	|  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
	|  05. #BODY                     |  body tag                      |
	|  06. #HEADER                   |  header tag                    |
	|  07. #PROJECTS                 |  project lists                 |
	|  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
	|  09. #MOBILE                   |  mobile view dropdown          |
	|  10. #SEARCH                   |  search field                  |
	|  11. #NAVIGATION               |  left panel & navigation       |
	|  12. #RIGHT PANEL              |  right panel userlist          |
	|  13. #MAIN PANEL               |  main panel                    |
	|  14. #MAIN CONTENT             |  content holder                |
	|  15. #PAGE FOOTER              |  page footer                   |
	|  16. #SHORTCUT AREA            |  dropdown shortcuts area       |
	|  17. #PLUGINS                  |  all scripts and plugins       |
	
	===================================================================
	
	-->
	
	<!-- #BODY -->
	<!-- Possible Classes

		* 'smart-style-{SKIN#}'
		* 'smart-rtl'         - Switch theme mode to RTL
		* 'menu-on-top'       - Switch to top navigation (no DOM change required)
		* 'no-menu'			  - Hides the menu completely
		* 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
		* 'fixed-header'      - Fixes the header
		* 'fixed-navigation'  - Fixes the main menu
		* 'fixed-ribbon'      - Fixes breadcrumb
		* 'fixed-page-footer' - Fixes footer
		* 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
	-->
	<body class="menu-on-top fixed-header fixed-navigation fixed-page-footer">

		{{-- Modul Keuangan --}}
        @if(keuangan::periode()->emptyData() || keuangan::periode()->missing())
            <div class="ez-popup" id="trial-popup">
                <div class="layout sm">
                    <div class="top-popup" style="background: none;">
                        <span class="title">
                            @if(keuangan::periode()->emptyData())
                                Periode Keuangan Belum Dibuat
                            @elseif(keuangan::periode()->missing())
                                Periode Keuangan Telah Memasuki Bulan Baru
                            @endif
                        </span>
                    </div>

                    @if(keuangan::periode()->emptyData())
                        <form action="{{ route('modul_keuangan.periode.save') }}" method="POST" id="modul_keuangan_form_periode">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                            <div class="content-popup">
                                <div class="col-md-12" style="margin-top: 0px;">
                                    Sistem Kami Tidak Bisa Menemukan Satu Pun Periode Keuangan Yang Ada. Agar Semua Proses Pada Aplikasi Ini Dapat Berjalan Tanpa Kendala, Anda Harus Membuat Satu Periode Keuangan Sesuai Dengan Bulan Pembukaan (cut off) Yang Diinginkan. Nantinya Anda Juga Harus Membuat Periode Keuangan Baru Setiap Bulannya. 
                                </div>

                                <div class="col-md-12 text-center" style="margin-top: 25px; background: #eee; padding: 20px 40px; border-radius: 10px;">
                                    <div class="row">
                                        <div class="col-md-1 offset-1" style="background: none;">
                                            <i class="fa fa-calendar" style="font-size: 24pt;"></i>
                                        </div>

                                        <div class="col-md-3" style="padding: 7px 0px 0px 0px; font-style: italic; font-weight: bold">
                                            Pilih Bulan Cut Off
                                        </div>

                                        <div class="col-md-7" style="padding: 7px 0px 0px 20px; font-style: italic; font-weight: bold;">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <select class="form-control modul-keuangan" name="bulan">
                                                        @for($a = 0; $a < date('m'); $a++)
                                                            <option value="{{ getBulan()[$a]['value'] }}">{{ getBulan()[$a]['nama'] }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-md-1" style="padding: 2px 0px;"><i class="fa fa-minus"></i></div>

                                                <div class="col-md-4">
                                                    <select class="form-control modul-keuangan" name="tahun">
                                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-left" style="margin-top: 5px; border-top: 1px solid #eee; padding-top: 15px;">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="loader" style="display: none;" id="modul_keuangan_status_periode">
                                               <div class="loading"></div> &nbsp; <span>Sedang Memproses Periode Baru. Harap Tunggu...</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-sm" id="modul_keuangan_proses_periode">Proses Periode</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @elseif(keuangan::periode()->missing())
                        <form action="{{ route('modul_keuangan.periode.save') }}" method="POST" id="modul_keuangan_form_periode">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly>
                            <div class="content-popup">
                                <div class="col-md-12" style="margin-top: 0px;">
                                    Sepertinya Periode Keuangan Telah Memasuki Bulan Baru. Anda Tidak Bisa Menggunakan Fitur-FItur Pada Sistem Sebelum Membuat Periode Baru Tersebut. Buat Sekarang ? 
                                </div>

                                <div class="col-md-12 text-center" style="margin-top: 25px; background: #eee; padding: 20px 0px;">
                                    <div class="row">
                                        <div class="col-md-1 offset-1" style="background: none;">
                                            <i class="fa fa-calendar" style="font-size: 24pt;"></i>
                                        </div>

                                        <div class="col-md-3" style="padding: 7px 0px 0px 0px; font-style: italic; font-weight: bold">
                                            Periode baru
                                        </div>

                                        <div class="col-md-7" style="padding: 7px 0px 0px 20px; font-style: italic; font-weight: bold;">
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <select class="form-control modul-keuangan" name="bulan">
                                                        <option value="{{ getBulan()[(date('n') - 1)]['value'] }}">{{ getBulan()[(date('n') - 1)]['nama'] }}</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-1" style="padding: 2px 0px;"><i class="fa fa-minus"></i></div>

                                                <div class="col-md-4">
                                                    <select class="form-control modul-keuangan" name="tahun">
                                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-left" style="margin-top: 5px; border-top: 1px solid #eee; padding-top: 15px;">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="loader" style="display: none;" id="modul_keuangan_status_periode">
                                               <div class="loading"></div> &nbsp; <span>Sedang Memproses Periode Baru. Harap Tunggu...</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-sm" id="modul_keuangan_proses_periode">Proses Periode</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        @endif

		<div id="overlay">
			<div class="content-loader" style="background: none; width:60%; margin: 17em auto; text-align: center; color: #eee;">
				<h3><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></h3>
				<span id="load-status-text"></span>
			</div>
		</div>

		<!-- HEADER -->
			@include('partials._header')
		<!-- END HEADER -->

		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
			
			@include('partials._navigation')

		<!-- END NAVIGATION -->

		<!-- MAIN PANEL -->
		<div id="main" role="main">
			@yield('ribbon')
			@yield('main_content')

			<!-- Modal untuk Detil DN -->
			<div class="modal fade" id="detilDNModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel">Detail Minimum Stock</h4>

						</div>

						<div class="modal-body">
							<div class="row">

								<!-- Widget ID (each widget will need unique ID)-->
								<div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

									<header>
										<span class="widget-icon"> <i class="fa fa-table"></i> </span>
										<h2 id="title_detail">Detail Minimum Stock</h2>
									</header>

									<!-- widget div-->
									<div>

										<!-- widget content -->
										<div class="widget-body no-padding">
											<div class="table-responsive padding-bottom-10">

												<table class="table">
													<tbody>
														<tr class="success">
															<td style="width: 25%">
																<label style="float:left"><strong>Nama Barang</strong></label>
															</td>
															<td style="width: 5%">
																<label>:</label>
															</td>
															<td style="width: 70%">
																<label id="dnItem"></label>
															</td>
														</tr>
	
														<tr class="warning">
															<td style="width: 25%">
																<label style="float:left"><strong>Lokasi Barang</strong></label>
															</td>
															<td style="width: 5%">
																<label>:</label>
															</td>
															<td style="width: 70%">
																<label id="dnPosisi"></label>
															</td>
														</tr>

														<tr class="danger">
															<td style="width: 25%">
																<label style="float:left"><strong>Pemilik Barang</strong></label>
															</td>
															<td style="width: 5%">
																<label>:</label>
															</td>
															<td style="width: 70%">
																<label id="dnPemilik"></label>
															</td>
														</tr>

														<tr class="success">
															<td style="width: 25%">
																<label style="float:left"><strong>Minimum Stock</strong></label>
															</td>
															<td style="width: 5%">
																<label>:</label>
															</td>
															<td style="width: 70%">
																<label><b id="dnMinStock"></b> Unit</label>
															</td>
														</tr>

														<tr class="info">
															<td style="width: 25%">
																<label style="float:left"><strong>Qty Stock</strong></label>
															</td>
															<td style="width: 5%">
																<label>:</label>
															</td>
															<td style="width: 70%">
																<label><b id="dnQty"></b> Unit</label>
															</td>
														</tr>

													</tbody>													
												</table>

											</div>

										</div>
										<!-- end widget content -->
									</div>
									<!-- end widget div -->
								</div>
								<!-- end widget -->
							</div>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
		</div>
		<!-- END MAIN PANEL -->

		<!-- PAGE FOOTER -->
			@include('partials._footer')
		<!-- END PAGE FOOTER -->

		<!--================================================== -->

		@include('partials._script')
			@yield('extra_script')

		
	</body>

</html>
