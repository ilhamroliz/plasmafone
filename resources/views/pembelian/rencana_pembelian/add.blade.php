@extends('main')

@section('title', 'Master Barang')

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
                        <div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        </div>
                        <h2><strong>Tambah Rencana Pembelian</strong></h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

						<!-- widget div-->
						<div>
							
							<!-- widget content -->
							<div class="widget-body no-padding">

								<!-- widget body text-->
								
								<div class="tab-content padding-10">

									<div class="tab-pane fade in active" id="hr1">
										
										<table id="dt_tambah" class="table table-striped table-bordered table-hover" width="100%">

											<thead>			                

												<tr>
                                                    <th data-hide="phone,tablet">No</th>
                                                    <th data-hide="phone,tablet">Nama Outlet</th>
                                                    <th data-hide="phone,tablet">Nama Barang</th>
                                                    <th data-hide="phone,tablet">Qty</th>
                                                    <th data-hide="phone,tablet">Aksi</th>

												</tr>

											</thead>

											<tbody>
												
											</tbody>

										</table>
										
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
													<tr class="info">
														<td><strong>Suplier</strong></td>
														<td><strong>:</strong></td>
														<td >
															<div class="form-group">
																<select class="form-control" name="" id="dt_suplier" >
																	<option selected="" value="00"></option>
																</select>
															</div>
								  						</td>
													</tr>
													<tr class="info">
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
														<td ><input type="text"  id="pr_qtyReq"></label></td>
													</tr>
													<tr hidden="">
														<td><input type="text" id="pr_dateRequest"></td>
														<td><input type="text"  ></td>
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

            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet : 1024,
                phone : 480
            };

            setTimeout(function () {

            tambahRencana = $('#dt_tambah').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/pembelian/rencana-pembelian/view_tambahRencana') }}",
                "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                    },
                "columns":[
                    {"data": "pr_id"},
                    {"data": "c_name"},
                    {"data": "i_nama"},
                    {"data": "pr_qtyReq"},
                    {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_tambah'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
             $('#overlay').fadeOut(200);
            }, 1000);
            
        });

        function edit(id){
            
            $.ajax({
                url : '{{url('/pembelian/rencana-pembelian/getRequest_id')}}',
                type: "GET",
                data: { 
					id : id,
                },
                dataType: "JSON",
                success: function(data)
                {
					
				// pr_idReq = data.data.pr_id;
				// pr_itemPlan = data.data.i_id;
				// pr_qtyReq = data.data.pr_qtyReq;
				// pr_dateRequest = data.data.pr_dateReq;

					if (data.data.i_img == "") {

							$('img#dt_image').attr("src", "{{asset('img/image-not-found.png')}}");

						}else{

							$('img#dt_image').attr("src", "{{asset('img/items/')}}"+"/"+data.data.i_img);

						}
					

					$('#dt_kelompok').text(data.data.i_kelompok);
					$('#dt_group').text(data.data.i_group);
					$('#dt_subgroup').text(data.data.i_sub_group);
					$('#dt_merk').text(data.data.i_merk);
					$('#dt_specificcode').text(data.data.i_specificcode);
					$('#dt_isactive').text(data.data.i_isactive);
					$('#dt_code').text(data.data.i_code);
					$('#dt_minstock').text(data.data.i_minstock);
					$('#dt_price').text(data.data.i_price);
					$('#dt_berat').text(data.data.i_berat);
					$('#dt_nama').text(data.data.i_nama);

					$('#pr_idReq').val(data.data.pr_id);
					$('#pr_itemPlan').val(data.data.i_id);
					$('#pr_qtyReq').val(data.data.pr_dateReq);
					$('#pr_dateRequest').val(data.data.pr_dateReq);
					

					$('#myModalLabel').text('FORM RENCANA PEMBELIAN');
					$('#myModal').modal('show');
                    $('#btnTambah').show();
                    $('#btnTolak').hide();
                    $('#btnBatal').show();
                },
                
            }); 

			suplier();
            
        }

		function suplier(){
			$.ajax({
                url : '{{url('/pembelian/rencana-pembelian/itemSuplier')}}',
                type: "GET",
                data: { 
                
                },
                dataType: "JSON",
                success: function(data)
                {
                    $('#dt_suplier').empty(); 
					row = "<option selected='' value='0'>Pilih Suplier</option>";
					$(row).appendTo("#dt_suplier");
					$.each(data, function(k, v) {
						row = "<option value='"+v.s_id+"'>"+v.s_company+"</option>";
						$(row).appendTo("#dt_suplier");
					});
                },
                
            });  
		}

        function batal(){
            $('#myModal').modal('hide');
        }

        function tambah(){
            $.ajax({
                url : '{{url('/pembelian/rencana-pembelian/tambahRencana')}}',
                type: "GET",
                data: { 
					pr_idReq :	$('#pr_idReq').val(),
					pr_itemPlan :	$('#pr_itemPlan').val(),
					pr_qtyReq :	$('#pr_qtyReq').val(),
					pr_dateRequest : $('#pr_dateRequest').val(),
                },
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status == 'GAGAL'){
						$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. data Gagal di tambahkan",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});
					}else{
						$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data telah ditambahkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});
					}
                },
                
            });  
        }

        function tolak(){
            $.ajax({
                url : '{{url('/pembelian/rencana-pembelian/tolakRequest')}}',
                type: "GET",
                data: { 
                
                },
                dataType: "JSON",
                success: function(data)
                {
                    
                },
                
            });  
		}
		
		var app = new Vue({
		el 		: '#content',
		data 	: {
			kelompok : 'select',
			group : 'select',
			sub_group : 'select',
			merk : 'select',
			btn_save_disabled 	: false,

			data_I_kelompok: [],
			data_I_group: [],
			data_I_sub_group: [],
			data_I_merk: [],

			form_data : {
				i_kelompok: '',
				i_group: '',
				i_sub_group: '',
				i_merk: '',
				i_nama: '',
				i_code: '',
				i_img: '',
				i_minstock: '',
				i_berat: '',
				i_specificcode: 'Y',
				i_isactive: 'Y'
				
			}

		},
		

		
		methods: {

			switch_kelompok: function(){
				if(this.kelompok == 'select'){
					this.kelompok = 'input';
					$('#select_kelompok').hide();
					$("#input_kelompok").show();
				}else{
					this.kelompok = 'select';
					this.form_data.i_kelompok = '';
					$('#data-form').data('bootstrapValidator').resetForm();
					$('#input_kelompok').hide();
					$("#select_kelompok").show();
				}
			},

			switch_group: function(){
				if(this.group == 'select'){
					this.group = 'input';
					$('#select_group').hide();
					$("#input_group").show();
				}else{
					this.group = 'select';
					this.form_data.i_group = '';
					$('#data-form').data('bootstrapValidator').resetForm();
					$('#input_group').hide();
					$("#select_group").show();
				}
			},

		

			i_kelompok_change: function(v){
				this.form_data.i_kelompok = v;
			},

			i_group_change: function(v){
				this.form_data.i_group = v;
			},

			

		}
	});

	</script>

@endsection