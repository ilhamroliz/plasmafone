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
		<li>Home</li><li>Pembelian</li><li>Purchase Return</li><li>Edit</li>
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

				<form id="purchase-form" class="form-horizontal" method="post">
					{{ csrf_field() }}
					<fieldset>
						<legend>
							Form Edit Purchase Return

							<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
								<a href="{{ url('/pembelian/purchase-return') }}">
									<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
								</a>
							</span>
						</legend>

						<div class="row" style="border-bottom: 1px dotted #aaa; margin-bottom: 20px;">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">Pilih Data Yang Diedit</label>
									<div class="col-xs-7 col-lg-7 inputGroupContainer">
										<select class="form-control" name="return_id" id="return_id">
											@foreach($data as $key => $return)
											<option value="{{ $return->pr_id }}">{{ $return->pr_po_id }} - {{ $return->pr_code }}</option>
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

							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-4 col-lg-4 control-label text-left">No. Purchase Order</label>
									<div class="col-xs-8 col-lg-8 inputGroupContainer">
										<input type="text" class="form-control" name="purchase_order" id="purchase_order" placeholder="Masukkan nomor purchase order...." value="{{ $data[0]->pr_po_id }}" readonly>
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
												<input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Masukkan kode barang" value="{{ $data[0]->prd_kode_barang }}" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="kuantitas" id="kuantitas" placeholder="Masukkan kuantitas barang" value="{{ $data[0]->prd_qty }}" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Harga Satuan</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="harga_satuan" id="harga_satuan" placeholder="Masukkan harga satuan barang" value="{{ $data[0]->prd_unit_price }}" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Total Bayar</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="total_bayar" id="total_bayar" placeholder="Masukkan total bayar" value="{{ $data[0]->po_total_bayar }}" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Supplier</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="hidden" name="id_supplier" id="id_supplier" value="{{ $data[0]->podt_kode_suplier }}">
												<input type="text" class="form-control" name="supplier" id="supplier" placeholder="Masukkan supplier barang" value="{{ $data[0]->s_company }}" readonly />
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
												<select class="form-control" name="methode_return" id="methode_return">
													<option value="" @if($data[0]->pr_methode_return == '') selected @endif>---Pilih methode return---</option>
													<option value="GB" @if($data[0]->pr_methode_return == 'GB') selected @endif>Ganti Barang Baru</option>
													<option value="PT" @if($data[0]->pr_methode_return == 'PT') selected @endif>Potong Tagihan</option>
													<option value="GU" @if($data[0]->pr_methode_return == 'GU') selected @endif>Ganti Uang</option>
													<option value="PN" @if($data[0]->pr_methode_return == 'PN') selected @endif>Potong Nota</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas Return</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="kuantitas_return" id="kuantitas_return" placeholder="Masukkan kuantitas return" value="{{ $data[0]->prd_qty }}" />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Total Harga Return</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="total_harga_return" id="total_harga_return" placeholder="Masukkan total harga return" value="{{ $data[0]->pr_total_price }}" readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Confirm Return</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<select class="form-control" name="confirm_return" id="confirm_return">
													<option value="WT" @if($data[0]->pr_status_return == 'WT') selected @endif>Waiting</option>
													<option value="CF" @if($data[0]->pr_status_return == 'CF') selected @endif>Confirmed</option>
												</select>
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
								<button class="btn btn-default" type="submit" id="submit">
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
	var i_total_bayar = document.getElementById('total_bayar');

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

	window.addEventListener('load', function(e){
		i_harga_satuan.value 		= formatRupiah(i_harga_satuan.value, 'Rp');
		i_total_bayar.value 		= formatRupiah(i_total_bayar.value, 'Rp');
		i_total_harga_return.value 	= formatRupiah(i_total_harga_return.value, 'Rp');
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

		// Pilih data edit
		$('#return_id').change(function(evt){
			evt.preventDefault(); let context = $(this);
			$('#form-load-section-status').fadeIn(200);

			axios.get(baseUrl+'/pembelian/purchase-return/get-current-return/'+context.val())
			.then((response) => {
				if(response.data == null){
					context.children('option:selected').attr('disabled', 'disabled');
					$.toast({
						text: 'Ups . Data Yang Ingin Anda Edit Sudah Tidak Ada..',
						showHideTransition: 'fade',
						icon: 'error'
					})
					$('#form-load-section-status').fadeOut(200);
				}else{
					// console.log(response.data);
					resetForm();
					init(response.data);
					$('#form-load-section-status').fadeOut(200);
				}
			})
			.catch((err) => {
				console.log(err);
			})

		});

		function init(data)
		{
			$('#purchase_order').val(data.po_no);
			$('#kode_barang').val(data.podt_kode_suplier);
			$('#kuantitas').val(data.podt_kuantitas);
			$('#harga_satuan').val(formatRupiah(data.podt_harga_satuan, 'Rp'));
			$('#total_bayar').val(formatRupiah(data.po_total_bayar, 'Rp'));
			$('#id_supplier').val(data.podt_kode_suplier);
			$('#supplier').val(data.s_company);
			$('#methode_return').val(data.pr_methode_return);
			$('#kuantitas_return').val(data.prd_qty);
			$('#total_harga_return').val(formatRupiah(data.pr_result_price, 'Rp'));
			$('#confirm_return').val(data.pr_status_return);
		}

		function resetForm()
		{
			$('#purchase_order').val('');
			$('#kode_barang').val('');
			$('#kuantitas').val('');
			$('#harga_satuan').val('');
			$('#total_bayar').val('');
			$('#id_supplier').val('');
			$('#supplier').val('');
			$('#methode_return').val('');
			$('#kuantitas_return').val('');
			$('#total_harga_return').val('');
			$('#confirm_return').val('');
		}
		// end pilih data edit

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

		// submit
		$('#purchase-form').submit(function(evt){
			evt.preventDefault();

			let btn = $('#submit');
			btn.attr('disabled', 'disabled');

			axios.post(baseUrl+'/pembelian/purchase-return/update', $('#purchase-form').serialize())
			.then((response) => {
				if(response.data.status == 'berhasil'){
					$("#return_id").children('option:selected');
					$.toast({
						text: 'Data Ini berhasil Diupdate',
						showHideTransition: 'fade',
						icon: 'success'
					});
				}else if(response.data.status == 'tidak ada'){
					$("#return_id").children('option:selected').attr('disabled', 'disabled');
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

		})
		// end submit
	})
</script>

@endsection