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
			<li>Home</li><li>Data Master</li><li>Tambah Master Member</li>
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

					Data Member <span><i class="fa fa-angle-double-right"></i> Tambah Data Member </span>

				</h1>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/master/member') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

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

							<h2><strong>Master Member</strong></h2>				
							
						</header>

						<div>
							
							<div class="widget-body">

								<form id="data-form" class="form-horizontal" method="post">
									{{ csrf_field() }}

									<fieldset>

										<legend>
											Form Tambah Member
										</legend>

										<div class="row">
											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Nama Member</label>
    												<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-user"></i></span>
															<input type="text" class="form-control" id="name" name="name" v-model="form_data.name" placeholder="Masukkan Nama Member" style="text-transform: uppercase" />
														</div>

													</div>
                                                </div>
                                                
                                                <div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">No. NIK</label>
    												<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
															<input type="text" class="form-control" id="nik" name="nik" v-model="form_data.nik" placeholder="Masukkan Nomor NIK" />
														</div>

													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">No. Telephone</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-phone"></i></span>
															<input type="text" class="form-control" id="telp" name="telp" v-model="form_data.telp" placeholder="Masukkan Nomor Telepon" />
														</div>

													</div>
                                                </div>
                                                
                                                <div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Email</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
															<input type="text" class="form-control" id="email" name="email" v-model="form_data.email" placeholder="Masukkan Alamat Email" />
														</div>

													</div>
												</div>

											</article>

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Alamat Member</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<textarea class="form-control" rows="5" style="resize: none;" placeholder="Masukkan Alamat Member" id="address" name="address" v-model="form_data.address"></textarea>

													</div>
												</div>
											</article>
										</div>
                                    </fieldset>
                                    
									<div class="form-actions">
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-default" type="reset" onclick="window.location = '{{url("/master/outlet")}}'">
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

		$(document).ready(function(){

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

			function validation_regis()
			{
				$('#data-form').bootstrapValidator({
					feedbackIcons : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					fields : {
						// code : {
						// 	validators : {
						// 		notEmpty : {
						// 			message : 'Isi kode outlet'
						// 		}
						// 	}
						// },
						name : {
							validators : {
								notEmpty : {
									message : 'Isi nama outlet'
								}
							}
						},
						telp : {
							validators : {
								notEmpty : {
									message : 'Isi telephone outlet'
								}
							}
						},
						address : {
							validators : {
								notEmpty : {
									message : 'Isi alamat outlet'
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
						// code 	: '',
						name 	: '',
						telp 	: '',
						address : '',
						note 	: ''
					}

				},
				mounted: function(){
					validation_regis();
					// overlay();
				},
				// created: function(){
				// 	axios.get(baseUrl+'/master/getcode')
				// 	.then(response => {
				// 		this.form_data.code = response.data;
				// 		out();
				// 	})
				// },
				methods: {
					submit_form: function(e){
						e.preventDefault();

						if($('#data-form').data('bootstrapValidator').validate().isValid()){
							this.btn_save_disabled = true;
							overlay();
							axios.post(baseUrl+'/master/outlet/add', 
								$('#data-form').serialize()
							).then((response) => {
								if (response.data.status == 'Access denied') {

									out();
									$.smallBox({
										title : "Gagal",
										content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
										color : "#A90329",
										timeout: 5000,
										icon : "fa fa-times bounce animated"
									});

								}else if(response.data.status == 'berhasil'){
									out();
									$.smallBox({
										title : "Berhasil",
										content : "Data outlet terbaru Anda berhasil tersimpan...!",
										color : "#739E73",
										timeout: 5000,
										icon : "fa fa-check bounce animated"
									});

									this.reset_form();
									// this.form_data.code = response.data.code;

								}
								//  else if(response.data.status == 'kode ada') {
								// 	out();
								// 	$.smallBox({
								// 		title : "Gagal",
								// 		content : 'Kode outlet <i>"'+response.data.code+'"</i> sudah ada! Mulai ulang halaman...',
								// 		color : "#A90329",
								// 		timeout: 5000,
								// 		icon : "fa fa-times bounce animated"
								// 	});
								// } 
								else if(response.data.status == 'nama ada') {
									out();
									$.smallBox({
										title : "Gagal",
										content : 'Nama outlet <i>"'+response.data.name+'"</i> sudah ada! Masukkan nama selain <i>"'+response.data.name+'"</i>',
										color : "#A90329",
										timeout: 5000,
										icon : "fa fa-times bounce animated"
									});
								} else {
									out();
									$.smallBox({
										title : "Gagal",
										content : "Ada kesalahan dalam proses input data, coba lagi...!",
										color : "#A90329",
										timeout: 5000,
										icon : "fa fa-times bounce animated"
									});
								}

							}).catch((err) => {
								out();
								$.smallBox({
									title : "Gagal",
									content : "Ada kesalahan jaringan, coba lagi...!",
									color : "#A90329",
									timeout: 5000,
									icon : "fa fa-times bounce animated"
								});
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
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});
						}
					},
					reset_form:function(){
						// this.form_data.code 		= '';
						this.form_data.name 		= '';
						this.form_data.telp			= '';
						this.form_data.address 		= '';
						this.form_data.note 		= '';
						$('#data-form').data('bootstrapValidator').resetForm();
					}
				}
			});

		})
	</script>

@endsection