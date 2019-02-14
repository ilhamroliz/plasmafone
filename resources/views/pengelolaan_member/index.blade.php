@extends('main')

@section('title', 'Pengelolaan Member')

@section('extra_style')
    <style type="text/css">
        .ui-autocomplete-input {
            z-index: 909 !important;
        }

        .checkbox.checkbox-single {

        label {
            width: 0;
            height: 16px;
            visibility: hidden;

                /*&
                :before {

                }

                &
                :after {
                    visibility: visible;
                }*/
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

            <li>Home</li><li>Penjualan</li><li>Pengelolaan Member</li>

        </ol>
        <!-- end breadcrumb -->

    </div>
    <!-- END RIBBON -->
@endsection


@section('main_content')

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">

            <!-- col -->
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-handshake-o"></i>
                    Penjualan <span><i class="fa fa-angle-double-right"></i> Pengelolaan Member </span>
                </h1>

            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="inbox-checkbox-triggered pull-right" style="padding-top: 15px;">
                    <div class="btn-group">
                        @if(Access::checkAkses(22, 'update'))
                        <a onclick="setKonversi()" rel="tooltip" title="" data-placement="bottom" data-original-title="Konversi" class="btn btn-default"><strong><i class="fa fa-exchange fa-lg text-warning"></i></strong></a>
                        <a onclick="pengaturan()" rel="tooltip" title="" data-placement="bottom" data-original-title="Pengaturan" class="btn btn-default"><strong><i class="fa fa-cogs fa-lg text-primary"></i></strong></a>
                        @endif
                        @if(Access::checkAkses(22, 'insert'))
                        <a onclick="addSaldo()" rel="tooltip" title="" data-placement="bottom" data-original-title="Tambah Saldo Poin" class="btn btn-default"><strong><i class="fa fa-cart-plus fa-lg text-success"></i></strong></a>
                        @endif
                    </div>
                </div>
            </div>
            <!-- end col -->

        </div>

        <!-- widget grid -->
        <section id="widget-grid" class="">
        <!-- row -->
            <!-- row -->
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Saldo Poin Member</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding form-horizontal">
                                <div class="tab-content padding-10">
                                    <table class="table table-hover table-striped table-bordered" id="poinmember">
                                        <thead>
                                        <tr>
                                            <th>Nama Member</th>
                                            <th>No Telp</th>
                                            <th>Saldo Poin</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <!-- row -->
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="jarviswidget jarviswidget-color-red" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Member yang berulang tahun</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding form-horizontal">
                                <div class="tab-content padding-10">
                                    <table class="table table-hover table-striped table-bordered" id="birthmember">
                                        <thead>
                                        <tr>
                                            <th>Nama Member</th>
                                            <th>Tgl Lahir</th>
                                            <th>Usia</th>
                                            <th>Ulangtahun</th>
                                            <th>No Telp</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <!-- row -->
            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="jarviswidget jarviswidget-color-blue" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>History Penukaran Saldo Poin</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding form-horizontal">
                                <div class="tab-content padding-10">
                                    <table class="table table-hover table-striped table-bordered" id="historymember">
                                        <thead>
                                        <tr>
                                            <th>Nama Member</th>
                                            <th>Tanggal</th>
                                            <th>Poin</th>
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
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

    <!-- Modal -->
    <div class="modal fade" id="modal-konversi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Konversi Saldo Poin ke Uang</h4>
                </div>
                <div class="modal-body">
                    <form id="form-konversi" class="smart-form" novalidate="novalidate">
                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-credit-card-alt"></i>
                                        <input type="text" id="saldo" name="saldo" placeholder="Saldo Poin">
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="input"> <i class="icon-prepend fa fa-money"></i>
                                        <input type="text" style="text-align: right" id="uang" name="uang" placeholder="Uang">
                                    </label>
                                </section>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="updateKonversi()">
                        Simpan
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal-tambahsaldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Saldo Member</h4>
                </div>
                <div class="modal-body no-padding">
                    <form id="form-belipoin" class="smart-form no-padding" novalidate="novalidate">
                        <fieldset class="">
                            <div class="row">
                                <section class="col col-12" style="width: 100%">
                                    <label class="label">Nama Member</label>
                                    <label class="input">
                                        <input type="text" id="namamember" name="nama_member" placeholder="Nama Member">
                                        <input type="hidden" id="id_member" name="id_member">
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="label">Saldo Poin Saat ini</label>
                                    <label class="input"> <i class="icon-prepend fa fa-credit-card"></i>
                                        <input type="text" id="saldo_now" name="saldo_now" placeholder="Jumlah Saldo" readonly>
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="label">Jumlah Penambahan</label>
                                    <label class="input"> <i class="icon-prepend fa fa-cart-plus"></i>
                                        <input type="text" id="jmlsaldo" name="jml_saldo" placeholder="Jumlah Saldo">
                                    </label>
                                </section>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="simpanPembelianPoin()">
                        Simpan
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal-pengaturan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Pengaturan Transaksi Saldo Poin</h4>
                </div>
                <div class="modal-body">
                    <form id="form-pengaturan" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <table class="table table-bordered table-striped table-striped table-hover" style="overflow: auto;" id="table-fitur">
                                    <thead>
                                    <tr>
                                        <th>Fitur</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr onclick="check(16, this)" style="cursor:pointer;">
                                        <td>Penjualan Reguler</td>
                                        <td>
                                            <div class="text-center">
                                                <div class="checkbox checkbox-primary no-padding checkbox-single checkbox-inline">
                                                    <input id="fitur-16" checked type="checkbox" class="checkfitur pilih" value="16" name="fitur" aria-label="Single radio One">
                                                    <label></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr onclick="check(17, this)" style="cursor:pointer;">
                                        <td>Penjualan Tempo</td>
                                        <td>
                                            <div class="text-center">
                                                <div
                                                    class="checkbox checkbox-primary no-padding checkbox-single checkbox-inline">
                                                    <input id="fitur-17" type="checkbox" class="checkfitur pilih" value="17" name="fitur" aria-label="Single radio One">
                                                    <label></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr onclick="check(19, this)" style="cursor:pointer;">
                                        <td>Penjualan Online</td>
                                        <td>
                                            <div class="text-center">
                                                <div
                                                    class="checkbox checkbox-primary no-padding checkbox-single checkbox-inline">
                                                    <input id="fitur-19" type="checkbox" class="checkfitur pilih" value="19" name="fitur" aria-label="Single radio One">
                                                    <label></label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div id="form-setting">
                                    <div class="form-group padding-10" style="display: block;">
                                        <label>Minimal Transaksi</label>
                                        <input class="form-control mintrans" name="mintrans" placeholder="Minimal Transaksi" type="text">
                                    </div>
                                    <div class="form-group padding-10 padding-top-0">
                                        <label>Poin yang didapat</label>
                                        <input class="form-control getpoin" name="getpoin" placeholder="Poin yang didapat" type="text">
                                    </div>
                                </div>
                                <div class="text-center" id="loading" style="display: none;">
                                    <div class="card-box" style="padding-top: 50px;">
                                        <div class="sk-circle">
                                            <div class="sk-circle1 sk-child"></div>
                                            <div class="sk-circle2 sk-child"></div>
                                            <div class="sk-circle3 sk-child"></div>
                                            <div class="sk-circle4 sk-child"></div>
                                            <div class="sk-circle5 sk-child"></div>
                                            <div class="sk-circle6 sk-child"></div>
                                            <div class="sk-circle7 sk-child"></div>
                                            <div class="sk-circle8 sk-child"></div>
                                            <div class="sk-circle9 sk-child"></div>
                                            <div class="sk-circle10 sk-child"></div>
                                            <div class="sk-circle11 sk-child"></div>
                                            <div class="sk-circle12 sk-child"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="simpanSetting()">
                        Simpan
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@section('extra_script')

    <script type="text/javascript">
        var poinmember = null;
        var birthmember = null;
        var historymember = null;
        $(document).ready(function () {
            $('#saldo').maskMoney({
                thousands:'.',
                decimal:',',
                allowZero:false,
                suffix: ' Poin'
            });

            $('#jmlsaldo').maskMoney({
                thousands:'.',
                decimal:',',
                allowZero:false,
                suffix: ' Poin'
            });

            $('#saldo_now').maskMoney({
                thousands:'.',
                decimal:',',
                allowZero:false,
                suffix: ' Poin'
            });

            $('.getpoin').maskMoney({
                thousands:'.',
                decimal:',',
                allowZero:false,
                suffix: ' Poin'
            });

            $('#uang').maskMoney({
                thousands:'.',
                decimal:',',
                allowZero:false,
                prefix: 'Rp. '
            });

            $('.mintrans').maskMoney({
                thousands:'.',
                decimal:',',
                allowZero:false,
                prefix: 'Rp. '
            });

            $( "#namamember" ).autocomplete({
                source: baseUrl+'/penjualan-reguler/cari-member',
                minLength: 1,
                select: function(event, data) {
                    setSaldo(data.item.id);
                }
            });

            setTimeout(function () {
                poinmember = $('#poinmember').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('pengelolaan-member/get-member-poin') }}",
                        "type": "get"
                    },
                    "columns":[
                        {"data": "m_name"},
                        {"data": "m_telp"},
                        {"data": "s_saldo"}
                    ],
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#poinmember'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
            }, 500);

            setTimeout(function () {
                birthmember = $('#birthmember').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('pengelolaan-member/get-member-birth') }}",
                        "type": "get"
                    },
                    "columns":[
                        {"data": "m_name"},
                        {"data": "lahir"},
                        {"data": "usia"},
                        {"data": "sisa"},
                        {"data": "m_telp"},
                    ],
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#birthmember'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
            }, 750);

            setTimeout(function () {
                historymember = $('#historymember').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ url('pengelolaan-member/get-member-history') }}",
                        "type": "get"
                    },
                    "columns":[
                        {"data": "m_name"},
                        {"data": "birth"},
                        {"data": "sc_poin"},
                        {"data": "sc_item"},
                        {"data": "sc_qty"},
                        {"data": "aksi"}
                    ],
                    "autoWidth" : true,
                    "language" : dataTableLanguage,
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                        "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                    "preDrawCallback" : function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_dt_basic) {
                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#historymember'), breakpointDefinition);
                        }
                    },
                    "rowCallback" : function(nRow) {
                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                    },
                    "drawCallback" : function(oSettings) {
                        responsiveHelper_dt_basic.respond();
                    }
                });
            }, 1000);

            $('#table-fitur').dataTable({
                "autoWidth" : true,
                "paging"	: false,
                "info"	: false,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-12'f>r>"+"t"+
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#table-fitur'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
        })

        function setKonversi() {
            axios.get(baseUrl+'/pengelolaan-member/get-konversi').then((response) => {
                var saldo = response.data.sc_saldo;
                var uang = response.data.sc_money;
                saldo = parseInt(saldo);
                uang = parseInt(uang);
                $('#uang').maskMoney('mask', uang);
                $('#saldo').maskMoney('mask', saldo);
                $('#modal-konversi').modal('show');
            })
        }

        function updateKonversi() {
            axios.get(baseUrl+'/pengelolaan-member/update-konversi?'+$("#form-konversi").serialize()).then((response) => {
                if (response.data.status == 'sukses'){
                    $.smallBox({
                        title: "Berhasil",
                        content: 'Data Konversi Sudah Tersimpan...!',
                        color: "#739E73",
                        timeout: 3000,
                        icon: "fa fa-check bounce animated"
                    });
                    $('#modal-konversi').modal('hide');
                }
            })
        }

        function addSaldo() {
            $('#modal-tambahsaldo').modal('show');
        }

        function setSaldo(id) {
            axios.get(baseUrl+'/pengelolaan-member/get-saldo-poin', {
                params: {
                    id: id
                }
            }).then((response) => {
                var data = response.data;
                var saldo = parseInt(data.s_saldo);
                $('#saldo_now').maskMoney('mask', saldo);
                $('#id_member').val(id);
            })
        }

        function simpanPembelianPoin() {
            axios.get(baseUrl+'/pengelolaan-member/simpan-saldo-poin?'+$('#form-belipoin').serialize()).then((response) => {
                if (response.data.status == 'sukses'){
                    $.smallBox({
                        title: "Berhasil",
                        content: 'Penambahan saldo berhasil...',
                        color: "#739E73",
                        timeout: 3000,
                        icon: "fa fa-check bounce animated"
                    });
                } else {
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. Simpan gagal, hubungi admin...",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                }
                $('#namamember').val('');
                $('#id_member').val("");
                $('#saldo_now').val("");
                $('#jmlsaldo').val("");
                $('#modal-tambahsaldo').modal('hide');
            })
        }

        function pengaturan() {
            $('#modal-pengaturan').modal('show');
            $(".checkfitur").prop("checked", false);
            document.getElementById("fitur-16").checked = true;
            getDataSetting(16);
        }

        function getDataSetting(id) {
            $('#form-setting').hide();
            $('#loading').show();
            axios.get(baseUrl+'/pengelolaan-member/get-data-setting/'+id).then((response) => {
                var poin = parseInt(response.data.ss_poin);
                var mintrans = parseInt(response.data.ss_mintransaction);
                $('.mintrans').maskMoney('mask', mintrans);
                $('.getpoin').maskMoney('mask', poin);
                $('#form-setting').show();
                $('#loading').hide();
            })
        }

        function check(id, field) {
            $(".checkfitur").prop("checked", false);
            document.getElementById("fitur-" + id).checked = true;
            getDataSetting(id);
        }
        
        function simpanSetting() {
            axios.get(baseUrl+'/pengelolaan-member/update-setting?'+$("#form-pengaturan").serialize()).then((response) => {
                if (response.data.status == 'sukses'){
                    $.smallBox({
                        title: "Berhasil",
                        content: 'Data setting berhasil diubah...',
                        color: "#739E73",
                        timeout: 3000,
                        icon: "fa fa-check bounce animated"
                    });
                    $('#modal-pengaturan').modal('hide');
                } else {
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. data setting gagal diubah, hubungi admin...",
                        color : "#A90329",
                        timeout: 3000,
                        icon : "fa fa-times bounce animated"
                    });
                }
            })
        }
    </script>

@endsection
