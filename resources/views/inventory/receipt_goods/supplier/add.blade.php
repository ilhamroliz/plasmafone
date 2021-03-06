@extends('main')

@section('title', 'Inventory Penerimaan Barang Dari Supplier')


@section('extra_style')
<script src="{{ asset('template_asset/js/libs/jquery-3.0.0.js') }}" type='text/javascript'></script>

<style type="text/css">



.edit{
    width: 100%;
    height: 25px;
}
.editMode{
    /*border: 1px solid black;*/
 
}

.txtedit{
    display: none;
    width: 99%;
    height: 30px;
}



</style>

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
			<li>Home</li><li>Inventory</li><li>Penerimaan Barang Dari Supplier</li><li>Tambah</li>
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
		<section id="widget-grid" class="" style="margin-bottom: 20px; min-height: 500px;">
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
			<div class="row ">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="padding: 0px 20px; margin-top: {{ $mt }};">

					{{-- FormTemplate .. --}}

					<form id="add-form" class="form-horizontal  " action="{{ url('/inventory/penerimaan/supplier/add') }}" method="post">
						{{ csrf_field() }}
						<fieldset class="">
							<legend>
								Form Tambah Penerimaan Barang Dari Supplier

								<span class="pull-right" style="font-size: 0.6em; font-weight: 600">
									<a href="{{ url('/inventory/penerimaan/supplier') }}">
										<i class="fa fa-arrow-left"></i> &nbsp;Kembali Ke Halaman Data Table
									</a>
								</span>
							</legend>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">No Purchase Order</label>
										<div class="col-xs-7 col-lg-7 inputGroupContainer">
											<select class="form-control" name="po" id="po" onchange="reload_table()">
												<option value="">---Pilih No Purchase Order---</option>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Nama Supplier</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="supplier" id="supplier" disabled=""/>
										</div>
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:15px;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Tanggal Order</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control" name="tgl_order" id="tgl_order" disabled=""/>
										</div>
										
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="col-xs-4 col-lg-4 control-label text-left">Tanggal Masuk</label>
										<div class="col-xs-8 col-lg-8 inputGroupContainer">
											<input type="text" class="form-control datepicker" name="tgl_masuk" id="tgl_masuk" data-dateformat="dd/mm/YYYY"/>
										</div>
										
									</div>
								</div>


							</div>
						</fieldset>

						
					</form>

					{{-- FormTemplate End .. --}}

				</div>
			</div>

			<!-- end row -->

			<!-- row -->
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 20px; margin-top: {{ $mt }};">
					<form id="table-form" method="post" action="{{ url('/inventory/penerimaan/supplier/edit-multiple') }}">
						{!! csrf_field() !!}
						<table id="dt_barang" class="table table-striped table-bordered table-hover" width="100%">
							<thead>			                
								<tr>
									<!-- <th class="text-center" data-hide="phone" width="4%">*</th>
									<th class="text-center" width="5%" style="vertical-align: middle;">
										---
									</th> -->
									<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;No</th>
									<th data-class="expand"><i class="fa fa-fw fa-building text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Nama Barang</th>
									<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Harga Barang</th>
									<th data-hide="phone"><i class="fa fa-fw fa-user text-muted hidden-md hidden-sm hidden-xs"></i> &nbsp;Jml Order</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Jml Diterima</th>
									<th data-hide="phone,tablet"><i class="fa fa-fw fa-map-marker txt-color-blue hidden-md hidden-sm hidden-xs"></i> &nbsp;Nama Gudang</th>
								</tr>
							</thead>
							<tbody>
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
			<div class="row form-actions" style="margin-left: 6px;margin-right: 7px; margin-top: 4px;">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px 0px; margin-top:0%;">
				<div class="">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-success col-md-12" onclick="simpanBarang()">
										<i class="fa fa-floppy-o"></i>
										&nbsp;Simpan
									</button>
								</div>
							</div>
						</div>
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
<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>
<script src="{{ asset('template_asset/js/notification/SmartNotification.min.js') }}"></script>
<script src="{{ asset('template_asset/js/app.config.js') }}"></script>
<script src="{{ asset('template_asset/js/bootstrap/bootstrap.min.js') }}"></script>
<script type="text/javascript">
var table_barang;
var baseUrl = '{{ url('/') }}';
$(document).ready(function(){
	reload_data();
	getPo();

});
	

	
	function updateQty(id){
			var input = $('#qty'+id).val();
			$.ajax({
						url : '{{url('/inventory/penerimaan/supplier/updateQty')}}',
						type: "POST",
						data: { 
							'id' : id,
							'qty' : input,
							_token : '{{ csrf_token() }}'


						},
						dataType: "JSON",
						success: function(data)
						{
							$.smallBox({
							title : "Berhasil",
							content : 'Data telah ditambahkan...!',
							color : "#739E73",
							timeout: 4000,
							icon : "fa fa-check bounce animated"
							});
							$('#dt_tambah').DataTable().ajax.reload();
							
						},
						
				}); 
		
		}

		function updateTgl(id){
			var input = $('#tgl'+id).val();
			$.ajax({
						url : '{{url('/inventory/penerimaan/supplier/updateTgl')}}',
						type: "POST",
						data: { 
							'id' : id,
							'tgl' : input,
							_token : '{{ csrf_token() }}'

						},
						dataType: "JSON",
						success: function(data)
						{
							$.smallBox({
							title : "Berhasil",
							content : 'Data telah ditambahkan...!',
							color : "#739E73",
							timeout: 4000,
							icon : "fa fa-check bounce animated"
							});
							$('#dt_tambah').DataTable().ajax.reload();
							
						},
						
				}); 
		
		}

		function updateGudang(ids){
			var input = $('#gudangHidden'+ids).val();
			var input = $('#gudangShow'+ids).val();
			$('#gudangShow'+ids).autocomplete({
				source: baseUrl+'/inventory/penerimaan/supplier/cariGudang',
				minLength: 2,
				select: function(event, data) {
					$('#gudangHidden'+ids).val(data.item.id);
					$('#gudangShow'+ids).val(data.item.label);
					if(input ==''){

					}else{
							$.ajax({
								url : '{{url('/inventory/penerimaan/supplier/updateGudang')}}',
								type: "POST",
								data: { 
									'id' : ids,
									'gudang' : $('#gudangHidden'+ids).val(),
									_token : '{{ csrf_token() }}'
								},
								dataType: "JSON",
								success: function(data)
								{
									reload_table();
								},
								
							}); 
					}
				}
			});
		}

