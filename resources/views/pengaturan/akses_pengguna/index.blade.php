@extends('main')

@section('title', 'Akses Pengguna')

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
		<li>Home</li><li>Pengaturan</li><li>Akses Pengguna</li>
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
		<section id="widget-grid" class="">

			@if(Session::has('flash_message_success'))
				<div class="col-md-12">
					<div class="alert alert-success alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
						{{ Session::get('flash_message_success') }} 
					</div>
				</div>
			@elseif(Session::has('flash_message_error'))
				<div class="col-md-12">
					<div class="alert alert-danger alert-block">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<h4 class="alert-heading">&nbsp;<i class="fa fa-frown-o"></i> &nbsp;Pemberitahuan Gagal</h4>
						{{ Session::get('flash_message_error') }}
					</div>
				</div>
			@endif

			<?php $mt = '20px'; ?>

			<!-- row -->
			<div class="row">

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-cog"></i> Pengelolaan Pengguna <span>> User</span></h1>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">
					<div class="page-title">
						<button class="btn btn-success" onclick=cekAksesTambah()><i class="fa fa-plus"></i>&nbsp;Tambah Data</button>
					</div>
				</div>
				
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-0" 
						data-widget-colorbutton="false" 
						data-widget-deletebutton="false" 
						data-widget-editbutton="false"
						data-widget-custombutton="false"
						data-widget-sortable="false">
						<!-- widget options:
							usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
							
							data-widget-colorbutton="false"	
							data-widget-editbutton="false"
							data-widget-togglebutton="false"
							data-widget-deletebutton="false"
							data-widget-fullscreenbutton="false"
							data-widget-custombutton="false"
							data-widget-collapsed="true" 
							data-widget-sortable="false"
							
						-->
						<header>
							<h2><strong>Pengelolaan Pengguna</strong></h2>											
						</header>

						<!-- widget div-->
						<div>
							
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
								<input class="form-control" type="text">
								<span class="note"><i class="fa fa-check text-success"></i> Change title to update and save instantly!</span>
								
							</div>
							<!-- end widget edit box -->
							
							<!-- widget content -->
							<div class="widget-body">
								{!! csrf_field() !!}
								<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
									<thead>			                
										<tr>
											<th class="text-center">Nama User</th>
											<th class="text-center">Username</th>
											<th class="text-center">Jabatan</th>
											<th class="text-center">Aksi</th>
										</tr>
									</thead>
								</table>
							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
				</article>

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
  	var user;
	$(document).ready(function(){
		setTimeout(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			user = $('#dt_basic').DataTable({
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				"autoWidth" : true,
				"language" : dataTableLanguage,
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
				},

				processing: true,
				searching: true,
				serverSide: true,
				"ajax": {
					"url": "{{ url('/pengaturan/akses-pengguna/dataUser') }}",
					"type": "post",
				},
				columns: [
					{data: 'm_name', name: 'm_name'},
					{data: 'm_username', name: 'm_username'},
					{data: 'nama', name: 'nama'},
					{data: 'aksi', name: 'aksi'}
				],
				responsive: false,
				//"language": dataTableLanguage,
			});
		}, 500);
	});

	function akses(id){
		$.ajax({
			url: '{{ url('/pengaturan/akses-pengguna/edit') }}/' + id,
			type: 'get',
			success: function(response){
				if(response.status == 'gagal') {
					// alert('Data Gagal Di Update');	
					// waitingDialog.hide();
					// $('#overlay').fadeOut(200);
					$.smallBox({
						title : "PERHATIAN !",
						content : "Anda tidak memiliki akses untuk mengubah Akses Pengguna",
						color : "#C46A69",
						iconSmall : "fa fa-times animated",
						timeout : 3000
					});
					// location.reload();
				}else{
					location.href = ('{{ url('/pengaturan/akses-pengguna/edit') }}/' + id);
				}
			}
		})
		// location.href = ('{{ url('/pengaturan/akses-pengguna/edit') }}/' + id);
	}

  function edit(id){
	$.ajax({
		url: '{{ url('/pengaturan/kelola-pengguna/edit') }}/' + id,
		type: 'get',
		success: function(response){
			if(response.status == 'gagal') {
				// alert('Data Gagal Di Update');	
				// waitingDialog.hide();
				// $('#overlay').fadeOut(200);
				$.smallBox({
					title : "PERHATIAN !",
					content : "Anda tidak memiliki akses untuk mengubah Data Pengguna",
					color : "#C46A69",
					iconSmall : "fa fa-times animated",
					timeout : 3000
				});
				// location.reload();
			}else{
				location.href = ('{{ url('/pengaturan/kelola-pengguna/edit') }}/' + id);
			}
		}
	})
    // location.href = ('{{ url('/pengaturan/kelola-pengguna/edit') }}/' + id);
  }

  function trigger(id){
    // location.href = ('{{ url('/pengaturan/kelola-pengguna/hapus') }}/' + id);
	
	$.SmartMessageBox({
		title : "PERHATIAN !",
		content : "Apakah Anda yakin ingin mengubah status Aktivasi User ?",
		buttons : '[No][Yes]'
	}, function(ButtonPressed) {
		if (ButtonPressed === "Yes") {
			$.ajax({
				url: '{{ url('/pengaturan/kelola-pengguna/hapus') }}/' + id,
				type: 'get',
				success: function(response){
					if(response.status == 'gagal') {
						// alert('Data Gagal Di Update');	
						// waitingDialog.hide();
						// $('#overlay').fadeOut(200);
						$.smallBox({
							title : "PERHATIAN !",
							content : "Anda tidak memiliki akses untuk menghapus Data Pengguna",
							color : "#C46A69",
							iconSmall : "fa fa-times animated",
							timeout : 3000
						});
						// location.reload();
					}else{
						$.smallBox({
							title : "Pemberitahuan",
							content : "<i class='fa fa-clock-o'></i> <i>Perubahan Status Aktivasi Disetujui</i>",
							color : "#659265",
							iconSmall : "fa fa-check fa-2x fadeInRight animated",
							timeout : 3000
						});
						location.href = ('{{ url('/pengaturan/kelola-pengguna/hapus') }}/' + id);
					}
				}
			})
			// location.href = ('{{ url('/pengaturan/kelola-pengguna/hapus') }}/' + id);

		}
		if (ButtonPressed === "No") {
			$.smallBox({
				title : "Pemberitahuan",
				content : "<i class='fa fa-clock-o'></i> <i>Perubahan Status Aktivasi Dibatalkan</i>",
				color : "#C46A69",
				iconSmall : "fa fa-times fa-2x fadeInRight animated",
				timeout : 3000
			});
		}

	});
	e.preventDefault();
  }

  function cekAksesTambah() {
	$.ajax({
		url: '{{ url('/pengaturan/kelola-pengguna/tambah') }}',
		success: function(response){
			if(response.status == 'gagal') {
				// alert('Data Gagal Di Update');	
				// waitingDialog.hide();
				// $('#overlay').fadeOut(200);
				$.smallBox({
					title : "PERHATIAN !",
					content : "Anda tidak memiliki akses untuk menambahkan Data Pengguna",
					color : "#C46A69",
					iconSmall : "fa fa-times animated",
					timeout : 3000
				});
				// location.reload();
			}else{
				location.href = ('{{ url('/pengaturan/kelola-pengguna/tambah') }}');
			}
		}
	})
  }
</script>

@endsection