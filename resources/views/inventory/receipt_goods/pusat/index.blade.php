@extends('main')

@section('title', 'Penerimaan Barang Dari Pusat')

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
		<li>Home</li><li>Inventory</li><li>Penerimaan Barang Dari Pusat</li>
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
					<a href="{{ url('/inventory/penerimaan/pusat') }}">
						<i class="fa fa-table"></i> &nbsp;Data Tabel
					</a>
				</li>
				<li>
					<a href="{{ url('/inventory/penerimaan/pusat/add') }}">
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
				<form id="table-form" method="post" action="{{ url('/inventory/penerimaan/pusat/edit-multiple') }}">
					{!! csrf_field() !!}
					<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
						<thead>			                
							<tr>
								<th class="text-center" data-hide="phone" width="4%">*</th>
								<th class="text-center" width="5%" style="vertical-align: middle;">
									---
								</th>
								<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Kategori</th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;IMEI</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kode Barang</th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Nama Barang</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kuantitas</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Tanggal Masuk</th>
								<th class="text-center" data-hide="phone,tablet" width="15%"> Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $key => $barang)
							<tr>
								<td class="text-center">{{ $key+1 }}</td>
								<td class="text-center">
									<input type="checkbox" class="check-me" name="data_check[]" data-id="{{$barang->i_id}}" value="{{ $barang->i_id }}"/>
								</td>
								<td>{{ $barang->i_kategori }}</td>
								<td>@if($barang->i_imei == "") <center> ----- </center> @else {{ $barang->i_imei }} @endif</td>
								<td>{{ $barang->i_kode_barang }}</td>
								<td>{{ $barang->i_nama_barang }}</td>
								<td><center>{{ $barang->i_qty }}</center></td>
								<td>{{ $barang->i_tgl_masuk }}</td>
								<td class="text-center">
									<button type="button" class="btn btn-xs btn-success btn-circle view" data-toggle="tooltip" data-placement="top" title="View Data" data-id="{{ $barang->i_id }}"><i class="fa fa-eye fa-fw"></i></button>
									<button class="btn btn-xs btn-success btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="{{ $barang->i_id }}"><i class="fa fa-pencil fa-fw"></i></button>
									<button class="btn btn-xs btn-success btn-circle hapus" data-toggle="tooltip" data-placement="top" title="Hapus Data" data-id="{{ $barang->i_id }}"><i class="fa fa-eraser fa-fw"></i></button>
								</td>
							</tr>
							@endforeach
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
								<h3 class="text-center" style="margin-bottom: 20px;">Penerimaan Barang Dari Supplier</h3>
								<table class="table table-responsive table-bordered">
									<tr>
										<td>Kategori</td>
										<td id="v_kategori"></td>
									</tr>
									<tr>
										<td>IMEI</td>
										<td id="v_imei"></td>
									</tr>
									<tr>
										<td>Kode Barang</td>
										<td id="v_kode_barang"></td>
									</tr>
									<tr>
										<td>Nama Barang</td>
										<td id="v_nama_barang"></td>
									</tr>
									<tr>
										<td>Kuantitas</td>
										<td id="v_qty"></td>
									</tr>
									<tr>
										<td>Tanggal Masuk</td>
										<td id="v_tgl_masuk"></td>
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
		$('.check-me').prop( "checked", false );
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
					axios.post(baseUrl+'/inventory/penerimaan/pusat/multiple-delete', {
						data 	: selected,
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

			window.location = baseUrl+'/inventory/penerimaan/pusat/edit?id='+context.data('id');
		});

		// hapus 1 click
		$(".hapus").click(function(evt){
			evt.preventDefault(); context = $(this);

			let ask = confirm('Apakah Anda Yakin Akan Menghapus Data Ini?');
			if(ask){
				$('#overlay').fadeIn(300);
				axios.post(baseUrl+'/inventory/penerimaan/pusat/multiple-delete', {
					data 	: [context.data('id')],
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
			axios.get(baseUrl+'/inventory/penerimaan/pusat/get-current-receipt-pusat/'+context.data('id'))
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
			var no_imei;
			if (data.i_imei == null) {
				no_imei = "-----";
			} else {
				no_imei = data.i_imei;
			}
			$('#v_kategori').text(data.i_kategori);
			$('#v_imei').text(no_imei);
			$('#v_kode_barang').text(data.i_kode_barang);
			$('#v_nama_barang').text(data.i_nama_barang);
			$('#v_qty').text(data.i_qty);
			$('#v_tgl_masuk').text(data.i_tgl_masuk);
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