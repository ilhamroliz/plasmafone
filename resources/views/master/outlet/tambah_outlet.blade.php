@extends('main')

@section('title', 'Master Outlet')


@section('extra_style')

@endsection


@section('ribbon')
	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.." data-html="true" onclick="location.reload()">
				<i class="fa fa-refresh"></i>
			</span> 
		</span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Home</li><li>Master</li><li>Master Outlet</li><li>Tambah</li>
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

		@if(Session::has('flash_message_success'))
			<?php $mt = '0px'; ?>
			<div class="col-md-8" style="margin-top: 20px;">
				<div class="alert alert-success alert-block">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
					{{ Session::get('flash_message_success') }} 
				</div>
			</div>
		@elseif(Session::has('flash_message_error'))
			<?php $mt = '0px'; ?>
			<div class="col-md-8" style="margin-top: 20px;">
				<div class="alert alert-danger alert-block">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
					{{ Session::get('flash_message_error') }}
				</div>
			</div>
		@endif

		<!-- widget grid -->
		<section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">

			<!-- row -->
			<div class="row">

				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1" style="padding: 10px 20px; margin-top: 20px; background: #fff;">


					{{-- FormTemplate .. --}}

					<form id="outlet-form" class="form-horizontal" action="{{ url('/master/outlet/add-outlet') }}" method="post">
						{{ csrf_field() }}
						<fieldset>
							<legend>
								Form Tambah Master Outlet

								<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
									<a href="{{ url('/master/outlet') }}">
										<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
									</a>
								</span>
							</legend>

							<div class="field_wrapper">
								<div class="row" style="margin-top:15px;">

									<div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-xs-3 col-lg-3 control-label text-left">Nama Outlet</label>
												<div class="col-xs-8 col-lg-8 inputGroupContainer">
													<input type="text" class="form-control" name="nama_outlet" id="nama_outlet" placeholder="Masukkan nama outlet" />
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="col-xs-3 col-lg-3 control-label text-left">Telephone</label>
												<div class="col-xs-8 col-lg-8 inputGroupContainer">
													<input type="text" class="form-control" name="telephone" id="telephone" placeholder="Masukkan nomor telephone" onkeypress="return isNumber(event)" />
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="col-xs-3 col-lg-3 control-label text-left">Alamat</label>
												<div class="col-xs-8 col-lg-8 inputGroupContainer">
													<textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" rows="4"></textarea>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="col-xs-3 col-lg-3 control-label text-left">Kecamatan</label>
												<div class="col-xs-8 col-lg-8 inputGroupContainer">
													<select class="form-control chosen-select" tabindex="2" placeholder="Pilih kecamatan" name="kecamatan" id="kecamatan">
														<option value="">---Pilih Kecamatan---</option>
													</select>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="col-xs-3 col-lg-3 control-label text-left">Kota</label>
												<div class="col-xs-8 col-lg-8 inputGroupContainer">
													<select data-search="true" class="form-control" placeholder = "Pilih kota" name="kota" id="kota">
														<option value="">---Pilih Kota---</option>
													</select>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="col-xs-3 col-lg-3 control-label text-left">Provinsi</label>
												<div class="col-xs-8 col-lg-8 inputGroupContainer">
													<select data-search="true" class="form-control" placeholder = "Pilih provinsi" name="provinsi" id="provinsi">
														<option value="">---Pilih Provinsi---</option>
													</select>
												</div>
											</div>
										</div>
									</div>								

								</div>
							</div>

						</fieldset>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-default" type="submit">
										<i class="fa fa-floppy-o"></i>
										&nbsp;Submit
									</button>
								</div>
							</div>
						</div>
					</form>

					{{-- FormTemplate End .. --}}

				</div>
			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')
	
	<!-- PAGE RELATED PLUGIN(S) -->
	<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/choosen/chosen.jquery.js') }}"></script>
	<!-- <script src="{{ asset('template_asset/js/plugin/choosen/init.js') }}"></script> -->

		<script type="text/javascript">

			function isNumber(evt) {
			    evt = (evt) ? evt : window.event;
			    var charCode = (evt.which) ? evt.which : evt.keyCode;
			    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			        return false;
			    }
			    return true;
			}

			$(document).ready(function(){

				// $('select').selectstyle();
				// $('.chosen-select').chosen();

				// Get kecamatan
				$.get(baseUrl+'/master/outlet/get-kecamatan', function(data){
					// console.log(data);
					$.each(JSON.parse(data),function(idx, val){
						var opt = "<option value='"+ val.id + "'>"+ val.nama_kecamatan + "</option>";
						$('#kecamatan').append(opt);
					});
				});

				// Get kota
				$.get(baseUrl+'/master/outlet/get-kota', function(data){
					// console.log(data);
					$.each(JSON.parse(data),function(idx, val){
						var opt = "<option value='"+ val.id + "'>"+ val.nama_kota + "</option>";
						$('#kota').append(opt);
					});
				});

				// Get provinsi
				$.get(baseUrl+'/master/outlet/get-provinsi', function(data){
					// console.log(data);
					$.each(JSON.parse(data),function(idx, val){
						var opt = "<option value='"+ val.id + "'>"+ val.nama_provinsi + "</option>";
						$('#provinsi').append(opt);
					});
				});
				

				// product form

				$('#outlet-form').bootstrapValidator({
					feedbackIcons : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					fields : {
						nama_outlet : {
							validators : {
								notEmpty : {
									message : 'Isi nama outlet'
								}
							}
						},
						telephone : {
							validators : {
								notEmpty : {
									message : 'Isi nomor telephone outlet'
								}
							}
						},
						alamat : {
							validators : {
								notEmpty : {
									message : 'Isi alamat outlet'
								}
							}
						},
						kecamatan : {
							validators : {
								notEmpty : {
									message : 'Pilih kecamatan outlet'
								}
							}
						},
						kota : {
							validators : {
								notEmpty : {
									message : 'Pilih kota outlet'
								}
							}
						},
						provinsi : {
							validators : {
								notEmpty : {
									message : 'Pilih provinsi outlet'
								}
							}
						}
					}
				});

				// end product form


				// End select order
			})
		</script>

@endsection