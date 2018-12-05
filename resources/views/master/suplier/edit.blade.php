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

					<form id="form-edit" class="form-horizontal" method="post">
						{{ csrf_field() }}
						<fieldset>
							<legend>
								Form Tambah Supplier

								<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
									<a href="{{ url('/master/suplier/suplier') }}">
										<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
									</a>
								</span>
							</legend>

							<div class="row" style="border-bottom: 1px dotted #aaa; margin-bottom: 20px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Pilih Data Yang Diedit</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" name="s_id" id="id">
												@foreach($data as $key => $suplier)
													<option value="{{ $suplier->s_id }}">{{ $suplier->s_id }} - {{ $suplier->s_name }}</option>
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

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Nama Perusahaan</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="s_company" placeholder="Masukkan Nama Perusahaan" value="{{ $data[0]->s_company }}" />
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Nama Supplier</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<input type="text" class="form-control" name="s_name" placeholder="Masukkan Nama Supplier" value="{{ $data[0]->s_name }}" id="s_name"/>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Limit</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="number" min="1" class="form-control" name="s_limit" placeholder="Masukkan Limitation" value="{{ $data[0]->s_limit }}" id="s_limit"/>
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
												<input type="text" class="form-control" name="s_phone" placeholder="Masukkan Nomor Telepon" value="{{ $data[0]->s_phone }}" id="s_phone"/>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Fax</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-fax"></i></span>
												<input type="text" class="form-control" name="s_fax" placeholder="Masukkan Nomor Fax Supplier" value="{{ $data[0]->s_fax }}" id="s_fax"/>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Alamat Supplier</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<textarea class="form-control" rows="5" style="resize: none;" placeholder="Masukkan Alamat Supplier" name="s_address" id="s_address">{{ $data[0]->s_address }}</textarea>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-3 col-lg-3 control-label text-left">Keterangan</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<textarea class="form-control" rows="5" style="resize: none;" placeholder="Tambahkan Keterangan Tentang Supplier" name="s_note" id="s_note">{{ $data[0]->s_note }}</textarea>
										</div>
									</div>
								</div>
							</div>

						</fieldset>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-default" type="reset" onclick="window.location = '{{url("/master/supplier")}}'">
										<i class="fa fa-times"></i>
										&nbsp;Batal
									</button>
									<button class="btn btn-primary" id="submit">
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
			$(document).ready(function(){

				var state = '{{ $data[0]->s_id }}';

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