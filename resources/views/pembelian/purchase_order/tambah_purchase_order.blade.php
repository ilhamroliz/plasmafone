@extends('main')

@section('title', 'Purchase Order')

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
		<li>Home</li><li>Pembelian</li><li>Purchase Order</li><li>Tambah</li>
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

				<form id="purchase-form" class="form-horizontal" action="{{ url('/pembelian/purchase-order/add-purchase') }}" method="post">
					{{ csrf_field() }}
					<fieldset>
						<legend>
							Form Tambah Purchase Order
							<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
								<a href="{{ url('/pembelian/purchase-order') }}">
									<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
								</a>
							</span>
						</legend>

						<div class="row" style="margin-top: 15px" >

							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-3 col-lg-3 control-label text-left">Request Order Cabang</label>
									<div class="col-xs-8 col-lg-8 inputGroupContainer">
										<select class="form-control" name="request_dt_no" id="request_dt_no">
											<option value="">---Pilih Request Order Cabang---</option>
											@foreach($data_request as $data)
											<option value="{{ $data->rdt_no }}">Cabang-{{ $data->c_nama }} | {{ $data->rdt_kode_barang }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>

						<hr>
						<div class="field_wrapper">
							<div class="row" style="margin-top:15px;">

								<div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Request Order No.</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="request_order" id="request_order" placeholder="Masukkan Nomor Request Order" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Status</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<select class="form-control" name="status" id="status">
													<option value="Menunggu">Menunggu</option>
													<option value="Diterima">Diterima</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Tipe Pembayaran</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<select class="form-control" name="tipe_pembayaran" id="tipe_pembayaran">
													<option value="Cash">Cash</option>
													<option value="Kredit">Kredit</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Total Harga</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="total_harga" id="total_harga" onkeypress="return isNumberKey(event)" placeholder="Masukkan total harga" required />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Diskon</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="number" min="0" class="form-control" name="diskon" id="diskon" placeholder="Masukkan diskon" />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">PPN</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="number" min="0" class="form-control" name="ppn" id="ppn" placeholder="Masukkan PPn" required />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Total Bayar</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="total_bayar" id="total_bayar" onkeypress="return isNumberKey(event)" placeholder="Masukkan total bayar" required />
											</div>
										</div>
									</div>
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
												<input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Masukkan Kode Barang" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Supplier</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="hidden" name="id_supplier" id="id_supplier">
												<input type="text" class="form-control" name="supplier" id="supplier" placeholder="Masukkan Nama Supplier" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="kuantitas" id="kuantitas" placeholder="Masukkan kuantitas" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Harga Satuan</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="harga_satuan" id="harga_satuan" onkeypress="return isNumberKey(event)" placeholder="Masukkan harga satuan" required />
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
	var i_total_harga = document.getElementById('total_harga');
	var i_total_bayar = document.getElementById('total_bayar');
	var i_harga_satuan = document.getElementById('harga_satuan');
	i_total_harga.addEventListener('keyup', function(e)
	{
		i_total_harga.value = formatRupiah(this.value, 'Rp');
	});

	i_total_bayar.addEventListener('keyup', function(e)
	{
		i_total_bayar.value = formatRupiah(this.value, 'Rp');
	});

	i_harga_satuan.addEventListener('keyup', function(e)
	{
		i_harga_satuan.value = formatRupiah(this.value, 'Rp');
	});

	function isNumberKey(evt) {
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
	}

	function formatRupiah(angka, prefix)
	{
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split	= number_string.split(','),
		sisa 	= split[0].length % 3,
		rupiah 	= split[0].substr(0, sisa),
		ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);

		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
	}

	$(document).ready(function(){

		// product form

		$('#purchase-form').bootstrapValidator({
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			fields : {
				total_harga : {
					validators : {
						notEmpty : {
							message : 'Total harga tidak boleh kosong'
						}
					}
				},
				ppn : {
					validators : {
						notEmpty : {
							message : 'PPn tidak boleh kosong'
						}
					}
				},
				total_bayar : {
					validators : {
						notEmpty : {
							message : 'Total bayar tidak boleh kosong'
						}
					}
				},
				harga_satuan : {
					validators : {
						notEmpty : {
							message : 'Harga satuan tidak boleh kosong'
						}
					}
				},
				request_dt_no : {
					validators : {
						notEmpty : {
							message : 'Pilih request order'
						}
					}
				}
			}
		});

		// end product form

		// Select Order request

		$('#request_dt_no').on('change', function(e){
			var rdt_no = $('#request_dt_no').val();
			axios.get(baseUrl+'/pembelian/purchase-order/get-request-purchase/'+rdt_no)
			.then((response) => {
					// console.log(response.data);
					initiate(response.data);
				})
			.catch((err) => {
				console.log(err);
			})
		});

		function initiate(data){
			$('#request_order').val(data.rdt_request);
			$('#kode_barang').val(data.rdt_kode_barang);
			$('#id_supplier').val(data.rdt_supplier);
			$('#supplier').val(data.s_name);
			$('#kuantitas').val(data.rdt_kuantitas_approv);
		}

		// End select order
	})
</script>

@endsection