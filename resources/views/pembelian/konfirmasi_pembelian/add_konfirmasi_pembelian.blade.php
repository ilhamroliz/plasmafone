@extends('main')

@section('title', 'Konfirmasi Pembelian')

<?php
use App\Http\Controllers\PlasmafoneController as Access;

function rupiah($angka)
{
    $hasil_rupiah = "Rp" . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
?>

@section('extra_style')
    <style type="text/css">
        .dataTables_length {
            float: right;
        }

        .dt-toolbar-footer > :last-child, .dt-toolbar > :last-child {
            padding-right: 0 !important;
        }

        .col-sm-1.col-xs-12.hidden-xs {
            padding: 0px;
        }
    </style>
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
            <li>Tambah Konfirmasi Pembelian</li>

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
                    <i class="fa-fw fa fa-credit-card"></i>
                    Pembelian
                    <span>
						<i class="fa fa-angle-double-right"></i>
						 Tambah Konfirmasi Pembelian
					</span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ url('pembelian/konfirmasi-pembelian') }}" class="btn btn-default"><i
                            class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

                </div>

            </div>
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

                        <header role="heading">

                            <h2><strong>Tambah Konfirmasi Pembelian</strong></h2>

                            <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

                        <!-- widget div-->
                        <div>

                            <!-- widget content -->

                            <div class="widget-body no-padding">

                                <!-- widget body text-->

                                <div class="tab-content padding-10 ">
                                    <div class="tab-pane fade in active" id="hr1">
                                        <table id="table-rencana" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead class="table-responsive">
                                            <tr>
                                                <th class="text-center" width="20%">Tanggal</th>
                                                <th class="text-center" width="40%">Nama Barang</th>
                                                <th class="text-center" width="10%">Qty</th>
                                                <th class="text-center" width="10%">Qty App</th>
                                                <th class="text-center" width="20%">Supplier</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($data as $row)
                                                <tr>
                                                    <td>{{ $row->pp_date }}</td>
                                                    <td>{{ $row->i_nama }}</td>
                                                    <td>{{ $row->pp_qtyreq }}</td>
                                                    <td>
                                                        <div class="text-center">
                                                        	<input type="hidden" name="pp_id[]" value="{{ $row->pp_id }}">
                                                        	<input type="hidden" name="pp_item[]" value="{{$row->pp_item}}">
                                                            <input type="number" min="1" class="form-control QtyApp" name="QtyApp[]" value="{{ $row->pp_qtyreq }}" style="width: 100%;">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <select name="supplier[]" class="pilihsupplier select2">
                                                                <option selected value="">Pilih Supplier</option>
                                                                @foreach ($supplier as $supp)
                                                                    <option
                                                                        value="{{ $supp->id }}">{{ $supp->text }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn-lg btn-block btn-primary text-center"
                                                        onclick="simpanConfirm()">Konfirmasi Semua
                                                </button>
                                            </div>
                                        </div>
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


@endsection

@section('extra_script')


    <script type="text/javascript">
        var table_registrasi_trans;
        var confirm;
        var tambahKonfirmasi;
        var input = $('#dt_harga2').val();
        var input2 = $('#dt_angka').val();
        var tambahRencana;
        $(document).ready(function () {

            $("#tpMemberNama").autocomplete({
                source: baseUrl + '/pembelian/request-pembelian/cariItem',
                minLength: 2,
                select: function (event, data) {
                    $('#tpMemberId').val(data.item.id);
                    $('#tpMemberNama').val(data.item.label);
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            semua = $('#table-rencana').DataTable({
                "autoWidth": true,
                "language": dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#table-rencana'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                }

            });

            $("input[type='text']").on("click", function () {
                $(this).select();
            });

            $(document).on("click", "span", function () {
                $(this).find("span[class~='caption']").hide();
                $(this).find("input[class~='editor']").fadeIn().focus();
            });

        });

        function getSupplier() {
            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/getSupplier')}}',
                type: "GET",
                data: {},
                dataType: "JSON",
                success: function (data) {
                    // for (var i = 0; i < data.length ; i++) {
                    // 	$('select').append("<option value='"+data[i].s_id+"'>"+data[i].s_company+"</option>");
                    // }
                    $('.pilihsupplier').select2({
                        data: data
                    });
                },

            });
        }

        function editFor(id) {
            $('#span' + id).hide();
            $('#i_nama' + id).show();

        }

        $(document).on("keydown", ".editor", function (e) {
            if (e.keyCode == 13) {

                var target = $(e.target);
                var harga = target.val();
                var id = target.attr("data-id");

                $.ajax({
                    url: '{{url('/pembelian/konfirmasi-pembelian/editDumy')}}',
                    type: "POST",
                    data: {
                        'id': id,
                        'harga': harga,
                        _token: '{{ csrf_token() }}'

                    },
                    dataType: "JSON",
                    success: function (data) {
                        reload_table();
                    },

                });
            }

        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }


        function tutup() {
            $('#detailModal').modal('hide');
        }

        function getTelp() {
            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/getTelp')}}',
                type: "GET",
                data: {
                    "s_id": $('dt_supplier2').val(),
                },
                dataType: "JSON",
                success: function (data) {
                    $('#dt_telepon').val("");
                    $('#dt_telepon').val(data.data.s_phone);
                },
            });
        }


        function getPlan_id(id) {

            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/getPlan_id')}}',
                type: "GET",
                data: {
                    id: id,
                },
                dataType: "JSON",
                success: function (data) {
                    pr_idPlan = data.data.pr_idPlan;
                    i_item = data.data.i_id;
                    pr_comp = data.data.pr_comp;
                    supplier = data.data.s_id;

                    if (data.data.i_img == "") {

                        $('img#dt_image').attr("src", "{{asset('img/image-not-found.png')}}");

                    } else {

                        $('img#dt_image').attr("src", "{{asset('img/items/')}}" + "/" + data.data.i_img);

                    }
                    $('#pr_idPlan').val(data.data.pr_idPlan);
                    $('#dt_item').val(data.data.i_nama);
                    $('#dt_merk').val(data.data.i_merk);
                    $('#dt_kelompok').val(data.data.i_kelompok);
                    $('#dt_code').val(data.data.i_specificcode);
                    $('#dt_harga').val(data.data.i_price);
                    $('#dt_qty').val(data.data.pr_qtyApp);
                    $('#dt_telepon').val(data.data.s_phone);

                    $.ajax({
                        url: '{{url('/pembelian/konfirmasi-pembelian/getSupplier')}}',
                        type: "GET",
                        data: {},
                        dataType: "JSON",
                        success: function (data) {
                            $('#dt_supplier2').empty();
                            row = "<option value='0'>Pilih Supplier</option>";
                            $(row).appendTo("#dt_supplier2");
                            $.each(data, function (k, v) {
                                if (v.s_id == supplier) {
                                    row = "<option selected='' value='" + v.s_id + "'>" + v.s_company + "</option>";
                                } else {
                                    row = "<option value='" + v.s_id + "'>" + v.s_company + "</option>";
                                }
                                $(row).appendTo("#dt_supplier2");
                            });
                        },
                    });

                    $('#myModalLabel').text('FORM DETAIL KONFIRMASI PEMBELIAN');
                    $('#detailModal').modal('show');
                    $('#btn_disetujui').show();
                    $('#btn_ditutup').show();
                    $('#btn_ditolak').hide();
                    $('#id_plan').hide();
                },

            });


        }

        function getTolak(id) {

            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/getPlan_id')}}',
                type: "GET",
                data: {
                    id: id,
                },
                dataType: "JSON",
                success: function (data) {
                    pr_idPlan = data.data.pr_idPlan;
                    i_item = data.data.i_id;
                    pr_comp = data.data.pr_comp;
                    supplier = data.data.s_id;

                    if (data.data.i_img == "") {

                        $('img#dt_image').attr("src", "{{asset('img/image-not-found.png')}}");

                    } else {

                        $('img#dt_image').attr("src", "{{asset('img/items/')}}" + "/" + data.data.i_img);

                    }
                    $('#dt_item').val(data.data.i_nama);
                    $('#dt_merk').val(data.data.i_merk);
                    $('#dt_kelompok').val(data.data.i_kelompok);
                    $('#dt_code').val(data.data.i_specificcode);
                    $('#dt_harga').val(data.data.i_price);
                    $('#dt_qty').val(data.data.pr_qtyApp);
                    $('#dt_telepon').val(data.data.s_phone);

                    $.ajax({
                        url: '{{url('/pembelian/konfirmasi-pembelian/getSupplier')}}',
                        type: "GET",
                        data: {},
                        dataType: "JSON",
                        success: function (data) {
                            $('#dt_supplier2').empty();
                            row = "<option value='0'>Pilih Supplier</option>";
                            $(row).appendTo("#dt_supplier2");
                            $.each(data, function (k, v) {
                                if (v.s_id == supplier) {
                                    row = "<option selected='' value='" + v.s_id + "'>" + v.s_company + "</option>";
                                } else {
                                    row = "<option value='" + v.s_id + "'>" + v.s_company + "</option>";
                                }
                                $(row).appendTo("#dt_supplier2");
                            });
                        },
                    });

                    $('#myModalLabel').text('FORM DETAIL KONFIRMASI PEMBELIAN');
                    $('#detailModal').modal('show');
                    $('#btn_disetujui').hide();
                    $('#btn_ditutup').show();
                    $('#btn_ditolak').show();
                },

            });


        }

        function suplier() {
            $.ajax({
                url: '{{url('/pembelian/rencana-pembelian/itemSuplier')}}',
                type: "GET",
                data: {},
                dataType: "JSON",
                success: function (data) {
                    $('#dt_supplier').empty();
                    row = "<option selected='' value='0'>Pilih Suplier</option>";
                    $(row).appendTo("#dt_supplier");
                    $.each(data, function (k, v) {
                        row = "<option value='" + v.s_id + "'>" + v.s_company + "</option>";
                        $(row).appendTo("#dt_supplier");
                    });
                },

            });
        }

        function setuju() {
            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/confirmSetuju')}}',
                type: "POST",
                data: {
                    pr_idPlan: $('#pr_idPlan').val(),
                    pr_item: i_item,
                    pr_comp: pr_comp,
                    pr_supplier: $('#dt_supplier2').val(),
                    pr_price: $('#dt_harga').val(),
                    pr_qtyApp: $('#dt_qty').val(),
                    pr_stsConf: "CONFIRM",
                    _token: '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function (data) {
                    if (data.status == 'GAGAL') {
                        $('#overlay').fadeOut(200);

                        $.smallBox({
                            title: "Gagal",
                            content: "Upsss. data Gagal di tambahkan",
                            color: "#A90329",
                            timeout: 5000,
                            icon: "fa fa-times bounce animated"
                        });
                    } else {

                        // var rule = 	$('#detailModal').modal('hide');
                        $('#detailModal').modal('hide');
                        $.smallBox({
                            title: "Berhasil",
                            content: 'Data telah ditambahkan...!',
                            color: "#739E73",
                            timeout: 4000,
                            icon: "fa fa-check bounce animated"
                        });
                        $('#table-rencana').DataTable().ajax.reload();


                    }
                },

            });
        }


        function tolak() {
            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/confirmTolak')}}',
                type: "POST",
                data: {
                    pr_idPlan: $('#pr_idPlan').val(),
                    pr_item: i_item,
                    pr_comp: pr_comp,
                    pr_supplier: $('#dt_supplier2').val(),
                    pr_price: $('#dt_harga').val(),
                    pr_qtyApp: $('#dt_qty').val(),
                    pr_stsConf: "CONFIRM",
                    _token: '{{ csrf_token() }}'

                },
                dataType: "JSON",
                success: function (data) {
                    if (data.status == 'GAGAL') {
                        $('#overlay').fadeOut(200);

                        $.smallBox({
                            title: "Gagal",
                            content: "Upsss. data Gagal di tambahkan",
                            color: "#A90329",
                            timeout: 5000,
                            icon: "fa fa-times bounce animated"
                        });
                    } else {

                        // var rule = 	$('#detailModal').modal('hide');
                        $('#detailModal').modal('hide');
                        $.smallBox({
                            title: "Berhasil",
                            content: 'Data telah ditambahkan...!',
                            color: "#739E73",
                            timeout: 4000,
                            icon: "fa fa-check bounce animated"
                        });
                        $('#table-rencana').DataTable().ajax.reload();


                    }
                },

            });
        }


        function calc(box) {
            one = document.autoSumForm.firstBox.value;
            two = document.autoSumForm.secondBox.value;
            // third = document.autoSumForm.thirdBox.value;

            if (box == 1) {
                if (one == "" || two == "") {
                    document.autoSumForm.thirdBox.value = "0";
                } else if (one == "" || two != "") {
                    document.autoSumForm.thirdBox.value = parseInt(one) * parseInt(two);
                } else if (one != "" || two == "") {

                    document.autoSumForm.thirdBox.value = parseInt(one) * parseInt(two);
                }

            } else if (box == 2) {
                if (one == "" || two == "") {
                    document.autoSumForm.thirdBox.value = "0";
                } else if (one == "" || two != "") {
                    document.autoSumForm.thirdBox.value = parseInt(one) * parseInt(two);
                } else if (one != "" || two == "") {

                    document.autoSumForm.thirdBox.value = parseInt(one) * parseInt(two);
                }

            }

        }

        function tampilSupplier() {
            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/tampilSupplier')}}',
                type: 'POST',
                data: {
                    'supplier': $('#dt_supplier').val(),
                    _token: '{{ csrf_token() }}'
                },
                dataType: "JSON",
                success: function (data) {
                    $('#pic').val(data.s_name);
                    $('#telepon').val(data.s_phone);
                    $('#fax').val(data.s_fax);
                    $('#alamat').val(data.s_address);
                }

            });
        }

        function simpanConfirm() {
            $.SmartMessageBox({
                title: "Konfirmasi Pembelian",
                content: "Apakah Anda Yakin Akan Mengajukan Confirm Order ?",
                buttons: '[Tidak][Ya]'
            }, function (ButtonPressed) {
                if (ButtonPressed === "Ya") {
                    var ar = $();
                    for (var i = 0; i < semua.rows()[0].length; i++) {
                        ar = ar.add(semua.row(i).node());
                    }
                    $.ajax({
                        url: '{{url('/pembelian/konfirmasi-pembelian/simpanConfirm')}}',
                        type: "GET",
                        data: ar.find('input').serialize() +'&'+ ar.find('select').serialize(),
                        dataType: "JSON",
                        success: function (data) {
                            if (data.status == 'sukses') {
                                $.smallBox({
                                	title: "Berhasil",
                                    content: 'Anda Telah Berhasil Mengajukan Request Order...!',
                                    color: "#739E73",
                                    timeout: 4000,
                                    icon: "fa fa-check bounce animated"
                                });
                                for(var i = 0; i < data.pcId.length; i++){
                                    window.open("{{url('/pembelian/konfirmasi-pembelian/print')}}"+"/"+data.pcId[i].idpc);
                                }
                                location.reload();

                            } else {
                                $.smallBox({
                                    title: "Gagal",
                                    content: 'Data gagal Di ajukan..!',
                                    color: "#C46A69",
                                    timeout: 4000,
                                    icon: "fa fa-check bounce animated"
                                });
                            }

                        },

                    });
                }

                if (ButtonPressed === "Tidak") {
                    $.smallBox({
                        title: "Peringatan...!!!",
                        content: "<i class='fa fa-clock-o'></i> <i>Anda Tidak Melakukan Pengajuan</i>",
                        color: "#C46A69",
                        iconSmall: "fa fa-times fa-2x fadeInRight animated",
                        timeout: 4000
                    });
                }

            });
        }


        function reload_data() {
            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/view_confirmAdd')}}',
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}'

                },
                dataType: "JSON",
                success: function (data) {
                    if (data.data == 'SUKSES') {
                        reload_data_trans();
                    } else {
                        $.smallBox({
                            title: "Peringatan...!!!",
                            content: "<i class='fa fa-clock-o'></i> <i>Anda Tidak Melakukan Pengajuan</i>",
                            color: "#C46A69",
                            iconSmall: "fa fa-times fa-2x fadeInRight animated",
                            timeout: 4000
                        });

                    }

                },

            });
        }

        function reload_table() {
            confirm.ajax.reload(null, false);
        }

        function editTable(id) {
            var input = $('#i_nama' + id).val();
            $.ajax({
                url: '{{url('/pembelian/konfirmasi-pembelian/editDumy')}}',
                type: "POST",
                data: {
                    'id': id,
                    'harga': input,
                    _token: '{{ csrf_token() }}'

                },
                dataType: "JSON",
                success: function (data) {
                    reload_table();
                },
            });
        }

    </script>

@endsection
