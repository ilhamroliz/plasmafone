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
															
															<input type="text" class="form-control" id="limit" name="limit" v-model="form_data.limit" placeholder="Masukkan Limitation"/>

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

										@endforeach

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

				var state = '';

				// validator

				$('#form-edit').bootstrapValidator({
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
						s_limit : {
							validators : {
								notEmpty : {
									message : 'Form Limit Tidak Boleh Kosong'
								},
								numeric : {
									message : 'Limit Hanya Boleh Inputan Angka'
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
						s_fax : {
							validators : {
								notEmpty : {
									message : 'Nomor Fax Tidak Boleh Kosong'
								},
								numeric : {
									message : 'Nomor Fax Ini Tampaknya Salah'
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

				$('#id').change(function(evt){
					evt.preventDefault(); let context = $(this);
					$('#form-load-section-status').fadeIn(200);

					axios.get(baseUrl+'/master/suplier/suplier/get/'+context.val())
						.then((response) => {
							if(response.data == null){
								context.children('option:selected').attr('disabled', 'disabled');
								context.val(state);
								$.toast({
								    text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
								    showHideTransition: 'fade',
								    icon: 'error'
								})
								$('#form-load-section-status').fadeOut(200);
							}else{
								$('#form-edit').data('bootstrapValidator').resetForm();
								state = response.data.s_id;
								initiate(response.data);
								$('#form-load-section-status').fadeOut(200);
							}
						})
						.catch((err) => {
							console.log(err);
						})
					
				})

				$('#form-edit').submit(function(evt){
					evt.preventDefault();

					if($(this).data('bootstrapValidator').validate().isValid()){
						
						let btn = $('#submit');
						btn.attr('disabled', 'disabled');
						btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Proses...');

						axios.post(baseUrl+'/master/suplier/suplier/update', $('#form-edit').serialize())
							.then((response) => {
								if(response.data.status == 'berhasil'){
									$("#id").children('option:selected').text($('#id').val()+' - '+$('#s_name').val());
									$.toast({
									    text: 'Data Ini berhasil Diupdate',
									    showHideTransition: 'fade',
									    icon: 'success'
									})
								}else if(response.data.status == 'tidak ada'){
									$("#id").children('option:selected').attr('disabled', 'disabled');
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
								btn.html('<i class="fa fa-floppy-o"></i> &nbsp;Simpan');
							})
					}

				})

				function initiate(data){
					$("#s_name").val(data.s_name);
					$("#s_limit").val(data.s_limit);
					$("#s_phone").val(data.s_phone);
					$("#s_fax").val(data.s_fax);
					$("#s_address").text(data.s_address);
					$("#s_note").text(data.s_name);
				}
			})
		</script>

@endsection