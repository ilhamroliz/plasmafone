@extends('main')

@section('title', 'Master Supplier')


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
			<li>Home</li><li>Data Master</li><li>Tambah Data Supplier</li>
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

					Data Supplier <span><i class="fa fa-angle-double-right"></i> Tambah Data Supplier </span>

				</h1>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/master/supplier') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

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

			<!-- row -->

			<div class="row">

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

	<script type="text/javascript">

		$(document).ready(function(){
			// product form
			var baseUrl = '{{ url('/') }}';

			function overlay()
			{
				$('#overlay').fadeIn(200);
				$('#load-status-text').text('Sedang Memproses...');
			}

			function out()
			{
				$('#overlay').fadeOut(200);
			}

			function validation_regis(){
				$('#data-form').bootstrapValidator({
					feedbackIcons : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					fields : {
						nama_perusahaan : {
							validators : {
								notEmpty : {
									message : 'Nama Perusahaan Tidak Boleh Kosong'
								}
							}
						},
						nama_suplier : {
							validators : {
								notEmpty : {
									message : 'Nama Supplier Tidak Boleh Kosong'
								}
							}
						},
						telp_suplier : {
							validators : {
								notEmpty : {
									message : 'Nomor Telepon Tidak Boleh Kosong'
								}
							}
						},
						alamat_suplier : {
							validators : {
								notEmpty : {
									message : 'Alamat Tidak Boleh Kosong'
								}
							}
						}
					}
				});
			}

			var app = new Vue({
				el 		: '#content',
				data 	: {

					btn_save_disabled 	: false,

					form_data : {
						nama_perusahaan 		: '',
						nama_suplier 			: '',
						telp_suplier 			: '',
						fax_suplier 			: '',
						alamat_suplier 			: '',
						keterangan				: ''
					}

				},
				mounted: function(){
					validation_regis();
					// console.log(this.form_data.nama_lengkap);
					$('#limit').maskMoney({thousands:'.', precision: 0, decimal:','});
				},
				methods: {
					submit_form: function(e){
						e.preventDefault();

						if($('#data-form').data('bootstrapValidator').validate().isValid()){
							this.btn_save_disabled = true;
							overlay();
							axios.post(baseUrl+'/master/supplier/add', 
								$('#data-form').serialize()
							).then((response) => {
								if(response.data.status == 'berhasil'){
									out();
									$.smallBox({
										title : "Berhasil",
										content : "Data Supplier terbaru Anda berhasil disimpan...!",
										color : "#739E73",
										timeout: 4000,
										icon : "fa fa-check bounce animated"
									});

									// Toast
									// $.toast({
									//     text: 'Data Supplier terbaru Anda berhasil disimpan...!',
									//     showHideTransition: 'fade',
									//     icon: 'success'
									// })

									this.reset_form();

								} else if(response.data.status == 'ada') {
									out();
									$.smallBox({
										title : "Gagal",
										content : 'Data perusahaan <i>"'+response.data.company+'"</i> sudah ada!',
										color : "#A90329",
										timeout: 4000,
										icon : "fa fa-times bounce animated"
									});

									// Toast
									// $.toast({
									//     text: 'Data perusahaan "'+response.data.company+'" sudah ada!',
									//     showHideTransition: 'fade',
									//     icon: 'error'
									// })
								}else {
									out();
									$.smallBox({
										title : "Gagal",
										content : "Ada kesalahan dalam proses input data, coba lagi...!",
										color : "#A90329",
										timeout: 4000,
										icon : "fa fa-times bounce animated"
									});

									// Toast
									// $.toast({
									//     text: 'Ada kesalahan dalam proses input data, coba lagi...!',
									//     showHideTransition: 'fade',
									//     icon: 'error'
									// })
								}

							}).catch((err) => {
								out();
								$.smallBox({
									title : "Gagal",
									content : "Ada kesalahan jaringan, coba lagi...!",
									color : "#A90329",
									timeout: 4000,
									icon : "fa fa-times bounce animated"
								});

								// Toast
								// $.toast({
								//     text: 'Ada kesalahan dalam proses input data, coba lagi...!',
								//     showHideTransition: 'fade',
								//     icon: 'error'
								// })
							}).then(() => {
								this.btn_save_disabled = false;
							})

							return false;
						}else{
							out();
							$.smallBox({
								title : "Gagal",
								content : "Ada kesalahan dengan inputan Anda. Harap mengecek ulang...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

							// Toast
							// $.toast({
							//     text: 'Ada Kesalahan Dengan Inputan Anda. Harap Mengecek Ulang..',
							//     showHideTransition: 'fade',
							//     icon: 'error'
							// })
						}
					},

					reset_form:function(){
						this.form_data.nama_perusahaan 		= '';
						this.form_data.nama_suplier 		= '';
						$("#limit").val("");
						this.form_data.telp_suplier			= '';
						this.form_data.fax_suplier 			= '';
						this.form_data.alamat_suplier 		= '';
						this.form_data.keterangan 			= '';
						$('#data-form').data('bootstrapValidator').resetForm();
					}
				}
			});

			// end product form
		})
	</script>

@endsection