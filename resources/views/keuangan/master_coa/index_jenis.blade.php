@extends('main')

@section('title', 'Return Barang')

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
		<li>Home</li>
		<li>management Keuangan</li>
		<li>Master Akun Keuangan</li>
		<li>Master Coa</li>
	</ol>

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
					<a href="{{ url('/keuangan/coa/jenis') }}">
						<i class="fa fa-table"></i> &nbsp;Master Jenis
					</a>
				</li>
				<li>
					<a href="{{ url('/keuangan/coa/kelompok') }}">
						<i class="fa fa-plus"></i> &nbsp;Master kelompok
					</a>
				</li>

				<li>
					<a href="{{ url('/keuangan/coa/bukubesar') }}" >
						<i class="fa fa-pencil-square"></i> &nbsp;Master Buku Besar
					</a>
				</li>
				<li>
					<a href="{{ url('/keuangan/coa/sub_bukubesar') }}" >
						<i class="fa fa-eraser"></i> &nbsp;Master Sub Buku Besar
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

		<!-- row -->
		<div class="col-md-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 20px; margin-top: {{ $mt }};">
				<form id="table-form" method="post" action="{{ url('/pembelian/purchase-return/edit-multiple') }}">
					{!! csrf_field() !!}
					<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
						<thead>			                
							<tr>
								<th class="text-center" data-hide="phone" width="4%">*</th>
								<th class="text-center" width="5%" style="vertical-align: middle;">
									---
								</th>
								<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;No. ACC </th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Nama ACC</th>
							</tr>
						</thead>
						<tbody>
							 <?php 
							function rupiah($angka){
								$hasil_rupiah = "Rp" . number_format($angka,2,',','.');
								return $hasil_rupiah;
							}
							?>
							
						</tbody>
					</table>
				</form>
			</div>
			
		</div>

		<div class="col-md-6">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 20px; margin-top: {{ $mt }};">
				<form id="table-form_2" method="post" action="{{ url('/pembelian/purchase-return/edit-multiple') }}">
					{!! csrf_field() !!}
					<table id="dt_basic_2" class="table table-striped table-bordered table-hover" width="100%">
						<thead>			                
							<tr>
								<th class="text-center" data-hide="phone" width="4%">*</th>
								<th class="text-center" width="5%" style="vertical-align: middle;">
									---
								</th>
								<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;No. ACC </th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Nama ACC</th>
							</tr>
						</thead>
						<tbody>
							
							
						</tbody>
					</table>
				</form>
			</div>
			
		</div>

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

						<form id="login-form" class="smart-form">

							<fieldset>

								<!-- <section>
									<div class="row">
										<label class="label col col-2">Order Nomor</label>
										<div class="col col-10">
											<label class="input"> <i class="icon-append fa fa-user"></i>
												<input type="text" disabled name="ro_no" id="ro_no" />
											</label>
										</div>
									</div>
								</section> -->
								<table class="table table-responsive table-bordered">
									<tr>
										<td>Nomor Purchase Order</td>
										<td id="npo"></td>
									</tr>
									<tr>
										<td>Kode Return</td>
										<td id="rc"></td>
									</tr>
									<tr>
										<td>Methode Return</td>
										<td id="mr"></td>
									</tr>
									<tr>
										<td>Tanggal Konfirmasi</td>
										<td id="tk"></td>
									</tr>
									<tr>
										<td>Total Harga Return</td>
										<td id="th"></td>
									</tr>
									<tr>
										<td>Result Harga</td>
										<td id="rh"></td>
									</tr>
									<tr>
										<td>Status Return</td>
										<td id="sr"></td>
									</tr>
									<tr>
										<td>Kode Barang</td>
										<td id="kb"></td>
									</tr>
									<tr>
										<td>Kuantitas Return</td>
										<td id="kr"></td>
									</tr>
									<tr>
										<td>Harga Satuan</td>
										<td id="hs"></td>
									</tr>
									
								</table>

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
		</div>
		<!-- /.modal -->

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
<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){

		let selected = [], return_id = [];

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

		$('#dt_basic_2').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_dt_basic) {
			responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic_2'), breakpointDefinition);
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
			return_id.push(context.data('id'));
			}else{
			selected.splice(_.findIndex(selected, function(o) { return o == context.val() }), 1);
		}
			//console.log(selected);
			//console.log(return_id);
		})

		// Hapus Click

		$("#multiple_delete").click(function(evt){
			evt.preventDefault();

			if(selected.length == 0){
				alert('Tidak Ada Data Yang Anda Pilih')
			}else{
				let ask = confirm(selected.length+' Data Akan Dihapus Apakah Anda Yakin ?');
				if(ask){
					$('#overlay').fadeIn(300);
					axios.post(baseUrl+'/pembelian/purchase-return/multiple-delete', {
						pr_id 	: selected,
						_token 	: '{{ csrf_token() }}'
					})
					.then((response) => {
						if(response.data.status == 'berhasil'){
						location.reload();
						// console.log(response);
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
		});

		// edit 1 click

		$(".edit").click(function(evt){
			evt.preventDefault(); context = $(this);

			window.location = baseUrl+'/pembelian/purchase-return/edit?id='+context.data('id');
		});

		// hapus 1 click
		$(".hapus").click(function(evt){
			evt.preventDefault(); context = $(this);

			let ask = confirm('Apakah Anda Yakin Akan Menghapus Data Ini?');
			if(ask){
				$('#overlay').fadeIn(300);
				axios.post(baseUrl+'/pembelian/purchase-return/multiple-delete', {
					pr_id 	: [context.data('id')],
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
		});

		// view click
		$(".view").click(function(evt){
			evt.preventDefault(); context = $(this);
			axios.get(baseUrl+'/pembelian/get-current-return/'+context.data('id'))
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
			// $('#myModal').modal('show');
		});

		function initiate(data){
			var status_return, methode_return;

			if (data.pr_methode_return == 'GB') {
				methode_return = "Ganti Barang Baru";
			} else if (data.pr_methode_return == 'PT') {
				methode_return = "Potong Tagihan";
			} else if (data.pr_methode_return == 'GU') {
				methode_return = "Ganti Uang";
			} else if (data.pr_methode_return == 'PN') {
				methode_return = "Potong Nota";
			}

			if (data.pr_status_return == 'WT') {
				status_return = "Waiting";
			} else if (data.pr_status_return == 'DE') {
				status_return = "Dapat Diedit";
			} else if (data.pr_status_return == 'CF') {
				status_return = "Confirmed";
			}

			$('#npo').text(data.pr_po_id);
			$('#rc').text(data.pr_code);
			$('#mr').text(methode_return);
			$('#tk').text(data.pr_confirm_date);
			$('#th').text(formatRupiah(data.pr_total_price, 'Rp'));
			$('#rh').text(formatRupiah(data.pr_result_price, 'Rp'));
			$('#sr').text(status_return);
			$('#kb').text(data.prd_kode_barang);
			$('#kr').text(data.prd_qty);
			$('#hs').text(formatRupiah(data.prd_unit_price, 'Rp'));
			$('#myModal').modal('show');
		}

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
	})
</script>

@endsection