@extends('main')

@section('title', 'Master Karyawan')


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
			<li>Home</li><li>Master</li><li>Karyawan</li>
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
				<ul class="menu-table hide-on-small">
					<li class="active">
						<a href="#">
							<i class="fa fa-table"></i> &nbsp;Data Table</li>
						</a>
					<li>
						<a href="{{ url('/master/karyawan/add') }}">
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

			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<ul id="sparks" class="">
					<li class="sparks-info">
						<h5> My Income <span class="txt-color-blue">$47,171</span></h5>
						<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">
							1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471
						</div>
					</li>
					<li class="sparks-info">
						<h5> Site Traffic <span class="txt-color-purple"><i class="fa fa-arrow-circle-up" data-rel="bootstrap-tooltip" title="Increased"></i>&nbsp;45%</span></h5>
						<div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">
							110,150,300,130,400,240,220,310,220,300, 270, 210
						</div>
					</li>
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
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 20px; margin-top: {{ $mt }};">
					<form id="table-form" method="post" action="{{ url('/master/karyawan/edit-multiple') }}">
						{!! csrf_field() !!}
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th class="text-center" data-hide="phone" width="4%">*</th>
									<th class="text-center" width="5%" style="vertical-align: middle;">
										---
									</th>
									<th data-class="expand" width="10%"><i class="fa fa-fw fa-address-book text-muted hidden-md hidden-sm hidden-xs"></i> 
										&nbsp;NIK
									</th>
									<th data-class="expand" width="15%"><i class="fa fa-fw fa-address-book text-muted hidden-md hidden-sm hidden-xs"></i> 
										&nbsp;Nama Karyawan
									</th>
									<th data-hide="phone" width="15%"><i class="fa fa-fw fa-code-fork text-muted hidden-md hidden-sm hidden-xs"></i> 
										&nbsp;Jabatan
									</th>
									<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
										&nbsp;Alamat
									</th>
									<th data-hide="phone,tablet" width="10%"><i class="fa fa-fw fa-phone txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
										&nbsp;Nomor Telp
									</th>
									<th data-hide="phone,tablet" width="15%"><i class="fa fa-fw fa-flag txt-color-blue hidden-md hidden-sm hidden-xs"></i> 
										&nbsp;Warga Negara
									</th>
									<th class="text-center" data-hide="phone,tablet" width="15%"> 
										Aksi
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $key => $datanya)
									<tr>
										<td class="text-center">{{ $key+1 }}</td>
										<td class="text-center">
											<input type="checkbox" class="check-me" name="data_check[]" data-id="{{$datanya->id_karyawan}}" value="{{ $datanya->id_karyawan }}"/>
										</td>
										<td>{{ $datanya->nik_karyawan }}</td>
		                                <td>{{ $datanya->nama_lengkap }}</td>
		                                <td>{{ $datanya->jabatan->nama.' '.$datanya->posisi->nama_posisi }}</td>
		                                <td>
		                                	<span data-toggle="tooltip" data-placement="top" title="{{ $datanya->kota->nama_kota }}, {{ $datanya->kota->provinsi->nama_provinsi }}">
		                                		{{ $datanya->alamat_rumah }}
		                                	</span>
		                                </td>
		                                <td>{{ $datanya->nomor_telp }}</td>
		                                <td>{{ $datanya->kewarganegaraan }}</td>
		                                <td class="text-center">
		                                	<button class="btn btn-xs btn-success btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="{{ $datanya->id_karyawan }}"><i class="fa fa-pencil fa-fw"></i></button>
		                                	<button class="btn btn-xs btn-success btn-circle hapus" data-toggle="tooltip" data-placement="top" title="Hapus Data" data-id="{{ $datanya->id_karyawan }}"><i class="fa fa-eraser fa-fw"></i></button>
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
							$('#load-status-text').text('Sedang Menghapus Data');
							axios.post(baseUrl+'/master/karyawan/multiple-delete', {
								data 	: selected,
								_token 	: '{{ csrf_token() }}'
							})
							.then((response) => {
								if(response.data.status == 'berhasil'){
									location.reload();
								}
							}).catch((error) => {
								$('#load-status-text').text('Internal Server Error');
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

					window.location = baseUrl+'/master/karyawan/edit?id='+context.data('id');
				})

				// hapus 1 click
				$(".hapus").click(function(evt){
					evt.preventDefault(); context = $(this);

					let ask = confirm('Apakah Anda Yakin . ?');
					if(ask){
						$('#overlay').fadeIn(300);
						$('#load-status-text').text('Sedang Menghapus Data')
						axios.post(baseUrl+'/master/karyawan/multiple-delete', {
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