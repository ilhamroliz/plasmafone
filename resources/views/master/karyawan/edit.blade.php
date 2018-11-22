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
			<li>Home</li><li>Master</li><li>Supplier</li><li>Edit</li>
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

		<!-- widget grid -->
		<section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">

			<!-- row -->
			<div class="row">
				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1" style="padding: 10px 20px; margin-top: 20px; background: #fff;">

					{{-- FormTemplate .. --}}

					<form id="data-form" class="form-horizontal" method="post">
						{{ csrf_field() }}
						<fieldset>
							<legend>
								Form Tambah Supplier

								<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
									<a href="{{ url('/master/karyawan') }}">
										<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
									</a>
								</span>
							</legend>

							<div class="row" style="border-bottom: 1px dotted #aaa; margin-bottom: 20px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Pilih Data Yang Diedit</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" name="nik_karyawan" id="nik_karyawan" @change="change_state">
												@foreach($data as $key => $suplier)
													<option value="{{ $suplier->id_karyawan }}">{{ $suplier->id_karyawan }} - {{ $suplier->nama_lengkap }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6 text-left" style="padding: 10px 0px; display:none;" id="form-load-section-status">
									<i class="fa fa-cog fa-spin fa-fw"></i> &nbsp;
									<small>Sedang Mengambil Data Baru...</small>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Nama Karyawan</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukkan Nama Lengkap Karyawan" v-model='form_data.nama_lengkap' />
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Jabatan karyawan</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" v-model="form_data.id_jabatan" name="id_jabatan">
												<option v-for="(data_jabatan, index) in jabatan" :value="data_jabatan.id">@{{ data_jabatan.nama }}</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Posisi Karyawan</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer" v-model="form_data.id_posisi">
											<select class="form-control" v-model="form_data.id_posisi" name="id_posisi">
												<option v-for="(data_posisi, index) in posisi" :value="data_posisi.id_posisi">@{{ data_posisi.nama_posisi }}</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Alamat Karyawan</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="alamat_rumah" v-model="form_data.alamat_rumah" placeholder="Masukkan Alamat Karyawan"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Provinsi/Kota</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer" v-model="form_data.id_kota">
											<select class="form-control" v-model="form_data.id_kota" name="id_kota">
												<optgroup v-for="data_provinsi in provinsi" :label="data_provinsi.nama_provinsi">
													<option v-for="data_kota in kota" :value="data_kota.id" v-if="data_kota.id_provinsi == data_provinsi.id">@{{ data_kota.nama_kota }}</option>
												</optgroup>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">No Telephone</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-phone"></i></span>
												<input type="text" class="form-control" name="nomor_telp" placeholder="Masukkan Nomor Telepon" v-model="form_data.nomor_telp"/>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Agama Karyawan</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="agama" placeholder="Masukkan Agama Karyawan" v-model="form_data.agama"/>
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Kewarganegaraan</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="kewarganegaraan" placeholder="Masukkan Kewarganegaraan Karyawan" v-model="form_data.Kewarganegaraan"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Status Pernikahan</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<select class="form-control" v-model="form_data.status_pernikahan" name="status_pernikahan">
												<option value="0">Belum Menikah</option>
												<option value="1">Sudah Menikah</option>
											</select>
										</div>
									</div>
								</div>
							</div>

						</fieldset>

						<fieldset style="margin-top: 20px;">
							<legend>
								<b>Informasi Pendidikan Terakhir</b>
							</legend>

							<div class="row">
								<div class="col-md-6" style="padding: 0px;">
									<div class="col-md-12">
										<div class="form-group">
											<label class="col-xs-4 col-lg-4 control-label text-left">Pendidikan SD</label>
											<div class="col-xs-7 col-lg-7 inputGroupContainer">
												<input type="text" class="form-control" name="pendidikan_sd" placeholder="Pendidikan SD Terakhir" v-model='form_data.pendidikan_sd' />
											</div>
										</div>
									</div>

									<div class="col-md-12">
										<div class="form-group">
											<label class="col-xs-4 col-lg-4 control-label text-left">Pendidikan SMP</label>
											<div class="col-xs-7 col-lg-7 inputGroupContainer">
												<input type="text" class="form-control" name="pendidikan_smp" placeholder="Pendidikan SMP Terakhir" v-model='form_data.pendidikan_smp' />
											</div>
										</div>
									</div>

									<div class="col-md-12">
										<div class="form-group">
											<label class="col-xs-4 col-lg-4 control-label text-left">Pendidikan SMA</label>
											<div class="col-xs-7 col-lg-7 inputGroupContainer">
												<input type="text" class="form-control" name="pendidikan_sma" placeholder="Pendidikan SMA Terakhir" v-model='form_data.pendidikan_sma' />
											</div>
										</div>
									</div>

									<div class="col-md-12">
										<div class="form-group">
											<label class="col-xs-4 col-lg-4 control-label text-left">Pendidikan Kuliah</label>
											<div class="col-xs-7 col-lg-7 inputGroupContainer">
												<input type="text" class="form-control" name="pendidikan_kuliah" placeholder="Pendidikan KULIAH Terakhir" v-model='form_data.pendidikan_kuliah' />
											</div>
										</div>
									</div>
								</div>
							</div>

						</fieldset>

						<fieldset>
							<div class="col-md-12 text-center" style="font-size: 0.8em; padding: 5px 0px; background: #eee; margin-top: 10px;">
								Dengan Menyimpan Karyawan Baru Ini. Akan Secara Otomatis Membuat Akses Ke System Dengan NIK Karyawan Sebagai Username dan '123456' (tanpa petik) Sebagai Password Default.
							</div>
						</fieldset>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-default" type="button" @click="submit_form" :disabled="btn_save_disabled">
										<i class="fa fa-floppy-o"></i>
										&nbsp;Simpan
									</button>
								</div>
							</div>
						</div>
					</form>

					{{-- FormTemplate End .. --}}

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
			
			var baseUrl = '{{ url('/') }}';

			function validation_regis(){
				$('#data-form').bootstrapValidator({
					feedbackIcons : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					fields : {
						nama_lengkap : {
							validators : {
								notEmpty : {
									message : 'Nama Lengkap Tidak Boleh Kosong',
								}
							}
						},
						alamat_rumah : {
							validators : {
								notEmpty : {
									message : 'Alamat Rumah Tidak Boleh Kosong',
								}
							}
						},
						nomor_telp : {
							validators : {
								notEmpty : {
									message : 'Nomor Telepon Tidak Boleh Kosong',
								},
								numeric : {
									message : 'Nomor Telepon Ini Sepertinya Tidak Valid'
								}
							}
						},
						agama : {
							validators : {
								notEmpty : {
									message : 'Agama Tidak Boleh Kosong',
								}
							}
						},
						kewarganegaraan : {
							validators : {
								notEmpty : {
									message : 'Kewarganegaraan Tidak Boleh Kosong',
								}
							}
						},

					}
				});
			}

			var app = new Vue({
				el 		: '#content',
				data 	: {

					jabatan 			: {},
					posisi 				: {},
					provinsi 			: {},
					kota 				: {},
					btn_save_disabled 	: false,

					form_data : {
						nama_lengkap 		: '',
						id_jabatan 			: '',
						id_posisi 			: '',
						id_kota 			: '',
						alamat_rumah 		: '',
						nomor_telp 			: '',
						Kewarganegaraan		: '',
						agama 				: '',
						status_pernikahan	: 0,
						pendidikan_sd 		: '',
						pendidikan_smp 		: '',
						pendidikan_sma 		: '',
						pendidikan_kuliah 	: '',
					}

				},
				mounted: function(){
					validation_regis();
					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menyiapkan Form');
					// console.log(this.form_data.nama_lengkap);
				},
				created: function(){
					axios.get(baseUrl+'/master/karyawan/get/form-resource')
							.then((response) => {
								// console.log(response.data);
								this.posisi 	= response.data.posisi;
								this.jabatan 	= response.data.jabatan;
								this.provinsi 	= response.data.provinsi;
								this.kota 		= response.data.kota; 

								this.form_data.id_jabatan = response.data.jabatan[0].id;
								this.form_data.id_posisi = response.data.posisi[0].id_posisi;
								this.form_data.id_kota = response.data.kota[0].id;

								$('#overlay').fadeOut(200);
							}).then(() => {
								this.change_state();
							});

				},
				methods: {
					submit_form: function(e){
						e.preventDefault();

						if($('#data-form').data('bootstrapValidator').validate().isValid()){
							this.btn_save_disabled = true;

							axios.post(baseUrl+'/master/karyawan/update', 
								$('#data-form').serialize()
							).then((response) => {
								console.log(response.data);
								if(response.data.status == 'berhasil'){
									$.toast({
									    text: 'Data Karyawan Terbaru Anda Berhasil Kami Update..',
									    showHideTransition: 'fade',
									    icon: 'success'
									})

									// this.reset_form();

								}else if(response.data.status == 'jabatan_not_found'){
									$.toast({
									    text: 'Ada Kesalahan Jabatan Yang Anda Pilih Sudah Tidak Bisa Kami Temukan. Cobalah Untuk Memuat Ulang Halaman..',
									    showHideTransition: 'fade',
									    icon: 'error'
									})
								}else if(response.data.status == 'posisi_not_found'){
									$.toast({
									    text: 'Ada Kesalahan Posisi Yang Anda Pilih Sudah Tidak Bisa Kami Temukan. Cobalah Untuk Memuat Ulang Halaman..',
									    showHideTransition: 'fade',
									    icon: 'error'
									})
								}else if(response.data.status == 'data_not_found'){
									$.toast({
									    text: 'Ada Kesalahan Karyawan Yang Anda Pilih Sudah Tidak Bisa Kami Temukan. Cobalah Untuk Memuat Ulang Halaman..',
									    showHideTransition: 'fade',
									    icon: 'error'
									})
								}

							}).catch((err) => {
								console.log(err);
							}).then(() => {
								this.btn_save_disabled = false;
							})

							return false;
						}else{
							$.toast({
							    text: 'Ada Kesalahan Dengan Inputan Anda. Harap Mengecek Ulang..',
							    showHideTransition: 'fade',
							    icon: 'error'
							})
						}
					},
					reset_form:function(){
						this.form_data.nama_lengkap 		= '';
						this.form_data.id_jabatan 			= this.jabatan[0].id;
						this.form_data.id_posisi 			= this.posisi[0].id_posisi;
						this.form_data.id_kota 				= this.kota[0].id;
						this.form_data.alamat_rumah 		= '';
						this.form_data.nomor_telp 			= '';
						this.form_data.Kewarganegaraan		= '';
						this.form_data.agama 				= '';
						this.form_data.status_pernikahan	= 0;
						this.form_data.pendidikan_sd 		= '';
						this.form_data.pendidikan_smp 		= '';
						this.form_data.pendidikan_sma 		= '';
						this.form_data.pendidikan_kuliah 	= '';
						$('#data-form').data('bootstrapValidator').resetForm();
					},
					change_state: function(e){
						let ctx = $('#nik_karyawan');
						$('#form-load-section-status').fadeIn(200);
						axios.get(baseUrl+'/master/karyawan/grab/'+ctx.val())
								.then((response) => {
									// console.log(response.data);
									if(response.data.nik_karyawan === undefined){
										$.toast({
										    text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
										    showHideTransition: 'fade',
										    icon: 'error'
										})
										ctx.children('option:selected').attr('disabled', 'disabled');
										this.reset_form();
									}else{
										this.form_data.nama_lengkap 		= response.data.nama_lengkap;
										this.form_data.id_jabatan 			= response.data.id_jabatan;
										this.form_data.id_posisi 			= response.data.id_posisi;
										this.form_data.id_kota 				= response.data.id_kota;
										this.form_data.alamat_rumah 		= response.data.alamat_rumah;
										this.form_data.nomor_telp 			= response.data.nomor_telp;
										this.form_data.Kewarganegaraan		= response.data.kewarganegaraan;
										this.form_data.agama 				= response.data.agama;
										this.form_data.status_pernikahan	= response.data.status_pernikahan;
										this.form_data.pendidikan_sd 		= response.data.pendidikan_sd;
										this.form_data.pendidikan_smp 		= response.data.pendidikan_smp;
										this.form_data.pendidikan_sma 		= response.data.pendidikan_sma;
										this.form_data.pendidikan_kuliah 	= response.data.pendidikan_kuliah;
									}
								}).catch((err) => {
									console.log(err)
								}).then(() => {
									$('#form-load-section-status').fadeOut(200);
									$('#data-form').data('bootstrapValidator').resetForm();
								})
					}
				}
			});

		</script>

@endsection