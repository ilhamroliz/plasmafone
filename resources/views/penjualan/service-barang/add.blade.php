@extends('main')

@section('title', 'Service Barang')

@section('extra_style')
    <style type="text/css">

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
            <li>Home</li><li>Penjualan</li><li>Service Barang</li>
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
                    <i class="fa-fw fa fa-wrench"></i>
                    Penjualan <span><i class="fa fa-angle-double-right"></i> Service Barang </span>
                </h1>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ route('service-barang') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

                </div>

            </div>

        </div>

        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Tambah Service Barang</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body">
                                <form class="form-horizontal" id="form_return">{{csrf_field()}}
                                    <fieldset>
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nama Member</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="cari-member" name="member" placeholder="Masukkan Nama Member" type="text"  style="text-transform: uppercase">
                                                                <label for="cari-member" class="glyphicon glyphicon-search" rel="tooltip" title="Nama Member"></label>
                                                                <input type="hidden" name="idmember" id="idmember">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kode Spesifik</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="kode" name="kode" placeholder="Masukkan Kode Spesifik" type="text"  style="text-transform: uppercase">
                                                                <label for="kode" class="glyphicon glyphicon-search" rel="tooltip" title="Kode Spesifik"></label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="idsales" id="idsales">

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nota</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="nota" name="nota" placeholder="Masukkan Nota Penjualan" type="text"  style="text-transform: uppercase">
                                                                <label for="nota" class="glyphicon glyphicon-search" rel="tooltip" title="Nota Penjualan"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Tanggal</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-daterange" id="date-range">
                                                            <input type="text" class="form-control" id="tgl_awal" name="tgl_awal"  placeholder="Tanggal Awal">
                                                            <span class="input-group-addon bg-custom text-white b-0">-</span>
                                                            <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir"  placeholder="Tanggal Akhir">
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </fieldset>
                                    <div class="form-action">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button class="btn btn-primary pull-right" id="btn_search"><i class="fa fa-search"></i> Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </section>

        <section id="widget-grid" class="">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="jarviswidget" id="wid-id-0"
                         data-widget-colorbutton="false"
                         data-widget-editbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-custombutton="false"
                         data-widget-sortable="false">
                        <header role="heading"><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a> </div>
                            <h2><strong>Daftar Nota Penjualan</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body no-padding">
                                <table id="dt_active" class="table table-striped table-bordered table-hover" width="100%">

                                    <thead>

                                    <tr>

                                        <th><i class="fa fa-fw fa-calendar txt-color-blue"></i>&nbsp;Tanggal</th>

                                        <th><i class="fa fa-fw fa-building txt-color-blue "></i>&nbsp;Nota</th>

                                        <th class="text-center" width="15%"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>

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
        </section>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

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

                                <!-- widget div-->
                                <div>

                                    <!-- widget content -->
                                    <div class="widget-body no-padding">

                                        <div class="table-responsive">

                                            <table class="table">

                                                <tbody>

                                                <tr>
                                                    <td><strong>Tanggal</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_tanggal"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Nota</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_nota"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Salesman</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_salesman"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Member</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_member"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>No. Telp.</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_telp"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Alamat</strong></td>
                                                    <td><strong>:</strong></td>
                                                    <td id="dt_address"></td>
                                                </tr>

                                                </tbody>

                                            </table>

                                            <table class="table table-bordered" id="table_item">
                                                <thead>
                                                <tr class="text-center">
                                                    <td>Item</td>
                                                    <td>Qty</td>
                                                    <td>Harga (Rp)</td>
                                                    <td style="display: none;" id="aksi">Aksi</td>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

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
    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')
    <script type="text/javascript">
        var aktif;
        $(document).ready(function () {
            aktif = $('#dt_active').dataTable({
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
                    $('#overlay').fadeOut(200);
                }
            });

            var responsiveHelper_dt_basic = undefined;

            var breakpointDefinition = {
                tablet : 1024,
                phone : 480
            };

            $("#cari-member").on("keyup", function (evt) {
                evt.preventDefault();
                if (evt.which != 13) {
                    $("#idmember").val('');
                }
            })

            $( "#cari-member" ).autocomplete({
                source: baseUrl+'/penjualan/service-barang/cari-member',
                minLength: 1,
                select: function(event, data) {
                    $("#idmember").val(data.item.id);
                }
            });

            $( "#kode" ).autocomplete({
                source: baseUrl+'/penjualan/service-barang/cari-kode',
                minLength: 1,
                select: function(event, data) {
                    $("#idsales").val(data.item.id);
                }
            });

            $( "#nota" ).autocomplete({
                source: baseUrl+'/penjualan/service-barang/cari-nota',
                minLength: 1,
                select: function(event, data) {
                    $("#idsales").val(data.item.id);
                }
            });

            $( "#date-range" ).datepicker({
                language: "id",
                format: 'dd-mm-yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true,
                todayHighlight: true
            });

            $("#btn_search").on("click", function (evt) {
                evt.preventDefault();
                if (
                    $("#cari-member").val() == "" &&
                    $("#idmember").val() == "" &&
                    $("#kode").val() == "" &&
                    $("#nota").val() == "" &&
                    $("#tgl_awal").val() == "" &&
                    $("#tgl_akhir").val() == ""
                ) {
                    $.smallBox({
                        title : "Pesan!",
                        content : "Tambahkan parameter untuk melakukan pencarian!",
                        color : "#A90329",
                        timeout: 5000,
                        icon : "fa fa-times bounce animated"
                    });
                } else {
                    getNota();
                }
            })

            function getNota() {
                // console.log(id);
                $('#overlay').fadeIn(200);

                if ( $.fn.DataTable.isDataTable('#dt_active') ) {
                    $('#dt_active').DataTable().destroy();
                }

                $('#dt_active').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ url('/penjualan/service-barang/cari?') }}"+$("#form_return").serialize(),
                    "columns":[
                        {"data": "tanggal"},
                        {"data": "nota"},
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
                        $('#overlay').fadeOut(200);
                    }
                });
            }
        })

        function detail(id, flag){
            $('#overlay').fadeIn(200);
            $('#load-status-text').text('Sedang Mengambil data...');

            axios.get(baseUrl+'/penjualan/service-barang/cari/detail/'+id+'/'+flag).then(response => {

                if (response.data.status == 'Access denied') {

                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
                        color : "#A90329",
                        timeout: 5000,
                        icon : "fa fa-times bounce animated"
                    });

                } else if (response.data.status == 'Not Found') {
                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Gagal",
                        content : "Data tidak ditemukan",
                        color : "#A90329",
                        timeout: 5000,
                        icon : "fa fa-times bounce animated"
                    });
                } else {
                    var row = '';
                    $('.tr').remove();
                    $('#title_detail').html('<strong>Detail Penjualan</strong>');
                    $('#dt_tanggal').text(response.data[0].tanggal);
                    $('#dt_nota').text(response.data[0].nota);
                    $('#dt_salesman').text(response.data[0].salesman);
                    $('#dt_member').text(response.data[0].m_name);
                    $('#dt_telp').text(response.data[0].m_telp);
                    $('#dt_address').text(response.data[0].m_address);
                    $("#aksi").hide();
                    response.data.forEach(function(element) {
                        if (element.code != ""){
                            row = '<tr class="tr"><td>'+element.code+' - '+element.nama_item+'</td><td align="center">'+element.qty+'</td><td><p style="float: right">'+element.total_net+'</p></td></tr>'
                        } else {
                            row = '<tr class="tr"><td>'+element.nama_item+ ' (' + element.specificcode +')'+'</td><td align="center">'+element.qty+'</td><td><p style="float: right">'+element.total_net+'</p></td></tr>'
                        }
                        $('#table_item tbody').append(row)
                    });
                    $('#overlay').fadeOut(200);
                    $('#myModal').modal('show');

                }
            })
        }

        function servicePenjualan(id, flag) {
            $('#overlay').fadeIn(200);
            $('#load-status-text').text('Sedang Mengambil data...');

            axios.get(baseUrl+'/penjualan/service-barang/cari/detail/'+id+'/'+flag).then(response => {

                if (response.data.status == 'Access denied') {

                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
                        color : "#A90329",
                        timeout: 5000,
                        icon : "fa fa-times bounce animated"
                    });

                } else if (response.data.status == 'Not Found') {
                    $('#overlay').fadeOut(200);
                    $.smallBox({
                        title : "Gagal",
                        content : "Data tidak ditemukan",
                        color : "#A90329",
                        timeout: 5000,
                        icon : "fa fa-times bounce animated"
                    });
                } else {
                    var row = '';
                    $('.tr').remove();
                    $('#title_detail').html('<strong>Detail Penjualan</strong>');
                    $('#dt_tanggal').text(response.data[0].tanggal);
                    $('#dt_nota').text(response.data[0].nota);
                    $('#dt_salesman').text(response.data[0].salesman);
                    $('#dt_member').text(response.data[0].m_name);
                    $('#dt_telp').text(response.data[0].m_telp);
                    $('#dt_address').text(response.data[0].m_address);
                    $("#aksi").show();
                    var url;
                    response.data.forEach(function(element) {
                        var spcode;
                        if (element.specificcode == "") {
                            spcode = null;
                        } else {
                            spcode = element.specificcode;
                        }
                        url = baseUrl+'/penjualan/service-barang/service/'+element.idsales+'/'+element.iditem+'/'+spcode;
                        if (element.code != ""){
                            row = '<tr class="tr"><td>'+element.code+' - '+element.nama_item+'</td><td align="center">'+element.qty+'</td><td><p style="float: right">'+element.total_net+'</p></td><td><a href="'+url+'" class="btn btn-xs btn-primary">Pilih</a></td></tr>'
                        } else {
                            row = '<tr class="tr"><td>'+element.nama_item+ ' (' + element.specificcode +')'+'</td><td align="center">'+element.qty+'</td><td><p style="float: right">'+element.total_net+'</p></td><td><a href="'+url+'" class="btn btn-xs btn-primary">Pilih</a></td></tr>'
                        }
                        $('#table_item tbody').append(row)
                    });
                    $('#overlay').fadeOut(200);
                    $('#myModal').modal('show');

                }
            })
        }
    </script>
@endsection

