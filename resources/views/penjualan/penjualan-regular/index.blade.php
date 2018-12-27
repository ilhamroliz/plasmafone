@extends('main')

@section('title', 'Penjualan Reguler')

@section('extra_style')

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
            <li>Home</li><li>Penjualan</li><li>Penjualan Reguler</li>
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
                    <i class="fa-fw fa fa-lg fa-handshake-o"></i>
                    Penjualan <span><i class="fa fa-angle-double-right"></i> Penjualan Reguler </span>
                </h1>
            </div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <h2><strong>Penjualan Reguler</strong></h2>
                        </header>
                        <div role="content">
                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="input-icon-left">
                                                    <i class="fa fa-user"></i>
                                                    <input class="form-control" id="cari-member" placeholder="Masukkan Nama Pembeli" type="text"  style="text-transform: uppercase">
                                                    <input type="hidden" value="" class="idMember" id="idMember">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" data-toggle="modal" data-target="#DaftarMember" class="btn btn-primary" title="Tambah Pembeli"><i class="fa fa-user-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8">
                                                <div class="input-icon-left">
                                                    <i class="fa fa-barcode"></i>
                                                    <input class="form-control" placeholder="Masukkan Nama Barang" type="text"  style="text-transform: uppercase">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-icon-left">
                                                    <i class="fa fa-sort-numeric-asc"></i>
                                                    <input class="form-control" placeholder="Qty" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <table class="table table-responsive table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Harga @</th>
                                                        <th>Diskon %</th>
                                                        <th>Diskon Rp</th>
                                                        <th>Total</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i>
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                            <!-- end widget content -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end widget grid -->
    </div>
    <!-- END MAIN CONTENT -->
    <!-- Modal -->
    <div class="modal fade" id="DaftarMember" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Member</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-icon-left">
                                        <i class="fa fa-user"></i>
                                        <input class="form-control" id="nama-member"  style="text-transform: uppercase" placeholder="Masukkan Nama Pembeli" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-icon-left">
                                        <i class="fa fa-phone"></i>
                                        <input class="form-control" id="nomor-member" placeholder="MASUKKAN NOMOR PEMBELI" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary" onclick="simpanmember()">
                        Simpan
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('extra_script')
<script>
    $(document).ready(function(){
        $('.togel').click();
        $( "#cari-member" ).autocomplete({
            source: baseUrl+'/penjualan-reguler/cari-member',
            minLength: 2,
            select: function(event, data) {
                getData(data.item);
            }
        });
    })

    $("#nomor-member").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    function simpanmember() {
        overlay();
        var nama = $('#nama-member').val();
        var nomor = $('#nomor-member').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: baseUrl + '/penjualan-reguler/simpan-member',
            type: 'get',
            data: {nama: nama, nomor: nomor},
            dataType: 'json',
            success: function (response) {
                out();
                $('#DaftarMember').modal('hide');
                if (response.status == 'nomor'){
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. Nomor sudah pernah didaftarkan",
                        color : "#C46A69",
                        timeout: 2000,
                        icon : "fa fa-warning shake animated"
                    });
                } else if (response.status == 'sukses'){
                    $.smallBox({
                        title : "Sukses",
                        content : "Data berhasil disimpan",
                        color : "#739E73",
                        timeout: 2000,
                        icon : "fa fa-check"
                    });
                } else if (response.status == 'gagal'){
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. Silhakan coba sesaat lagi",
                        color : "#C46A69",
                        timeout: 2000,
                        icon : "fa fa-warning shake animated"
                    });
                }
            },
            error: function (xhr, status) {
                out();
                $('#DaftarMember').modal('hide');
                if (status == 'timeout') {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                }
                else if (xhr.status == 0) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                }
                else if (xhr.status == 500) {
                    $('.error-load').css('visibility', 'visible');
                    $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                }
            }
        });
    }

    function getData(data) {
        $('#idMember').val(data.id);
    }
</script>
@endsection
