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

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/penjualan-reguler') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

				</div>

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
                                <form class="form-horizontal" id="form-penjualan">
                                    <fieldset>

                                        <div class="row">
                                            
                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                                <div class="form-group">
                                                    <div class="col-md-10">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="cari-salesman" placeholder="Masukkan Nama Sales" type="text"  style="text-transform: uppercase">
                                                                <input type="hidden" name="salesman" id="salesman" value="">
                                                                <input type="hidden" name="jenis_pembayaran" value="C">
                                                                <label for="salesman" class="glyphicon glyphicon-search" rel="tooltip" title="Nama Sales"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-10">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="cari-member" placeholder="Masukkan Nama Pembeli" type="text"  style="text-transform: uppercase">
                                                                <input type="hidden" value="" class="idMember" id="idMember" name="idMember">
                                                                <input type="hidden" name="id_group" id="id_group">
                                                                <label for="cari-member" class="glyphicon glyphicon-search" rel="tooltip" title="Nama Pembeli"></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                    <button type="button" data-toggle="modal" data-target="#DaftarMember" class="btn btn-primary" title="Tambah Pembeli"><i class="fa fa-user-plus"></i></button>
                                                    </div>
                                                    
                                                </div>
                                                <div id="detail_mem" style="display: none">
                                                    <div class="form-group">

                                                        <div class="col-md-12">

                                                            <label class="control-label text-left">Jenis Member</label>
                                                            &nbsp; &colon; &nbsp;
                                                            <strong id="jenis_member"></strong>
                                                            
                                                        </div>

                                                    </div>

                                                    <div class="form-group">

                                                        <div class="col-md-12">

                                                            <label class="control-label text-left">Alamat</label>
                                                            &nbsp; &colon; &nbsp;
                                                            <strong id="alamat"></strong>
                                                            
                                                        </div>

                                                    </div>
                                                </div>

                                            </article>

                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="pull-right">
                                                            <h1 class="font-400 total-tampil">Rp. 0</h1>
                                                            <input type="hidden" name="totalGross" id="totalGross">
                                                            <input type="hidden" name="totalHarga" id="totalHarga">
                                                        </div>
                                                    </div>
                                                </div>

                                            </article>

                                        </div>

                                        <div id="search_barang" style="display: none">
                                        
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="input-icon-left">
                                                        <i class="fa fa-barcode"></i>
                                                        <input class="form-control" onkeyup="setSearch()" id="cari-stock" placeholder="Masukkan Nama Barang" type="text"  style="text-transform: uppercase">
                                                        <input type="hidden" id="stockid" name="stockid">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-icon-left">
                                                        <i class="fa fa-sort-numeric-asc"></i>
                                                        <input class="form-control" placeholder="Qty" id="qty" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" id="tambahketable" class="btn btn-primary" onclick="tambah()"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <table class="table table-responsive table-striped table-bordered" id="table-penjualan">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 32%;">Nama Barang</th>
                                                        <th style="width: 8%;">Qty</th>
                                                        <th style="width: 15%;">Harga @</th>
                                                        @if(Auth::user()->m_level === 1 OR Auth::user()->m_level === 2 OR Auth::user()->m_level === 3 OR Auth::user()->m_level == 4)
                                                        <th style="width: 8%;">Diskon %</th>
                                                        <th style="width: 12%;">Diskon Rp</th>
                                                        @endif
                                                        <th style="width: 15%;">Total</th>
                                                        <th style="width: 10%;">Aksi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary" type="button" onclick="detailPembayaran()">
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

    <!-- Modal Detail Pembayaran -->
    <div class="modal fade" id="DetailPembayaran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Detail Pembayaran</h4>
                </div>
                <div class="modal-body kontenpembayaran">
                
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- End modal detail pembayaran -->

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
                                        <input class="form-control" id="nomor-member" placeholder="MASUKKAN NOMOR TELEPHONE YANG BISA DIHUBUNGI" type="text">
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
    var namaGlobal = null;
    var qtyGlobal = null;
    var idGlobal = [];
    var idItem = [];
    var iCode = [];
    var arrCode = [];
    var arrIdStock = [];
    var arrKodeGlobal = [];
    var spkode = [];
    var hargaGlobal = null;
    var stockGlobal = null;
    var kodespesifikGlobal = null;
    var kodeGlobal = null;
    var spesifikGlobal = null;
    var searchGlobal = null;

    $(document).ready(function(){
        $('.togel').click();


        if ($("#stockid").val() == "") {
			$("#tambahketable").attr('disabled', true);
		}
        $("#cari-salesman").focus();
        
        $( "#cari-salesman" ).autocomplete({
            source: baseUrl+'/penjualan-reguler/cari-sales',
            minLength: 1,
            select: function(event, data) {
                $("#salesman").val(data.item.id);
                $("#cari-member").focus();
            },
            open: function(){
                $(this).autocomplete('widget').zIndex(10);
            }
        });

        $( "#cari-member" ).autocomplete({
            source: baseUrl+'/penjualan-reguler/cari-member',
            minLength: 1,
            select: function(event, data) {
                getData(data.item);
                getDetailMember(data.item.id);

            }
        });

        $( "#cari-stock" ).autocomplete({
            source: function(request, response) {
                $.getJSON(baseUrl+'/penjualan-reguler/cari-stock', { jenis: $("#id_group").val(), term: $("#cari-stock").val() },
                    response);
            },
            minLength: 1,
            select: function(event, data) {
                setStock(data.item);
                $("#stockid").val(data.item.id);
				if ($("#stockid").val() == "") {
					$("#tambahketable").attr('disabled', true);
				} else {
					$("#tambahketable").attr('disabled', false);
				}
            }
        });

        function getDetailMember(id)
        {
            $("#detail_mem").hide("slow");
            $("#search_barang").hide("slow");
            $("#cari-stock").val("");
            $("#qty").val("");
            axios.get(baseUrl+'/penjualan-reguler/getdetailmember/'+id)
            .then(function (response) {
                // handle success
                // console.log(response.data.jenis);
                $("#jenis_member").text(response.data.jenis);
                $("#id_group").val(response.data.id_group);
                $("#alamat").text(response.data.alamat);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                $("#detail_mem").show("slow");
                $("#search_barang").show("slow");
                $("#cari-stock").focus();
            });

        }
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

        var price = 0;
        if (data.i_code == "") {
            namaGlobal = data.i_nama;
        } else {
            namaGlobal = data.i_code+" - "+data.i_nama;
        }

        iCode = data.i_code;

        if(data.gp_price != null) {
            price = data.gp_price;
        } else if (data.op_price != null) {
            price = data.op_price;
        } else {
            price = data.i_price;
        }
        hargaGlobal = parseInt(price);
        idGlobal = data.s_id;
        idItem = data.i_id;
        kodespesifikGlobal = data.sd_specificcode;
        spesifikGlobal = data.i_specificcode;
        kodeGlobal = data.sm_specificcode;
        arrCode.push(data.i_code);
        arrIdStock.push(data.s_id);
        setArrayId();
    }

    function setSearch(){
        searchGlobal = $('#cari-stock').val();
    }

    $("#nomor-member").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $("#qty").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $("#qty").on("keyup",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which == 13)) {
            $('#tambahketable').click();
        }
    });

    $('#form-penjualan').on('submit', function (event) {
        return false;
    })

    $("#cari-stock").on('keyup',function(e) {

        if(e.which === 13) {
            var specificcode = $(this).val();
            var harga = 0;
            if (spkode.includes(specificcode) == true) {
                $.smallBox({
                    title : "Pesan!",
                    content : "Item sudah ditambahkan",
                    color : "#A90329",
                    timeout: 5000,
                    icon : "fa fa-times bounce animated"
                });
                $(this).val("");
                return;
            }
            if (arrCode.includes(specificcode) == true) {

                var kuantitas = $(".qty-"+specificcode).val();
                var qty = parseInt(kuantitas) + 1;
                var hrg = $("."+specificcode).val();
                hrg = parseInt(hrg);
                var discPercent = $(".discp-"+specificcode).val();
                    discPercent = discPercent.replace("%", "");
                var discValue = $(".discv-"+specificcode).val();
                    discPercent = discPercent.replace(".", "");

                if (discPercent == "") {
                    discPercent = 0;
                } else if (discPercent == 0) {
                    discPercent = 0;
                } else {
                    discPercent = parseInt(discPercent);
                }

                if (discValue == "") {
                    discValue = 0;
                } else if (discValue == 0) {
                    discValue = 0;
                } else {
                    discValue = parseInt(discValue);
                }

                if (discPercent == 0 && discValue == 0) {
                    harga += qty * hrg;
                } else if (discPercent != 0) {
                    harga += ((100 - discPercent)/100) * (hrg * qty);
                } else if (discValue != 0) {
                    harga += qty * hrg - discValue;
                }

                $('.totalItem-'+specificcode).val(harga);
                $(".qty-"+specificcode).val(qty);
                $(".harga-"+specificcode).text(convertToRupiah(parseInt(harga)));

                $(this).val("");
                updateTotalTampil();
            } else {
                searchStock();
            }
        }
    });

    function searchStock() {
        axios.get(baseUrl + '/penjualan-reguler/search-stock', {
            params: {
                term : $('#cari-stock').val(),
                jenis: $('#id_group').val(),
                _token : $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(function (response) {
            if (response.data.message == "Tidak ditemukan") {
                $.smallBox({
                    title : "Gagal",
                    content : "Upsss. Barang tidak ditemukan",
                    color : "#A90329",
                    timeout: 5000,
                    icon : "fa fa-times bounce animated"
                });
            } else {
                setStock(response.data[0]);
                $("#stockid").val(response.data[0].data.id);
                tambah();
            }
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
            // always executed
        });

    }

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

    function tambah() {
        qtyGlobal = $('#qty').val();
        if (qtyGlobal === null || qtyGlobal === "") {
            qtyGlobal = 1;
        }
        if (qtyGlobal > stockGlobal){
            qtyGlobal = stockGlobal;
        }
        var row = '';
        if (spesifikGlobal == 'N'){
            var inputs = document.getElementsByClassName( 'idStock' ),
                idStock  = [].map.call(inputs, function( input ) {
                    return parseInt(input.value);
                });
            if (idStock.includes(idGlobal)){
                var qtyawal = $('.qty-'+idGlobal).val();
                qtyakhir = parseInt(qtyawal) + parseInt(qtyGlobal);
                if (qtyakhir > stockGlobal){
                    qtyakhir = stockGlobal;
                }
                $('.qty-'+idGlobal).val(qtyakhir);
                var harga = qtyakhir * hargaGlobal;
                $('.totalItem-'+idGlobal).val(harga);
                harga = toRupiah(harga);
                $('.harga-'+idGlobal).html('Rp.<p style="float: right">'+harga+'</p>');

                updateTotalTampil();
            } else {
                row = '<tr id="'+idGlobal+'" class="tr">' +
                    '<td style="width: 32%;">'+namaGlobal+
                    '<input type="hidden" class="idStock" name="idStock[]" value="'+idGlobal+'" />'+
                    '<input type="hidden" class="qtystock" name="qtystock[]" value="'+stockGlobal+'" />'+
                    '<input type="hidden" class="kode" name="kode[]" value="'+kodespesifikGlobal+'" />'+
                    '<input type="hidden" class="harga '+iCode+'" id="harga-'+idGlobal+'" name="harga[]" value="'+hargaGlobal+'" />'+
                    '<input type="hidden" class="grossItem" name="grossItem[]" id="grossItem-'+idGlobal+'" value="'+qtyGlobal * hargaGlobal+'">'+
                    '<input type="hidden" class="totalItem totalItem-'+iCode+' totalItem-'+idGlobal+'" name="totalItem[]" id="totalItem-'+iCode+'" value="'+qtyGlobal * hargaGlobal+'">'+
                    '</td>' +
                    '<td style="width: 8%;"><input style="width: 100%; text-align: center;" onkeyup="ubahQty(\''+stockGlobal+'\', \'harga-'+idGlobal+'\', \'qty-'+idGlobal+'\', \'discp-'+idGlobal+'\', \'discv-'+idGlobal+'\', \'lbltotalItem-'+idGlobal+'\', \'totalItem-'+idGlobal+'\', \'grossItem-'+idGlobal+'\')" type="text" class="qtyTable qty-'+idGlobal+' qty-'+iCode+'" id="qty-'+idGlobal+'" name="qtyTable[]" value="'+qtyGlobal+'" /></td>' +
                    '<td style="width: 15%;">Rp.<p style="float: right">'+toRupiah(hargaGlobal)+'</p></td>' +
                    '@if(Auth::user()->m_level === 1 OR Auth::user()->m_level === 2 OR Auth::user()->m_level === 3 OR Auth::user()->m_level == 4)<td style="width: 8%;"><input style="width: 100%; text-align: right" type="text" onkeyup="isiDiscp(\'discp-'+idGlobal+'\', \'discv-'+idGlobal+'\', \'qty-'+idGlobal+'\', \'harga-'+idGlobal+'\', \'lbltotalItem-'+idGlobal+'\', \'totalItem-'+idGlobal+'\')" class="discp discp-'+iCode+'" data-id="'+idGlobal+'" id="discp-'+idGlobal+'" name="discp[]" value="0%" /></td>@endif' +
                    '@if(Auth::user()->m_level === 1 OR Auth::user()->m_level === 2 OR Auth::user()->m_level === 3 OR Auth::user()->m_level == 4)<td style="width: 12%;"><input style="width: 100%; text-align: right" type="text" onkeyup="isiDiscv(\'discp-'+idGlobal+'\', \'discv-'+idGlobal+'\', \'qty-'+idGlobal+'\', \'harga-'+idGlobal+'\', \'lbltotalItem-'+idGlobal+'\', \'totalItem-'+idGlobal+'\')" class="discv discv-'+iCode+'" data-id="'+idGlobal+'" id="discv-'+idGlobal+'" name="discv[]" value="0" /></td>@endif' +
                    '<td style="width: 15%;" id="lbltotalItem-'+idGlobal+'" class="harga-'+idGlobal+' harga-'+iCode+'">Rp.<p style="float: right">'+toRupiah(qtyGlobal * hargaGlobal)+'</p></td>' +
                    '<td style="width: 10%;" class="text-center"><button type="button" onclick="hapus('+idGlobal+')" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>';

                $("#table-penjualan tbody").append(row);
                $('.discp').maskMoney({thousands:'', precision: 0, decimal:',', allowZero:true, suffix: '%'});
                $('.discv').maskMoney({thousands:'', precision: 0, decimal:',', allowZero:true});

                $(".qtyTable").on("keypress keyup blur",function (event) {
                    $(this).val($(this).val().replace(/[^\d].+/, ""));
                    if ((event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });
                setArrayId();
            }
        } else {
            if (arrKodeGlobal.includes(kodeGlobal) == true) {
                $.smallBox({
                    title : "Pesan!",
                    content : "Item sudah ditambahkan",
                    color : "#A90329",
                    timeout: 5000,
                    icon : "fa fa-times bounce animated"
                });

            } else {
                var id = idGlobal+kodeGlobal;
                row = '<tr id="'+id+'" class="tr">' +
                    '<td style="width: 32%;">'+namaGlobal+' '+kodespesifikGlobal+''+
                    '<input type="hidden" class="idStock" name="idStock[]" value="'+idGlobal+'" />'+
                    '<input type="hidden" class="qtystock" name="qtystock[]" value="'+stockGlobal+'" />'+
                    '<input type="hidden" class="kode" name="kode[]" value="'+kodeGlobal+'" />'+
                    '<input type="hidden" class="spesifikkode" name="spesifikkode[]" value="'+kodeGlobal+'" />'+
                    '<input type="hidden" class="harga" id="harga-'+idGlobal+'" name="harga[]" value="'+hargaGlobal+'" />'+
                    '<input type="hidden" class="grossItem" name="grossItem[]" id="grossItem-'+idGlobal+'" value="'+hargaGlobal+'">'+
                    '<input type="hidden" class="totalItem" name="totalItem[]" id="totalItem-'+idGlobal+'" value="'+hargaGlobal+'">'+
                    '</td>' +
                    '<td style="width: 8%;" class="text-center"><input style="width: 100%; text-align: center;" type="hidden" class="qtyTable" id="qty-'+idGlobal+'" name="qtyTable[]" value="1" />1</td>' +
                    '<td style="width: 15%;">Rp.<p style="float: right">'+toRupiah(hargaGlobal)+'</p></td>' +
                    '@if(Auth::user()->m_level === 1 OR Auth::user()->m_level === 2 OR Auth::user()->m_level === 3 OR Auth::user()->m_level == 4)<td style="width: 8%;"><input style="width: 100%; text-align: right" type="text" onkeyup="isiDiscp(\'discp-'+idGlobal+'\', \'discv-'+idGlobal+'\', \'qty-'+idGlobal+'\', \'harga-'+idGlobal+'\', \'lbltotalItem-'+idGlobal+'\', \'totalItem-'+idGlobal+'\')" class="discp discp-'+iCode+'"  data-id="'+idGlobal+'" id="discp-'+idGlobal+'" name="discp[]" value="0%" /></td>@endif' +
                    '@if(Auth::user()->m_level === 1 OR Auth::user()->m_level === 2 OR Auth::user()->m_level === 3 OR Auth::user()->m_level == 4)<td style="width: 12%;"><input style="width: 100%; text-align: right" type="text" onkeyup="isiDiscv(\'discp-'+idGlobal+'\', \'discv-'+idGlobal+'\', \'qty-'+idGlobal+'\', \'harga-'+idGlobal+'\', \'lbltotalItem-'+idGlobal+'\', \'totalItem-'+idGlobal+'\')" class="discv discv-'+iCode+'"  data-id="'+idGlobal+'" id="discv-'+idGlobal+'" name="discv[]" value="0" /></td>@endif' +
                    '<td style="width: 15%;" id="lbltotalItem-'+idGlobal+'">Rp.<p style="float: right">'+toRupiah(hargaGlobal)+'</p></td>' +
                    '<td style="width: 10%;" class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="hapus('+id+')"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>';
                $("#table-penjualan tbody").append(row);
                $('.discp').maskMoney({thousands:'', precision: 0, decimal:',', allowZero:true, suffix: '%'});
                $('.discv').maskMoney({thousands:'', precision: 0, decimal:',', allowZero:true});
                setArrayId();
            }

        }
        $('#cari-stock').val('');
        $('#qty').val('');
        $('#cari-stock').focus();

        var inputs = document.getElementsByClassName( 'kode' ),
            kode  = [].map.call(inputs, function( input ) {
                return input.value;
            });

        $( "#cari-stock" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: '{{ url('penjualan-reguler/cari-stock') }}',
                    data: {
                        kode: kode,
                        jenis: $("#id_group").val(),
                        term: searchGlobal
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            minLength: 1,
            select: function(event, data) {
                setStock(data.item);
                $("#stockid").val(data.item.id);
				if ($("#stockid").val() == "") {
					$("#tambahketable").attr('disabled', true);
				} else {
					$("#tambahketable").attr('disabled', false);
				}
            }
        });
        $("#stockid").val("");
		if ($("#stockid").val() == "") {
			$("#tambahketable").attr('disabled', true);
		} else {
			$("#tambahketable").attr('disabled', false);
		}
        updateTotalTampil();
    }

    function setArrayId() {
        var inputs = document.getElementsByClassName('spesifikkode'),
            spesifikkode  = [].map.call(inputs, function( input ) {
                return input.value.toString();
            });
        spkode = spesifikkode;
        var inputs = document.getElementsByClassName('kode'),
            code  = [].map.call(inputs, function( input ) {
                return input.value.toString();
            });
        arrKodeGlobal = code;
        arrCode = code;
        $( "#cari-stock" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: '{{ url('penjualan-reguler/cari-stock') }}',
                    data: {
                        kode: code,
                        jenis: $("#id_group").val(),
                        term: searchGlobal
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            minLength: 1,
            select: function(event, data) {
                setStock(data.item);
                $("#stockid").val(data.item.id);
                if ($("#stockid").val() == "") {
                    $("#tambahketable").attr('disabled', true);
                } else {
                    $("#tambahketable").attr('disabled', false);
                }
            }
        });
    }

    function isiDiscp(discp, discv, qty, harga, lbltotItem, totItem) {
        var total = 0;
        var a = $("#"+discv).val(), quantity = parseInt($("#"+qty).val()), price = parseInt($("#"+harga).val()), disc = parseInt($("#"+discp).val().replace("%", ""));

        if (disc > 100) {
            $("#"+discp).val("100%");
        }
        
        if (a == "") {
            a = 0;
            
        } else {
            a = parseInt(a);
        }

        if(a != 0) {
            $("#"+discp).val("0%");
        } else if($("#"+discp).val().replace("%", "") == 0 && a == 0){
            total += price * quantity;
            $("#"+lbltotItem).html('Rp.<p style="float: right">'+toRupiah(total)+'</p>');
            $("#"+totItem).val(parseInt(total));
            // $(".total-tampil").text(convertToRupiah(total));
        } else {
            total += ((100 - disc)/100) * (price * quantity);
            $("#"+lbltotItem).html('Rp.<p style="float: right">'+toRupiah(total)+'</p>');
            $("#"+totItem).val(parseInt(total));
            // $(".total-tampil").text(convertToRupiah(total));
        }
        updateTotalTampil();

    }

    function isiDiscv(discp, discv, qty, harga, lbltotItem, totItem) {
        var total = 0;
        var a = $("#"+discp).val(), quantity = parseInt($("#"+qty).val()), price = parseInt($("#"+harga).val()), disc = $("#"+discv).val().replace('.', '');

        if (a == "") {
            a = "0%";
        }

        if(a != "0%") {
            $("#"+discv).val("0");
        } else {
            total += quantity * price - disc;
            $("#"+lbltotItem).html('Rp.<p style="float: right">'+toRupiah(total)+'</p>');
            $("#"+totItem).val(total);
        }
        updateTotalTampil();

    }

    function ubahQty(stock, hargaAwal, inputQty, discp, discv, lbltotalItem, totalItem, grossItem) {
        stock = parseInt(stock);

        var harga = 0;
        var input = parseInt($('#'+inputQty).val());
        var discPercent = $("#"+discp).val().replace("%", "");
        var discValue = $("#"+discv).val().replace(".", "");
        var awalHarga = $("#"+hargaAwal).val();
            awalHarga = parseInt(awalHarga);

        if (discPercent == "") {
            discPercent = 0;
        } else if (discPercent == 0) {
            discPercent = 0;
        } else {
            discPercent = parseInt(discPercent);
        }

        if (discValue == "") {
            discValue = 0;
        } else if (discValue == 0) {
            discValue = 0;
        } else {
            discValue = parseInt(discValue);
        }

        if (isNaN(input)){
            input = 0;
        }
        if (input > stock){
            input = stock;
            $('#'+inputQty).val(input);
        }

        if (discPercent == 0 && discValue == 0) {
            harga += input * awalHarga;
        } else if (discPercent != 0) {
            harga += ((100 - discPercent)/100) * (awalHarga * input);
        } else if (discValue != 0) {
            harga += input * awalHarga - discValue;
        }

        $('#'+grossItem).val(input * awalHarga);
        $('#'+totalItem).val(harga);
        $("#"+lbltotalItem).html('Rp.<p style="float: right">'+toRupiah(parseInt(harga))+'</p>');
        updateTotalTampil();
    }

    function hapus(id) {
        $('#'+id).remove();
        setArrayId();
        updateTotalTampil();
    }
    
    function updateTotalTampil() {
        var totalGross = 0;
        var totalHarga = 0;

        var inputs = document.getElementsByClassName( 'harga' ),
            arharga  = [].map.call(inputs, function( input ) {
                return input.value;
            });
        var inputs = document.getElementsByClassName( 'qtyTable' ),
            arqty  = [].map.call(inputs, function( input ) {
                return input.value;
            });
        var inputs = document.getElementsByClassName( 'totalItem' ),
            artotalItem  = [].map.call(inputs, function( input ) {
                return input.value;
            });

        for (var i = 0; i < arharga.length; i++){
            totalGross += (parseInt(arharga[i]) * parseInt(arqty[i]));
        }

        for (var i = 0; i < artotalItem.length; i++){
            totalHarga += parseInt(artotalItem[i]);
        }

        $("#totalGross").val(totalGross);
        $('.total-tampil').html(convertToRupiah(totalHarga));
        $("#totalHarga").val(totalHarga);
        
    }

    function detailPembayaran(){
        var total = $('#totalHarga').val();
        total = convertToAngka(total);
        if (isNaN(total)) {
            $.smallBox({
                title : "Peringatan!",
                content : "Lengkapi data penjualan regular",
                color : "#A90329",
                timeout: 5000,
                icon : "fa fa-times bounce animated"
            });
        } else {
            $.ajax({
                url: baseUrl + '/penjualan-reguler/detailPembayaran/'+total,
                timeout: 5000,
                type: 'get',
                success: function(response){
                    $('.kontenpembayaran').empty();
                    $('.kontenpembayaran').append(response);
                    $('#DetailPembayaran').modal('show');
                }, error:function(x, e) {
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
       
    }

    function simpanPenjualan() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: baseUrl + '/penjualan-reguler/simpan',
            type: 'post',
            data: $('#form-penjualan, #formDetailPembayaran').serialize(),
            success: function(response){
                if (response == "lengkapi data") {
                    $.smallBox({
                        title : "Peringatan!",
                        content : "Lengkapi data penjualan regular",
                        color : "#A90329",
                        timeout: 5000,
                        icon : "fa fa-times bounce animated"
                    });
                    $('#overlay').fadeOut(200);
                } else if (response == "false") {
                    $.smallBox({
                        title : "Gagal",
                        content : "Upsss. Terjadi kesalahan",
                        color : "#A90329",
                        timeout: 5000,
                        icon : "fa fa-times bounce animated"
                    });
                    $('#DetailPembayaran').modal('hide');
                    
                } else {
                    $.smallBox({
                        title : "Berhasil",
                        content : 'Transaksi Anda berhasil...!',
                        color : "#739E73",
                        timeout: 5000,
                        icon : "fa fa-check bounce animated"
                    });
                    $(".tr").remove();
                    $("#cari-salesman").val("");
                    $("#cari-member").val("");
                    $("#idMember").val("");
                    $("#detail_mem").hide("slow");
                    $("#search_barang").hide("slow");
                    $("#cari-salesman").focus();
                    updateTotalTampil();
                    cetak(response.salesman, response.idSales, response.totHarga, response.payment_method, response.payment, response.dibayar, response.kembali);
                    $('#DetailPembayaran').modal('hide');
                    
                }
            }, error:function(x, e) {
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

    function cetak(salesman, idSales, totHarga, payment_method, payment, dibayar, kembali){
        window.open(baseUrl + '/penjualan-reguler/struk/'+salesman+'/'+idSales+'/'+totHarga+'/'+payment_method+'/'+payment+'/'+dibayar+'/'+kembali, '', "width=800,height=600");
    }



</script>
@endsection
