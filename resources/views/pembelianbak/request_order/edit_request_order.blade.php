@extends('main')

@section('title', 'Request Order')

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
		<li>Home</li><li>Pembelian</li><li>Request Order</li><li>Tambah Request</li>
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
							Form Edit Request Order
							<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
								<a href="{{ url('/pembelian/request-order') }}">
									<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
								</a>
							</span>
						</legend>

						<div class="row" style="border-bottom: 1px dotted #aaa; margin-bottom: 20px;">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">Pilih Data Yang Diedit</label>
									<div class="col-xs-7 col-lg-7 inputGroupContainer">
										<select class="form-control" name="rdt_request_no" id="id">
											@foreach($data as $key => $order)
											<option value="{{ $order->rdt_no }}">{{ $order->rdt_request }} - {{ $order->c_nama }}</option>
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

						<div class="row" style="margin-top: 15px" >
							<input type="hidden" name="no_req" id="no_req" value="{{ $data[0]->rdt_request }}">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-3 col-lg-3 control-label text-left">Cabang</label>
									<div class="col-xs-8 col-lg-8 inputGroupContainer">
										<input type="text" class="form-control" name="ro_cabang" id="ro_cabang" placeholder="Masukkan Cabang" value="{{ $data[0]->c_nama }}" required readonly />
									</div>
									<!-- <a href="javascript:void(0);" class="btn btn-xs btn-success btn-circle add_button" title="Add field"><i class="fa fa-plus fa-fw"></i></a> -->
								</div>
							</div>
						</div>

						<hr>
						<div class="field_wrapper">
							<div class="row" style="margin-top:15px;">

								<div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kode Barang</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Masukkan kode barang" value="{{ $data[0]->rdt_kode_barang }}" required />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="number" class="form-control" name="kuantitas" id="kuantitas" placeholder="Masukkan kuantitas" value="{{ $data[0]->rdt_kuantitas }}" required />
											</div>
										</div>
									</div>

								</div>								

							</div>
						</div>

					</fieldset>

					<div class="form-actions">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-default" id="submit">
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

		var state = '{{ $data[0]->rdt_no }}';

		// validator

		$('#form-edit').bootstrapValidator({
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			fields : {
				cabang : {
					validators : {
						notEmpty : {
							message : 'Cabang Tidak Boleh Kosong'
						}
					}
				},
				kode_barang : {
					validators : {
						notEmpty : {
							message : 'Kode Barang Tidak Boleh Kosong'
						}
					}
				},
				rdt_kuantitas : {
					validators : {
						notEmpty : {
							message : 'Kuantitas Tidak Boleh Kosong'
						},
						numeric : {
							message : 'Kuantitas Ini Tampaknya Salah'
						}
					}
				},
				rdt_kuantitas_approv : {
					validators : {
						notEmpty : {
							message : 'Kuantitas Approval Tidak Boleh Kosong'
						},
						numeric : {
							message : 'Kuantitas Approval Ini Tampaknya Salah'
						}
					}
				}
			}
		});

		// end validator

		$('#id').change(function(evt){
			evt.preventDefault(); let context = $(this);
			$('#form-load-section-status').fadeIn(200);

			axios.get(baseUrl+'/pembelian/request-order/get/'+context.val())
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
					state = response.data.rdt_no;
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

				axios.post(baseUrl+'/pembelian/request-order/update', $('#form-edit').serialize())
				.then((response) => {
					if(response.data.status == 'berhasil'){
						$("#id").children('option:selected').text($('#no_req').val()+' - '+$('#ro_cabang').val());
						$.toast({
							text: 'Data Ini berhasil Diupdate',
							showHideTransition: 'fade',
							icon: 'success'
						});
					}else if(response.data.status == 'tidak ada'){
						$("#id").children('option:selected').attr('disabled', 'disabled');
						$.toast({
							text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
							showHideTransition: 'fade',
							icon: 'error'
						});
					}
				}).catch((err) => {
					console.log(err);
				}).then(function(){
					btn.removeAttr('disabled');
				})
			}

		})

		function initiate(data){
			$("#ro_no").val(data.ro_no);
			$("#cabang").val(data.ro_cabang);
			$("#kode_barang").val(data.rdt_kode_barang);
			$("#kuantitas").val(data.rdt_kuantitas);
		}
	})
</script>

@endsection