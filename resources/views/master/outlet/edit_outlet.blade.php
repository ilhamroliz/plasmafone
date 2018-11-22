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
			<li>Home</li><li>Master</li><li>Master Outlet</li><li>Edit</li>
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

					<form id="outlet-form" class="form-horizontal" method="post">
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

							<div class="row" style="border-bottom: 1px dotted #aaa; margin-bottom: 20px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Pilih Data Yang Diedit</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" name="select_cabang" id="select_cabang">
												@foreach($data as $key => $outlet)
													<option value="{{ $outlet->c_id }}">{{ $outlet->c_nama }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6 text-left" style="padding: 10px 0px; display: none;" id="form-load-section-status">
									<i class="fa fa-cog fa-spin fa-fw"></i> &nbsp;
									<small>Sedang Mengambil Data Baru...</small>
								</div>
							</div>

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
									<button class="btn btn-default" type="submit" id="submit">
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

			var select_cabang = document.getElementById('select_cabang').value;

			function isNumber(evt) {
			    evt = (evt) ? evt : window.event;
			    var charCode = (evt.which) ? evt.which : evt.keyCode;
			    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			        return false;
			    }
			    return true;
			}

			function get_outlet(){
				axios.get(baseUrl+'/master/outlet/get-outlet/'+select_cabang)
				.then((response) => {
					if(response.data == null){
						$.toast({
						    text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
						    showHideTransition: 'fade',
						    icon: 'error'
						})
						$('#form-load-section-status').fadeOut(200);
					}else{
						$('#outlet-form').data('bootstrapValidator').resetForm();
						initiate(response.data);
						$('#form-load-section-status').fadeOut(200);
					}
				})
				.catch((err) => {
					console.log(err);
				})
			}

			document.getElementById('select_cabang').addEventListener("change", function(evt){
				// alert(this.value);
				$('#form-load-section-status').fadeIn(200);
				axios.get(baseUrl+'/master/outlet/get-outlet/'+this.value)
				.then((response) => {
					console.log(response.data);
					if(response.data == null){
						$.toast({
						    text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
						    showHideTransition: 'fade',
						    icon: 'error'
						})
						$('#form-load-section-status').fadeOut(200);
					}else{
						$('#outlet-form').data('bootstrapValidator').resetForm();
						initiate2(response.data);
						$('#form-load-section-status').fadeOut(200);
					}
				})
				.catch((err) => {
					console.log(err);
				})
			});

			function initiate(data){
				// alert(data.c_kecamatan);
				$('#kecamatan option[value='+data.c_kecamatan+']').attr('selected','selected');
				$('#kota option[value='+data.c_kota+']').attr('selected','selected');
				$('#provinsi option[value='+data.c_provinsi+']').attr('selected','selected');
				$('#nama_outlet').val(data.c_nama);
				$('#telephone').val(data.c_telephone);
				$('#alamat').val(data.c_alamat);
				
			}
			function initiate2(data){
				// alert(data.c_kecamatan);
				document.getElementById('kecamatan').value = data.c_kecamatan;
				document.getElementById('kota').value = data.c_kota;
				document.getElementById('provinsi').value = data.c_provinsi;
				$('#nama_outlet').val(data.c_nama);
				$('#telephone').val(data.c_telephone);
				$('#alamat').val(data.c_alamat);
				
			}

			$(document).ready(function(){
				let g_k = get_kec();
				get_kota();
				get_prov();
				// Get kecamatan
				function get_kec(){
					$.get(baseUrl+'/master/outlet/get-kecamatan', function(data){
						// console.log(data);
						$.each(JSON.parse(data),function(idx, val){
							var opt = "<option value='"+ val.id + "'>"+ val.nama_kecamatan + "</option>";
							$('#kecamatan').append(opt);
						});
					});
				}

				// Get kota
				function get_kota(){
					$.get(baseUrl+'/master/outlet/get-kota', function(data){
						// console.log(data);
						$.each(JSON.parse(data),function(idx, val){
							var opt = "<option value='"+ val.id + "'>"+ val.nama_kota + "</option>";
							$('#kota').append(opt);
						});
					});
				}
				

				// Get provinsi
				function get_prov(){
					$.get(baseUrl+'/master/outlet/get-provinsi', function(data){
						// console.log(data);
						$.each(JSON.parse(data),function(idx, val){
							var opt = "<option value='"+ val.id + "'>"+ val.nama_provinsi + "</option>";
							$('#provinsi').append(opt);
						});
					});
				}
				
				// $('#select_cabang').change(function(evt){
				// 	evt.preventDefault(); let context = $(this);
				// 	$('#form-load-section-status').fadeIn(200);

				// 	axios.get(baseUrl+'/master/outlet/get-outlet/'+context.val())
				// 	.then((response) => {
				// 		if(response.data == null){
				// 		$.toast({
				// 		    text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
				// 		    showHideTransition: 'fade',
				// 		    icon: 'error'
				// 		})
				// 		$('#form-load-section-status').fadeOut(200);
				// 	}else{
				// 		$('#outlet-form').data('bootstrapValidator').resetForm();
				// 		initiate(response.data);
				// 		$('#form-load-section-status').fadeOut(200);
				// 	}
				// 	})
				// 	.catch((err) => {
				// 		console.log(err);
				// 	})
					
				// })

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
				// var select_cabang = $('#select_cabang').val();

				if (select_cabang != "") {
					setTimeout('get_outlet()', 6000);
				}

				

				$('#outlet-form').submit(function(evt){
					evt.preventDefault();

					let btn = $('#submit');
					btn.attr('disabled', 'disabled');

					axios.post(baseUrl+'/master/outlet/update-outlet', $('#outlet-form').serialize())
					.then((response) => {
						if(response.data.status == 'berhasil'){
							$.toast({
							    text: 'Data Ini berhasil Diupdate',
							    showHideTransition: 'fade',
							    icon: 'success'
							})
						}else if(response.data.status == 'tidak ada'){
							$.toast({
							    text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
							    showHideTransition: 'fade',
							    icon: 'error'
							})
						}
					}).catch((err) => {
						console.log(err);
					}).then(function(){
						btn.removeAttr('disabled');
					})
				});

				// End select order
			})
		</script>

@endsection