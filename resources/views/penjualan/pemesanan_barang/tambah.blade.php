@extends('main')

@section('title', 'Pemesanan Barang')

@section('extra_style')

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
            <li>Penjualan</li>
            <li>Pemesanan Barang</li>
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
                    <i class="fa-fw fa fa-handshake-o"></i>
                    Penjualan
                    <span>
						<i class="fa fa-angle-double-right"></i>
						Tambah Pemesanan Barang
					</span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">
                    <a href="{{ url('penjualan/pemesanan-barang') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

            <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-sortable="false" role="widget">
                    
                    <header role="heading">
                        <div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus "></i></a> <a href="javascript:void(0);" class="button-icon jarviswidget-fullscreen-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Fullscreen"><i class="fa fa-expand "></i></a>
                        </div>
                        <h2><strong>Form Tambah Pemesanan Barang</strong></h2>

                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form id="tpForm" class="form-inline" role="form">
                                {{csrf_field()}}
                                <fieldset>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 no-padding padding-bottom-10">										
                                            <div class="form-group col-md-12">
                                                <div class="col-md-5 inputGroupContainer">
                                                    <div class="input-group" style="width: 100%">
                                                        <span class="input-group-addon" style="width: 40px"><i class="fa fa-user"></i></span>
                                                        <input type="hidden" id="tpMemberId" name="tpMemberId">
													    <input type="text" class="form-control" id="tpMemberNama" name="tpMemberNama" style="width: 100%" placeholder="Masukkan Nama Member">												
                                                    </div>													
												</div>
												<div class="col-md-1">
													<a onclick="modal_tambah()" class="btn btn-success" title="Tambah Member" style="width:100%"><i class="fa fa-user-plus"></i></a>												
												</div>
                                                <div class="col-md-2">
                                                    <h4><strong>Total Tagihan</strong></h4>
                                                </div>
                                                <div class="col-md-1"><strong>:</strong></div>
                                                <div class="col-md-3">
                                                    <h4><strong>
                                                        <span style="float: left; width: 15%">
                                                            Rp.
                                                        </span>
                                                        <span style="float: right; width: 85%" class="text-align-right tpShowTagihan">

                                                        </span>
                                                    </strong></h4>		
                                                </div>										
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12 no-padding">
											<div class="form-group col-md-12">
												<div class="col-md-6 inputGroupContainer">
                                                    <div class="input-group" style="width: 100%">
                                                        <span class="input-group-addon" style="width: 40px"><i class="fa fa-barcode"></i></span>                                                        
                                                        <input type="hidden" id="tpItemId" name="tpItemId">
													    <input type="text" class="form-control" id="tpItemNama" name="tpItemNama" placeholder="Masukkan Nama/Kode Barang">
                                                    </div>                                                    
                                                </div>


                                                <div class="col-md-2">
                                                    <h4><strong>Pembayaran</strong></h4>
                                                </div>
                                                <div class="col-md-1"><strong>:</strong></div>
                                                <div class="col-md-3">
                                                    <div class="form-group"  style="width: 100%">
                                                        <select class="form-control" name="tpPembayaran" id="tpPembayaran">
                                                            <option value="" selected disabled>==== PILIH PEMBAYARAN ====</option>
                                                            <option value="lunas">LUNAS</option>
                                                            <option value="tidak">TIDAK LUNAS</option>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>
									
                                    <div class="col-md-12">

                                        <table id="tpTable" class="table table-striped table-bordered table-hover tpTable" width="100%">
                                            <thead>
                                                <tr>
													<th data-hide="phone,tablet" width="50%">Nama Barang</th>
                                                    <th data-hide="phone,tablet" width="25%">Harga Barang</th>													
                                                    <th data-hide="phone,tablet" width="15%">Jumlah Barang</th>
                                                    <th data-hide="phone,tablet" width="10%">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
									
                                    </div>
                                </fieldset>

								<div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-block btn-primary text-center" onclick="simpan_pemesanan()">Masukkan Pemesanan Barang</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!-- end widget content -->
                    </div>
                    <!-- end widget div -->
                </div>
            <!-- end widget -->
			</div>
			
			<!-- Modal Untuk Tambah Member -->
            <div class="modal fade" id="tmModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4><strong>Form Tambah Member</strong></h4>
                        </div>
                        <div class="modal-body no-padding">

                            <form id="tmForm" class="smart-form">
                                <fieldset>

                                    <section>
                                        <div class="row">
                                            <label class="label col col-3">Nama Member</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="namaMember" id="namaMember" style="text-transform: uppercase" placeholder="Masukkan Nama Member">
                                                </label>
                                            </div>
										</div>
									</section>

									<section>
										<div class="row">
                                            <label class="label col col-3">Nomor ID</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="noNIK" id="noNIK" placeholder="Masukkan Nomor Identitas Member (no KTP/SIM/dll)">
                                                </label>
                                            </div>
                                        </div>
									</section>
									
									<section>
										<div class="row">
                                            <label class="label col col-3">Nomor Telepon</label>
                                            <div class="col col-9 has-feedback">
                                                <label class="input">
                                                    <input type="text" name="noTelp" id="noTelp" placeholder="Masukkan Nomor Telepon/HP Member">
                                                </label>
                                            </div>
                                        </div>
									</section>

                                </fieldset>
                                
                                <footer>
                                    <a class="btn btn-primary" onclick="simpan_member()"><i class="fa fa-floppy-o"></i>
                                        Simpan
									</a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        Kembali
                                    </button>

                                </footer>
                            </form>						
                                    

                        </div>

                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- Akhir Modal untuk Tambah Group /.modal -->

        </div>

    </div>
    <!-- END MAIN CONTENT -->

