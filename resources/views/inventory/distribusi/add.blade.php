@extends('main')

@section('title', 'Tambah Distribusi Barang')

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
            <li>Home</li><li>Inventory</li><li>Tambah Distribusi Barang</li>
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
                    Inventory <span><i class="fa fa-angle-double-right"></i> Tambah Distribusi Barang </span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

				<div class="page-title">

					<a href="{{ url('/distribusi-barang') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

				</div>

			</div>
        </div>
        <!-- widget grid -->
        <section id="widget-grid" class="">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                        <header>
                            <h2><strong>Tambah Distribusi Barang</strong></h2>
                        </header>
                        <div role="content">
                            <!-- widget content -->
                            <div class="widget-body">
                                <form class="form-horizontal" id="form-distribusi">
									{{ csrf_field()}}
                                    <fieldset>

                                        <div class="row">
                                            
                                            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                                                <div class="form-group">
                                                    <div class="col-md-10">
                                                        <div class="input-group input-group-md">
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-send"></i></span>
                                                            <div class="icon-addon addon-md">
                                                                <input class="form-control" id="cari-outlet" placeholder="Masukkan Nama Outlet Tujuan" type="text"  style="text-transform: uppercase">
                                                                <input type="hidden" name="outlet" id="outlet" value="">
                                                                <label for="cari-outlet" class="glyphicon glyphicon-search" rel="tooltip" title="Cari Outlet"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="detail_outlet" style="display: none">
                                                    <div class="form-group">

                                                        <div class="col-md-12">

                                                            <label class="control-label text-left">Nama Outlet</label>
                                                            &nbsp; &colon; &nbsp;
                                                            <strong id="nama_outlet"></strong>
                                                            
                                                        </div>

													</div>
													
													<div class="form-group">

                                                        <div class="col-md-12">

                                                            <label class="control-label text-left">No. Telp.</label>
                                                            &nbsp; &colon; &nbsp;
                                                            <strong id="telp"></strong>
                                                            
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
                                                <table class="table table-responsive table-striped table-bordered" id="table-distribusi">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 32%;">Nama Barang</th>
                                                        <th style="width: 8%;">Qty</th>
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
                                                <button class="btn btn-primary" type="button" onclick="simpan()">
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
@endsection

