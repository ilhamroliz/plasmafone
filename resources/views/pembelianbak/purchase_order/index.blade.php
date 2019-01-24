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
		<li>Home</li><li>Pembelian</li><li>Purchase Order</li>
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

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<ul class="menu-table hide-on-small">
				<li class="">
					<a href="{{ url('/pembelian/purchase-order') }}">
						<i class="fa fa-table"></i> &nbsp;Purchase Order
					</a>
				</li>
				<li>
					<a href="{{ url('/pembelian/purchase-order/add') }}">
						<i class="fa fa-plus"></i> &nbsp;Tambahkan Data
					</a>
				</li>

				<li>
					<a href="#" id="multiple_edit">
						<i class="fa fa-pencil-square"></i> &nbsp;Edit Data
					</a>
				</li>
				<li>
					<a href="#" id="multiple_delete">
						<i class="fa fa-eraser"></i> &nbsp;Hapus Data
					</a>
				</li>
				<li>
					<a href="{{ url('/pembelian/purchase-order/cetak') }}" id="print">
						<i class="fa fa-print"></i> &nbsp;Cetak
					</a>
				</li>

				<li class="right"><i class="fa fa-bars"></i></li>
			</ul>
		</div>
	</div>

	<!-- widget grid -->
	<section id="widget-grid" class="">

		<?php $mt = '20px'; ?>

		@if(Session::has('flash_message_success'))
		<?php $mt = '0px'; ?>
		<div class="col-md-12" style="margin-top: 20px;">
			<div class="alert alert-success alert-block">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
				{{ Session::get('flash_message_success') }} 
			</div>
		</div>
		@elseif(Session::has('flash_message_error'))
		<?php $mt = '0px'; ?>
		<div class="col-md-12" style="margin-top: 20px;">
			<div class="alert alert-danger alert-block">
				<a class="close" data-dismiss="alert" href="#">×</a>
				<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
				{{ Session::get('flash_message_error') }}
			</div>
		</div>
		@endif

		<!-- row -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 20px; margin-top: {{ $mt }};">
				<form id="table-form" method="post" action="{{ url('/pembelian/purchase-order/edit-multiple') }}">
					{!! csrf_field() !!}
					<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
						<thead>			                
							<tr>
								<th class="text-center" data-hide="phone" width="4%">*</th>
								<th class="text-center" width="5%" style="vertical-align: middle;">
									---
								</th>
								<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Purchase Order</th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Nomor Purchase Detail</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kode Barang</th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Supplier</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kuantitas</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Harga Satuan</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Status</th>
								<th class="text-center" data-hide="phone,tablet" width="15%"> Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								function rupiah($angka){
									$hasil_rupiah = "Rp" . number_format($angka,2,',','.');
									return $hasil_rupiah;
								}
							?>
							@foreach($data as $key => $data)
							<tr>
								<td class="text-center">{{ $key+1 }}</td>
								<td class="text-center">
									<input type="checkbox" class="check-me" name="data_check[]" data-id="{{$data->podt_purchase}}" value="{{ $data->podt_no }}"/>
								</td>
								<td>{{ $data->podt_purchase }}</td>
								<td>{{ $data->podt_no }}</td>
								<td>{{ $data->podt_kode_barang }}</td>
								<td>{{ $data->s_name }}</td>
								<td><center>{{ $data->podt_kuantitas }}</center></td>
								<td style="text-align: right;">{{ rupiah($data->podt_harga_satuan) }}</td>
								<td>{{ $data->po_status }}</td>
								<td class="text-center">
									<button type="button" class="btn btn-xs btn-success btn-circle view" data-toggle="tooltip" data-placement="top" title="View Data" data-id="{{ $data->podt_no }}"><i class="glyphicon glyphicon-folder-open"></i></button>
									<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="{{ $data->podt_no }}"><i class="glyphicon glyphicon-edit"></i></button>
									<button class="btn btn-xs btn-danger btn-circle hapus" data-toggle="tooltip" data-placement="top" title="Hapus Data" data-id="{{ $data->podt_no }}" rel="{{ $data->podt_purchase }}"><i class="glyphicon glyphicon-trash"></i></button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</form>
			</div>
		</div>

		<!-- end row -->

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title">
							<img src="{{ asset('template_asset/img/logo.png') }}" width="150" alt="SmartAdmin">
						</h4>
					</div>
					<div class="modal-body no-padding">

						<form id="view-form" class="smart-form">

							<fieldset>
								<section>
									<div class="row">
										<label class="label col col-2">Cabang</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="cabang" id="cabang" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Kode Barang</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="kode_barang" id="kode_barang" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Kuantitas</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="kuantitas" id="kuantitas" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Harga Satuan</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="harga_satuan" id="harga_satuan" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Tipe Pembayaran</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="tipe_pembayaran" id="tipe_pembayaran" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Total Harga</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="total_harga" id="total_harga" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Diskon</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="diskon" id="diskon" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">PPN</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="ppn" id="ppn" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Total Bayar</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="total_bayar" id="total_bayar" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Status</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="status" id="status" />
											</label>
										</div>
									</div>
								</section>

								<section>
									<div class="row">
										<label class="label col col-2">Supplier</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="supplier" id="supplier" />
											</label>
										</div>
									</div>
								</section>
							</fieldset>

							<footer>
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Tutup
								</button>

							</footer>
						</form>						


					</div>

				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


	</section>
	<!-- end widget grid -->

