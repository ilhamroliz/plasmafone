@extends('main')

@section('title', 'Penerimaan Barang Dari Supplier')

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
		<li>Home</li><li>Inventory</li><li>Penerimaan Barang</li><li>view bbm dt</li>
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
					<a href="{{ url('/inventory/penerimaan/supplier') }}">
						<i class="fa fa-table"></i> &nbsp;Data Tabel
					</a>
				</li>
				<li>
					<!-- <a href="{{ url('/inventory/penerimaan/supplier/add') }}"> -->
					<a href="{{ url('/inventory/penerimaan/supplier/formAdd') }}">
						<i class="fa fa-plus"></i> &nbsp;Tambahkan Data
					</a>
				</li>

				<li>
					<a href="#" id="multiple_edit">
						<i class="fa fa-pencil-square"></i> &nbsp;Edit Data
					</a>
				</li>
					
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
				<form id="table-form">
					{!! csrf_field() !!}
					<div class="table-responsive"  >
					<table id="dt_bbm" class="table table-striped table-bordered table-hover " width="100%">
						<thead>			                
							<tr>
								
								<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;No.</th>
								<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Kode BM</th>
								<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Kode PO</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Nama Supplier</th>
								<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Status</th>
								<th class="text-center" data-hide="phone,tablet" width="15%"> Aksi</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
					</div>
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
												<input type="text" disabled name="ro_no" id="ro_no" placeholder="aaaaaaaaaaaaa" />
											</label>
										</div>
									</div>
								</section>
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
									<tr>
										<td>Supplier</td>
										<td id="v_supplier"></td>
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
var data = id_bbm;


var table_bbm; 

	$(document).ready(function(){
			reload_data();
            alert(data);
	})

	function reload_data(){
		table_bbm= $('#dt_bbm').DataTable({
			"language" : dataTableLanguage,
			"searching": false,
            "ajax": {
                    "url": '{{url('/inventory/penerimaan/supplier/load_bbm')}}',
                    "type": "POST",  
                    "data": function ( data ) {
                        
						data._token = '{{ csrf_token() }}';
                    },
                },
        } );
    }

	function view_bbm_dt(id)
	{
		id_bbm = id;
		window.location = url;
	}

	function reload_table(){
		
		$.ajax({
			url : '{{url('/inventory/penerimaan/supplier/getEntitas_po')}}',
			type: "POST",
			data: { 
				po: $('#po').val(),
				_token 	: '{{ csrf_token() }}'
			},
			dataType: "JSON",
			success: function(data)
			{
				
				$('#supplier').val(data.s_company);
				$('#tgl_order').val(data.p_date);
				table_barang.ajax.reload(null, false);
			}
		});

    }

	function openModal(){
			$('#myModal').modal('show',true);
		}
</script>

@endsection