@section('extra_script')
    <script>
    var namaGlobal = null;
    var qtyGlobal = null;
    var idGlobal = [];
    var idItem = [];
    var iCode = [];
    var arrCode = [];
    var hargaGlobal = null;
    var stockGlobal = null;
    var kodespesifikGlobal = null;
    var kodeGlobal = null;
    var spesifikGlobal = null;
    var searchGlobal = null;

    $(document).ready(function(){
        $("#cari-outlet").val("");
		if ($("#stockid").val() == "") {
			$("#tambahketable").attr('disabled', true);
		}

        $("#cari-outlet").focus();

        $( "#cari-outlet" ).autocomplete({
            source: baseUrl+'/distribusi-barang/cari-outlet',
            minLength: 1,
            select: function(event, data) {
                getData(data.item);
                getDetailOutlet(data.item);
            }
        });

        $( "#cari-stock" ).autocomplete({
            source: baseUrl+'/distribusi-barang/cari-stock',
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

        function getDetailOutlet(data)
        {
            $("#detail_outlet").hide("slow");
            $("#search_barang").hide("slow");
            $("#cari-stock").val("");
            $("#qty").val("");
			$("#nama_outlet").text(data.nama);
			$("#telp").text(data.telp);
			$("#alamat").text(data.alamat);
			$("#detail_outlet").show("slow");
			$("#search_barang").show("slow");
			// $("#cari-stock").focus();
        }
    })

    function setStock(info){
        var data = info.data;
        var price = 0;
        if (data.i_code == "") {
            namaGlobal = data.i_nama;
        } else {
            namaGlobal = data.i_code+" - "+data.i_nama;
        }
        
        stockGlobal = data.s_qty;

        if(data.gp_price != null) {
            price = data.gp_price;
        } else if (data.gp_price != null) {
            price = data.gp_price;
        } else {
            price = data.i_price;
        }
        hargaGlobal = parseInt(price);

        iCode = data.i_code;
        idGlobal = data.s_id;
        idItem = data.i_id;
        kodespesifikGlobal = data.sd_specificcode;
        spesifikGlobal = data.i_specificcode;
        kodeGlobal = data.sm_specificcode;
        arrCode.push(data.i_code);
    }

    function cekIsiArrayItem(data){
        var hitung = arrCode.length;
        for (var i = 0; i <= hitung; i++) {
            if (arrCode[i] == data) {
               return 'sudah';
            }
        }
        return 'lanjut';
    }

    function setSearch(){
        searchGlobal = $('#cari-stock').val();
    }

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

    $('#form-distribusi').on('submit', function (event) {
        return false;
    });

    $("#cari-stock").on('keyup',function(e) {
        if(e.which === 13) {
            var specificcode = $(this).val();
            if (cekIsiArrayItem(specificcode) == "sudah") {
                var kuantitas = $(".qty-"+specificcode).val();
                var qty = parseInt(kuantitas) + 1;
        
                $(".qty-"+specificcode).val(qty);
                
                $(this).val("");
            } else {
                searchStock();
            }
        }
    });

    function searchStock() {
		if ($('#cari-stock').val() != "") {
			axios.get(baseUrl + '/distribusi-barang/search-stock', {
				params: {
					term : $('#cari-stock').val(),
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
        
    }

    function getData(data) {
        $('#outlet').val(data.id);
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
            } else {
                row = '<tr id="'+idGlobal+'" class="tr">' +
                    '<td style="width: 32%;">'+namaGlobal+
                    '<input type="hidden" class="idStock" name="idStock[]" value="'+idGlobal+'" />'+
                    '<input type="hidden" class="qtystock" name="qtystock[]" value="'+stockGlobal+'" />'+
                    '<input type="hidden" class="kode" name="kode[]" value="'+kodespesifikGlobal+'" />'+
                    '<input type="hidden" class="harga '+iCode+'" id="harga-'+idGlobal+'" name="harga[]" value="'+hargaGlobal+'" />'+
                    '</td>' +
                    '<td style="width: 8%;"><input style="width: 100%; text-align: center;" onkeyup="ubahQty(\''+stockGlobal+'\', \'harga-'+idGlobal+'\', \'qty-'+idGlobal+'\', \'discp-'+idGlobal+'\', \'discv-'+idGlobal+'\', \'lbltotalItem-'+idGlobal+'\', \'totalItem-'+idGlobal+'\', \'grossItem-'+idGlobal+'\')" type="text" class="qtyTable qty-'+idGlobal+' qty-'+iCode+'" id="qty-'+idGlobal+'" name="qtyTable[]" value="'+qtyGlobal+'" /></td>' +
                    '<td style="width: 10%;" class="text-center"><button type="button" onclick="hapus('+idGlobal+')" class="btn btn-danger btn-xs"><i class="fa fa-minus"></i></button></td>' +
                    '</tr>';

                $("#table-distribusi tbody").append(row);

                $(".qtyTable").on("keypress keyup blur",function (event) {
                    $(this).val($(this).val().replace(/[^\d].+/, ""));
                    if ((event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });
            }
        } else {
            row = '<tr id="'+kodeGlobal+'" class="tr">' +
                '<td style="width: 32%;">'+namaGlobal+' '+kodespesifikGlobal+''+
                '<input type="hidden" class="idStock" name="idStock[]" value="'+idGlobal+'" />'+
                '<input type="hidden" class="qtystock" name="qtystock[]" value="'+stockGlobal+'" />'+
                '<input type="hidden" class="kode" name="kode[]" value="'+kodeGlobal+'" />'+
                '<input type="hidden" class="harga" id="harga-'+idGlobal+'" name="harga[]" value="'+hargaGlobal+'" />'+
                '</td>' +
                '<td style="width: 8%;" class="text-center"><input style="width: 100%; text-align: center;" type="hidden" class="qtyTable" id="qty-'+idGlobal+'" name="qtyTable[]" value="1" />1</td>' +
                '<td style="width: 10%;" class="text-center"><button type="button" class="btn btn-danger btn-xs" onclick="hapus(\''+kodeGlobal+'\')"><i class="fa fa-minus"></i></button></td>' +
                '</tr>';
            $("#table-distribusi tbody").append(row);

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
                    url: '{{ url('distribusi-barang/cari-stock') }}',
                    data: {
                        kode: kode,
                        term: searchGlobal
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            minLength: 2,
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
    }

    function ubahQty(stock, inputQty) {
        stock = parseInt(stock);

        var input = parseInt($('#'+inputQty).val());

        if (isNaN(input)){
            input = 0;
        }
        if (input > stock){
            input = stock;
            $('#'+inputQty).val(input);
        }
    }

    function hapus(id) {
        $('#'+id).remove();
    }

    function simpan() {
		$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan menyimpan data ini?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menghapus...');

					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						url: baseUrl + '/distribusi-barang/simpan',
						type: 'post',
						data: $('#form-distribusi').serialize(),
						success: function(response){
							if (response == "lengkapi data") {
								$.smallBox({
									title : "Peringatan!",
									content : "Lengkapi data distribusi barang",
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
								$('#overlay').fadeOut(200);
								
							} else {
								$.smallBox({
									title : "Berhasil",
									content : 'Transaksi Anda berhasil...!',
									color : "#739E73",
									timeout: 5000,
									icon : "fa fa-check bounce animated"
								});
								$(".tr").remove();
								$("#detail_mem").hide("slow");
								$("#search_barang").hide("slow");
								$("#detail_outlet").hide("slow");
            					$("#search_barang").hide("slow");
								$("#cari-outlet").val("");
								$("#cari-outlet").focus();
								$('#overlay').fadeOut(200);
                                console.log(response);
								cetak(response.id);
								
							}
						}, error:function(x, e) {
							if (x.status == 0) {
								alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
								$('#overlay').fadeOut(200);
							} else if (x.status == 404) {
								alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
								$('#overlay').fadeOut(200);
							} else if (x.status == 500) {
								alert('ups !! Server sedang mengalami gangguan. harap coba lagi nanti');
								$('#overlay').fadeOut(200);
							} else if (e == 'parsererror') {
								alert('Error.\nParsing JSON Request failed.');
								$('#overlay').fadeOut(200);
							} else if (e == 'timeout'){
								alert('Request Time out. Harap coba lagi nanti');
								$('#overlay').fadeOut(200);
							} else {
								alert('Unknow Error.\n' + x.responseText);
								$('#overlay').fadeOut(200);
							}
						}
					})

				}
	
			});
        
    }

	function updateTotalTampil() {
        var inputs = document.getElementsByClassName( 'qtyTable' ),
            arqty  = [].map.call(inputs, function( input ) {
                return input.value;
            });
        
    }

    function cetak(id){
        window.open(baseUrl + '/distribusi-barang/struk/'+id, '', "width=800,height=600");
    }

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
        return hasil;

    }

    function convertToAngka(rupiah)
    {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }
</script>
@endsection
