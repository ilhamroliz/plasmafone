@extends('main')

@section('title', 'Konfirmasi Pembelian')


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
		<li>Home</li><li>Pembelian</li><li>Konfirmasil Pembelian</li>
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
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<select class="form-control" name="supplier" id="supplier">
				<option value="">---Pilih Supplier---</option>
				@foreach($data_supplier as $supplier)
				<option value="{{ $supplier->s_id }}">{{ $supplier->s_name }}</option>
				@endforeach
			</select>
		</div>
		<div>
			<input type="hidden" name="id_supplier" id="id_supplier" value="{{ $data }}" />
			<a href="{{ url('/pembelian/konfirmasi-pembelian/print/'.$data) }}" target="_blank" class="btn btn-primary" disabled id="btn_cetak"><i class="fa fa-print"></i>&nbsp;Print</a>
			<a href="{{ url('/pembelian/konfirmasi-pembelian/download-pdf/'.$data) }}" target="_blank" class="btn btn-danger" disabled id="btn_download"><i class="fa fa-download"></i>&nbsp;Download</a>
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
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 20px; margin-top: {{ $mt }};">
			
				<form id="table-form" method="post" action="{{ url('/pembelian/rencana-pembelian/rencana-pembelian/edit-multiple') }}">
				{!! csrf_field() !!}
					<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
						<thead>			                
							<tr>
								<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Request Order</th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Request Nomor</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Cabang</th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Kode Barang</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kuantitas</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kuantitas Approval</th>
								<th class="text-center" data-hide="phone,tablet" width="15%"> Status</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Supplier</th>
								<!-- <th class="text-center" data-hide="phone,tablet" width="15%"> Aksi</th> -->
							</tr>
						</thead>
						<tbody>
							@if($data != "Null")
							@foreach($data_order as $order)
							<tr>
								<td>{{ $order->rdt_request }}</td>
								<td>{{ $order->rdt_no }}</td>
								<td>{{ $order->c_nama }}</td>
								<td>{{ $order->rdt_kode_barang }}</td>
								<td><center>{{ $order->rdt_kuantitas }}</center></td>
								<td><center>{{ $order->rdt_kuantitas_approv }}</center></td>
								<td>{{ $order->rdt_status }}</td>
								<td>{{ $order->s_name }}</td>
                            </tr>
                            @endforeach
                            @endif
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

        				<form id="login-form" class="smart-form">

        					<fieldset>
        						<section>
        							<div class="row">
        								<label class="label col col-2">Order Nomor</label>
        								<div class="col col-10">
        									<label class="input"> <i class="icon-append fa fa-user"></i>
        										<input type="text" disabled name="ro_no" id="ro_no" />
        									</label>
        								</div>
        							</div>
        						</section>

        						<section>
        							<div class="row">
        								<label class="label col col-2">Cabang</label>
        								<div class="col col-10">
        									<label class="input"> <i class="icon-append fa fa-user"></i>
        										<input type="text" disabled name="ro_cabang" id="ro_cabang" />
        									</label>
        								</div>
        							</div>
        						</section>

        						<section>
        							<div class="row">
        								<label class="label col col-2">Detail Order Nomor</label>
        								<div class="col col-10">
        									<label class="input"> <i class="icon-append fa fa-user"></i>
        										<input type="text" disabled name="rdt_no" id="rdt_no" />
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
        								<label class="label col col-2">Kuantitas Approval</label>
        								<div class="col col-10">
        									<label class="input"> <i class="icon-append fa fa-user"></i>
        										<input type="text" disabled name="kuantitas_approv" id="kuantitas_approv" />
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

		if ($('#id_supplier').val() != "Null") {
			$('#btn_cetak').removeAttr('disabled');
			$('#btn_download').removeAttr('disabled');
		}

		let selected = [];

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
			if(context.is(':checked'))
				selected.push(context.val());
			else
				selected.splice(_.findIndex(selected, function(o) { return o == context.val() }), 1);

			// console.log(selected);
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
					axios.post(baseUrl+'/master/suplier/suplier/multiple-delete', {
						data 	: selected,
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

			window.location = baseUrl+'/pembelian/rencana-pembelian/rencana-pembelian/edit?id='+context.data('id');
		})

		// hapus 1 click
		$(".hapus").click(function(evt){
			evt.preventDefault(); context = $(this);

			let ask = confirm('Apakah Anda Yakin . ?');
			if(ask){
				$('#overlay').fadeIn(300);
				axios.post(baseUrl+'/master/suplier/suplier/multiple-delete', {
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
		})

		$('.status').on('change', function(e){
			var value = $(this).val();
			var no = $(this).attr('rel');
			var rdt_req = $(this).attr('rel1');
			// window.location = baseUrl+'/pembelian/rencana-pembelian/request-order-status?status='+value+'&&rdt_no='+no;
			$('#overlay').fadeIn(300);
			axios.post(baseUrl+'/pembelian/rencana-pembelian/request-order-status', {
				status 	: value,
				rdt_no 	: no,
				rdt_request : rdt_req,
				_token 	: '{{ csrf_token() }}'
			})
			.then((response) => {
				if(response.data.status == 'rencana pembelian'){
					$.toast({
						text: 'Status untuk Request Detail "'+no+'" berhasil diubah ke "Rencana Pembelian".',
						showHideTransition: 'fade',
						icon: 'success'
					});
					location.reload();
				} else if (response.data.status == 'ditunda') {
					$.toast({
						text: 'Status untuk Request Detail "'+no+'" berhasil diubah ke "Ditunda".',
						showHideTransition: 'fade',
						icon: 'success'
					});
					location.reload();
				} else if (response.data.status == 'dibatalkan') {
					$.toast({
						text: 'Status untuk Request Detail "'+no+'" berhasil diubah ke "Dibatalkan".',
						showHideTransition: 'fade',
						icon: 'success'
					});
					location.reload();
				} else if (response.data.status == 'pending') {
					$.toast({
						text: 'Status untuk Request Detail "'+no+'" berhasil diubah ke "Pending".',
						showHideTransition: 'fade',
						icon: 'success'
					});
					location.reload();
				}
			}).catch((error) => {
				console.log(error);
			})
		});

		// Change Supplier
		$('#supplier').change(function(evt){
			evt.preventDefault(); let context = $(this);
			$('#form-load-section-status').fadeIn(200);
			// alert(context.val());
			window.location = baseUrl+'/pembelian/konfirmasi-pembelian/get-data-order/'+context.val();
			
		})

		// view click
		$(".view").click(function(evt){
			evt.preventDefault(); context = $(this);
			axios.get(baseUrl+'/pembelian/request-order/get/'+context.data('id'))
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
					initiate(response.data);
				}
			})
			.catch((err) => {
				console.log(err);
			})
			
		});

		function initiate(data){
			$('#ro_no').val(data.ro_no);
			$('#ro_cabang').val(data.ro_cabang);
			$('#rdt_no').val(data.rdt_no);
			$('#kode_barang').val(data.rdt_kode_barang);
			$('#kuantitas').val(data.rdt_kuantitas);
			$('#kuantitas_approv').val(data.rdt_kuantitas_approv);
			$('#status').val(data.rdt_status);
			var supp;
			if (data.rdt_supplier == "0") {
				supp = "Belum Ada";
			}else{
				supp = data.s_name;
			}
			$('#supplier').val(supp);
			$('#myModal').modal('show');
		}
	})
</script>

@endsection