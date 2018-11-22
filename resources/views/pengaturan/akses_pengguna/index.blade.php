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
				<div class="col-md-12">
					<h1>AKSES PENGGUNA</h1>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 20px; margin-top: {{ $mt }};">
					<form id="table-form" method="post" action="{{ url('/pengaturan/akses-pengguna/edit') }}">
						{!! csrf_field() !!}
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
                                <tr>
                                    <td class="text-center">ID User</td>
                                    <td class="text-center">Nama User</td>
                                    <td class="text-center">Username</td>
                                    <td class="text-center">Jabatan</td>
                                    <td class="text-center">Aksi</td>
                                </tr>
							</thead>
							<tbody>
								@foreach($data_users as $key => $data_user)
                                <tr>
                                    <td>{{ $data_user->m_id }}</td>
                                    <td>{{ $data_user->m_name }}</td>
                                    <td>{{ $data_user->m_username }}</td>
                                    <td>{{ $data_user->nama }}</td>
                                    <td class="text-center">
                                        <button type="button" 
                                                class="btn btn-xs btn-success btn-circle edit" 
                                                data-toggle="tooltip" 
                                                data-placement="top"
                                                data-id="{{ $data_user->m_id }}"
                                                data-title="Edit Hak Akses">
                                        <i class="fa fa-key fa-fw"></i>
                                        </button>
                                    </td>
                                </tr>
								@endforeach
							</tbody>
						</table>
					</form>
				</div>
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

		window.location = baseUrl+'/pengaturan/akses-pengguna/edit?id='+context.data('id');
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
		$('#ro_cabang').val(data.c_nama);
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