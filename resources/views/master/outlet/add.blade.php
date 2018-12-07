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
			<li>Home</li><li>Data Master</li><li>Tambah Master Outlet</li>
		</ol>
		<!-- end breadcrumb -->

	</div>
	<!-- END RIBBON -->
@endsection


@section('main_content')

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row hidden-mobile">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<h1 class="page-title txt-color-blueDark">

					<i class="fa-fw fa fa-asterisk"></i>

					Data Outlet <span><i class="fa fa-angle-double-right"></i> Tambah Data Outlet </span>

				</h1>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/master/outlet') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

				</div>

			</div>

		</div>

		<!-- widget grid -->
		<section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">

			@if(Session::has('flash_message_success'))
				<div class="col-md-12">
					<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
						{{ Session::get('flash_message_success') }} 
					</div>
				</div>
			@elseif(Session::has('flash_message_error'))
				<div class="col-md-12">
					<div class="alert alert-danger alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
						{{ Session::get('flash_message_error') }}
					</div>
				</div>
			@endif

			<!-- row -->
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>

							<h2><strong>Master Supplier</strong></h2>				
							
						</header>

						<div>
							
							<div class="widget-body">

								<form id="data-form" class="form-horizontal" method="post">
									{{ csrf_field() }}

									<fieldset>

										<legend>
											Form Tambah Supplier
										</legend>

										<div class="row">

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Nama Perusahaan</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-building"></i></span>

															<input type="text" class="form-control" name="nama_perusahaan" v-model="form_data.nama_perusahaan" placeholder="Masukkan Nama Perusahaan" style="text-transform: uppercase" />

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Nama Supplier</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-user"></i></span>

															<input type="text" class="form-control" name="nama_suplier" v-model="form_data.nama_suplier" placeholder="Masukkan Nama Supplier" style="text-transform: uppercase" />

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">No Telephone</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-phone"></i></span>

															<input type="text" class="form-control" name="telp_suplier" v-model="form_data.telp_suplier" placeholder="Masukkan Nomor Telepon" />

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Fax</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-fax"></i></span>

															<input type="text" class="form-control" name="fax_suplier" v-model="form_data.fax_suplier" placeholder="Masukkan Nomor Fax Supplier" />

														</div>

													</div>

												</div>

											</article>

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Limit</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-money"></i></span>
															
															<input type="text" class="form-control" id="limit" name="limit" placeholder="Masukkan Limitation"/>

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Alamat Supplier</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<textarea class="form-control" rows="5" style="resize: none;" placeholder="Masukkan Alamat Supplier" name="alamat_suplier" v-model="form_data.alamat_suplier"></textarea>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Keterangan</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<textarea class="form-control" rows="5" style="resize: none;" placeholder="Tambahkan Keterangan Tentang Supplier" name="keterangan" v-model="form_data.keterangan"></textarea>

													</div>

												</div>

											</article>
											
										</div>

									</fieldset>

									<div class="form-actions">

										<div class="row">

											<div class="col-md-12">

												<button class="btn btn-default" type="reset" onclick="window.location = '{{url("/master/supplier")}}'">
													<i class="fa fa-times"></i>
													&nbsp;Batal
												</button>

												<button class="btn btn-primary" type="button" @click="submit_form" :disabled="btn_save_disabled">
													<i class="fa fa-floppy-o"></i>
													&nbsp;Simpan
												</button>

											</div>

										</div>

									</div>

								</form>

							</div>

						</div>

					</div>

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