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
			<li>Home</li><li>Data Master</li><li>Edit Data Supplier</li>
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

					Data Supplier <span><i class="fa fa-angle-double-right"></i> Edit Data Supplier </span>

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

										@foreach($suppliers as $supplier)

										<input type="hidden" id="sid" name="sid" value="{{ Crypt::encrypt($supplier->s_id) }}">

										<div class="row">

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Nama Perusahaan</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-building"></i></span>

															<input type="text" class="form-control" name="nama_perusahaan" v-model="form_data.nama_perusahaan" placeholder="Masukkan Nama Perusahaan" value="{{ $supplier->s_company }}" style="text-transform: uppercase" />

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Nama Supplier</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-user"></i></span>

															<input type="text" class="form-control" name="nama_suplier" v-model="form_data.nama_suplier" placeholder="Masukkan Nama Supplier" value="{{ $supplier->s_name }}" style="text-transform: uppercase" />

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">No Telephone</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-phone"></i></span>

															<input type="text" class="form-control" name="telp_suplier" v-model="form_data.telp_suplier" placeholder="Masukkan Nomor Telepon" value="{{ $supplier->s_phone }}" />

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Fax</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-fax"></i></span>

															<input type="text" class="form-control" name="fax_suplier" v-model="form_data.fax_suplier" placeholder="Masukkan Nomor Fax Supplier" value="{{ $supplier->s_fax }}" />

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Status Supplier</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<select class="form-control" name="isactive">
															<option value="Y" @if($supplier->s_isactive == "Y") selected @endif>AKTIF</option>
															<option value="N" @if($supplier->s_isactive == "N") selected @endif>NON AKTIF</option>
														</select>

													</div>

												</div>

											</article>

											<article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Limit</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<div class="input-group">

															<span class="input-group-addon"><i class="fa fa-money"></i></span>
															
															<input type="text" class="form-control" id="limit" name="limit" v-model="form_data.limit" placeholder="Masukkan Limitation" value="{{ number_format($supplier->s_limit,0,',','.') }}"/>

														</div>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Alamat Supplier</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<textarea class="form-control" rows="5" style="resize: none;" placeholder="Masukkan Alamat Supplier" name="alamat_suplier" v-model="form_data.alamat_suplier">{{ $supplier->s_address }}</textarea>

													</div>

												</div>

												<div class="form-group">

													<label class="col-xs-4 col-lg-4 control-label text-left">Keterangan</label>

													<div class="col-xs-8 col-lg-8 inputGroupContainer">

														<textarea class="form-control" rows="5" style="resize: none;" placeholder="Tambahkan Keterangan Tentang Supplier" name="keterangan" v-model="form_data.keterangan">{{ $supplier->s_note }}</textarea>

													</div>

												</div>

											</article>
											
										</div>

										@endforeach

									</fieldset>

									<div class="form-actions">

										<div class="row">

											<div class="col-md-12">

												<button class="btn btn-default" type="reset" onclick="window.location = '{{url("/master/supplier")}}'">
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

			var baseUrl = '{{ url('/') }}';

			$('#limit').maskMoney({thousands:'.', precision: 0, decimal:','});

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

			$('#data-form').bootstrapValidator({
				feedbackIcons : {
					valid : 'glyphicon glyphicon-ok',
					invalid : 'glyphicon glyphicon-remove',
					validating : 'glyphicon glyphicon-refresh'
				},
				fields : {
					s_company : {
						validators : {
							notEmpty : {
								message : 'Nama Perusahaan Tidak Boleh Kosong'
							}
						}
					},
					s_name : {
						validators : {
							notEmpty : {
								message : 'Nama Supplier Tidak Boleh Kosong'
							}
						}
					},
					s_phone : {
						validators : {
							notEmpty : {
								message : 'Nomor Telepon Tidak Boleh Kosong'
							},
							numeric : {
								message : 'Nomor Telepon Ini Tampaknya Salah'
							}
						}
					},
					s_address : {
						validators : {
							notEmpty : {
								message : 'Alamat Tidak Boleh Kosong'
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

				axios.post(baseUrl+'/master/supplier/edit/'+ $('#sid').val(), $('#data-form').serialize()).then((response) => {

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
							content : "Data Supplier berhasil diubah...!",
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
							content : "Upsss. Gagal mengedit data...! Coba lagi",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});

					}

				}).catch((err) => {
					out();
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Gagal mengedit data...! Coba lagi",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});
					
				}).then(function(){
					btn.removeAttr('disabled');
					btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Simpan');
					out();
				})

			})

		})
	</script>

@endsection