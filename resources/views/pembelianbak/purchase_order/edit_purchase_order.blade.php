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
		<li>Home</li><li>Pembelian</li><li>Purchase Order</li><li>Edit</li>
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
							Form Edit Purchase Order
							<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
								<a href="{{ url('/pembelian/purchase-order') }}">
									<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
								</a>
							</span>
						</legend>

						<div class="row" style="margin-top: 15px" >

							<div class="col-md-6">
								<div class="form-group">
									<label class="col-xs-3 col-lg-3 control-label text-left">Pilih Data Yang Diedit</label>
									<div class="col-xs-8 col-lg-8 inputGroupContainer">
										<input type="hidden" name="po_no" id="po_no" value="{{ $data[0]->podt_purchase }}">
										<select class="form-control" name="podt_no" id="podt_no">
											@foreach($data as $key => $dt)
											<option value="{{ $dt->podt_no }}">Cabang-{{ $dt->c_nama }} | {{ $dt->podt_kode_barang }}</option>
											@endforeach
										</select>
										<input type="hidden" name="ro_cabang" id="ro_cabang" value="{{ $data[0]->ro_cabang }}">
										<input type="hidden" name="ro_kode_barang" id="ro_kode_barang" value="{{ $data[0]->podt_kode_barang }}">
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
												<input type="text" class="form-control" name="request_order" id="request_order" placeholder="Masukkan Nomor Request Order" value="{{ $data[0]->po_request_order_no }}" required readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Status</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<select class="form-control" name="status" id="status">
													<option value="Menunggu" @if($data[0]->po_status == "Menunggu") selected @endif>Menunggu</option>
													<option value="Diterima" @if($data[0]->po_status == "Diterima") selected @endif>Diterima</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Tipe Pembayaran</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<select class="form-control" name="tipe_pembayaran" id="tipe_pembayaran">
													<option value="Cash" @if($data[0]->po_type_pembayaran == "Cash") selected @endif>Cash</option>
													<option value="Kredit" @if($data[0]->po_type_pembayaran == "Kredit") selected @endif>Kredit</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Total Harga</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="total_harga" id="total_harga" onkeypress="return isNumberKey(event)" placeholder="Masukkan total harga" rel="{{ $data[0]->po_total_harga }}" required />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Diskon</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="number" min="0" class="form-control" name="diskon" id="diskon" placeholder="Masukkan diskon" value="{{ $data[0]->po_diskon }}" />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">PPN</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="number" min="0" class="form-control" name="ppn" id="ppn" placeholder="Masukkan PPn" value="{{ $data[0]->po_ppn }}" required />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Total Bayar</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="total_bayar" id="total_bayar" onkeypress="return isNumberKey(event)" placeholder="Masukkan total bayar" rel="{{ $data[0]->po_total_bayar }}" required />
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
												<input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Masukkan Kode Barang" value="{{ $data[0]->podt_kode_barang }}" required readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Supplier</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="hidden" name="id_supplier" id="id_supplier">
												<input type="text" class="form-control" name="supplier" id="supplier" placeholder="Masukkan Nama Supplier" value="{{ $data[0]->s_name }}" required readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Kuantitas</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="kuantitas" id="kuantitas" placeholder="Masukkan kuantitas" value="{{ $data[0]->podt_kuantitas }}" required readonly />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-xs-3 col-lg-3 control-label text-left">Harga Satuan</label>
											<div class="col-xs-8 col-lg-8 inputGroupContainer">
												<input type="text" class="form-control" name="harga_satuan" id="harga_satuan" onkeypress="return isNumberKey(event)" placeholder="Masukkan harga satuan" rel="{{ $data[0]->podt_harga_satuan }}" required />
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
	function isNumberKey(evt) {
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
	}

	$(document).ready(function(){

		var i_total_harga = document.getElementById('total_harga');
		var i_total_bayar = document.getElementById('total_bayar');
		var i_harga_satuan = document.getElementById('harga_satuan');
		i_total_harga.addEventListener('keyup', function(e)
		{
			i_total_harga.value = formatRupiah(this.value, 'Rp');
		});

		i_total_harga.value = formatRupiah($('#total_harga').attr('rel'), 'Rp');

		i_total_bayar.addEventListener('keyup', function(e)
		{
			i_total_bayar.value = formatRupiah(this.value, 'Rp');
		});

		i_total_bayar.value = formatRupiah($('#total_bayar').attr('rel'), 'Rp');

		i_harga_satuan.addEventListener('keyup', function(e)
		{
			i_harga_satuan.value = formatRupiah(this.value, 'Rp');
		});

		i_harga_satuan.value = formatRupiah($('#harga_satuan').attr('rel'), 'Rp');

		

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

		function rupiah(angka, prefix)
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

		// product form

		$('#form-edit').bootstrapValidator({
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
				order_request : {
					validators : {
						notEmpty : {
							message : 'Pilih request order'
						}
					}
				}
			}
		});

		$('#form-edit').submit(function(evt){
			evt.preventDefault();
			let btn = $('#submit');
			btn.attr('disabled', 'disabled');
			axios.post(baseUrl+'/pembelian/purchase-order/update', $('#form-edit').serialize())
			.then((response) => {
				if(response.data.status == 'berhasil'){
					$("#podt_no").children('option:selected').text("Cabang-"+$('#ro_cabang').val()+' | '+$('#ro_kode_barang').val());
					$.toast({
						text: 'Data Ini berhasil Diupdate',
						showHideTransition: 'fade',
						icon: 'success'
					})
				}else if(response.data.status == 'tidak ada'){
					$("#podt_no").children('option:selected').attr('disabled', 'disabled');
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
			})

		})

		// end product form

		// Select Order request

		$('#podt_no').on('change', function(e){
			var podt_no = $('#podt_no').val();
			// console.log(podt_no);
			axios.get(baseUrl+'/pembelian/purchase-order/get-purchase/'+podt_no)
			.then((response) => {
				// console.log(response.data);
				initiate(response.data);
			})
			.catch((err) => {
				console.log(err);
			})
		});

		function initiate(data){
			$('#po_no').val(data.podt_purchase);
			$('#request_order').val(data.po_request_order_no);
			$('#ro_cabang').val(data.ro_cabang);
			$('#ro_kode_barang').val(data.podt_kode_barang);
			$('#status').val(data.po_status);
			$('#tipe_pembayaran').val(data.po_type_pembayaran);
			$('#total_harga').val(rupiah(data.po_total_harga, 'Rp'));
			$('#diskon').val(data.po_diskon);
			$('#ppn').val(data.po_ppn);
			$('#total_bayar').val(rupiah(data.po_total_bayar, 'Rp'));
			$('#kode_barang').val(data.podt_kode_barang);
			$('#supplier').val(data.s_name);
			$('#kuantitas').val(data.podt_kuantitas);
			$('#harga_satuan').val(rupiah(data.podt_harga_satuan, 'Rp'));
		}

		// End select order
	})
</script>

@endsection