@extends('main')

@section('title', 'Konfirmasi Pembelian')

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
                                                    <th class="text-center" width="30%">No. Confirm</th>
                                                    <th class="text-center" width="45%">Nama Supplier</th>
                                                    <th class="text-center" width="15%">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="hr2">

                                        <div class="row form-group">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="col-md-4">
        
                                                    <div>
                                                        <div class="input-group input-daterange" id="date-range">
                                                            <input type="text" class="form-control" id="tgl_awal" name="tgl_awal"  placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
                                                            <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                            <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir"  placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
                                                        </div>
                                                    </div>
        
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" id="nota" class="form-control" name="nota" placeholder="Masukkan No.Nota" style="width: 100%; float: left">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="hidden" name="idSupp" id="idSupp">
                                                        <input type="text" id="namaSupp" class="form-control" name="namaSupp" placeholder="Masukkan Nama Supplier" style="width: 80%; float: left">
        
                                                        <button type="button" class="btn btn-primary btn-sm icon-btn ml-2" onclick="cariHistory()" style="width: 10%; margin-left: 5%">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="dt_history" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center" width="10%">No.</th>
                                                <th class="text-center" width="30%">No. Confirm</th>
                                                <th class="text-center" width="40%">Nama Supplier</th>
                                                <th class="text-center" width="20%">Status</th>
                                            </tr>
                                            </thead>

                                            <tbody id="historyBody">
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
                                                                <th width="70%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
                                                                <th width="20%"><i class="fa fa-fw fa-cart-arrow-down txt-color-blue"></i>&nbsp;Jumlah Unit</th>
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

								<div class="row" id="divSimpan">
									<div class="col-md-12 text-align-right" style="margin-right: 20px;">
										<button class="btn btn-primary" onclick="simpanEdit()"><i class="fa fa-floppy-o"></i>&nbsp;Simpan</button>
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

            $( "#date-range" ).datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true,
                todayHighlight: true
            });
            
            $('#dt_history').DataTable({
                "language": dataTableLanguage
            });

            $('#dt_detail').DataTable({
                "language": dataTableLanguage,
                "pageLength": 5,
                "lengthChange": false,
                "searching": false,
                "autoWidth": false
            });

            $( "#nota" ).autocomplete({
				source: baseUrl+'/pembelian/konfirmasi-pembelian/auto-nota',
				minLength: 1,
				select: function(event, data) {
					$('#nota').val(data.item.label);
				}
			});

			$( "#namaSupp" ).autocomplete({
				source: baseUrl+'/pembelian/konfirmasi-pembelian/auto-supp',
				minLength: 1,
				select: function(event, data) {
					$('#idSupp').val(data.item.id);
					$('#namaSupp').val(data.item.label);
				}
			});

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
                    {"data": "s_company"},
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
            }, 500);


        })


        function detil(id){

            axios.get(baseUrl+'/pembelian/konfirmasi-pembelian/edit?id='+id).then((response) => {

                $('#title_detail').html('Konfirmasi Pembelian '+response.data.data.pc_nota);

                $('#dmNoNota').text(response.data.data.pc_nota);
                $('#dmNamaSupp').text(response.data.data.s_company);
                $('#dmAddrSupp').text(response.data.data.s_address);
                $('#dmTelpSupp').text(response.data.data.s_phone);

                $('#dt_detail').DataTable().clear();

                for(var i = 0; i < response.data.dataDT.length; i++){

                    $('#dt_detail').DataTable().row.add([
                        i+1,
                        response.data.dataDT[i].i_nama,
                        '<div><input type="text" name="qtyDT[]" class="form-control text-align-right qtyDT" value="'+response.data.dataDT[i].pcd_qty+'" readonly></div>'
                    ]).draw();
                }

                $('#divSimpan').css('display', 'none');
                $('#detilModal').modal('show');
            });

        }

        function edit(id){

            axios.get(baseUrl+'/pembelian/konfirmasi-pembelian/edit?id='+id).then((response) => {

                $('#title_detail').html('Konfirmasi Pembelian '+response.data.data.pc_nota)

                $('#dmId').val(response.data.id);
                $('#dmNoNota').text(response.data.data.pc_nota);
                $('#dmNamaSupp').text(response.data.data.s_company);
                $('#dmAddrSupp').text(response.data.data.s_address);
                $('#dmTelpSupp').text(response.data.data.s_phone);

                $('#dt_detail').DataTable().clear();

                for(var i = 0; i < response.data.dataDT.length; i++){

                    $('#dt_detail').DataTable().row.add([
                        i+1,
                        response.data.dataDT[i].i_nama,
                        '<div><input type="text" name="qtyDT[]" class="form-control text-align-right qtyDT" value="'+response.data.dataDT[i].pcd_qty+'"></div>'
                    ]).draw();
                    $('.qtyDT').maskMoney();
                }

                $('#divSimpan').css('display', 'block');
                $('#detilModal').modal('show');
            });

        }

        function simpanEdit(){
            $('#overlay').fadeIn(200);
            $('#load-status-text').text('Sedang Menyimpan Data...');
            
            var ar = $();
            for (var i = 0; i < $('#dt_detail').DataTable().rows()[0].length; i++) {
                ar = ar.add($('#dt_detail').DataTable().row(i).node())
            }

            var id = $('#dmId').val();
            var data = ar.find('input').serialize() + '&id='+ id;

            axios.post(baseUrl+'/pembelian/konfirmasi-pembelian/edit', data).then((response) => {

                if(response.data.status == 'ecSukses'){
                    $('#detilModal').modal('hide');
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Data Konfirmasi Pembelian Berhasil Diubah...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
                    });
                    location.reload();
                }else{
                    $('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Maaf, Data Konfirmasi Pembelian Gagal Diubah ",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});
                }

            });

        }

        function cariHistory(){

			var tglAwal = $('#tgl_awal').val();
			var tglAkhir = $('#tgl_akhir').val();
			var nota = $('#nota').val();
			var idSupp = $('#idSupp').val();

			if($('#namaSupp').val() == ''){
				idSupp = null;
			}

			axios.post(baseUrl+'/pembelian/konfirmasi-pembelian/getHistory', {tglAwal: tglAwal, tglAkhir: tglAkhir, nota: nota, idSupp: idSupp}).then((response) => {

				$('#historyBody').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

				$('#dt_history').DataTable().clear();
				for(var i = 0; i < response.data.data.length; i++){
                    $status = '';
                    if(response.data.data[i].pc_status == "Y"){
                        $status = '<span class="label label-success">PURCHASING</span>';
                    }else if(response.data.data[i].pc_status == "N"){
                        $status = '<span class="label label-danger">DITOLAK</span>';
                    }else{
                        $status = '<span class="label label-warning">MENUNGGU</span>';
                    }
                    $('#dt_history').DataTable().row.add([
                        i + 1,
                        response.data.data[i].pc_nota,
                        response.data.data[i].s_company,
                        $status
                    ]).draw();
				}

			});

		}

        function hapus(id){

        }

    </script>

@endsection
