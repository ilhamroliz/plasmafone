@extends('main')

@section('title', 'Rencana Pembelian')

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
		<li>Home</li><li>Pembelian</li><li>Request Order</li>
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
					<a href="{{ url('/pembelian/request-order') }}">
						<i class="fa fa-table"></i> &nbsp;Request Order
					</a>
				</li>
				<li>
					<a href="{{ url('/pembelian/request-order/add') }}">
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
					<form id="table-form" method="post" action="{{ url('/pembelian/request-order/edit-multiple') }}">
						{!! csrf_field() !!}
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th class="text-center" data-hide="phone" width="4%">*</th>
									<th class="text-center" width="5%" style="vertical-align: middle;">
										---
									</th>
									<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Request Order</th>
									<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Request Nomor</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Cabang</th>
									<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Kode Barang</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kuantitas</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kuantitas Approval</th>
									<!-- <th class="text-center" data-hide="phone,tablet" width="15%"> Tindakan</th> -->
									<th class="text-center" data-hide="phone,tablet" width="15%"> Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach($r_orders_dt as $key => $r_order)
								<tr>
									<td class="text-center">{{ $key+1 }}</td>
									<td class="text-center">
										<input type="checkbox" class="check-me" name="data_check[]" data-id="{{$r_order->rdt_request}}" value="{{ $r_order->rdt_no }}"/>
									</td>
									<td>{{ $r_order->rdt_request }}</td>
									<td>{{ $r_order->rdt_no }}</td>
									<td>{{ $r_order->c_nama }}</td>
									<td>{{ $r_order->rdt_kode_barang }}</td>
									<td><center>{{ $r_order->rdt_kuantitas }}</center></td>
									<td><center>{{ $r_order->rdt_kuantitas_approv }}</center></td>
		                                <!-- <td>
		                                	<select name="status[]" rel="{{ $r_order->rdt_no }}" rel1="{{ $r_order->rdt_request }}" rel2="{{ $r_order->rdt_kode_barang }}" rel3="{{ $r_order->rdt_kuantitas }}" rel4="{{ $r_order->rdt_kuantitas_approv }}" class="input-sm status">
		                                		<option value="" @if($r_order->rdt_status == "") selected @endif>Pilih</option>
		                                		<option value="Rencana Pembelian" @if($r_order->rdt_status == "Rencana Pembelian") selected @endif>Rencana Pembelian</option>
		                                		<option value="Ditunda" @if($r_order->rdt_status == "Ditunda") selected @endif>Ditunda</option>
		                                		<option value="Dibatalkan" @if($r_order->rdt_status == "Dibatalkan") selected @endif>Dibatalkan</option>
		                                	</select>
		                                </td> -->
		                                <td class="text-center">
		                                	<button type="button" class="btn btn-xs btn-success btn-circle view" data-toggle="tooltip" data-placement="top" title="View Data" data-id="{{ $r_order->rdt_no }}"><i class="fa fa-eye fa-fw"></i></button>
		                                	<button class="btn btn-xs btn-success btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="{{ $r_order->rdt_no }}"><i class="fa fa-pencil fa-fw"></i></button>
		                                	<button class="btn btn-xs btn-success btn-circle hapus" data-toggle="tooltip" data-placement="top" title="Hapus Data" data-id="{{ $r_order->rdt_no }}" rel="{{ $r_order->rdt_request }}"><i class="fa fa-eraser fa-fw"></i></button>
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

		let selected = [], request_no = [];

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
				request_no.push(context.data('id'));
			}else{
				selected.splice(_.findIndex(selected, function(o) { return o == context.val() }), 1);
			}

			// console.log(selected);
			// console.log(request_no);
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
					axios.post(baseUrl+'/pembelian/request-order/multiple-delete', {
						rdt_request : request_no,
						rdt_no 	: selected,
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

			window.location = baseUrl+'/pembelian/request-order/edit?id='+context.data('id');
		});

		// hapus 1 click
		$(".hapus").click(function(evt){
			evt.preventDefault(); context = $(this);

			let ask = confirm('Apakah Anda Yakin Akan Menghapus Data Ini?');
			if(ask){
				$('#overlay').fadeIn(300);
				axios.post(baseUrl+'/pembelian/request-order/multiple-delete', {
					rdt_no 	: [context.data('id')],
					rdt_request : [context.attr('rel')],
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

		$('.status').on('change', function(e){
			var value = $(this).val();
			var rdt_no = $(this).attr('rel');
			var rdt_request = $(this).attr('rel1');
			var kode_barang = $(this).attr('rel2');
			var kuantitas = $(this).attr('rel3');
			var kuantitas_approv = $(this).attr('rel4');
			axios.post(baseUrl+'/pembelian/rencana-pembelian/request-order-status', {
				rdt_no: rdt_no, rdt_request: rdt_request, status: value, kode_barang: kode_barang, kuantitas: kuantitas, kuantitas_approv: kuantitas_approv,
				_token 	: '{{ csrf_token() }}'
			})
			.then((response) => {
				if(response.data.status == 'kosong'){
					location.reload();
					$.toast({
						text: 'Status order barang "Null"!',
						showHideTransition: 'fade',
						icon: 'success'
					})
				} else if(response.data.status == 'dibatalkan'){
					location.reload();
					$.toast({
						text: 'Status order barang "Dibatalkan"!',
						showHideTransition: 'fade',
						icon: 'success'
					})
				} else if(response.data.status == 'ditunda'){
					location.reload();
					$.toast({
						text: 'Status order barang "Ditunda"!',
						showHideTransition: 'fade',
						icon: 'success'
					})
				} else {
					location.reload();
					$.toast({
						text: 'Status order barang "Rencana Pembelian"!',
						showHideTransition: 'fade',
						icon: 'success'
					})
				}
			}).catch((error) => {
				console.log(error);
			})
		});

		function initiate(data){
			$('#ro_no').val(data.ro_no);
			$('#ro_cabang').val(data.c_nama);
			$('#rdt_no').val(data.rdt_no);
			$('#kode_barang').val(data.rdt_kode_barang);
			$('#kuantitas').val(data.rdt_kuantitas);
			$('#kuantitas_approv').val(data.rdt_kuantitas_approv);
			$('#myModal').modal('show');
		}

	})
</script>

@endsection