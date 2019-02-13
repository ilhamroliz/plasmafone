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
                                <form class="form-horizontal" id="form_service">
                                    {{csrf_field()}}
                                    <fieldset>
                                        <div class="row">
                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <input type="hidden" name="idsales" id="idsales" value="{{ Crypt::encrypt($data->sd_sales) }}">
                                                <input type="hidden" name="iditem" id="iditem" value="{{ Crypt::encrypt($data->sd_item) }}">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nota</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                                                            <input class="form-control" id="nota" name="nota" readonly type="text"  style="text-transform: uppercase" value="{{$data->s_nota}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kode Spesifik</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                                                            <input class="form-control" id="kode" name="kode" readonly type="text"  style="text-transform: uppercase" value="{{$data->sd_specificcode}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nama Barang</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                                                            <input class="form-control" id="nama_item" name="nama_item" readonly type="text"  style="text-transform: uppercase" value="@if($data->sd_specificcode != "") {{$data->i_nama}} ({{$data->sd_specificcode}}) @else {{$data->i_code}} - {{$data->i_nama}} @endif">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kuantitas</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                                            <input class="form-control" id="qty" name="qty" @if($data->sd_specificcode != "") readonly @endif type="text"  style="text-transform: uppercase" value="{{$data->sd_qty}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Keterangan</label>
                                                    <div class="col-md-9">
                                                        <textarea id="ket" name="ket" class="form-control" rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </fieldset>
                                    <div class="form-action">
                                        <div class="row">
                                            <div class="col-md-6" id="btn_position">
                                                <button class="btn btn-primary pull-right" id="btn_service" disabled><i class="fa fa-wrench"></i> Service</button>
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

    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('extra_script')
    <script type="text/javascript">
        $(document).ready(function () {

            if ($("#ket").val() == "") {
                $("#btn_service").attr('disabled', true);
            } else {
                $("#btn_service").attr('disabled', false);
            }

            $("#ket").on('keyup', function (evt) {
                evt.preventDefault();
                if ($("#ket").val() == "") {
                    $("#btn_service").attr('disabled', true);
                } else {
                    $("#btn_service").attr('disabled', false);
                }
            })

            $("#qty").on("keyup", function (evt) {
                evt.preventDefault();
                var qty_awal = '{{ $data->sd_qty }}';
                if ($(this).val() > qty_awal) {
                    $(this).val(qty_awal);
                }
            })

            $("#btn_service").on("click", function (evt) {
                evt.preventDefault();
                simpan();
            })

            function simpan() {
                $.SmartMessageBox({
                    title: "Pesan!",
                    content: 'Service barang ini?',
                    buttons: '[Batal][Ya]'
                }, function (ButtonPressed) {
                    if (ButtonPressed === "Ya") {
                        overlay();
                        axios.post(baseUrl+'/penjualan/service-barang/add-service', $("#form_service").serialize())
                            .then(function (response) {
                                console.log(response.data.status);
                                out();
                                if (response.data.status == "true") {
                                    $.smallBox({
                                        title : "Berhasil",
                                        content : 'Return barang berhasil...!',
                                        color : "#739E73",
                                        timeout: 5000,
                                        icon : "fa fa-check bounce animated"
                                    });
                                    cetak(response.data.id)
                                    window.location = baseUrl + '/penjualan/return-penjualan';
                                } else if (response.data.status == "not found") {
                                    $.smallBox({
                                        title : "Gagal",
                                        content : "Upsss. Data tidak ditemukan!",
                                        color : "#A90329",
                                        timeout: 5000,
                                        icon : "fa fa-times bounce animated"
                                    });
                                } else if (response.data.status == "false") {
                                    $.smallBox({
                                        title : "Gagal",
                                        content : "Upsss. Terjadi kesalahan sistem!",
                                        color : "#A90329",
                                        timeout: 5000,
                                        icon : "fa fa-times bounce animated"
                                    });
                                }
                            })
                            .catch(function (error) {
                                out();
                                console.log(error);
                            });
                    }
                });
            }

            function cetak(id){
                window.open(baseUrl + '/penjualan/service-barang/struk/'+id, '', "width=800,height=600");
            }
        })
    </script>
@endsection
