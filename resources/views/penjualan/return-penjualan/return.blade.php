@extends('main')

@section('title', 'Return Penjualan')

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
            <li>Home</li><li>Layanan Perbaikan</li><li>Perbaikan Barang</li>
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
                    Layanan Perbaikan <span><i class="fa fa-angle-double-right"></i> Perbaikan Barang </span>
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
                            <h2><strong>Tambah Return Penjualan</strong></h2>
                        </header>
                        <div role="content">
                            <div class="widget-body">
                                <form class="form-horizontal" id="form_return">
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

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Aksi</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-wrench"></i></span>
                                                            <select class="form-control" id="aksi" name="aksi">
                                                                <option value="">Pilih</option>
                                                                <option value="Ganti Barang Sejenis">Ganti Barang Sejenis</option>
                                                                <option value="Ganti Barang Lain">Ganti Barang Lain</option>
                                                                <option value="Ganti Uang">Ganti Uang</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>

                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="display: none" id="form_gb">
                                                <legend>Ganti Barang Sejenis</legend>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nama Barang</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                                                            <input class="form-control" id="item_baru" name="item_baru" type="text"  style="text-transform: uppercase">
                                                            <input type="hidden" name="codespecific" id="codespecific">
                                                            <input type="hidden" name="idstock" id="idstock">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kuantitas</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                                            <input class="form-control" id="qty_baru" name="qty_baru" readonly type="text"  style="text-transform: uppercase">
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>

                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="display: none" id="form_gbl">
                                                <legend>Ganti Barang Lain</legend>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nama Barang</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                                                            <input class="form-control" id="item_lain" name="item_lain" type="text"  style="text-transform: uppercase">
                                                            <input type="hidden" id="iditem_lain" name="iditem_lain">
                                                            <input type="hidden" name="code_lain" id="code_lain">
                                                            <input type="hidden" name="idstock_lain" id="idstock_lain">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kuantitas</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                                            <input class="form-control" id="qty_lain" name="qty_lain" type="text"  style="text-transform: uppercase">
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>

                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="display: none" id="form_gu">
                                                <legend>Ganti Uang</legend>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kode Spesifik</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                                                            <input class="form-control" id="kode_gu" name="kode_gu" readonly type="text"  style="text-transform: uppercase" value="{{$data->sd_specificcode}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Nama Barang</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                                                            <input class="form-control" id="nama_item_gu" name="nama_item_gu" readonly type="text"  style="text-transform: uppercase" value="{{$data->i_nama}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kuantitas</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                                            <input class="form-control" id="qty_gu" name="qty_gu" readonly type="text"  style="text-transform: uppercase" value="{{$data->sd_qty}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Harga Jual</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                                            <input class="form-control" id="harga_jual" name="harga_jual" readonly type="text"  style="text-transform: uppercase" value="{{number_format($data->sd_total_net,0,',', '.')}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Kuantitas Kembali</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                                            <input class="form-control" id="qty_return" name="qty_return" readonly type="text"  style="text-transform: uppercase">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-3 control-label text-left">Uang Kembali</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                                            <input class="form-control" id="kembali" name="kembali" readonly type="text"  style="text-transform: uppercase">
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </fieldset>
                                    <div class="form-action">
                                        <div class="row">
                                            <div class="col-md-6" id="btn_position">
                                                <button class="btn btn-primary pull-right" id="btn_next" disabled><i class="fa fa-send"></i> Lanjutkan</button>
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
        var stockGlobal = null;
        $(document).ready(function () {
            $("#aksi").on("change", function (evt) {
                evt.preventDefault();

                if ($(this).val() == "Ganti Barang Sejenis") {
                    if ($("#qty").val() == "" || $("#qty").val() == "0") {
                        $.smallBox({
                            title : "Peringatan!",
                            content : "Masukkan kuantitas yang dikembalikan",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $("#qty").focus();
                        $(this).val('');
                    } else if ($("#ket").val() == "") {
                        $.smallBox({
                            title : "Peringatan!",
                            content : "Keterangan tidak boleh kosong",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $("#ket").focus();
                        $(this).val('');
                    } else {
                        $.SmartMessageBox({
                            title : "Pesan!",
                            content : 'Kuantitas yang dikembalikan '+$("#qty").val(),
                            buttons : '[Batal][Ya]'
                        }, function(ButtonPressed) {
                            if (ButtonPressed === "Ya") {
                                axios.get(baseUrl+'/penjualan/return-penjualan/checkStock/'+$("#iditem").val()).then(response => {
                                    // console.log(response.data);
                                    if (parseInt($("#qty").val()) > parseInt(response.data)) {
                                        $.smallBox({
                                            title : "Peringatan!",
                                            content : "Stock hanya tersedia "+response.data.s-qty+' buah',
                                            color : "#A90329",
                                            timeout: 5000,
                                            icon : "fa fa-times bounce animated"
                                        });
                                        $(this).val('');
                                    } else {
                                        $("#qty_baru").val($("#qty").val());
                                        $("#form_gu").hide('slow');
                                        $("#form_gbl").hide('slow');
                                        $("#form_gb").show('slow');
                                        $("#btn_position").removeClass("col-md-6");
                                        $("#btn_position").addClass("col-md-12");
                                        $("#item_baru").val('');
                                        $("#codespecific").val('');
                                        $("#idstock").val('');
                                    }
                                })
                            } else {
                                $("#aksi").val('');
                                $("#btn_next").attr("disabled", true);
                            }
                        });

                    }
                } else if ($(this).val() == "Ganti Barang Lain") {
                    if ($("#qty").val() == "" || $("#qty").val() == "0") {
                        $.smallBox({
                            title : "Peringatan!",
                            content : "Masukkan kuantitas yang dikembalikan",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $("#qty").focus();
                        $(this).val('');
                    } else if ($("#ket").val() == "") {
                        $.smallBox({
                            title : "Peringatan!",
                            content : "Keterangan tidak boleh kosong",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $("#ket").focus();
                        $(this).val('');
                    } else {
                        $.SmartMessageBox({
                            title : "Pesan!",
                            content : 'Kuantitas yang dikembalikan '+$("#qty").val(),
                            buttons : '[Batal][Ya]'
                        }, function(ButtonPressed) {
                            if (ButtonPressed === "Ya") {
                                $("#form_gu").hide('slow');
                                $("#form_gb").hide('slow');
                                $("#form_gbl").show('slow');
                                $("#btn_position").removeClass("col-md-6");
                                $("#btn_position").addClass("col-md-12");
                                $("#item_lain").val('')
                                $("#iditem_lain").val('');
                                $("#code_lain").val('');
                                $("#idstock_lain").val('');
                            } else {
                                $("#aksi").val('');
                                $("#btn_next").attr("disabled", true);
                            }
                        });

                    }
                } else if ($(this).val() == "Ganti Uang") {
                    if ($("#qty").val() == "" || $("#qty").val() == "0") {
                        $.smallBox({
                            title : "Peringatan!",
                            content : "Masukkan kuantitas yang dikembalikan",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $("#qty").focus();
                        $(this).val('');
                    } else if ($("#ket").val() == "") {
                        $.smallBox({
                            title : "Peringatan!",
                            content : "Keterangan tidak boleh kosong",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                        $("#ket").focus();
                        $(this).val('');
                    } else {
                        $.SmartMessageBox({
                            title : "Pesan!",
                            content : 'Kuantitas yang dikembalikan '+$("#qty").val(),
                            buttons : '[Batal][Ya]'
                        }, function(ButtonPressed) {
                            if (ButtonPressed === "Ya") {
                                $("#qty_return").val($("#qty").val());
                                var value = '{{ number_format($data->sd_value, 0, ',', '') }}';
                                var kembali = parseInt(value) * parseInt($("#qty").val());
                                $("#kembali").val(toRupiah(kembali));
                                $("#form_gb").hide('slow');
                                $("#form_gbl").hide('slow');
                                $("#form_gu").show('slow');
                                $("#btn_position").removeClass("col-md-6");
                                $("#btn_position").addClass("col-md-12");
                                $("#btn_next").attr("disabled", false);
                            } else {
                                $("#aksi").val('');
                                $("#btn_next").attr("disabled", true);
                            }
                        });

                    }

                }
            })

            $("#qty").on("keyup", function (evt) {
                evt.preventDefault();
                var qty_awal = '{{ $data->sd_qty }}';
                if ($(this).val() > qty_awal) {
                    $(this).val(qty_awal);
                }
                $("#aksi").val('');
                $("#form_gb").hide('slow');
                $("#form_gbl").hide('slow');
                $("#form_gu").hide('slow');
                $("#btn_position").removeClass("col-md-12");
                $("#btn_position").addClass("col-md-6");
            })

            $("#qty_baru").on("keyup", function (evt) {
                evt.preventDefault();
                var qty_awal = '{{ $data->sd_qty }}';
                if ($(this).val() > qty_awal) {
                    $(this).val(qty_awal);
                }
            })

            $("#item_baru").on("keyup", function (evt) {
                evt.preventDefault();
                $("#codespecific").val('');
                $("#idstock").val('');
                $("#btn_next").attr("disabled", true);
            })

            $( "#item_baru" ).autocomplete({
                source: function(request, response) {
                    $.getJSON(baseUrl+'/penjualan/return-penjualan/cariitembaru', { item: $("#iditem").val(), term: $("#item_baru").val() },
                        response);
                },
                minLength: 1,
                select: function(event, data) {
                    $("#codespecific").val(data.item.data.sm_specificcode);
                    $("#idstock").val(data.item.data.s_id);
                    $("#btn_next").attr("disabled", false);
                }
            });

            $( "#item_lain" ).autocomplete({
                source: baseUrl+'/penjualan/return-penjualan/cariitemlain',
                minLength: 1,
                select: function(event, data) {
                    // console.log(data.item)
                    setStock(data.item);
                }
            });

            $("#item_lain").on("keyup", function (evt) {
                evt.preventDefault();
                $("#iditem_lain").val('');
                $("#code_lain").val('');
                $("#idstock_lain").val('');
                $("#btn_next").attr("disabled", true);
            })

            $("#btn_next").on("click", function (evt) {
                evt.preventDefault();
                simpan();
            })

            function setStock(info){
                var data = info.data;

                axios.get(baseUrl+'/penjualan-reguler/checkStock/'+data.i_id)
                    .then(function (response) {
                        // handle success
                        stockGlobal = response.data;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
                $("#iditem_lain").val(data.i_id);
                $("#code_lain").val(data.sm_specificcode);
                $("#idstock_lain").val(data.s_id)
                $("#btn_next").attr("disabled", false);
            }

            function simpan() {
                overlay();
                axios.post(baseUrl+'/penjualan/return-penjualan/add', $("#form_return").serialize())
                .then(function (response) {
                    console.log(response.data);
                    out();
                    if (response.data == true) {
                        $.smallBox({
                            title : "Berhasil",
                            content : 'Return barang berhasil...!',
                            color : "#739E73",
                            timeout: 5000,
                            icon : "fa fa-check bounce animated"
                        });
                        window.location = baseUrl + '/penjualan/return-penjualan';
                    } else if (response.data == "not found") {
                        $.smallBox({
                            title : "Gagal",
                            content : "Upsss. Data tidak ditemukan distok!",
                            color : "#A90329",
                            timeout: 5000,
                            icon : "fa fa-times bounce animated"
                        });
                    } else {
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
        })
    </script>
@endsection