</div>
<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')

<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){

		var i_harga_satuan = document.getElementById('harga_satuan');
		var i_total_harga = document.getElementById('total_harga');
		var i_total_bayar = document.getElementById('total_bayar');


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

		let selected = []; po_dt_purchase = [];

		/* BASIC ;*/
		var responsiveHelper_dt_basic = undefined;
		var responsiveHelper_datatable_fixed_column = undefined;
		var responsiveHelper_datatable_col_reorder = undefined;
		var responsiveHelper_datatable_tabletools = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};
		
		$('#dt_basic').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});
		
		/* END BASIC */

		$('.check-me').change(function(evt){
			evt.preventDefault(); context = $(this);
			if(context.is(':checked')){
				selected.push(context.val());
				po_dt_purchase.push(context.data('id'));
			}else{
				selected.splice(_.findIndex(selected, function(o) { return o == context.val() }), 1);
			}

			// console.log(selected);
		})

		// hapus 1 click
		$(".hapus").click(function(evt){
			evt.preventDefault(); context = $(this);

			let ask = confirm('Apakah Anda Yakin . ?');
			if(ask){
				$('#overlay').fadeIn(300);
				axios.post(baseUrl+'/pembelian/purchase-order/multiple-delete', {
					podt_no 	: [context.data('id')],
					podt_purchase : [context.attr('rel')],
					_token 	: '{{ csrf_token() }}'
				})
				.then((response) => {
					if(response.data.status == 'berhasil'){
						location.reload();
					}
				}).catch((error) => {
					console.log(error);
				})
			}
		})


		// Hapus Click

		$("#multiple_delete").click(function(evt){
			evt.preventDefault();

			if(selected.length == 0){
				alert('Tidak Ada Data Yang Anda Pilih')
			}
			else{
				let ask = confirm(selected.length+' Data Akan Dihapus Apakah Anda Yakin . ?');
				if(ask){
					$('#overlay').fadeIn(300);
					axios.post(baseUrl+'/pembelian/purchase-order/multiple-delete', {
						podt_no 	: selected,
						podt_purchase : po_dt_purchase,
						_token 	: '{{ csrf_token() }}'
					})
					.then((response) => {
						if(response.data.status == 'berhasil'){
							location.reload();
						}
					}).catch((error) => {
						console.log(error);
					})
				}
			}

		})

		// Edit Click

		$("#multiple_edit").click(function(evt){
			evt.preventDefault();

			if(selected.length == 0){
				alert('Tidak Ada Data Yang Anda Pilih')
			}else{
				$("#table-form").submit();
			}
		})

		// edit 1 click

		$(".edit").click(function(evt){
			evt.preventDefault(); context = $(this);

			window.location = baseUrl+'/pembelian/purchase-order/edit?id='+context.data('id');
		})

		// view click
		$(".view").click(function(evt){
			evt.preventDefault(); context = $(this);
			// alert(context.data('id'));
			axios.get(baseUrl+'/pembelian/purchase-order/get/'+context.data('id'))
			.then((response) => {
				if(response.data == null){
					$.toast({
						text: 'Ups . Data Yang Ingin Anda Lihat Sudah Tidak Ada..',
						showHideTransition: 'fade',
						icon: 'error'
					})
					$('#form-load-section-status').fadeOut(200);
				}else{
						// console.log(response.data);
						initiate(response.data);
					}
				})
			.catch((err) => {
				console.log(err);
			})
			
		});

		function initiate(data){
			$('#cabang').val(data.c_nama);
			$('#kode_barang').val(data.podt_kode_barang);
			$('#kuantitas').val(data.podt_kuantitas);
			$('#harga_satuan').val(data.podt_harga_satuan);
			i_harga_satuan.value = formatRupiah($('#harga_satuan').val(), 'Rp');
			$('#tipe_pembayaran').val(data.po_type_pembayaran);
			$('#total_harga').val(data.po_total_harga);
			i_total_harga.value = formatRupiah($('#total_harga').val(), 'Rp');
			$('#diskon').val(data.po_diskon+"%");
			$('#ppn').val(data.po_ppn+"%");
			$('#total_bayar').val(data.po_total_bayar);
			i_total_bayar.value = formatRupiah($('#total_bayar').val(), 'Rp');
			$('#status').val(data.po_status);
			$('#supplier').val(data.s_name);
			$('#myModal').modal('show');
		}
	})
</script>

@endsection