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
            <li>Request Order</li>
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
						 Request Order
					</span>
                </h1>
            </div>
            @if(Access::checkAkses(49, 'insert') == true)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                    <div class="page-title">

                        <a href="{{ url('/pembelian/request-pembelian/tambah') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah
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
                                    <a data-toggle="tab" href="#hr1">
                                        <i style="color: #739E73;" class="fa fa-lg fa-rotate-right fa-spin"></i>
                                        <span class="hidden-mobile hidden-tablet"> Menunggu </span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr2">
                                        <i style="color: #C79121;" class="fa fa-lg fa-check"></i>
                                        <span class="hidden-mobile hidden-tablet"> DiProses </span>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr3">
                                        <i style="color: #b5201d;" class="fa fa-lg fa-ban"></i>
                                        <span class="hidden-mobile hidden-tablet"> DiTolak </span>
                                    </a>
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
                                        <table id="waitingReq_table" class="table table-sm table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center" data-hide="phone,tablet" width="25%">Tanggal Request</th>
                                                <th class="text-center" data-hide="phone,tablet" width="45%">Nama Barang</th>
                                                <th class="text-center" data-hide="phone,tablet" width="5%">Qty</th>
                                                <th class="text-center" data-hide="phone,tablet" width="10%">Status</th>
                                                <th class="text-center" data-hide="phone,tablet" width="15%">Aksi</th>
                                            </tr>
                                            </thead>

                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="hr2">
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-left" style="margin-top:1%;margin-bottom:1%">
                                            <div class="col-md-4 pull-left" style="padding-left: 0;">
    											<div class="input-group input-daterange" id="date-range" style="">
    												<input type="text" class="form-control" id="tgl_awal" name="tgl_awal" value="" placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
    												<span class="input-group-addon bg-custom text-white b-0">Sampai</span>
    												<input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir" value="" placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">

                                                </div>
    										</div>
                                            <div class="col-md-7 pull-left">
    											<div class="form-group">
    												<button type="button" class="btn btn-primary btn-sm icon-btn ml-2" onclick="search()" >
    													<i class="fa fa-search"></i>
    												</button>
    											</div>
    										</div>
                                        </div>
                                        <table id="dt_proses" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                                <tr>

                                                    <th data-hide="phone,tablet" width="1%">No</th>
                                                    <th >Nama Outlet</th>
                                                    <th data-hide="phone,tablet" width="35%">Nama Barang</th>
                                                    <th data-hide="phone,tablet" >Qty</th>
                                                    <th data-hide="phone,tablet" width="15%">Status</th>

                                                </tr>
                                            </thead>

                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="hr3">
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-left" style="margin-top:1%;margin-bottom:1%">
                                            <div class="col-md-4 pull-left" style="padding-left: 0;">
                                                <div class="input-group input-daterange" id="date_range_tolak" style="">
                                                    <input type="text" class="form-control" id="tgl_awal_tolak" name="tgl_awal_tolak" value="" placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
                                                    <span class="input-group-addon bg-custom text-white b-0">Sampai</span>
                                                    <input type="text" class="form-control" id="tgl_akhir_tolak" name="tgl_akhir_tolak" value="" placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">

                                                </div>
                                            </div>
                                            <div class="col-md-7 pull-left">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary btn-sm icon-btn ml-2" onclick="search()" >
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <table id="dt_tolak" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                                <tr>
                                                    <th data-hide="phone,tablet" width="5%">Tanggal</th>
                                                    <th data-hide="phone,tablet" width="25%">Nama Outlet</th>
                                                    <th data-hide="phone,tablet" width="35%">Nama Barang</th>
                                                    <th data-hide="phone,tablet" width="5%">Qty</th>
                                                    <th data-hide="phone,tablet" width="15%">Aksi</th>

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

    </div>
    <!-- END MAIN CONTENT -->

    <!-- Modal Edit Qty -->
    <div class="modal fade" id="editQty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Request Order</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="hidden" id="ro_id">
                                <label for="i_nama">Nama Barang</label>
                                <input type="text" class="form-control" id="i_nama" readonly />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ro_qty">Kuantitas</label>
                                <input type="number" min="0" class="form-control" id="ro_qty"/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="update()">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Update
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Qty Ditolak -->
    <div class="modal fade" id="editQtyTolak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Request Order</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="hidden" id="jenis">
                                <input type="hidden" id="ro_id1">
                                <label for="i_nama">Nama Barang</label>
                                <input type="text" class="form-control" id="i_nama1" readonly />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ro_qty">Kuantitas</label>
                                <input type="number" min="0" class="form-control" id="ro_qty1"/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="updateTolak()">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Update
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_script')

    <!-- PAGE RELATED PLUGIN(S) -->
	<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>


	<script type="text/javascript">
		var menunggu, diproses, semua, inaktif, table_proses, table_tolak;

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyiapkan...');

		var baseUrl = '{{ url('/') }}';


        $(document).ready(function(){

            var tanggal  = new Date().getDate();
            var bulan    = new Date().getMonth();
            var tahun    = new Date().getFullYear();
            var arrbulan = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            $('#tgl_awal').val(tanggal+"/"+arrbulan[bulan]+"/"+tahun);
            $('#tgl_akhir').val(tanggal+"/"+arrbulan[bulan]+"/"+tahun);

            // Date Range Tolak
            $('#tgl_awal_tolak').val(tanggal+"/"+arrbulan[bulan]+"/"+tahun);
            $('#tgl_akhir_tolak').val(tanggal+"/"+arrbulan[bulan]+"/"+tahun);

            $( "#tgl_awal" ).datepicker({
    			language: "id",
    			format: 'dd/mm/yyyy',
    			prevText: '<i class="fa fa-chevron-left"></i>',
    			nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true
    		});

    		$( "#tgl_akhir" ).datepicker({
    			language: "id",
    			format: 'dd/mm/yyyy',
    			prevText: '<i class="fa fa-chevron-left"></i>',
    			nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true
    		});

            $('#date-range').datepicker({
                todayHighlight: true
            });

            // Date Range Tolak
            $( "#tgl_awal_tolak" ).datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true
            });

            $( "#tgl_akhir_tolak" ).datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true
            });

            $( "#date_range_tolak" ).datepicker({
                todayHighlight: true
            });

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

                menunggu = $('#waitingReq_table').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/pembelian/request-pembelian/t') }}",
                  /*  "fnCreatedRow": function (row, data, index) {
                        $('td', row).eq(0).html(index + 1);
                        },*/
                    "columns":[
                        {"data": "ro_date"},
                        {"data": "i_nama"},
                        {"data": "ro_qty"},
                        {"data": "ro_state"},
                        {"data": "aksi"}
                    ],
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#waitingReq_table'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
               overlay();
            }, 500);

            tampil_diproses();
            tampil_ditolak();
        });
		/* END BASIC */

		function refresh_tab(){
		    menunggu.api().ajax.reload();
		    diproses.api().ajax.reload();
		    semua.api().ajax.reload();
		}

        function tampil_diproses(){
            table_proses= $('#dt_proses').DataTable({
                "ajax": {
                    "url": '{{url('/pembelian/request-pembelian/proses')}}',
                    "type": 'post',
                    "data": function ( data ) {
                        data.tgl_akhir = $('#tgl_akhir').val();
                        data.tgl_awal  = $('#tgl_awal').val();
                        data._token    = '{{ csrf_token() }}';
                    },
                }
            });
        };

        function tampil_ditolak(){
            table_tolak= $('#dt_tolak').DataTable({
                "ajax": {
                    "url": '{{url('/pembelian/request-pembelian/tolak')}}',
                    "type": 'post',
                    "data": function ( data ) {
                        data.tgl_akhir_tolak = $('#tgl_akhir_tolak').val();
                        data.tgl_awal_tolak  = $('#tgl_awal_tolak').val();
                        data._token    = '{{ csrf_token() }}';
                    },
                }
            });
        }

        function search(){
            table_proses.ajax.reload(null, false);
            table_tolak.ajax.reload(null, false);
        }


		function hapus(val){

			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan manghapus data member ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menghapus...');

					axios.get(baseUrl+'/master/member/delete/'+val).then((response) => {

						if(response.data.status == 'hapusberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data member berhasil dihapus...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda hapus sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal menghapus data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});
						}

					}).catch((err) => {
						out();
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal menghapus data...! Coba lagi dengan mulai ulang halaman",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});

					}).then(function(){
						$('#overlay').fadeOut(200);
					});
				}

			});

		}

		function edit(ro_id,i_nama,ro_qty){

			$('#editQty').modal('show');
            $('#ro_id').val(ro_id);
            $('#i_nama').val(i_nama);
            $('#ro_qty').val(ro_qty);

		}

        function editQtyTolak(i_nama,id,qty){

            $('#i_nama1').val(i_nama);
            $('#ro_id1').val(id);
            $('#ro_qty1').val(qty);
            $('#editQtyTolak').modal('show');

        }

        function update(){

            overlay();
            var id = $('#ro_id').val();
            var qty = $('#ro_qty').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/pembelian/request-pembelian/updateReq',
                type: 'get',
                data: {id: id, qty: qty},
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status =='sukses'){
                        $.smallBox({
                            title  : "Berhasil",
                            content: 'Data telah diupdate...!',
                            color  : "#739E73",
                            timeout: 4000,
                            icon   : "fa fa-check bounce animated"
                        });
                        $('#waitingReq_table').DataTable().ajax.reload();
                    } else {
                        $.smallBox({
                            title  : "GAGAL",
                            content: 'Data telah GAGAL diupdate...!',
                            color  : "#739E73",
                            timeout: 4000,
                            icon   : "fa fa-check bounce animated"
                        });
                        $('#waitingReq_table').DataTable().ajax.reload();
                    }

                    out();
                    $('#editQty').modal('hide');
                },
            })
        }

        function updateTolak(){

            overlay();
            var id = $('#ro_id1').val();
            var qty = $('#ro_qty1').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/pembelian/request-pembelian/updateReqTolak',
                type: 'get',
                data: {id: id, qty: qty},
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status =='sukses'){
                        $.smallBox({
                            title  : "Berhasil",
                            content: 'Data telah diupdate...!',
                            color  : "#739E73",
                            timeout: 4000,
                            icon   : "fa fa-check bounce animated"
                        });
                        $('#dt_tolak').DataTable().ajax.reload();
                        $('#waitingReq_table').DataTable().ajax.reload();
                    } else {
                        $.smallBox({
                            title  : "GAGAL",
                            content: 'Data telah GAGAL diupdate...!',
                            color  : "#739E73",
                            timeout: 4000,
                            icon   : "fa fa-check bounce animated"
                        });
                        $('#dt_tolak').DataTable().ajax.reload();
                        $('#waitingReq_table').DataTable().ajax.reload();
                    }

                    out();
                    $('#editQtyTolak').modal('hide');
                },
            })
        }

        function hapusReq(id)
        {
            $.SmartMessageBox({
                title   : "Konfirmasi...!",
                content : "Apakah Anda Yakin Ingin Menghapus Data Ini ?",
                buttons : '[Tidak][Ya]'
            },
            function(ButtonPressed) {
                if (ButtonPressed === "Ya") {
                    $.ajax({
                        url : '{{url('/pembelian/request-pembelian/hapusReq')}}',
                        type: "GET",
                        data: { id : id },

                        dataType: "JSON",
                        success: function(data)
                        {
                            if(data.status == "sukses"){
                                $.smallBox({
                                    title   : "Berhasil",
                                    content : 'Data telah Di hapus...!',
                                    color   : "#739E73",
                                    timeout : 4000,
                                    icon    : "fa fa-check bounce animated"
                                });
                                $('#waitingReq_table').DataTable().ajax.reload();
                            }else{
                                $.smallBox({
                                    title   : "Berhasil",
                                    content : 'Data gagal Di hapus...!',
                                    color   : "#739E73",
                                    timeout : 4000,
                                    icon    : "fa fa-check bounce animated"
                                });
                                $('#waitingReq_table').DataTable().ajax.reload();
                            }

                            out();

                        }
                    });
                }
                if (ButtonPressed === "Tidak") {
                    $.smallBox({
                        title    : "Peringatan...!!!",
                        content  : "<i class='fa fa-clock-o'></i> <i>Anda Tidak Melakukan Penghapusan</i>",
                        color    : "#C46A69",
                        iconSmall: "fa fa-times fa-2x fadeInRight animated",
                        timeout  : 4000
                    });
                }
            });
            e.preventDefault();
        }

		function detail(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil data...');

			var status;

			axios.get(baseUrl+'/master/member/detail/'+id).then(response => {

				if (response.data.status == 'ditolak') {

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
						color : "#A90329",
						timeout: 5000,
						icon : "fa fa-times bounce animated"
					});

				} else {

					$('#title_detail').html('<strong>Detail Member "'+response.data.data.m_name+'"</strong>');
					$('#dt_nik').text(response.data.data.m_nik);
					$('#dt_name').text(response.data.data.m_name);
					$('#dt_phone').text(response.data.data.m_telp);
					$('#dt_address').text(response.data.data.m_address);

					if(response.data.data.m_status == "AKTIF"){

						status = "AKTIF";

					}else{

						status = "NON AKTIF";

					}

					$('#dt_isactive').text(status);
					$('#dt_created').text(response.data.data.m_insert);
					$('#overlay').fadeOut(200);
					$('#myModal').modal('show');

				}

			});
		}

		function statusactive(id){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan mengaktifkan data member ini ? ',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/member/active/'+id).then((response) => {

						if (response.data.status == 'ditolak') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'aktifberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data member <i>"'+response.data.name+'"</i> berhasil diaktifkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda aktifkan sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							// console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal mengaktifkan data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});
						}
					}).catch((err) => {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal mengaktifkan data...! Coba lagi dengan mulai ulang halaman",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});

					}).then(function(){
						$('#overlay').fadeOut(200);
					})

				}

			});
		}

		function statusnonactive(id){
			$.SmartMessageBox({
				title   : "Pesan!",
				content : 'Apakah Anda yakin akan menonaktifkan data member ini ? ',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/member/nonactive/'+id).then((response) => {

						if (response.data.status == 'ditolak') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'nonaktifberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data member <i>"'+response.data.name+'"</i> berhasil dinonaktifkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda nonaktifkan sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal menonaktifkan data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}

					}).catch((err) => {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal menonaktifkan data...! Coba lagi dengan mulai ulang halaman",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});

					}).then(function(){
						$('#overlay').fadeOut(200);
					})

				}

			});
		}

        $(document).ready(function () {
            $('#date-range-p').datepicker({
                autoclose: true,
                todayHighlight: true
            });
        })

	</script>

@endsection
