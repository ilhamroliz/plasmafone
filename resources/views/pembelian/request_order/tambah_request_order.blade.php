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
		<li>Home</li><li>Pembelian</li><li>Request Order</li><li>Tambah</li>
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

	@if(Session::has('flash_message_success'))
	<?php $mt = '0px'; ?>
	<div class="col-md-8" style="margin-top: 20px;">
		<div class="alert alert-success alert-block">
			<a class="close" data-dismiss="alert" href="#">×</a>
			<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
			{{ Session::get('flash_message_success') }} 
		</div>
	</div>
	@elseif(Session::has('flash_message_error'))
	<?php $mt = '0px'; ?>
	<div class="col-md-8" style="margin-top: 20px;">
		<div class="alert alert-danger alert-block">
			<a class="close" data-dismiss="alert" href="#">×</a>
			<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
			{{ Session::get('flash_message_error') }}
		</div>
	</div>
	@endif

	<!-- widget grid -->
	<section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">

		<!-- row -->
		<div class="row">

			<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1" style="padding: 10px 20px; margin-top: 20px; background: #fff;">

				{{-- FormTemplate .. --}}

				<form id="ro-form" class="form-horizontal" action="{{ url('/pembelian/request-order/add') }}" method="post">
					{{ csrf_field() }}
					<fieldset>
						<legend>
							Form Tambah Request Order
							<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
								<a href="{{ url('/pembelian/request-order') }}">
									<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
								</a>
							</span>
						</legend>

						<div class="row" style="margin-top: 15px" >

							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-3 col-lg-3 control-label text-left">Cabang</label>
									<div class="col-xs-8 col-lg-8 inputGroupContainer">
										<select name="ro_cabang" id="ro_cabang" class="form-control">
											<option value="">---Pilih Cabang---</option>
											@foreach($data_outlet as $key => $outlet)
											<option value="{{ $outlet->c_id }}">{{ $outlet->c_nama }}</option>
											@endforeach
										</select>
									</div>
									<a href="javascript:void(0);" class="btn btn-xs btn-success btn-circle add_button" title="Add field"><i class="fa fa-plus fa-fw"></i></a>
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
												<input type="text" class="form-control" name="kode_barang[]" placeholder="Masukkan kode barang" required />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="number" class="form-control" min="1" name="kuantitas[]" placeholder="Masukkan kuantitas" required />
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
								<button class="btn btn-default" type="submit">
									<i class="fa fa-floppy-o"></i>
									&nbsp;Submit
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

		var addButton = $('.add_button');
		var wrapper = $('.field_wrapper');
		var fieldHTML = '<div><a href="javascript:void(0);" class="btn btn-xs btn-danger btn-circle remove_button" title="Remove Field"><i class="fa fa-minus fa-fw"></i></a><hr><div class="row" style="margin-top:15px;"><div><div class="col-md-6"><div class="form-group"><label class="col-xs-3 col-lg-3 control-label text-left">Kode Barang</label><div class="col-xs-8 col-lg-8 inputGroupContainer"><input type="text" class="form-control" name="kode_barang[]" placeholder="Masukkan kode barang" required /></div></div></div><div class="col-md-6"><div class="form-group"><label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label><div class="col-xs-8 col-lg-8 inputGroupContainer"><input type="number" min="1" class="form-control" name="kuantitas[]" placeholder="Masukkan kuantitas" required /></div></div></div></div></div><div>';
		var x = 1;
		$(addButton).click(function(){
			x++;
			$(wrapper).append(fieldHTML);
		});
		$(wrapper).on('click', '.remove_button', function(e){
			e.preventDefault();
			$(this).parent('div').remove();
			x--;
		});
		// product form

		$('#ro-form').bootstrapValidator({
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			fields : {
				ro_cabang : {
					validators : {
						notEmpty : {
							message : 'Cabang Tidak Boleh Kosong'
						}
					}
				},
				ro_no : {
					validators : {
						notEmpty : {
							message : 'Order Nomor Tidak Boleh Kosong'
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

		// end product form
	})
</script>

@endsection