function reload_data(){
	table_barang= $('#dt_barang').DataTable({
			"language" : dataTableLanguage,
			"searching": false,
            "ajax": {
                    "url": '{{url('/inventory/penerimaan/supplier/detailPo')}}',
                    "type": "POST",  
                    "data": function ( data ) {
                        data.po = $('#po').val();
						data._token = '{{ csrf_token() }}';
                    },
                },
        } );
    }

	function reload_datatable(){
		table_barang= $('#dt_barang').DataTable({
			"language" : dataTableLanguage,
			"searching": false,
            "ajax": {
                    "url": '{{url('/inventory/penerimaan/supplier/detailPo')}}',
                    "type": "POST",  
                    "data": function ( data ) {
						data._token = '{{ csrf_token() }}';
                    },
                },
        } );

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


	function getPo()
	{
			$.ajax({
			url : '{{url('/inventory/penerimaan/supplier/getPo')}}',
			type: "POST",
			data: { 
				_token 	: '{{ csrf_token() }}'
			},
			dataType: "JSON",
			success: function(data)
			{
				$('#po').empty(); 
				row = "<option selected='' value='00'>Pilih No Purchasing</option>";
				$(row).appendTo("#po");
				$.each(data, function(k, v) {
					row = "<option value='"+v.p_id+"'>"+v.p_nota+"</option>";
					$(row).appendTo("#po");
				});
			},
			
		});  
	}

	function simpanBarang()
	{
		$.SmartMessageBox({
			title : "Peringatan Konfirmasi",
			content : "Apakah Anda Yakin Sudah Menerima Barang ?",
			buttons : '[Tidak][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {
					$.ajax({
						url : '{{url('/inventory/penerimaan/supplier/terimaBarang')}}',
						type: "POST",
						data: { 
							po : $('#po').val(),
							_token 	: '{{ csrf_token() }}'
						},
						dataType: "JSON",
						success: function(data)
						{
							
							
							if(data.status == 'gagal')
							{
								$.smallBox({
									title : "Gagal",
									content : 'Data gagal Di ajukan..!',
									color : "#739E73",
									timeout: 4000,
									icon : "fa fa-check bounce animated"
									});
									$('#tpMemberId').val("");
									$('#tpMemberNama').val("");
									$('#qty').val("");
									$('#dt_barang').DataTable().ajax.reload();
								// $('#table-rencana').DataTable().ajax.reload();
							}else{

								$.ajax({
										url : '{{url('/inventory/penerimaan/supplier/getPo')}}',
										type: "POST",
										data: { 
											_token 	: '{{ csrf_token() }}'
										},
										dataType: "JSON",
										success: function(data)
										{
											$('#po').empty(); 
											row = "<option selected='' value='00'>Pilih No Purchasing</option>";
											$(row).appendTo("#po");
											$.each(data, function(k, v) {
												row = "<option value='"+v.p_id+"'>"+v.p_nota+"</option>";
												$(row).appendTo("#po");
											});

											$.smallBox({
											title : "Berhasil",
											content : 'Anda Telah Berhasil Masukkan barang...!',
											color : "#739E73",
											timeout: 4000,
											icon : "fa fa-check bounce animated"
											});
											getPo();
											$('#dt_barang').DataTable().ajax.reload();
										},
										
									});  
								
								
							}
							
						},
							
					}); 
				}
				if (ButtonPressed === "Tidak") {
					$.smallBox({
						title : "Peringatan...!!!",
						content : "<i class='fa fa-clock-o'></i> <i>Anda Tidak Melakukan Pengajuan</i>",
						color : "#C46A69",
						iconSmall : "fa fa-times fa-2x fadeInRight animated",
						timeout : 4000
					});
				}

			});
			e.preventDefault();
		}

</script>

@endsection