@endsection

@section('extra_script')
<script src="{{ asset('template_asset/js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>


<script type="text/javascript">

	var table;
	$(document).ready(function () {

        $('.tpShowTagihan').html('0,00');

		table = $('#tpTable').DataTable({
			paging : false,
			searching : false
		});

		$( "#tpMemberNama" ).autocomplete({
			source: baseUrl+'/penjualan/pemesanan-barang/get-member',
			minLength: 2,
			select: function(event, data) {
				$('#tpMemberId').val(data.item.id);
				$('#tpMemberNama').val(data.item.label);
			}
		});

		$( "#tpItemNama" ).autocomplete({
			source: baseUrl+'/penjualan/pemesanan-barang/get-item',
			minLength: 2,
			select: function(event, data) {
				$('#tpItemId').val(data.item.id);
				$('#tpItemNama').val(data.item.label);
				dt_addBarang(data.item.id, data.item.label, data.item.harga);
			}
		});
	});

	function dt_addBarang(id, nama, harga){
		hargarp = accounting.formatMoney(harga, "", 2, ".", ",");
		table.row.add([
			nama+'<input type="hidden" name="idItem[]" class="idItem" value="'+id+'"><input type="hidden" class="hargaItem" name="hargaItem[]" value="'+harga+'">',
			'<div><span style="float: left;">Rp. </span><span style="float: right;">'+hargarp+'</span></div>',
			'<input type="text" min="1" class="form-control qtyItem" style="width: 100%; text-align: right;" name="qtyItem[]" value="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onkeyup="update_showHarga()">',
	        '<div class="text-center"><button type="button" class="btn btn-danger btn-circle btnhapus"><i class="fa fa-remove"></i></button></div>'		
		]).draw(false);

		var inputs = document.getElementsByClassName( 'idItem' ),
        names  = [].map.call(inputs, function( input ) {
            return input.value;
        });

        $( "#tpItemNama" ).autocomplete({
            source: function(request, response) {
                $.getJSON(baseUrl+'/penjualan/pemesanan-barang/get-item', { idItem: names, term: $("#tpItemNama").val() }, 
                          response);
            },
            minLength: 3,
            select: function(event, data) {
                $('#tpItemId').val(data.item.id);
                $('#tpItemNama').val(data.item.label);
                dt_addBarang(data.item.id, data.item.label, data.item.harga);
            }
        });

		$('#tpItemNama').val('');
        update_showHarga();
	}

	$('.tpTable tbody').on( 'click', 'button.btnhapus', function () {
        table
            .row( $(this).parents('tr') )
            .remove()
            .draw();
        var inputs = document.getElementsByClassName( 'idItem' ),
        names  = [].map.call(inputs, function( input ) {
            return input.value;
        });

        $( "#tpItemNama" ).autocomplete({
            source: function(request, response) {
                $.getJSON(baseUrl+'/penjualan/pemesanan-barang/get-item', { idItem: names, term: $("#tpItemNama").val() }, 
                          response);
            },
            minLength: 3,
            select: function(event, data) {
                $('#tpItemId').val(data.item.id);
                $('#tpItemNama').val(data.item.label);
                dt_addBarang(data.item.id, data.item.label, data.item.harga);
            }
        });
		$('#tpItemNama').val('');
        update_showHarga();
    });

	function update_showHarga(){
		var inputs = document.getElementsByClassName( 'hargaItem' ),
        hargaItem  = [].map.call(inputs, function( input ) {
            return input.value;
        });

        var inputs = document.getElementsByClassName( 'qtyItem' ),
        qtyItem  = [].map.call(inputs, function( input ) {
            return input.value;
        });

        var total = 0;

        for (var i = 0; i < hargaItem.length; i++) {
            total = total + (hargaItem[i] * qtyItem[i]);
		}
		
		totalrp = accounting.formatMoney(total, "", 2, ".", ",");

        $('.tpShowTagihan').html(totalrp);
	}

	function modal_tambah(){
		$('#tmModal').modal('show');
	}

	function simpan_member(){
		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyimpan Data...');

		var namaMember = $('#namaMember').val();
		var noTelp = $('#noTelp').val();
		var noNIK = $('#noNIK').val();

		if (namaMember == '' || noTelp == '' || noNIK == '') {
            $('#overlay').fadeOut(200);
            $.smallBox({
				title : "Perhatian !",
				content : "Mohon Lengkapi Data Member Terlebih Dahulu !",
				color : "#A90329",
				timeout: 4000,
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
        url: baseUrl + '/penjualan/pemesanan-barang/tambah-member',
        type: 'post',
        data: $('#tmForm').serialize(),
        success: function(response){
            if(response.status=='tmSukses'){

              	$('#overlay').fadeOut(200);
				$.smallBox({
					title : "Berhasil",
					content : 'Data Member Berhasil Disimpan...!',
					color : "#739E73",
					timeout: 4000,
					icon : "fa fa-check bounce animated"
				});

				$('#tmModal').modal('hide');
				$('#namaMember').val('');
				$('#noTelp').val('');
				$('#noNIK').val('');

            }else if(response.status=='nikAda'){

                $('#overlay').fadeOut(200);
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Data Member dengan NIK : "+response.member+", Sudah Ada !",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});

            }else if(response.status=='telpAda'){

                $('#overlay').fadeOut(200);
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Data Member dengan No. Telp : "+response.member+", Sudah Ada !",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});

            }else if(response.status=='tmGagal'){

                $('#overlay').fadeOut(200);
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Data Pemesanan Barang Gagal Disimpan ",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});

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
        });

	}

	function simpan_pemesanan(){

        $('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyimpan Data...');

		var namaMember = $('#tpMemberNama').val();
		var qty;
        var harga;

        var inputs = document.getElementsByClassName( 'hargaItem' ),
        harga  = [].map.call(inputs, function( input ) {
            return input.value;
        });

        var inputs = document.getElementsByClassName( 'qtyItem' ),
        qty  = [].map.call(inputs, function( input ) {
            return input.value;
        });

        if (harga.length <= 0) {
			$('#overlay').fadeOut(200);
            $.smallBox({
				title : "Gagal",
				content : "Data tidak dapat disimpan tanpa Masukan BARANG",
				color : "#A90329",
				timeout: 4000,
				icon : "fa fa-times bounce animated"
			});
            return false;
        }

        if (namaMember == '') {
            $('#overlay').fadeOut(200);
            $.smallBox({
				title : "Gagal",
				content : "Data tidak dapat disimpan tanpa Masukan MEMBER",
				color : "#A90329",
				timeout: 4000,
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
        url: baseUrl + '/penjualan/pemesanan-barang/tambah-pemesanan',
        type: 'post',
        data: $('#tpForm').serialize(),
        success: function(response){
            if(response.status=='tpSukses'){

              	$('#overlay').fadeOut(200);
				$.smallBox({
					title : "Berhasil",
					content : 'Data Pemesanan Barang Berhasil Disimpan...!',
					color : "#739E73",
					timeout: 4000,
					icon : "fa fa-check bounce animated"
				});
				location.reload();
                location.open("");

            }else if(response.status=='dpNull'){

                $('#overlay').fadeOut(200);
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Member belum pernah melakukan transaksi. Pembayaran harus LUNAS !",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});

            }else if(response.status=='tpGagal'){

                $('#overlay').fadeOut(200);
				$.smallBox({
					title : "Gagal",
					content : "Maaf, Data Pemesanan Barang Gagal Disimpan ",
					color : "#A90329",
					timeout: 4000,
					icon : "fa fa-times bounce animated"
				});

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
        });
    }

</script>

@endsection
