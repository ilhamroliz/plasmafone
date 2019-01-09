@extends('main')

@section('title', 'Master Member')


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

								<form id="form-tambah" class="form-horizontal" method="post">
									{{ csrf_field() }}

									<fieldset>

										<legend>
											Form Tambah Master
										</legend>

										<div class="row">

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Nama Member</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-user" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="name" name="name" v-model="form_data.name" placeholder="Masukkan Nama Member" style="text-transform: uppercase" />
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">No. Identitas</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-credit-card" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="nik" name="nik" v-model="form_data.nik" placeholder="Masukkan Nomor Identitas" />
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">ID. Member</label>
													<div class="col-xs-9 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-credit-card" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="idmember" name="idmember" v-model="form_data.idmember" placeholder="Masukkan Nomor ID Member" />
															<span class="input-group-addon"> <input type="checkbox" onchange="klik()" id="checklist" name="checklist" value="Y"> </span>
														</div>
															<small class="help-block" data-bv-validator="notEmpty" data-bv-for="idmember" id="valididmember" data-bv-result="INVALID" style="display:none;color:#b94a48">Isi ID Member</small>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">No. Telephone</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-phone" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="telp" name="telp" v-model="form_data.telp" placeholder="Masukkan Nomor Telepon" />
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Email</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-envelope" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="email" name="email" v-model="form_data.email" placeholder="Masukkan Alamat Email" />
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Tipe Member</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<select class="form-control" name="tipe" id="tipe" v-model="form_data.tipe">
																<option value="" disabled>== Jenis Member ==</option>
																<option value="0">DEFAULT</option>
																@foreach($getJM as $data)
																	<option value="{{ $data->g_id }}">{{ $data->g_name }}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>

											</article>

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">
                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Tanggal Lahir</label>
                                                    <div class="col-xs-8 col-lg-8">
                                                        <select id="tanggal" class="form-control col-sm-2" style="width: 30%;" name="tanggal" v-model="form_data.tanggal"></select>
                                                        <select id="bulan" class="form-control col-sm-4" style="width: 30%; margin-left: 10px" name="bulan" v-model="form_data.bulan"></select>
                                                        <select id="tahun" class="form-control col-sm-3" style="width: 30%; margin-left: 10px" name="tahun" v-model="form_data.tahun"></select>
                                                    </div>
                                                </div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Alamat Member</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<textarea class="form-control" rows="5" style="resize: none;" placeholder="Masukkan Alamat Member" id="address" name="address" v-model="form_data.address"></textarea>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-md-4 control-label text-left">Provinsi</label>
													<div class="col-md-8 inputGroupContainer">
															<select class="form-control" name="provinsi" id="provinsi" onchange="getkota()">
																<option value="" selected disabled>== Pilih Provinsi ==</option>
																@foreach ($provinsi as $key => $value)
																	<option value="{{$value->wp_id}}">{{$value->wp_name}}</option>
																@endforeach
															</select>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-xs-4 col-lg-4 control-label text-left">Kota</label>
													<div class="col-xs-5 col-lg-8 inputGroupContainer">
															<select class="form-control" name="kota" id="kota" onchange="getkecamatan()">
																<option value="" selected disabled>== Pilih Kota ==</option>
															</select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Kecamatan</label>
													<div class="col-xs-5 col-lg-8 inputGroupContainer">
															<select class="form-control" name="kecamatan" id="kecamatan" onchange="getdesa()">
																<option value="" selected disabled>== Pilih Kecamatan ==</option>
															</select>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Desa</label>
													<div class="col-xs-9 col-lg-8 inputGroupContainer">
															<select class="form-control" name="desa" id="desa">
																<option value="" selected disabled>== Pilih Desa ==</option>
															</select>
													</div>
												</div>

											</article>

										</div>

									</fieldset>

									<div class="form-actions">

										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-default" type="reset" onclick="window.location = '{{url("/master/member")}}'">
													<i class="fa fa-times"></i>
													&nbsp;Batal
												</button>

												<button class="btn btn-primary" type="button" @click="tambah_form" :disabled="btn_save_disabled" onclick="btnform()">
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
	{{-- <!-- <script src="{{ asset('template_asset/js/plugin/choosen/init.js') }}"></script> --> --}}
	<script src="{{ asset('template_asset/js/dobpicker.js') }}"></script>

	<script type="text/javascript">
	var checklistcount = 0;

		$(document).ready(function(){

			$.dobPicker({
				// Selectopr IDs
				daySelector: '#tanggal',
				monthSelector: '#bulan',
				yearSelector: '#tahun',

				// Default option values
				dayDefault: '= Tanggal =',
				monthDefault: '= Bulan =',
				yearDefault: '= Tahun =',

				// Minimum age
				minimumAge: 5,

				// Maximum age
				maximumAge: 80
			});

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
				$('#form-tambah').bootstrapValidator({
					feedbackIcons : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					fields : {
						nik : {
							validators : {
								notEmpty : {
									message : 'Isi No. Identitas'
								}
							}
						},
						name : {
							validators : {
								notEmpty : {
									message : 'Isi nama Member'
								}
							}
						},
						telp : {
							validators : {
								notEmpty : {
									message : 'Isi telepon Member'
								}
							}
						},
						address : {
							validators : {
								notEmpty : {
									message : 'Isi alamat Member'
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
						nik 	: '',
						name 	: '',
						telp 	: '',
						address : '',
						email 	: '',
						tipe	: '',
						tanggal : '',
						bulan	: '',
						tahun	: ''
					}

				},
				mounted: function(){
					validation_regis();
					// overlay();
				},
				methods: {
					tambah_form: function(e){
						e.preventDefault();

						if($('#form-tambah').data('bootstrapValidator').validate().isValid()){
							this.btn_save_disabled = true;
							overlay();
							axios.post(baseUrl+'/master/member/simpan-tambah',
								$('#form-tambah').serialize()+'&tipe='+$('#tipe').val()+'&checklist='+$('#checklist').val()
							).then((response) => {
								if (response.data.status == 'ditolak') {

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
										content : "Data member terbaru Anda berhasil tersimpan...!",
										color : "#739E73",
										timeout: 5000,
										icon : "fa fa-check bounce animated"
									});

									this.reset_form();
								}else if(response.data.status == 'nikada') {
									out();
									$.smallBox({
										title : "Gagal",
										content : 'Data member dengan NIK <i>"'+response.data.name+'"</i> sudah ada!',
										color : "#A90329",
										timeout: 5000,
										icon : "fa fa-times bounce animated"
									});
								}else if(response.data.status == 'telpada') {
									out();
									$.smallBox({
										title : "Gagal",
										content : 'Data member dengan No. Telp <i>"'+response.data.name+'"</i> sudah ada!',
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
						this.form_data.nik 			= '';
						this.form_data.name 		= '';
						this.form_data.telp			= '';
						this.form_data.address 		= '';
						this.form_data.email 		= '';
						this.form_data.tipe 		= '';
						this.form_data.tanggal 		= '';
						this.form_data.bulan 		= '';
						this.form_data.tahun 		= '';

						$('#form-tambah').data('bootstrapValidator').resetForm();
					}
				}
			});
		});


		function klik(){
			if (checklistcount == 0) {
				checklistcount = 1;
				$('#idmember').attr('readonly', true);
				$('#idmember').attr('placeholder', 'Auto');
			} else {
				checklistcount = 0;
				$('#idmember').attr('readonly', false);
				$('#idmember').attr('placeholder', 'Masukkan Nomor ID Member');
			}
		}

		function btnform(){
			if ($('#idmember').val() == "" && checklistcount == 0) {
				$('#valididmember').css('display', '');
			} else {
				$('#valididmember').css('display', 'none');
			}
		}


		function getkota(){
			$('#kecamatan').find('option').remove().end().append('<option value="" selected disabled>== Pilih Kecamatan ==</option>');		
			$('#desa').find('option').remove().end().append('<option value="" selected disabled>== Pilih Desa ==</option>');		

			var html = '<option value="" disabled>== Pilih Kota ==</option>';
			var provinsi = $('#provinsi').val();
			$.ajax({
				type: 'get',
				dataType: 'json',
				data: {provinsi},
				url: baseUrl + '/master/member/getkota',
				success : function(response){
						for (var i = 0; i < response.length; i++) {
							html += '<option value="'+response[i].wc_id+'">'+response[i].wc_name+'</option>';
						}
					$('#kota').html(html);
				}
			});
		}

		function getkecamatan(){
			$('#desa').find('option').remove().end().append('<option value="" selected disabled>== Pilih Desa ==</option>');		

			var html = '<option value="" disabled>== Pilih Kecamatan ==</option>';
			var kota = $('#kota').val();
			$.ajax({
				type: 'get',
				dataType: 'json',
				data: {kota},
				url: baseUrl + '/master/member/getkecamatan',
				success : function(response){
					for (var i = 0; i < response.length; i++) {
						html += '<option value="'+response[i].wk_id+'">'+response[i].wk_name+'</option>';
					}
					$('#kecamatan').html(html);
				}
			});
		}

		function getdesa(){
			var html = '<option value="" disabled>== Pilih Desa ==</option>';
			var kecamatan = $('#kecamatan').val();
			$.ajax({
				type: 'get',
				dataType: 'json',
				data: {kecamatan},
				url: baseUrl + '/master/member/getdesa',
				success : function(response){
					for (var i = 0; i < response.length; i++) {
						html += '<option value="'+response[i].wd_id+'">'+response[i].wd_name+'</option>';
					}
					$('#desa').html(html);
				}
			});
		}

	</script>

@endsection
