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

			<!-- row -->
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Pengelolaan Pengguna <span>> User</span></h1>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 20px; margin-top: {{ $mt }};">
					<!-- <form id="table-form" method="post" action="{{ url('/pengaturan/akses-pengguna/edit') }}"> -->
						{!! csrf_field() !!}
						<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
                                <tr>
                                    <th class="text-center">ID User</th>
                                    <th class="text-center">Nama User</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
							</thead>
							<!-- <tbody>
								@foreach($data_users as $key => $data_user)
                                <tr>
                                    <td>{{ $data_user->m_id }}</td>
                                    <td>{{ $data_user->m_name }}</td>
                                    <td>{{ $data_user->m_username }}</td>
                                    <td>{{ $data_user->nama }}</td>
                                    <td class="text-center">
                                        <button type="button" 
                                                class="btn btn-xs btn-warning btn-circle edit" 
                                                data-toggle="tooltip" 
                                                data-placement="top"
                                                data-id="{{ $data_user->m_id }}"
                                                data-title="Edit Hak Akses">
                                        <i class="fa fa-wrench"></i>
                                        </button>
                                    </td>
                                </tr>
								@endforeach
							</tbody> -->
						</table>
					<!-- </form> -->
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
				// "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				// "t"+
				// "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
				// "autoWidth" : true,
				// "preDrawCallback" : function() {
				// 	// Initialize the responsive datatables helper once.
				// 	if (!responsiveHelper_dt_basic) {
				// 		responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				// 	}
				// },
				// "rowCallback" : function(nRow) {
				// 	responsiveHelper_dt_basic.createExpandIcon(nRow);
				// },
				// "drawCallback" : function(oSettings) {
				// 	responsiveHelper_dt_basic.respond();
				// },

				processing: true,
				searching: true,
				paging: false,
				ordering: false,
				serverSide: true,
				"ajax": {
					"url": "{{ url('pengaturan/akses-pengguna/dataUser') }}",
					"type": "get"
				},
				columns: [
					{data: 'm_id', name: 'm_id'},
					{data: 'm_name', name: 'm_name'},
					{data: 'm_username', name: 'm_username'},
					{data: 'nama', name: 'nama'},
					{data: 'aksi', name: 'aksi'}
				],
				responsive: false,
				// "language": dataTableLanguage,
			});
		}, 500);
	});

  function akses(id){
    location.href = ('{{ url('pengaturan/akses-pengguna/edit') }}/' + id);
  }
</script>

<script type="text/javascript">
$(document).ready(function(){

	// let selected = [];

	// /* BASIC ;*/
	// var responsiveHelper_dt_basic = undefined;
	// var responsiveHelper_datatable_fixed_column = undefined;
	// var responsiveHelper_datatable_col_reorder = undefined;
	// var responsiveHelper_datatable_tabletools = undefined;

	// var breakpointDefinition = {
	// 	tablet : 1024,
	// 	phone : 480
	// };

	// $('#dt_basic').dataTable({
	// 	"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
	// 	"t"+
	// 	"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
	// 	"autoWidth" : true,
	// 	"preDrawCallback" : function() {
	// 		// Initialize the responsive datatables helper once.
	// 		if (!responsiveHelper_dt_basic) {
	// 			responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
	// 		}
	// 	},
	// 	"rowCallback" : function(nRow) {
	// 		responsiveHelper_dt_basic.createExpandIcon(nRow);
	// 	},
	// 	"drawCallback" : function(oSettings) {
	// 		responsiveHelper_dt_basic.respond();
	// 	}
	// });

	/* END BASIC */

	$('.check-me').change(function(evt){
		evt.preventDefault(); context = $(this);
		if(context.is(':checked'))
			selected.push(context.val());
		else
			selected.splice(_.findIndex(selected, function(o) { return o == context.val() }), 1);

		// console.log(selected);
	})

	// edit 1 click

	$(".edit").click(function(evt){
		evt.preventDefault(); context = $(this);

		window.location = baseUrl+'/pengaturan/akses-pengguna/edit?id='+context.data('id');
	})

})
</script>

@endsection