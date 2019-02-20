@extends('main')

@section('title', 'Refund')

@section('extra_style')
    <style>
        .smart-form fieldset {
            padding: 10px 14px 5px;
        }
        .smart-form .btn-style {
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 13px;
            line-height: 1.42857143;
            border-radius: 2px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            float: right;
        }
    </style>
@endsection

<?php
use App\Http\Controllers\PlasmafoneController as Plasma;
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
            <li>Home</li><li>Pembelian</li><li>Refund</li>
        </ol>

    </div>
    <!-- END RIBBON -->
@endsection

@section('main_content')
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-asterisk"></i>
                    Pembelian <span><i class="fa fa-angle-double-right"></i> Refund </span>
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
                            <h2><strong>Tambah Refund</strong></h2>
                        </header>
                        <div role="content">
                            <!-- widget content -->
                            <div class="widget-body padding-10">
                                <form id="form-tambah" class="smart-form form-horizontal">
                                    <section class="form-group">
                                        <div class="col col-3 padding-left-0">
                                            <select class="select2" id="supplier" name="supplier" onchange="setSupplier()">
                                                <option value="" selected>Pilih Supplier</option>
                                                @foreach($supplier as $supp)
                                                    <option value="{{ $supp->s_id }}">{{ $supp->s_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col col-6 padding-left-0">
                                            <label class="input"> <i class="icon-append fa fa-font"></i>
                                                <input type="text" id="namabarang" placeholder="Masukkan Nama/Kode Barang" style="text-transform: uppercase" readonly>
                                                <input type="hidden" name="item" id="idItem">
                                                <b class="tooltip tooltip-bottom-right">Masukkan Nama/Kode Barang</b>
                                            </label>
                                        </div>
                                        <div class="col col-1 padding-left-0">
                                            <button type="button" disabled class="btn btn-primary btn-style btn-khusus" onclick="cari()"><i class="fa fa-search"></i> Cari</button>
                                        </div>
                                        <div class="col col-1 padding-left-0">
                                            <button type="button" disabled class="btn btn-warning btn-style btn-refresh" onclick="refresh()"><i class="fa fa-refresh"></i> Reset</button>
                                        </div>
                                        <div class="col col-1 padding-left-0">
                                            <button type="button" disabled class="btn btn-success btn-style btn-simpan" onclick="simpan()"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </section>
                                    <section class="form-group baris-1" style="display: none">
                                        <div class="col col-3 padding-left-0">
                                            <label class="label">Harga Pembelian</label>
                                            <label class="input"> <i class="icon-append fa fa-at"></i>
                                                <input type="text" name="hargalama" id="hargalama" readonly placeholder="Harga Terakhir" style="text-transform: uppercase">
                                                <b class="tooltip tooltip-bottom-right">Harga Terakhir</b>
                                            </label>
                                        </div>
                                        <div class="col col-3 padding-left-0">
                                            <label class="label">Harga Baru</label>
                                            <label class="input"> <i class="icon-append fa fa-money"></i>
                                                <input type="text" name="hargabaru" id="hargabaru" onkeyup="setHargaBaru()" placeholder="Harga Baru" style="text-transform: uppercase">
                                                <b class="tooltip tooltip-bottom-right">Harga Baru</b>
                                            </label>
                                        </div>
                                        <div class="col col-3 padding-left-0">
                                            <label class="label">Qty</label>
                                            <label class="input"> <i class="icon-append fa fa-cubes"></i>
                                                <input type="text" name="qty" id="qty" placeholder="QTY" readonly style="text-transform: uppercase">
                                                <b class="tooltip tooltip-bottom-right">Kuantitas</b>
                                            </label>
                                        </div>
                                        <div class="col col-3 padding-left-0">
                                            <label class="label">Refund</label>
                                            <label class="input"> <i class="icon-append fa fa-money"></i>
                                                <input type="text" name="totalrefund" id="totalrefund" placeholder="Total Refund" readonly style="text-transform: uppercase">
                                                <b class="tooltip tooltip-bottom-right">Total Refund</b>
                                            </label>
                                        </div>
                                    </section>
                                </form>
                                <div class="smart-form form-horizontal">
                                    <section class="form-group baris-1" style="display: none">
                                        <table class="table table-striped table-bordered table-hover" width="100%" id="listkode" style="cursor: pointer">
                                            <thead>
                                            <tr>
                                                <th style="width: 5%;">No</th>
                                                <th style="width: 20%;">Posisi</th>
                                                <th style="width: 25%;">Kode Spesifik</th>
                                                <th style="width: 20%;">Supplier</th>
                                                <th style="width: 20%;">Harga</th>
                                                <th style="width: 10%;">Aksi</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </section>
                                </div>

                            </div>
                            <!-- end widget content -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </section>
    </div>
@endsection

@section('extra_script')
    <script type="text/javascript">
        var tablekode;
        var dataGlobal;
        $(document).ready(function () {

            $('#tanggal').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true
            });

            tablekode = $('#listkode').DataTable({
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                    "<'dt-toolbar-footer'<'col-xs-12 col-sm-12 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#listkode'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
            $( "#namabarang" ).autocomplete({
                source: baseUrl+'/pembelian/refund/get-item',
                minLength: 1,
                select: function(event, data) {
                    setData(data);
                    dataGlobal = data;
                    $('.btn-khusus').attr('disabled', false);
                }
            });
            $('#hargabaru').maskMoney({
                thousands:'.',
                precision: 0,
                decimal:',',
                allowZero:true,
                prefix: 'Rp. '
            });
        })
        
        function setSupplier() {
            $('#namabarang').attr('readonly', false);
        }

        function setData(data) {
            overlay();
            var id = data.item.id;
            $('#idItem').val(id);
            var supp = $('#supplier').val();
            if (supp == null || supp == ''){
                $.smallBox({
                    title : "Perhatian",
                    content : "Isi Supplier terlebih dahului ",
                    color : "#c69021",
                    timeout: 3000,
                    icon : "fa fa-times bounce animated"
                });
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/pembelian/refund/get-data',
                type: 'post',
                data: {id: id, supplier: supp},
                success: function(response){
                    tablekode.clear();
                    for (var i = 0; i < response.length; i++){
                        var hargarp = convertToRupiah(response[i].sm_hpp.replace('.00', ''));
                        tablekode.row.add( [
                            '',
                            response[i].posisi + "<input type='hidden' class='stock' name='id_stock[]' value='"+response[i].s_id+"'>",
                            response[i].sd_specificcode + "<input type='hidden' class='specificcode' name='specificcode[]' value='"+response[i].sd_specificcode+"'>",
                            response[i].supplier,
                            hargarp + "<input type='hidden' class='hargahpp' name='hargahpp[]' value='"+response[i].sm_hpp.replace('.00', '')+"'>",
                            "<div class='text-center'><button type='button' class='btn btn-danger hapusrow btn-xs'><i class='fa fa-minus'></i></button></div>",
                        ] ).draw(false);
                        if (i == (response.length - 1)){
                            var harga = convertToRupiah(response[i].sm_hpp.replace('.00', ''));
                            $('#hargalama').val(harga);
                        }
                        $('#listkode .hapusrow').on( 'click', function () {
                            tablekode
                                .row( $(this).parents('tr') )
                                .remove()
                                .draw();

                            setTotalRefund();
                            $('.btn-refresh').attr('disabled', false);
                        } );
                        $('#qty').val(response.length);
                    }
                    tablekode.on( 'order.dt search.dt', function () {
                        tablekode.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                            cell.innerHTML = i+1;
                        } );
                    } ).draw();
                    out();
                }, error:function(x, e) {
                    out();
                    if (x.status == 0) {
                        alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                    } else if (x.status == 404) {
                        alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                    } else if (x.status == 500) {
                        alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout'){
                        alert('Request Time out. Harap coba lagi nanti');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            })
        }

        function setTotalRefund(){
            var ar = $();
            for (var i = 0; i < tablekode.rows()[0].length; i++) {
                ar = ar.add(tablekode.row(i).node());
            }
            var jumlah = ar.find('input.hargahpp'),
                hargahpp  = [].map.call(jumlah, function( input ) {
                    return parseInt(input.value);
                });

            hargabaru = convertToAngka($('#hargabaru').val());
            hargabaru = parseInt(hargabaru);
            hargalama = convertToAngka($('#hargalama').val());
            hargalama = parseInt(hargalama);
            if (isNaN(hargabaru)){
                hargabaru = 0;
            }
            $('#qty').val(hargahpp.length);
            total = (hargalama * hargahpp.length) - (hargabaru * hargahpp.length);
            $('#totalrefund').val(convertToRupiah(total));
        }

        function setHargaBaru() {
            var baru = $('#hargabaru').val();
            baru = convertToAngka(baru);
            baru = parseInt(baru);
            hargalama = convertToAngka($('#hargalama').val());
            hargalama = parseInt(hargalama);

            var ar = $();
            for (var i = 0; i < tablekode.rows()[0].length; i++) {
                ar = ar.add(tablekode.row(i).node());
            }
            var jumlah = ar.find('input.hargahpp'),
                hargahpp  = [].map.call(jumlah, function( input ) {
                return parseInt(input.value);
            });

            total = (hargalama * hargahpp.length) - (baru * hargahpp.length);
            $('#totalrefund').val(convertToRupiah(total));
        }

        function cari() {
            $('.baris-1').show('slow');
            $('.btn-simpan').attr('disabled', false);
            setTotalRefund();
        }

        function refresh() {
            setData(dataGlobal);
            setTotalRefund();
        }

        function simpan() {
            overlay();
            var ar = $();
            for (var i = 0; i < tablekode.rows()[0].length; i++) {
                ar = ar.add(tablekode.row(i).node());
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/pembelian/refund/simpan',
                type: 'post',
                data: $('#form-tambah').serialize() + '&' + ar.find('input').serialize(),
                success: function(response){
                    out();
                    if (response.status == 'sukses'){
                        $.smallBox({
                            title: "Berhasil",
                            content: 'Data berhasil disimpan',
                            color: "#739E73",
                            timeout: 3000,
                            icon: "fa fa-check bounce animated"
                        });
                        setTimeout(function () {
                            window.location = "{{ url('pembelian/refund') }}";
                        }, 2000);
                    } else {
                        $.smallBox({
                            title: "Gagal",
                            content: "Upsss. Simpan gagal, hubungi admin...",
                            color: "#A90329",
                            timeout: 3000,
                            icon: "fa fa-times bounce animated"
                        });
                    }
                }, error:function(x, e) {
                    out();
                    if (x.status == 0) {
                        alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
                    } else if (x.status == 404) {
                        alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
                    } else if (x.status == 500) {
                        alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout'){
                        alert('Request Time out. Harap coba lagi nanti');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            })
        }

    </script>
@endsection
