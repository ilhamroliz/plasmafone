@extends('main')

@section('title', 'Inventory|Penerimaan Barang Dari Distribusi')

@section('extra_style')

@endsection

<?php 
use App\Http\Controllers\PlasmafoneController as Access;
?>

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
			<li>Home</li><li>Inventory</li><li>Penerimaan Barang Dari Supplier</li>
		</ol>

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

					Inventory <span><i class="fa fa-angle-double-right"></i> Penerimaan Barang Dari Supplier </span>

				</h1>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/inventory/penerimaan/supplier') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

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

                    <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

                        <header>

                                <h2><strong>Supplier</strong></h2>
                            
                        </header>

                        <div>
                            
                            <div class="widget-body">

                                <form class="form-horizontal" method="post">
                                    {{ csrf_field() }}

                                    <fieldset>  

                                        <div class="row">
                                            <input type="hidden" id="id" value="{{ $id }}">

                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                                <div class="form-group">

                                                    <label class="col-xs-4 col-lg-4 control-label text-left">No. Nota</label>

                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">

                                                        <div class="input-group">

                                                            <span class="input-group-addon"><i class="fa fa-building"></i></span>

                                                            <input type="text" class="form-control" readonly style="text-transform: uppercase" value="{{ $getData[0]->p_nota }}" />

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label class="col-xs-4 col-lg-4 control-label text-left">Nama Supplier</label>

                                                    <div class="col-xs-8 col-lg-8 inputGroupContainer">

                                                        <div class="input-group">

                                                            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                                                            <input type="text" class="form-control" style="text-transform: uppercase" readonly value="{{ $getData[0]->s_company }}" />

                                                        </div>

                                                    </div>

                                                </div>

                                            </article>
                                            
                                        </div>

                                    </fieldset>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

						<header>
							
                            <h2><strong>Daftar Item</strong></h2>

						</header>

						<div>
							
							<div class="widget-body no-padding">

								<table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">

                                    <thead>		

                                        <tr>

                                            <th width="50%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>

											<th width="15%"><i class="fa fa-fw fa-cube txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Qty</th>
											
											<th width="15%"><i class="fa fa-fw fa-cube txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Qty Diterima</th>

                                            <th class="text-center" width="20%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

							</div>

						</div>

					</div>

				</div>
			</div>

			<!-- end row -->



            <!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				<div class="modal-dialog" style="width: 60%">

					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel"><strong>Jumlah barang yang diterima</strong></h4>

						</div>
						<form id="form_qtyReceived">{{ csrf_field() }}
							<div class="modal-body">

								<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="text-center col-md-12 control-label" id="nama_item" style="font-weight:bold"></label>
											</div>
										</div>
								</div><br>
				
								<div class="row terima margin-bottom-10">
                                    
                                    <form id="formInput">

                                        <input type="hidden" id="id">
                                        <input type="hidden" id="idItem">
                                        <input type="hidden" id="supplier">
                                        <input type="hidden" id="detailid">
                                        <input type="hidden" id="sumqty">
                                        
                                        <div class="col-md-12 no-padding margin-bottom-10">
                                            <label class="col-md-4 control-label text-left">Nota Delivery Order</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="notaDO" name="notaDO" style="text-transform: uppercase" placeholder="Masukkan Nota DO"/>
                                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding margin-bottom-10">
                                            <label class="col-md-4 control-label text-left">Jumlah Diterima</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="rcvd" name="rcvd" style="text-transform: uppercase" readonly/>
                                                    <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12 no-padding margin-bottom-10 KS">
                                            <label class="col-md-4 control-label text-left">Kode Spesifik</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="kode" name="kode" style="text-transform: uppercase" placeholder="Masukkan Kode Spesifik"/>
                                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding margin-bottom-10 EXP">
                                            <label class="col-md-4 control-label text-left">Tanggal Kadaluarsa</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="expDate" name="expDate" style="text-transform: uppercase" placeholder="Masukkan Tanggal Kadaluarsa Barang"/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding margin-bottom-10 JML">
                                            <label class="col-md-4 control-label text-left">Jumlah Barang</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="jmlBarang" name="jmlBarang" style="text-transform: uppercase" placeholder="Masukkan Jumlah Barang Yang Diterima"/>
                                                    <span class="input-group-addon"><i class="fa fa-calculator"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </form>

								</div>


                                <!-- TABLE untuk Modal TERIMA Barang -->
                                <div class="row" id="tbl_kode">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                                            <header>
                                                <h2><strong>Daftar barang yang sudah diterima</strong></h2>
                                            </header>
                                            <div>
                                                <div class="widget-body no-padding">
                                                    <table id="dt_code" class="table table-striped table-bordered table-hover tbl_input" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" width="30%"><i class="fa fa-fw fa-building txt-color-blue"></i>&nbsp;Nota DO</th>
                                                                <th class="text-center" width="50%"><i class="fa fa-fw fa-barcode txt-color-blue"></i>&nbsp;Kode</th>
                                                                <th class="text-center" width="20%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="dc">
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="tbl_exp_kode">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                                            <header>
                                                <h2><strong>Daftar barang yang sudah diterima</strong></h2>
                                            </header>
                                            <div>
                                                <div class="widget-body no-padding">
                                                    <table id="dt_code_exp" class="table table-striped table-bordered table-hover tbl_input" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" width="25%"><i class="fa fa-fw fa-building txt-color-blue"></i>&nbsp;Nota DO</th>
                                                                <th class="text-center" width="25%"><i class="fa fa-fw fa-calendar txt-color-blue"></i>&nbsp;Tanggal Kadaluarsa</th>
                                                                <th class="text-center" width="30%"><i class="fa fa-fw fa-barcode txt-color-blue"></i>&nbsp;Kode Spesifik</th>
                                                                <th class="text-center" width="20%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="dce">
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
				
							</div>
						</form>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Batal
							</button>
							<button type="button" id="simpan" class="btn btn-primary" onclick="simpan()">
								Simpan
							</button>
						</div>

					</div><!-- /.modal-content -->

				</div><!-- /.modal-dialog -->

			</div>
            <!-- /.modal -->


            <!-- Modal -->
			<div class="modal fade" id="detilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel">Detail</h4>

						</div>

						<div class="modal-body">		
							<div class="row">
								<!-- Widget ID (each widget will need unique ID)-->
								<div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

									<header>

										<span class="widget-icon"> <i class="fa fa-table"></i> </span>
										<h2 id="title_detail"></h2>

                                    </header>
                                    <input type="hidden" id="idItemEdit">

									<!-- widget div-->
									<div>
										<!-- widget content -->
										<div class="widget-body no-padding">											
											<div class="table-responsive">
												<table class="table">
													<tbody>
														<tr>
															<td><strong>Nota PO</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_nota"></td>
														</tr>
														<tr>
															<td><strong>Nama Supplier</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_supp"></td>
														</tr>
														<tr>
															<td><strong>No. Telp Supplier</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_telp"></td>
														</tr>
														<tr>
															<td><strong>Nama Barang</strong></td>
															<td><strong>:</strong></td>
															<td id="dt_item"></td>
														</tr>
													</tbody>
												</table>


                                                <div id="divDTC" style="display:none">
                                                    <table class="table table-bordered" id="table_item_sc">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <td>Nota DO</td>
                                                                <td>Kode Spesifik</td>
                                                                <td>Aksi</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dtcBody">
                                                        </tbody>
                                                    </table>		
                                                </div>
                                                <div id="divDTE" style="display:none">
                                                    <table class="table table-bordered" id="table_item_exp">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <td>Nota DO</td>
                                                                <td>Tanggal Kadaluarsa</td>
                                                                <td>QTY Diterima</td>
                                                                <td>Aksi</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dteBody">
                                                        </tbody>
                                                    </table>		
                                                </div>
                                                <div id="divDTCE" style="display:none">
                                                    <table class="table table-bordered" id="table_item_scexp">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <td>Nota DO</td>
                                                                <td>Tanggal Kadaluarsa</td>
                                                                <td>Kode Spesifik</td>
                                                                <td>Aksi</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dtceBody">
                                                        </tbody>
                                                    </table>		
                                                </div>
                                                <div id="divDTN" style="display:none">
                                                    <table class="table table-bordered" id="table_item_non">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <td>Nota DO</td>
                                                                <td>Qty</td>
                                                                <td>Aksi</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dtnBody">
                                                        </tbody>
                                                    </table>		
                                                </div>

																						
											</div>
										</div>
										<!-- end widget content -->
									</div>
									<!-- end widget div -->
								</div>
								<!-- end widget -->
							</div>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>
            <!-- /.modal -->


            <!-- Modal -->
			<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				<div class="modal-dialog" style="width: 60%">

					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel"><strong>Jumlah barang yang diterima</strong></h4>

						</div>
						<form id="form_qtyReceived">{{ csrf_field() }}
							<div class="modal-body">

								<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="text-center col-md-12 control-label" id="nama_item" style="font-weight:bold"></label>
											</div>
										</div>
								</div><br>
				
								<div class="row terima margin-bottom-10">
                                    
                                    <form id="formInput">

                                        <input type="hidden" id="status">

                                        <input type="hidden" id="scEdit">
                                        <input type="hidden" id="jmlEdit">

                                        <input type="hidden" id="refPD">
                                        <input type="hidden" id="refSD">
                                        <input type="hidden" id="refSM">
                                        
                                        <div class="col-md-12 no-padding margin-bottom-10">
                                            <label class="col-md-4 control-label text-left">Nota Delivery Order</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="eNotaDO" name="eNotaDO" style="text-transform: uppercase" placeholder="Masukkan Nota DO"/>
                                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding margin-bottom-10">
                                            <label class="col-md-4 control-label text-left">Nama Barang</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="eItem" name="eItem" style="text-transform: uppercase" readonly/>
                                                    <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding margin-bottom-10">
                                            <label class="col-md-4 control-label text-left">Jumlah Diterima</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="eRcvd" name="eRcvd" style="text-transform: uppercase" readonly/>
                                                    <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12 no-padding margin-bottom-10 EKS">
                                            <label class="col-md-4 control-label text-left">Kode Spesifik</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="eKode" name="eKode" style="text-transform: uppercase" placeholder="Masukkan Kode Spesifik"/>
                                                    <span class="input-group-addon"><i class="fa fa-barcode"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding margin-bottom-10 EEXP">
                                            <label class="col-md-4 control-label text-left">Tanggal Kadaluarsa</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="eExpDate" name="eExpDate" style="text-transform: uppercase" placeholder="Masukkan Tanggal Kadaluarsa Barang"/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 no-padding margin-bottom-10 EJML">
                                            <label class="col-md-4 control-label text-left">Jumlah Barang</label>
                                            <div class="col-xs-8 col-lg-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="eJmlBarang" name="eJmlBarang" style="text-transform: uppercase" placeholder="Masukkan Jumlah Barang Yang Diterima"/>
                                                    <span class="input-group-addon"><i class="fa fa-calculator"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </form>
								</div>
							</div>
						</form>

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Batal
							</button>
							<button type="button" id="simpan" class="btn btn-primary" onclick="simpanEdit()">
								Simpan
							</button>
						</div>

					</div><!-- /.modal-content -->

				</div><!-- /.modal-dialog -->

			</div>
            <!-- /.modal -->
            

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
        var aktif, tbl_code, rows = null;
        var dtc, dtce, dte, dtn;

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyiapkan...');

		
		var baseUrl = '{{ url('/') }}';

		/* BASIC ;*/
        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;
        
        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };

        $(document).ready( function() {
            $( "#expDate" ).datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true,
                todayHighlight: true
            });

            dtc = $('#dt_code').DataTable({
                "order": [],
                "searching": false,
                "autoWidth": false,
                "language": dataTableLanguage,
                "paging": false,
                "info": false
            });
            dtce = $('#dt_code_exp').DataTable({
                "order": [],
                "pageLength": 5,
                "searching": false,
                "lengthChange": false,
                "autoWidth": false,
                "language": dataTableLanguage,
                "paging": false,
                "info": false
            });


            ddtc = $('#table_item_sc').DataTable({
                "order": [],
                "searching": false,
                "autoWidth": false,
                "language": dataTableLanguage,
                "paging": false,
                "info": false
            });
            ddte = $('#table_item_exp').DataTable({
                "order": [],
                "pageLength": 5,
                "searching": false,
                "lengthChange": false,
                "autoWidth": false,
                "language": dataTableLanguage,
                "paging": false,
                "info": false
            });
            ddtce = $('#table_item_scexp').DataTable({
                "order": [],
                "pageLength": 5,
                "searching": false,
                "lengthChange": false,
                "autoWidth": false,
                "language": dataTableLanguage,
                "paging": false,
                "info": false
            });
            ddtn = $('#table_item_non').DataTable({
                "order": [],
                "pageLength": 5,
                "searching": false,
                "lengthChange": false,
                "autoWidth": false,
                "language": dataTableLanguage,
                "paging": false,
                "info": false
            });

        });
        
        
        setTimeout(function () {

            aktif = $('#dt_active').DataTable({
                "processing": true,
                "serverSide": true,
                "orderable": false,
                "order": [],
                "ajax": "{{ url('/inventory/penerimaan/supplier/get-item?id='.$id) }}",
                "columnDefs": [
                    { className: 'text-center', targets: [1, 2] }
                ],
                "columns":[
                    {"data": "i_nama"},
                    {"data": "qty"},
                    {"data": "qtyr"},
                    {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_active'), breakpointDefinition);
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

        }, 500);

        /* END BASIC */

        function detail(id, item){

            axios.post(baseUrl+'/inventory/penerimaan/supplier/detailReceived'+'/'+id+'/'+item ).then((response) => {

                $('#dt_nota').html(response.data.data.p_nota);
                $('#dt_supp').html(response.data.data.s_company);
                $('#dt_telp').html(response.data.data.s_phone);
                $('#dt_item').html(response.data.data.i_nama);
                $('#idItemEdit').val(response.data.data.i_id);

                $('#divDTC').css('display', 'none');
                $('#divDTE').css('display', 'none');
                $('#divDTCE').css('display', 'none');
                $('#divDTN').css('display', 'none');
                
                if(response.data.item.i_specificcode == 'Y' && response.data.item.i_expired == 'N'){

                    $('#dtcBody').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

                    ddtc.clear();
                    for(var i = 0; i < response.data.dataSM.length; i++){
                        ddtc.row.add([
                            '<input type="hidden" id="refPD-a'+i+'" value="'+response.data.dataDT[i].pd_purchase+ '-' +response.data.dataDT[i].pd_detailid+'">'+
                            '<input type="hidden" id="refSM-a'+i+'" value="'+response.data.dataSM[i].sm_stock+ '-' +response.data.dataSM[i].sm_detailid+'">'+
                            '<input type="hidden" id="reff-a'+i+'" value="'+response.data.dataSM[i].sm_reff+'">'+response.data.dataSM[i].sm_reff,
                            '<input type="hidden" id="sc-a'+i+'" value="'+response.data.dataDT[i].pd_specificcode+'">'+response.data.dataDT[i].pd_specificcode,
                            '<div class="text-center">'+
                                '<a class="btn btn-warning btn-circle" onclick="edit(\''+'a'+i+'\')"><i class="fa fa-edit"></i></a>'+
                            '</div>'
                        ]).draw();
                    }

                    $('#divDTC').css('display', 'block');

                }else if(response.data.item.i_specificcode == 'N' && response.data.item.i_expired == 'Y'){

                    $('#dteBody').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

                    ddte.clear();
                    for(var i = 0; i < response.data.dataSM.length; i++){
                        ddte.row.add([
                            '<input type="hidden" id="refPD-b'+i+'" value="'+response.data.dataDT[0].pd_purchase+ '-' +response.data.dataDT[0].pd_detailid+'">'+
                            '<input type="hidden" id="refSM-b'+i+'" value="'+response.data.dataSM[i].sm_stock+ '-' +response.data.dataSM[i].sm_detailid+'">'+
                            '<input type="hidden" id="reff-b'+i+'" value="'+response.data.dataSM[i].sm_reff+'">'+response.data.dataSM[i].sm_reff,
                            '<input type="hidden" id="exp-b'+i+'" value="'+response.data.dataSM[i].sm_expired+'">'+response.data.dataSM[i].sm_expired,
                            '<input type="hidden" id="jml-b'+i+'" value="'+response.data.dataSM[i].sm_qty+'">'+response.data.dataSM[i].sm_qty,
                            '<div class="text-center">'+
                                '<a class="btn btn-warning btn-circle" onclick="edit(\''+'b'+i+'\')"><i class="fa fa-edit"></i></a>'+
                            '</div>'
                        ]).draw();
                    }

                    $('#divDTE').css('display', 'block');

                }else if(response.data.item.i_specificcode == 'Y' && response.data.item.i_expired == 'Y'){

                    $('#dtceBody').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

                    ddtce.clear();
                    for(var i = 0; i < response.data.dataSM.length; i++){
                        ddtce.row.add([
                            '<input type="hidden" id="refPD-c'+i+'" value="'+response.data.dataDT[i].pd_purchase+ '-' +response.data.dataDT[i].pd_detailid+'">'+
                            '<input type="hidden" id="refSM-c'+i+'" value="'+response.data.dataSM[i].sm_stock+ '-' +response.data.dataSM[i].sm_detailid+'">'+
                            '<input type="hidden" id="reff-c'+i+'" value="'+response.data.dataSM[i].sm_reff+'">'+response.data.dataSM[i].sm_reff,
                            '<input type="hidden" id="exp-c'+i+'" value="'+response.data.dataSM[i].sm_expired+'">'+response.data.dataSM[i].sm_expired,
                            '<input type="hidden" id="jml-c'+i+'" value="'+response.data.dataDT[i].pd_specificcode+'">'+response.data.dataDT[i].pd_specificcode,
                            '<div class="text-center">'+
                                '<a class="btn btn-warning btn-circle" onclick="edit(\''+'c'+i+'\')"><i class="fa fa-edit"></i></a>'+
                            '</div>'
                        ]).draw();
                    }

                    $('#divDTCE').css('display', 'block');

                }else{

                    $('#dtnBody').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

                    ddtn.clear();
                    for(var i = 0; i < response.data.dataSM.length; i++){
                        ddtn.row.add([
                            '<input type="hidden" id="refPD-d'+i+'" value="'+response.data.dataDT[0].pd_purchase+ '-' +response.data.dataDT[0].pd_detailid+'">'+
                            '<input type="hidden" id="refSM-d'+i+'" value="'+response.data.dataSM[i].sm_stock+ '-' +response.data.dataSM[i].sm_detailid+'">'+
                            '<input type="hidden" id="reff-d'+i+'" value="'+response.data.dataSM[i].sm_reff+'">'+response.data.dataSM[i].sm_reff,
                            '<input type="hidden" id="qty-d'+i+'" value="'+response.data.dataSM[i].sm_qty+'">'+response.data.dataSM[i].sm_qty,
                            '<div class="text-center">'+
                                '<a class="btn btn-warning btn-circle" onclick="edit(\''+'d'+i+'\')"><i class="fa fa-edit"></i></a>'+
                            '</div>'
                        ]).draw();
                    }

                    $('#divDTN').css('display', 'block');

                }

            })

            $('#detilModal').modal('show');

        }

        /* Sebelum Menampilkan Form Edit .... */
        function edit(id){

            var nota, ks, exp, jml, refPD, refSM;

            $('.EKS').css('display', 'none');
            $('.EEXP').css('display', 'none');
            $('.EJML').css('display', 'none');

            refPD = $('#refPD-'+id).val();
            refSM = $('#refSM-'+id).val();
            $('#refPD').val(refPD);
            $('#refSM').val(refSM);

            if(id.includes('a') == true){

                $('#status').val('cs');

                nota = $('#reff-'+id).val();
                $('#eNotaDO').val(nota);
                ks = $('#sc-'+id).val();
                $('#eKode').val(ks);

                $('#scEdit').val(ks);

                $('.EKS').css('display', 'block');

            }else if(id.includes('b') == true){

                $('#status').val('exp');

                nota = $('#reff-'+id).val();
                $('#eNotaDO').val(nota);
                exp = $('#exp-'+id).val();
                $('#eExpDate').val(exp);
                jml = $('#qty-'+id).val();
                $('#eJmlBarang').val(jml);

                $('#jmlEdit').val(jml);

                $('.EEXP').css('display', 'block');
                $('.EJML').css('display', 'block');

            }else if(id.includes('c') == true){

                $('#status').val('csexp');

                nota = $('#reff-'+id).val();
                $('#eNotaDO').val(nota);
                exp = $('#exp-'+id).val();
                $('#eExpDate').val(exp);
                ks = $('#sc-'+id).val();
                $('#eKode').val(ks);

                $('#scEdit').val(ks);

                $('.EKS').css('display', 'block');
                $('.EEXP').css('display', 'block');
                
            }else{

                $('#status').val('non');

                nota = $('#reff-'+id).val();
                $('#eNotaDO').val(nota);
                jml = $('#qty-'+id).val();
                $('#eJmlBarang').val(jml);

                $('#jmlEdit').val(jml);

                $('.EJML').css('display', 'block');

            }
            $('#editModal').modal('show');
        }

        function simpanEdit(){

            var notaS = $('#eNotaDO').val();
            var expS = $('#eExpDate').val();
            var kodeS = $('#eKode').val();
            var jmlS = $('#eJmlBarang').val();

            var refPD = $('#refPD').val();
            var refSM = $('#refSM').val();

            var status = $('#status').val();
            var item = $('#idItemEdit').val();

            var jmlEdit = $('#jmlEdit').val();
            var scEdit = $('#scEdit').val();

            var data = '';
            if(status == 'cs'){       

                data = 'kode=' + kodeS + '&notaDO=' + notaS + '&refPD=' + refPD + '&refSM=' + refSM + '&status=' + status + '&item=' + item + '&scEdit=' + scEdit;

            }else if(status == 'exp'){

                data = 'exp=' + expS + '&jml=' + jmlS + '&notaDO=' + notaS + '&refPD=' + refPD + '&refSM=' + refSM + '&status=' + status + '&item=' + item + '&jmlEdit=' + jmlEdit;
                
            }else if(status == 'csexp'){

                data = 'exp=' + expS + 'kode=' + kodeS + '&notaDO=' + notaS + '&refPD=' + refPD + '&refSM=' + refSM + '&status=' + status + '&item=' + item + '&scEdit=' + scEdit;
                
            }else{

                data = '&jml=' + jmlS + '&notaDO=' + notaS + '&refPD=' + refPD + '&refSM=' + refSM + '&status=' + status + '&item=' + item + '&jmlEdit=' + jmlEdit;

            }

            axios.post(baseUrl+'/inventory/penerimaan/supplier/editReceived', data).then((response) => {

                

            })

        }


		function refresh_tab(){
            aktif.ajax.reload();
        }

        function resetInput(){
            $('#tbl_kode').css('display', 'none');
            $('#tbl_exp_kode').css('display', 'none');

            $('#notaDO').val("");
            $('#kode').val("");
            $('#expCode').val("");
            $('#jmlBarang').val("");

            $('.KS').css('display', 'none');
            $('.EXP').css('display', 'none');
            $('.JML').css('display', 'none');
        }

        $('#kode').on('keyup', function(event){

            if($('#kode').val() != ''){
                $('#simpan').prop('disabled', false);
            }

            if ( event.which == 13 ) {
                addRow();
             }

        });

        $('.tbl_input tbody').on( 'click', 'a.btnhapus', function () {
            console.log("Mashooookk");
            
            if(sc == 'Y' && exp == 'N'){

                dtc.row( $(this).parents('tr') ).remove().draw();
                
            }else if(sc == 'Y' && exp == 'Y'){

                dtce.row( $(this).parents('tr') ).remove().draw();

            }

        });

        function addRow(){

            var speccode = $('#kode').val();
            var expdate = $('#expDate').val();
            var notado = $('#notaDO').val();
            var jmlbrg = $('#jmlBarang').val();

            var sumqty = $('#sumqty').val();
            var rcvd = $('#rcvd').val();

            if(sc == 'Y' && exp == 'N'){

                if(speccode == ''){
                    $.smallBox({
                        title : "Perhatian",
                        content : "Mohon isi KODE SPESIFIKASI terlebih dahulu !!!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    return false;
                }

                if(notado == ''){
                    $.smallBox({
                        title : "Perhatian",
                        content : "Mohon isi NOTA DELIVERY ORDER terlebih dahulu !!!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    return false;
                }

                if(parseInt(sumqty) == parseInt(rcvd) + dtc.rows().data().length){
                    $.smallBox({
                        title : "Perhatian",
                        content : "Jumlah Masukkan dan Barang yang sudah diterima sudah mencapai QTY Maksimal PO ini !!!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    return false;
                }

                var inputs = document.getElementsByClassName( 'kode' ),
                names  = [].map.call(inputs, function( input ) {
                    return input.value;
                });

                if(names.includes(speccode) == true){
                    $.smallBox({
                        title : "Perhatian",
                        content : "Kode Spesifikasi sudah ada di dalam tabel !!!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    return false;
                }

                $('#dt_code').DataTable().row.add([
                    '<input type="hidden" name="notaDO[]" value="'+notado+'">'+notado,
                    '<input type="hidden" class="kode" name="kode[]" value="'+speccode+'">'+speccode.toUpperCase(),
                    '<div class="text-center">'+
                        '<a class="btn btn-danger btn-circle btnhapus"><i class="fa fa-close"></i></a>'+
                    '</div>'
                ]).draw();


            }else if(sc == 'Y' && exp == 'Y'){

                if(speccode == ''){
                    $.smallBox({
                        title : "Perhatian",
                        content : "Mohon isi KODE SPESIFIKASI terlebih dahulu !!!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    return false;
                }

                if(notado == ''){
                    $.smallBox({
                        title : "Perhatian",
                        content : "Mohon isi NOTA DELIVERY ORDER terlebih dahulu !!!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    return false;
                }

                if(parseInt(sumqty) == parseInt(rcvd) + dtc.rows().data().length){
                    $.smallBox({
                        title : "Perhatian",
                        content : "Jumlah Masukkan dan Barang yang sudah diterima sudah mencapai QTY Maksimal PO ini !!!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    return false;
                }

                var inputs = document.getElementsByClassName( 'kode' ),
                names  = [].map.call(inputs, function( input ) {
                    return input.value;
                });

                if(names.includes(speccode) == true){
                    $.smallBox({
                        title : "Perhatian",
                        content : "Kode Spesifikasi sudah ada di dalam tabel !!!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    return false;
                }

                $('#dt_code_exp').DataTable().row.add([
                    '<input type="hidden" name="notaDO[]" value="'+notado+'">'+notado,
                    '<input type="hidden" name="expDate[]" value="'+expdate+'">'+expdate,
                    '<input type="hidden" class="kode" name="kode[]" value="'+speccode+'">'+speccode.toUpperCase(),
                    '<div class="text-center">'+
                        '<a class="btn btn-danger btn-circle btnhapus"><i class="fa fa-close"></i></a>'+
                    '</div>'
                ]).draw();

            }

            $('#kode').val('');
            $('#expDate').val('');
            $('#jmlBarang').val('');            

        }

		function terima(id, item){

            axios.get(baseUrl+'/inventory/penerimaan/supplier/item-receive/'+id+'/'+item).then(response => {

                $('#nama_item').html(response.data.data.nama_item);

                $('#id').val(id);
                $('#supplier').val(response.data.data.supplier);
                $('#idItem').val(item);
                $('#detailid').val(response.data.data.iddetail);
                $('#sumqty').val(response.data.data.sum_qty);
                $('#rcvd').val(response.data.data.sum_qtyReceived);

                resetInput();

                getTableModal(id, item);
                
                $('#myModal').modal('show');

            })
        }
        
        function getTableModal(id, item){
            var dataDT = 'id=' + id + '&item=' + item;
            axios.post(baseUrl+'/inventory/penerimaan/supplier/getItemDT', dataDT).then((respon) => {

                sc = respon.data.item.i_specificcode;
                exp = respon.data.item.i_expired; 

                if(respon.data.item.i_specificcode == 'Y' && respon.data.item.i_expired == 'N'){
                    $('#dc').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data masukkan</td></tr>');
                    $('#dt_code').DataTable().clear();

                    $('#tbl_kode').css('display', 'block'); 
                    $('.KS').css('display', 'block');

                }else if(respon.data.item.i_specificcode == 'N' && respon.data.item.i_expired == 'Y'){

                    $('.EXP').css('display', 'block');
                    $('.JML').css('display', 'block');

                }else if(respon.data.item.i_specificcode == 'Y' && respon.data.item.i_expired == 'Y'){
                    $('#dce').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data masukkan</td></tr>');
                    $('#dt_code_exp').DataTable().clear();

                    $('#tbl_exp_code').css('display', 'block');
                    $('.KS').css('display', 'block');
                    $('.EXP').css('display', 'block');

                }else{

                    $('.JML').css('display', 'block');

                }
            })

        }

		function qtyTerima(qtySisa) {
			var input = parseInt($("#qty").val());
			if (isNaN(input)){
				input = 0;
			}
			if (input > parseInt(qtySisa)){
				$("#qty").val(input);
			}
		}

		function simpan() {
            $('#overlay').fadeIn(200);
            
            var idpo = $('#id').val();
            var supplier = $('#supplier').val();
            var idItem = $('#idItem').val();
            var sumqty = $('#sumqty').val();

            var notaDO = $('#notaDO').val();
            var expDate = $('#expDate').val();
            var jmlBarang = $('#jmlBarang').val();
            var rcvd = $('#rcvd').val();


            if(parseInt(sumqty) < parseInt(rcvd) + parseInt(jmlBarang)){
                $('#overlay').fadeOut(200);
                $.smallBox({
                    title : "Perhatian",
                    content : "Maaf, Jumlah Barang dan yang sudah diterima melebihi QTY Barang pada PO ini !!! Max 22",
                    color : "#A90329",
                    timeout: 3000,
                    icon : "fa fa-times bounce animated"
                });
                return false;
            }


            var ar = $();
            var data = '';
            if(sc == 'Y' && exp == 'N'){
                for (var i = 0; i < dtc.rows()[0].length; i++) {
                    ar = ar.add(dtc.row(i).node())
                }

                data = ar.find('select,input,textarea').serialize() + '&idpo=' + idpo + '&iditem=' + idItem;
            }else if(sc == 'Y' && exp == 'N'){

                data =  'notaDO=' + notaDO + '&expDate=' + expDate + '&qty=' + jmlBarang + '&qtyR=' + rcvd + '&idpo=' + idpo + '&iditem=' + idItem;
            }else if(sc == 'Y' && exp == 'N'){
                for (var i = 0; i < dtce.rows()[0].length; i++) {
                    ar = ar.add(dtce.row(i).node())
                }

                data = ar.find('select,input,textarea').serialize() + '&idpo=' + idpo + '&iditem=' + idItem;
            }else{

                data =  'notaDO=' + notaDO + '&expDate=' + expDate + '&qty=' + jmlBarang + '&qtyR=' + rcvd + '&idpo=' + idpo + '&iditem=' + idItem;
            }


            axios.post(baseUrl+'/inventory/penerimaan/supplier/item-receive/add', data).then((response) => {

                if(response.data.status == 'sukses'){

                    $('#myModal').modal('hide');
                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Berhasil",
                        content : 'Transaksi Anda berhasil...!',
                        color : "#739E73",
                        timeout: 3000,
                        icon : "fa fa-check bounce animated"
                    });

                    var id = $('#id').val();
                    var item = $('#idItem').val();

                    $('#kode').val("");
                    $('#expCode').val("");
                    $('#jmlBarang').val("");

                    refresh_tab();

                }else if(response.data.status == 'ada'){

                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Peringatan!",
                        content : "Kode sudah ada!",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                    $('#kode').focus();
                    $("#error").removeClass("has-success");
                    $("#error").addClass("has-error");
                    $("#icon").removeClass("fa fa-barcode");
                    $("#icon").removeClass("fa fa-check");
                    $("#icon").addClass("glyphicon glyphicon-remove-circle");
                    $("#message").html("Kode tidak ditemukan");
                    $("#simpan").attr("disabled", true);

                }else{

                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. Terjadi kesalahan. Cobalah beberapa saat lagi ...",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });

                }

            })
			
		}

	</script>

@endsection
