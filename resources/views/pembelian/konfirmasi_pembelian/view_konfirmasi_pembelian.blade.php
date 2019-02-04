@extends('main')

@section('title', 'Request Order')

@section('extra_style')

@endsection

@section('ribbon')
    <!-- RIBBON -->
    <div id="ribbon">

	<span class="ribbon-button-alignment">
		<span id="refresh" class="btn btn-ribbon" data-title="refresh" rel="tooltip" data-placement="bottom"
              data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.."
              data-html="true" onclick="location.reload()">
			<i class="fa fa-refresh"></i>
		</span>
	</span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Pembelian</li>
            <li>konfirm Pembelian</li>
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
                    <i class="fa-fw fa fa-credit-card"></i>
                    Pembelian
                    <span>
						<i class="fa fa-angle-double-right"></i>
						 Konfirmasi Pembelian
					</span>
                </h1>
            </div>
            @if(Access::checkAkses(2, 'insert') == true)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                    <div class="page-title">

                        <a href="{{ url('/pembelian/konfirmasi-pembelian/view_addKonfirmasi') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah
                            Data</a>

                    </div>

                </div>
            @endif
        </div>

        <!-- widget grid -->
        <section id="widget-grid" class="">

            <?php $mt = '20px'; ?>

            @if(Session::has('flash_message_success'))
                <?php $mt = '0px'; ?>
                <div class="col-md-12">
                    <div class="alert alert-success alert-block">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil
                        </h4>
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
                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false"
                         data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <ul id="widget-tab-1" class="nav nav-tabs pull-left">
                                <li class="active">
                                    <a data-toggle="tab" href="#hr1"> <i style="color: #739E73;"
                                                                         class="fa fa-lg fa-rotate-right fa-spin"></i> <span
                                            class="hidden-mobile hidden-tablet">Menunggu </span> </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #C79121;"
                                                                         class="fa fa-lg fa-history"></i> <span
                                            class="hidden-mobile hidden-tablet">History</span></a>
                                </li>


                            </ul>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <!-- widget body text-->
                                <div class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="hr1">
                                        <table id="dt_co" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="10%">No.</th>
                                                    <th class="text-center" width="75%">No. Confirm</th>
                                                    <th class="text-center" width="15%">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="hr2">
                                        <table id="dt_pr" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center" width="5%">No.</th>
                                                <th class="text-center" width="15%">No. Confirm</th>
                                                <th class="text-center" width="15%">Status</th>
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

            <!-- Modal untuk Detil & Edit Konfirmasi Pembelian -->
			<div class="modal fade" id="detilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								&times;
							</button>

							<h4 class="modal-title" id="myModalLabel">Detail Konfirmasi Pembelian</h4>

						</div>

						<div class="modal-body">			
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

												<div class="col-md-12 padding-top-10 ">
													<input type="hidden" id="dmId">
													<div class="form-group">
														<label class="col-md-3" style="float:left"><strong>No. Nota</strong></label>
														<label class="col-md-1">:</label>
														<label class="col-md-8" id="dmNoNota"></label>
													</div>

													<div class="form-group">
														<label class="col-md-3" style="float:left"><strong>Nama Supplier</strong></label>
														<label class="col-md-1">:</label>
														<div class="col-md-8">
															<label id="dmNamaSupp"></label>
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-3" style="float:left"><strong>Alamat Supplier</strong></label>
														<label class="col-md-1">:</label>
														<label class="col-md-8" id="dmAddrSupp"></label>
													</div>

													<div class="form-group">
														<label class="col-md-3" style="float:left"><strong>Telp Supplier</strong></label>
														<label class="col-md-1">:</label>
														<label class="col-md-8" id="dmTelpSupp"></label>
                                                    </div>                                                
												</div>

                                                <div>
                                                    <table id="dt_detail" class="table table-striped table-bordered table-hover">
                                                        <thead>		
                                                            <tr>
                                                                <th width="10%">&nbsp;No.</th>
                                                                <th width="60%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
                                                                <th width="30%"><i class="fa fa-fw fa-cart-arrow-down txt-color-blue"></i>&nbsp;Jumlah Unit</th>
                                                            </tr>
                                                        </thead>
    
                                                        <tbody>
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

								<div class="row">
									<div class="col-md-12 text-align-right" style="margin-right: 20px;">
										<button class="btn btn-primary" onclick="simpanStatus()"><i class="fa fa-floppy-o"></i>&nbsp;Simpan</button>
									</div>
								</div>
							</div>			
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

    <script type="text/javascript">
        var co, pr, semua;

        $('#overlay').fadeIn(200);
        $('#load-status-text').text('Sedang Menyiapkan...');

        var baseUrl = '{{ url('/') }}';


        $(document).ready(function(){

            $('#overlay').fadeIn(200);
            $('#load-status-text').text('Sedang Menyiapkan...');

            // $('#tabs').tabs();

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

            setTimeout(function () {

            co = $('#dt_co').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/pembelian/konfirmasi-pembelian/view_confirmApp') }}",
                "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                    },
                "columns":[
                    {"data": "pc_id"},
                    {"data": "pc_nota"},
                    {"data": "aksi"}
                ],
                "autoWidth" : false,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_co'), breakpointDefinition);
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


            setTimeout(function () {

            pr = $('#dt_pr').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/pembelian/konfirmasi-pembelian/view_confirmPurchase') }}",
                "fnCreatedRow": function (row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                    },
                "columns":[
                    {"data": "pc_id"},
                    {"data": "pc_nota"},
                    {"data": "pc_status"}
                ],
                "autoWidth" : false,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_pr'), breakpointDefinition);
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


        })


        function detil(id){

        }

        function edit(id){

            axios.get(baseUrl+'/pembelian/konfirmasi-pembelian/editConfirm?id='+id).then((response) => {

                $('#dmNoNota').val(response.data.data.pc_nota);
                $('#dmNamaSupp').val(response.data.data.s_company);
                $('#dmAddrSupp').val(response.data.data.s_address);
                $('#dmTelpSupp').val(response.data.data.s_phone);

                for(var i = 0; i < response.data.dataDT.length; i++){

                    

                }

            });

            $('#detilModal').modal('show');
        }

        function hapus(id){

        }

    </script>

@endsection
