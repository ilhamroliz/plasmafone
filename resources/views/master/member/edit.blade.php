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
			<li>Home</li><li>Data Master</li><li>Edit Master Member</li>
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
					Data Member <span><i class="fa fa-angle-double-right"></i> Edit Data Member </span>
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

								<form id="form-edit" class="form-horizontal" method="post">
									{{ csrf_field() }}

									<fieldset>

										<legend>
											Form Edit Member
										</legend>

										@foreach($member as $member)

										<div class="row">
											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Nama Member</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-user" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="name" name="name" v-model="form_data.name" placeholder="Masukkan Nama Member" style="text-transform: uppercase" value="{{ $member->m_name }}" />
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">No. ID</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-credit-card" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="nik" name="nik" v-model="form_data.nik" placeholder="Masukkan No. ID Member" value="{{ $member->m_nik }}" readonly/>
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">No. Telephone</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-phone" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="telp" name="telp" v-model="form_data.telp" placeholder="Masukkan Nomor Telepon" value="{{ $member->m_telp }}" />
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Email</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<span class="input-group-addon"><i class="fa fa-envelope" style="width: 15px"></i></span>
															<input type="text" class="form-control" id="email" name="email" v-model="form_data.email" placeholder="Masukkan Alamat Email" value="{{ $member->m_email }}" />
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Tipe Member</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<div class="input-group">
															<select class="form-control" name="tipe" id="tipe" v-model="form_data.tipe">
																<option value="" @if($member->m_jenis == "") selected @endif disabled>== Jenis Member ==</option>																																	
																@foreach($getJM as $data)
																	@if($data->g_id == $member->m_jenis)
																	<option value="{{ $data->g_id }}" selected >{{ $data->g_name }}</option>
																	@else
																	<option value="{{ $data->g_id }}">{{ $data->g_name }}</option>
																	@endif
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
                                                        <select id="tanggal" class="form-control col-sm-2" style="width: 28%;" name="tanggal" v-model="form_data.tanggal"></select>
                                                        <select id="bulan" class="form-control col-sm-4" style="width: 35%; margin-left: 10px" name="bulan" v-model="form_data.bulan"></select>
                                                        <select id="tahun" class="form-control col-sm-3" style="width: 30%; margin-left: 10px" name="tahun" v-model="form_data.tahun"></select>
                                                    </div>
                                                </div>

												<div class="form-group">
													<label class="col-xs-4 col-lg-4 control-label text-left">Alamat Member</label>
													<div class="col-xs-8 col-lg-8 inputGroupContainer">
														<textarea class="form-control" rows="5" style="resize: none;" placeholder="Masukkan Alamat Member" id="address" name="address" v-model="form_data.address">{{ $member->m_address }}</textarea>
													</div>
												</div>

											</article>
											
										</div>

										@endforeach

									</fieldset>

									<div class="form-actions">
										<div class="row">
											<div class="col-md-12">

												<button class="btn btn-default" type="reset" onclick="window.location = '{{url("/master/member")}}'">
													<i class="fa fa-times"></i>
													&nbsp;Batal
												</button>

												<button class="btn btn-primary" type="button" id="submit">
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
	<script src="{{ asset('template_asset/js/dobpicker.js') }}"></script>


	<script type="text/javascript">

		var baseUrl = '{{ url('/') }}';

		$.dobPicker({
			// Selectopr IDs
			daySelector: '#tanggal',
			monthSelector: '#bulan',
			yearSelector: '#tahun',

			// Default option values
			dayDefault: 'Tanggal',
			monthDefault: 'Bulan',
			yearDefault: 'Tahun',

			// Minimum age
			minimumAge: 10,

			// Maximum age
			maximumAge: 80
		});
		
		$('#tanggal').val('{{ $day }}');
		$('#bulan').val('{{ $month }}');
		$('#tahun').val('{{ $year }}');

		function overlay()
		{
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Memproses...');
		}

		function out()
		{
			$('#overlay').fadeOut(200);
		}

		// validator

		$('#form-edit').bootstrapValidator({
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			fields : {
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

		// end validator

		$('#submit').click(function(evt){

			evt.preventDefault();

			var btn = $('#submit');
			btn.attr('disabled', 'disabled');
			btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Proses...');

			overlay();

			axios.post(baseUrl+'/master/member/simpan-edit/'+ $('#nik').val(), $('#form-edit').serialize()).then((response) => {

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
						content : 'Data Member <i>"'+response.data.name+'"</i> berhasil diubah...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
					});

				}else if(response.data.status == 'tidak ada'){

					out();
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Data yang ingin Anda ubah sudah tidak ada...!",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});

				}else{
					out();

					$.smallBox({
						title : "Gagal",
						content : "Upsss. Gagal mengedit data...! Coba lagi dengan mulai ulang halaman",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});

				}

			}).catch((err) => {
				out();
				$.smallBox({
					title : "Gagal",
					content : "Upsss. Gagal mengedit data...! Coba lagi dengan mulai ulang halaman",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});
				
			}).then(function(){
				btn.removeAttr('disabled');
				btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Simpan');
				out();
			});

		});

	</script>

@endsection