@extends('main')

@section('title', 'Master Supplier')

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
			<li>Home</li><li>Data Master</li><li>Master Supplier</li>
		</ol>
		<!-- end breadcrumb -->

	</div>
	<!-- END RIBBON -->
@endsection


@section('main_content')

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<h1 class="page-title txt-color-blueDark">

					<i class="fa-fw fa fa-asterisk"></i>

					Data Master <span><i class="fa fa-angle-double-right"></i> Master Supplier </span>

				</h1>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/master/supplier/add') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah Data</a>

				</div>

			</div>

		</div>

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<?php $mt = '20px'; ?>

			@if(Session::has('flash_message_success'))
				<?php $mt = '0px'; ?>
				<div class="col-md-12">
						<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
						{{ Session::get('flash_message_success') }} 
					</div>
				</div>
			@elseif(Session::has('flash_message_error'))
				<?php $mt = '0px'; ?>
				<div class="col-md-12">
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
					<form id="table-form" method="post" action="{{ url('/master/suplier/suplier/edit-multiple') }}">
						{!! csrf_field() !!}
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th class="text-center" data-hide="phone" width="4%">*</th>
									<th class="text-center" width="5%" style="vertical-align: middle;">
										---
									</th>
									<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Perusahaan</th>
									<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Nama Suplier</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Alamat</th>
									<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;No.Telephone</th>
									<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-fax txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Faximily</th>
									<th class="text-center" data-hide="phone,tablet" width="15%"> Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach($suppliers as $key => $supplier)
									<tr>
										<td class="text-center">{{ $key+1 }}</td>
										<td class="text-center">
											<input type="checkbox" class="check-me" name="data_check[]" data-id="{{$supplier->s_id}}" value="{{ $supplier->s_id }}"/>
										</td>
		                                <td>{{ $supplier->s_company }}</td>
		                                <td>{{ $supplier->s_name }}</td>
		                                <td>{{ $supplier->s_address }}</td>
		                                <td>{{ $supplier->s_phone }}</td>
		                                <td>{{ $supplier->s_fax }}</td>
		                                <td class="text-center">
		                                	<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="{{ $supplier->s_id }}"><i class="glyphicon glyphicon-edit"></i></button>
		                                	<button class="btn btn-xs btn-danger btn-circle hapus" data-toggle="tooltip" data-placement="top" title="Hapus Data" data-id="{{ $supplier->s_id }}"><i class="glyphicon glyphicon-trash"></i></button>
		                                </td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</form>
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
		<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				var baseUrl = '{{ url('/') }}';

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

					console.log(selected);
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
							$('#load-status-text').text('Sedang Menghapus Data')
							axios.post(baseUrl+'/master/suplier/suplier/multiple-delete', {
								data 	: selected,
								_token 	: '{{ csrf_token() }}'
							})
							.then((response) => {
								if(response.data.status == 'berhasil'){
									location.reload();
								}
							}).catch((error) => {
								$('#load-status-text').text('Internal Server Error')
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

					window.location = baseUrl+'/master/suplier/suplier/edit?id='+context.data('id');
				})

				// hapus 1 click
				$(".hapus").click(function(evt){
					evt.preventDefault(); context = $(this);

					let ask = confirm('Apakah Anda Yakin . ?');
					if(ask){
						$('#overlay').fadeIn(300);
						$('#load-status-text').text('Sedang Menghapus Data')
						axios.post(baseUrl+'/master/suplier/suplier/multiple-delete', {
							data 	: [context.data('id')],
							_token 	: '{{ csrf_token() }}'
						})
						.then((response) => {
							if(response.data.status == 'berhasil'){
								location.reload();
							}
						}).catch((error) => {
							$('#load-status-text').text('Internal Server Error')
						})
					}
				})
			})
		</script>

@endsection