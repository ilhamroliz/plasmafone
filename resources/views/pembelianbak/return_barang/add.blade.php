@extends('main')

@section('title', 'Purchase Return')

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
		<li>Home</li><li>Pembelian</li><li>Purchase Return</li><li>Tambah</li>
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

				<form id="purchase-form" class="form-horizontal" action="{{ url('/pembelian/purchase-return/add') }}" method="post">
					{{ csrf_field() }}
					<fieldset>
						<legend>
							Form Tambah Purchase Return
							<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
								<a href="{{ url('/pembelian/purchase-return') }}">
									<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
								</a>
							</span>
						</legend>

						<div class="row" style="margin-top: 15px" >

							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">No. Purchase Order</label>
									<div class="col-xs-8 col-lg-8 inputGroupContainer">
										<input type="text" list="list_purchase" class="form-control" name="purchase_order" id="purchase_order" placeholder="Masukkan nomor purchase order...." autocomplete="off" autofocus="" onchange="showPurchase()">
										<datalist id="list_purchase">
											@foreach($purchase as $purchase)
											<option value="{{ $purchase->podt_purchase }}">{{ $purchase->podt_purchase }}</option>
											@endforeach
										</datalist>
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
												<input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Masukkan kode barang" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="kuantitas" id="kuantitas" placeholder="Masukkan kuantitas barang" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Harga Satuan</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="harga_satuan" id="harga_satuan" placeholder="Masukkan harga satuan barang" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Total Bayar</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="total_bayar" id="total_bayar" placeholder="Masukkan total bayar" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Supplier</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="hidden" name="id_supplier" id="id_supplier">
												<input type="text" class="form-control" name="supplier" id="supplier" placeholder="Masukkan supplier barang" readonly />
											</div>
										</div>
									</div>
								</div>								

							</div>
						</div>

						<hr>
						<div class="field_wrapper" id="main_return">
							<div class="row" style="margin-top:15px;">

								<div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Methode Return</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<select class="form-control" name="methode_return" id="methode_return" required>
													<option value="">---Pilih methode return---</option>
													<option value="GB">Ganti Barang Baru</option>
													<option value="PT">Potong Tagihan</option>
													<option value="GU">Ganti Uang</option>
													<option value="PN">Potong Nota</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas Return</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="kuantitas_return" id="kuantitas_return" placeholder="Masukkan kuantitas return" required />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Total Harga Return</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="total_harga_return" id="total_harga_return" placeholder="Masukkan total harga return" readonly />
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

	var i_purchase_order = document.getElementById('purchase_order');
	var i_kuantitas_return = document.getElementById('kuantitas_return');
	var i_kuantitas = document.getElementById('kuantitas');
	var i_total_harga_return = document.getElementById('total_harga_return');
	var i_harga_satuan = document.getElementById('harga_satuan');
	i_kuantitas_return.addEventListener('keyup', function(e)
	{
		if (i_kuantitas_return.value > i_kuantitas.value) {
			alert('Jumlah kuantitas return tidak boleh melebihi jumlah kuantitas yang diterima!');
			i_kuantitas_return.value = '';
		}else{
			var n_hs = i_harga_satuan.value;
			var replace_rp = n_hs.toString().replace('Rp', '').replace(/\./g,'');
			var n_th = parseInt(i_kuantitas_return.value) * parseInt(replace_rp);
			i_total_harga_return.value = formatRupiah(n_th, 'Rp');
		}
	});

	function formatRupiah(angka, prefix)
	{
		var number_string = angka.toString(),
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

	function showPurchase() 
	{
		if (i_purchase_order.value == '') {
			$('#main_return').hide();
		}
		this.reset();
		var parameter = $("#purchase_order").val();
		axios.get(baseUrl+'/pembelian/show-purchase/'+parameter)
		.then((response) => {
			if(response.data == null){
				$.toast({
					text: 'Ups . Data Yang Anda pilih belum diterima atau sudah dihapus!',
					showHideTransition: 'fade',
					icon: 'error'
				})
				$('#form-load-section-status').fadeOut(200);
			}else{
				initiate(response.data);
				$('#main_return').show();
				$('#form-load-section-status').fadeOut(200);
			}
		})
		.catch((err) => {
			console.log(err);
		})
	}

	function initiate(data)
	{
		$('#kode_barang').val(data.podt_kode_barang);
		$('#kuantitas').val(data.podt_kuantitas);
		$('#harga_satuan').val(formatRupiah(data.podt_harga_satuan, 'Rp'));
		$('#total_bayar').val(formatRupiah(data.po_total_bayar, 'Rp'));
		$('#supplier').val(data.s_company);
		$('#id_supplier').val(data.s_id);
	}

	function reset()
	{
		$('#kode_barang').val('');
		$('#kuantitas').val('');
		$('#harga_satuan').val('');
		$('#total_bayar').val('');
		$('#supplier').val('');
		$('#id_supplier').val('');
	}

	$(document).ready(function(){

		if ($('#purchase_order').val() == '') {
			$('#main_return').hide();
		}else{
			$('#main_return').show();
		}

		// product form
		$('#purchase-form').bootstrapValidator({
			feedbackIcons : {
				valid : 'glyphicon glyphicon-ok',
				invalid : 'glyphicon glyphicon-remove',
				validating : 'glyphicon glyphicon-refresh'
			},
			fields : {
				purchase_order : {
					validators : {
						notEmpty : {
							message : 'Masukkan nomor purchase order'
						}
					}
				},
				methode_return : {
					validators : {
						notEmpty : {
							message : 'Pilih methode return barang'
						}
					}
				},
				kuantitas_return : {
					validators : {
						notEmpty : {
							message : 'Masukkan kuantitas return barang'
						}
					}
				}
			}
		});
		// end product form
	})
</script>

@endsection