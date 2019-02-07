@extends('main')

@section('title', 'Pengelolaan Member')

@section('extra_style')
    <style type="text/css">
        .ui-autocomplete-input {
            z-index: 909 !important;
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
                        <a rel="tooltip" title="" data-placement="bottom" data-original-title="Pengaturan" class="btn btn-default"><strong><i class="fa fa-cogs fa-lg text-primary"></i></strong></a>
                        @endif
                        <a href="javascript:void(0);" rel="tooltip" title="" data-placement="bottom" data-original-title="History Penukaran Poin" class="btn btn-default"><strong><i class="fa fa-history fa-lg text-danger"></i></strong></a>
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
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Nama Member</th>
                                            <th>No Telp</th>
                                            <th>Saldo Poin</th>
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
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Nama Member</th>
                                            <th>Hari Lahir</th>
                                            <th>No Telp</th>
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

@endsection

@section('extra_script')

    <script type="text/javascript">
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

            $('#uang').maskMoney({
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
    </script>

@endsection
