@extends('main')

@section('title', 'Request Order')

<?php 
	use App\Http\Controllers\PlasmafoneController as Access;

	function rupiah($angka){
		$hasil_rupiah = "Rp" . number_format($angka,2,',','.');
		return $hasil_rupiah;
	}
?>

@section('extra_style')
	<style type="text/css">
		.dataTables_length {
			float: right;
		}
		.dt-toolbar-footer > :last-child, .dt-toolbar > :last-child {
    		padding-right: 0 !important;
		}
		.col-sm-1.col-xs-12.hidden-xs {
		    padding: 0px;
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

			<li>Home</li><li>Pembelian</li><li>Rencana Pembelian</li>

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
                    <i class="fa-fw fa fa-credit-card"></i>
                    Pembelian
                    <span>
						<i class="fa fa-angle-double-right"></i>
						 Rencana Pembelian
					</span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ url('pembelian/rencana-pembelian') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

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

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

                    <header role="heading">
                        <div class="jarviswidget-ctrls" role="menu">
							<!-- <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a>  -->
							<!-- <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> -->
                        </div>
                        <h2><strong>Tambah Rencana Pembelian</strong></h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="row">
								<div class="form-group col-md-8">
									<label class="sr-only" for="namabarang">Nama Barang</label>
									<input type="hidden" id="tpMemberId" name="tpMemberId">
									<input type="text" class="form-control" id="tpMemberNama" name="tpMemberNama" style="width: 100%;text-transform :uppercase" placeholder="Masukkan Nama Item" >
									<!-- <input type="text" class="form-control" id="namabarang" name="item" placeholder="Masukkan Nama/Kode Barang" style="width: 100%"> -->
									<div id="list_barang">
										
									</div>
									
								</div>
									<!-- {{csrf_field()}} -->
                                   
                                    <div class="form-group col-md-2">
                                        <label class="sr-only" for="kuantitas">QTY</label>
                                        <input type="number" class="form-control" id="qty" name="kuantitas" placeholder="QTY" style="width: 100%" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button class="btn btn-primary" onclick="tambah()" id="okTambah">Tambah</button>
                                    </div>
							</div>
							<div class="widget-body no-padding">

								<!-- widget body text-->
								
								<div class="tab-content padding-10">
								

									<div class="tab-pane fade in active" id="hr1">
										
										<table id="table-rencana" class="table table-striped table-bordered table-hover" width="100%">

											<thead>			                

												<tr>
													<th data-hide="phone,tablet" width="75%">Nama Barang</th>
                                                    <th data-hide="phone,tablet" width="10%">Qty</th>
                                                    <th data-hide="phone,tablet" width="15%">Aksi</th>

												</tr>

											</thead>

											<tbody>
												
											</tbody>

										</table>
										
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-12">
                                       	 		<button class="btn-lg btn-block btn-primary text-center" onclick="simpanRequest()" >Tambah Semua Rencana</button>
											</div>
										</div>
                                    </div>

								</div>
								
								<!-- end widget body text-->
								
								<!-- widget footer -->
								<div class="widget-footer text-right">
								
									
								</div>
								<!-- end widget footer -->
								
							</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
							
					</div>

				</div>

			</div>

			<!-- end row -->

			<!-- row -->

			<div class="row">

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Detail Barang</h4>

					</div>

					<div class="modal-body">

						<div style="margin-bottom: 15px;" class="preview thumbnail">

							<img id="dt_image" src="">

						</div>
		
						<div class="row">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

								<header>

									<span class="widget-icon"> <i class="fa fa-table"></i> </span>

									<h2 id="title_detail"></h2>

								</header>

								<!-- widget div-->
								<div>

									<!-- widget content -->
									<div class="widget-body no-padding">
										
										<div class="table-responsive">
											
											<table class="table">
												<tbody>

													<tr class="success">
														<td><strong>Kelompok</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_kelompok"></td>
													</tr>

													<tr class="danger">
														<td><strong>Group</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_group"></td>
													</tr>

													<tr class="warning">
														<td><strong>Sub Group</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_subgroup"></td>
													</tr>

													<tr class="info">
														<td><strong>Merk</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_merk"></td>
													</tr>

													<tr class="success">
														<td><strong>Nama</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_nama"></td>
													</tr>

													<tr class="danger">
														<td><strong>Spesifik Kode</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_specificcode"></td>
													</tr>

													<tr class="warning">
														<td><strong>Kode</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_code"></td>
													</tr>

													<tr class="info">
														<td><strong>Status</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_isactive"></td>
													</tr>

													<tr class="success">
														<td><strong>Min Stock</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_minstock"></td>
													</tr>

													<tr class="danger">
														<td><strong>Berat (Gram)</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_berat"></td>
													</tr>

													<tr class="warning">
														<td><strong>Harga</strong></td>
														<td><strong>:</strong></td>
														<td ><label id="dt_price"></label></td>
													</tr>
													<tr class="info" id="in_sup">
														<td><strong>Suplier</strong></td>
														<td><strong>:</strong></td>
														<td >
															<div class="form-group">
																<select class="form-control" name="" id="dt_supplier" >
																	<!-- <option selected="" value="00"></option> -->
																</select>
															</div>
								  						</td>
													</tr>
													<tr class="info" id="in_qty">
														<td><strong>QTY APPROVE</strong></td>
														<td><strong>:</strong></td>
														<td >
															<div class="form-group">
																
																<input type="text" class="form-control" id="dt_qtyApp"  placeholder="QTY" style="width: 100%" >
															</div>
								  						</td>
													</tr>
													<tr hidden="">
														<td><input type="text" id="pr_idReq"></td>
														<td><input type="text"  id="pr_itemPlan"></td>
														<td ><input type="text"  id="pr_qt"></label></td>
													</tr>
													<tr hidden="">
														<td><input type="text" id="pr_dateRequest"></td>
														<td><input type="text" id="dt_comp" ></td>
														<td ><input type="text"  ></label></td>
													</tr>


												</tbody>

											</table>
											
										</div>
                                        
									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->
                                
							</div>
							<!-- end widget -->
                            <div class="form-group col-md-12 text-right">
                                            
                                            <button class="btn btn-primary" onclick="batal()" id="btnBatal">Batal</button>
                                            <button class="btn btn-primary" onclick="tambah()" id="btnTambah">Tambah</button>
                                            <button class="btn btn-primary" onclick="tolak()" id="btnTolak">Tolak</button>
                                        </div>
						</div>
                        
		
					</div>

				</div><!-- /.modal-content -->

			</div><!-- /.modal-dialog -->

		</div>
		<!-- /.modal -->

	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')


	<script type="text/javascript">
		var tambahRencana;
        $(document).ready(function () {
			$( "#tpMemberNama" ).autocomplete({
				source: baseUrl+'/pembelian/request-pembelian/cariItem',
				minLength: 2,
				select: function(event, data) {
					$('#tpMemberId').val(data.item.id);
					$('#tpMemberNama').val(data.item.label);
					$('#qty').focus();
				}
			});

			
				$("#qty").on("keyup",function (event) {
				$(this).val($(this).val().replace(/[^\d].+/, ""));
				if ((event.which == 13)) {
					$('#okTambah').click();
				}
			});

			$.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

			reload_data();
            
        }); 

		function tambah(){
			$.ajax({
				url : '{{url('/pembelian/request-pembelian/addDumyReq')}}',
				type: "POST",
				data: {  
					'qty' : $('#qty').val(),
					'item' : $('#tpMemberId').val(),
					_token : '{{ csrf_token() }}'
				},
				dataType: "JSON", 
				success: function(data)
				{
					if(data.data =='SUKSES'){
						$.smallBox({
							title : "Berhasil",
							content : 'Data telah ditambahkan...!',
							color : "#739E73",
							timeout: 4000,
							icon : "fa fa-check bounce animated"
							});
							$('#tpMemberId').val("");
							$('#tpMemberNama').val("");
							$('#qty').val("");
							$('#table-rencana').DataTable().ajax.reload();
					}else{
						$.smallBox({
							title : "GAGAL",
							content : 'Data telah GAGAL ditambahkan...!',
							color : "#739E73",
							timeout: 4000,
							icon : "fa fa-check bounce animated"
							});
							$('#tpMemberId').val("");
							$('#tpMemberNama').val("");
							$('#qty').val("");
							$('#table-rencana').DataTable().ajax.reload();
					}
					
					// reload_table();
				},
				
		}); 
		}

		function hapusData(id){
			$.ajax({
							url : '{{url('/pembelian/request-pembelian/hapusDumy')}}',
							type: "GET",
							data: { 
								id : id,
							},
							dataType: "JSON",
							success: function(data)
							{
								if(data.status == "sukses"){
									$.smallBox({
										title : "Berhasil",
										content : 'Data telah Di hapus...!',
										color : "#739E73",
										timeout: 4000,
										icon : "fa fa-check bounce animated"
										});
										$('#tpMemberId').val("");
										$('#tpMemberNama').val("");
										$('#qty').val("");
										$('#table-rencana').DataTable().ajax.reload();
								}else{
									$.smallBox({
										title : "Berhasil",
										content : 'Data gagal Di hapus...!',
										color : "#739E73",
										timeout: 4000,
										icon : "fa fa-check bounce animated"
										});
										$('#tpMemberId').val("");
										$('#tpMemberNama').val("");
										$('#qty').val("");
										$('#table-rencana').DataTable().ajax.reload();
								}
								
							},
							
						});  
			
			 
		}

		function editDumy(id){
			var input = $('#i_nama'+id).val();
			$.ajax({
						url : '{{url('/pembelian/request-pembelian/editDumy')}}',
						type: "GET",
						data: { 
							'id' : id,
							'qty' : input,
 
						},
						dataType: "JSON",
						success: function(data)
						{
							
							Swal({
									position: 'top-end',
									type: 'danger',
									title: 'Request Order Telah Di edit',
									showConfirmButton: false,
									timer: 7500,
								});
							
							$('#table-rencana').DataTable().ajax.reload();
							
						},
						
				}); 
		}

		function simpanRequest(){
			$.SmartMessageBox({
					title : "Konfirmasi...!",
					content : "Apakah Anda Yakin Akan Mengajukan Request Order ?",
					buttons : '[Tidak][Ya]'
				}, function(ButtonPressed) {
					if (ButtonPressed === "Ya") {
						$.ajax({
							url : '{{url('/pembelian/request-pembelian/simpanRequest')}}',
							type: "GET",
							data: { 
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
										$('#table-rencana').DataTable().ajax.reload();
									// $('#table-rencana').DataTable().ajax.reload();
								}else if(data.status == 'notFound'){
									$.smallBox({
										title : "Peringatan",
										content : 'Data Not Found!',
										color : "#739E73",
										timeout: 4000,
										icon : "fa fa-check bounce animated"
										});
										$('#tpMemberId').val("");
										$('#tpMemberNama').val("");
										$('#qty').val("");
										$('#table-rencana').DataTable().ajax.reload();
								}else{
									$.smallBox({
										title : "Berhasil",
										content : 'Anda Telah Berhasil Mengajukan Request Order...!',
										color : "#739E73",
										timeout: 4000,
										icon : "fa fa-check bounce animated"
										});
										$('#tpMemberId').val("");
										$('#tpMemberNama').val("");
										$('#qty').val("");
										$('#table-rencana').DataTable().ajax.reload();
										$('#tpMemberNama').focus();
								}
								// $('#table-rencana').DataTable().fnDestroy();
								
							},
								
						}); 
		
						// $.smallBox({
						// 	title : "Callback function",
						// 	content : "<i class='fa fa-clock-o'></i> <i>You pressed Yes...</i>",
						// 	color : "#659265",
						// 	iconSmall : "fa fa-check fa-2x fadeInRight animated",
						// 	timeout : 4000
						// });
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


		function reload_data(){
        table_registrasi= $('#table-rencana').DataTable({
				"language" : dataTableLanguage,
				"ajax": {
						"url": '{{url('/pembelian/request-pembelian/ddRequest_dummy')}}',
						"type": "POST",  
						"data": function ( data ) {
							data._token = '{{ csrf_token() }}';
						},
					},
			} );
		}

		function reload_table(){
			table_registrasi.ajax.reload(null, false);

		}
		// function load_table()
		// {
		// 	var tambahRencana;
		// 	var responsiveHelper_dt_basic = undefined;
        //     var responsiveHelper_datatable_fixed_column = undefined;
        //     var responsiveHelper_datatable_col_reorder = undefined;
        //     var responsiveHelper_datatable_tabletools = undefined;

        //     var breakpointDefinition = {
        //         tablet : 1024,
        //         phone : 480
        //     };

        //     setTimeout(function () {

        //     tambahRencana = $('#dt_tambah').dataTable({
        //         "processing": true,
        //         "serverSide": true,
		// 		// "data" : {
		// 		// 	"comp" : $('#dt_supplier').val(),
		// 		// },
        //         "ajax": "{{ url('/pembelian/rencana-pembelian/view_tambahRencana') }}",
        //         "fnCreatedRow": function (row, data, index) {
        //             $('td', row).eq(0).html(index + 1);
        //             },
        //         "columns":[
        //             {"data": "pr_id"},
        //             {"data": "c_name"},
        //             {"data": "i_nama"},
        //             {"data": "pr_qtyReq"},
		// 			{"data": "input"},
        //             {"data": "aksi"}
        //         ],
        //         "autoWidth" : true,
        //         "language" : dataTableLanguage,
        //         "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
        //         "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        //         "preDrawCallback" : function() {
        //             // Initialize the responsive datatables helper once.
        //             if (!responsiveHelper_dt_basic) {
        //                 responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_tambah'), breakpointDefinition);
        //             }
        //         },
        //         "rowCallback" : function(nRow) {
        //             responsiveHelper_dt_basic.createExpandIcon(nRow);
        //         },
        //         "drawCallback" : function(oSettings) {
        //             responsiveHelper_dt_basic.respond();
        //         }
        //     });
        //      $('#overlay').fadeOut(200);
        //     }, 1000);
		// }


	</script>

@endsection