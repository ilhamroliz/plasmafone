@extends('main')

@section('title', 'Master Outlet')


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
			<li>Home</li><li>Master</li><li>Master Outlet</li>
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
					<li class="">
						<a href="#">
							<i class="fa fa-table"></i> &nbsp;Master Outlet
						</a>
					</li>
					<li>
						<a href="{{ url('/master/outlet/add') }}">
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
					<form id="table-form" method="post" action="{{ url('/master/outlet/edit-multiple') }}">
						{!! csrf_field() !!}
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<th class="text-center" data-hide="phone" width="4%">*</th>
									<th class="text-center" width="5%" style="vertical-align: middle;">
										---
									</th>
									<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Nama</th>
									<th data-hide="phone"><i class="fa fa-fw fa-phone text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Telephone</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Alamat</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kecamatan</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Kota/Kabupaten</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Provinsi</th>
									<th class="text-center" data-hide="phone,tablet" width="15%"> Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $cabang)
									<tr>
										<td class="text-center"></td>
										<td class="text-center">
											<input type="checkbox" class="check-me" name="data_check[]" value="{{ $cabang->c_id }}"/>
										</td>
										<td>{{ $cabang->c_nama }}</td>
										<td>{{ $cabang->c_telephone }}</td>
		                                <td>{{ $cabang->c_alamat }}</td>
		                                <td>{{ $cabang->nama_kecamatan }}</td>
		                                <td>{{ $cabang->nama_kota }}</td>
		                                <td>{{ $cabang->nama_provinsi }}</td>
		                                <td class="text-center">
		                                	<button type="button" class="btn btn-xs btn-success btn-circle view" data-toggle="tooltip" data-placement="top" title="View Data" data-id="{{ $cabang->c_id }}"><i class="glyphicon glyphicon-folder-open"></i></button>
		                                	<button class="btn btn-xs btn-warning btn-circle edit" data-toggle="tooltip" data-placement="top" title="Edit Data" data-id="{{ $cabang->c_id }}"><i class="glyphicon glyphicon-edit"></i></button>
		                                	<button class="btn btn-xs btn-danger btn-circle hapus" data-toggle="tooltip" data-placement="top" title="Hapus Data" data-id="{{ $cabang->c_id }}"><i class="glyphicon glyphicon-trash"></i></button>
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
													<label class="label col col-2">Nama Cabang</label>
													<div class="col col-10">
														<label class="input"> <i class="icon-append fa fa-user"></i>
															<input type="text" disabled name="nama_cabang" id="nama_cabang" />
														</label>
													</div>
												</div>
											</section>

											<section>
												<div class="row">
													<label class="label col col-2">Telephone</label>
													<div class="col col-10">
														<label class="input"> <i class="icon-append fa fa-user"></i>
															<input type="text" disabled name="telephone" id="telephone" />
														</label>
													</div>
												</div>
											</section>

											<section>
												<div class="row">
													<label class="label col col-2">Alamat</label>
													<div class="col col-10">
														<label class="input"> <i class="icon-append fa fa-user"></i>
															<textarea class="form-control" style="background-color: #fff; cursor: default;" rows="4" name="alamat" id="alamat" disabled></textarea>
														</label>
													</div>
												</div>
											</section>

											<section>
												<div class="row">
													<label class="label col col-2">Kecamatan</label>
													<div class="col col-10">
														<label class="input"> <i class="icon-append fa fa-user"></i>
															<input type="text" disabled name="kecamatan" id="kecamatan" />
														</label>
													</div>
												</div>
											</section>

											<section>
												<div class="row">
													<label class="label col col-2">Kota/Kabupaten</label>
													<div class="col col-10">
														<label class="input"> <i class="icon-append fa fa-user"></i>
															<input type="text" disabled name="kota" id="kota" />
														</label>
													</div>
												</div>
											</section>

											<section>
												<div class="row">
													<label class="label col col-2">Provinsi</label>
													<div class="col col-10">
														<label class="input"> <i class="icon-append fa fa-user"></i>
															<input type="text" disabled name="provinsi" id="provinsi" />
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
					}else{
						selected.splice(_.findIndex(selected, function(o) { return o == context.val() }), 1);
					}

					console.log(selected);
				})

				// hapus 1 click
				$(".hapus").click(function(evt){
					evt.preventDefault(); context = $(this);

					let ask = confirm('Apakah Anda Yakin . ?');
					if(ask){
						$('#overlay').fadeIn(300);
						axios.post(baseUrl+'/master/outlet/multiple-delete', {
							id 	: [context.data('id')],
							_token 	: '{{ csrf_token() }}'
						})
						.then((response) => {
							if(response.data.status == 'berhasil'){
								location.reload();
							}
						}).catch((error) => {
							console.log(error);
						});
					}
				})


				// Hapus Click

				$("#multiple_delete").click(function(evt){
					evt.preventDefault();

					if(selected.length == 0){
						alert('Tidak Ada Data Yang Anda Pilih');
					}else{
						let ask = confirm(selected.length+' Data Akan Dihapus Apakah Anda Yakin . ?');
						if(ask){
							$('#overlay').fadeIn(300);
							axios.post(baseUrl+'/master/outlet/multiple-delete', {
								id 	: selected,
								_token 	: '{{ csrf_token() }}'
							})
							.then((response) => {
								if(response.data.status == 'berhasil'){
									location.reload();
								}
							}).catch((error) => {
								console.log(error);
							});
						}
					}

				})

				// Edit Click

				$("#multiple_edit").click(function(evt){
					evt.preventDefault();

					if(selected.length == 0){
						alert('Tidak Ada Data Yang Anda Pilih');
					}else{
						$("#table-form").submit();
					}
				})

				// edit 1 click

				$(".edit").click(function(evt){
					evt.preventDefault(); context = $(this);

					window.location = baseUrl+'/master/outlet/edit?id='+context.data('id');
				})

				// view click
				$(".view").click(function(evt){
					evt.preventDefault(); context = $(this);
					// alert(context.data('id'));
					axios.get(baseUrl+'/master/outlet/get-outlet/'+context.data('id'))
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
					$('#nama_cabang').val(data.c_nama);
					$('#telephone').val(data.c_telephone);
					$('#alamat').val(data.c_alamat);
					$('#kecamatan').val(data.nama_kecamatan);
					$('#kota').val(data.nama_kota);
					$('#provinsi').val(data.nama_provinsi);
					$('#myModal').modal('show');
				}
			})
		</script>

@endsection