@extends('main')

@section('title', 'Master Gudang')


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
							Form Edit Gudang

							<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
								<a href="{{ url('/master/gudang') }}">
									<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
								</a>
							</span>
						</legend>

						<div class="row" style="border-bottom: 1px dotted #aaa; margin-bottom: 20px;">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">Pilih Data Yang Diedit</label>
									<div class="col-xs-7 col-lg-7 inputGroupContainer">
										<select class="form-control" name="id" id="id">
											@foreach($data as $key => $gudang)
											<option value="{{ $gudang->g_id }}">{{ $gudang->g_nama }}</option>
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
									<label class="col-xs-4 col-lg-4 control-label text-left">Kode Gudang</label>
									<div class="col-xs-7 col-lg-7 inputGroupContainer">
										<input type="text" class="form-control" name="kode_gudang" id="kode_gudang" placeholder="Masukkan kode gudang" value="{{ $data[0]->g_kode }}" readonly />
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">Nama Gudang</label>
									<div class="col-xs-7 col-lg-7 inputGroupContainer">
										<input type="text" class="form-control" name="nama_gudang" id="nama_gudang" placeholder="Masukkan nama gudang" value="{{ $data[0]->g_nama }}" />
									</div>
								</div>
							</div>
						</div>

					</fieldset>

					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn btn-default" id="submit">
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

		var state = '{{ $data[0]->g_id }}';

				// validator

				$('#form-edit').bootstrapValidator({
					feedbackIcons : {
						valid : 'glyphicon glyphicon-ok',
						invalid : 'glyphicon glyphicon-remove',
						validating : 'glyphicon glyphicon-refresh'
					},
					fields : {
						kode_gudang : {
							validators : {
								notEmpty : {
									message : 'Kode Gudang Tidak Boleh Kosong'
								}
							}
						},
						nama_gudang : {
							validators : {
								notEmpty : {
									message : 'Nama Gudang Tidak Boleh Kosong'
								}
							}
						}
					}
				});

				// end validator

				$('#id').change(function(evt){
					evt.preventDefault(); let context = $(this);
					$('#form-load-section-status').fadeIn(200);

					axios.get(baseUrl+'/master/gudang/get/'+context.val())
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
							state = response.data.g_id;
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

					let btn = $('#submit');
					btn.attr('disabled', 'disabled');

					axios.post(baseUrl+'/master/gudang/update', $('#form-edit').serialize())
					.then((response) => {
						if(response.data.status == 'berhasil'){
							$("#id").children('option:selected').text($('#nama_gudang').val());
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
					});

				})

				function initiate(data){
					$("#kode_gudang").val(data.g_kode);
					$("#nama_gudang").val(data.g_nama);
				}
			})
		</script>

		@endsection