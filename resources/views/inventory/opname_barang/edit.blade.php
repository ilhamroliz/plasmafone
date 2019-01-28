@extends('main')

@section('title', 'Pembuatan Rencana Penjualan')

@section('extra_style')
	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/MonthPicker.css') }}">
	<style>

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
			<li>Home</li><li>Inventory</li><li>Opname Barang Pusat</li>
		</ol>

	</div>
	<!-- END RIBBON -->
@endsection

@section('main_content')
    <div id="content">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <h1 class="page-title txt-color-blueDark">
                    <i class="fa-fw fa fa-cube"></i>
                    Inventory <span><i class="fa fa-angle-double-right"></i> Opname Barang Pusat </span>
                </h1>
            </div>

           <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">
				<div class="page-title">
					<a href="{{ url('/inventory/opname-barang/pusat') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>
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
                        <h2><strong>Form Edit Data Opname Barang Pusat</strong></h2>

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
                            <form id="trpForm" class="form-inline" role="form">
                                {{csrf_field()}}
                                <input type="hidden" id="idOpname" value="{{ $id }}">
                                <fieldset>
									 <div class="row no-padding margin-bottom-10 padding-bottom-10">
                                        <form id="formOsTambah">

                                        <div class="col-md-12">
                                            <label class="col-md-6">Nama Barang</label>

                                            <label class="col-md-6">Lokasi Barang</label>
                                        </div>

                                        <div class="col-md-12">

                                            <div class="col-md-6">
                                                <input type="hidden" id="idItem" name="idItem">
                                                <input type="text" class="form-control" id="nameItem" name="nameItem" placeholder="Masukkan Nama Item" style="text-transform: uppercase; width: 100%">
                                            </div>

                                            <div class="col-md-5">
                                                <input type="hidden" id="idComp" name="idComp" value="{{Auth::user()->m_comp}}">
                                                <input type="text" class="form-control" id="nameComp" name="nameComp" value="Plasmafone Pusat" style="text-transform: uppercase; width: 100%" readonly>
                                            </div>

                                            <div class="col-md-1">
                                                <a class="btn btn-primary" onclick="cariTambah()" style="width: 100%"><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- ======================================= -->
                                    <div
                                        id="divQtyHpp"
                                        class="row no-padding margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15"
                                        style="border-top: 1px solid black">

                                        <div class="col-md-6">
                                            <label class="col-md-3">Qty Sistem</label>
                                            <div class="col-md-9 no-padding">
                                                <input type="text" class="form-control text-align-right" id="osQtyS" name="osQtyS" style="width: 100%" readonly>
                                            </div>

                                            @if(Auth::user()->m_level < 5)
                                                <label class="col-md-3 margin-top-5">AKSI</label>
                                                <div class="col-md-9 no-padding margin-top-5">
                                                    <select name="aksiSelect" id="aksiSelect" class="form-control" style="width: 100%">
                                                        <option value="" selected disabled>== PILIH AKSI ==</option>
                                                        <option value="1">Samakan dengan SISTEM</option>
                                                        <option value="2">Samakan dengan REAL</option>
                                                    </select>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-md-3 no-padding margin-bottom-5 qtyR">Qty Real</label>
                                            <div class="col-md-9 margin-bottom-5 qtyR">
                                                <input type="text" class="form-control text-align-right" id="osQtyR" name="osQtyR" style="width: 100%">
                                            </div>

                                            <label class="col-md-3 no-padding">HPP</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control text-align-right" id="osHpp" name="osHpp" style="width: 100%">
                                            </div>

                                            <div class="col-md-3"></div>
                                            <div class="col-md-9">
                                                <div class="note">
                                                    HPP Terakhir adalah Rp. <strong id="hppNote"></strong>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- ======================================= -->
                                    <div class="col-md-12" id="divCodeTable">

                                        <table id="codeTable" class="table table-striped table-bordered table-hover codeTable" style="width: 100%">
                                            <thead>
                                                <tr>
													<th data-hide="phone,tablet" style="width: 80%">Specific Code</th>
                                                    <th data-hide="phone,tablet" style="width: 20%">Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody id="codeshowdata">
                                            </tbody>
                                        </table>

									</div>

									<div class="col-md-12 no-padding" id="divNote">
										<div class="col-md-1">
											<label><b>Catatan :</b></label>
										</div>

										<div class="col-md-11 inputGroupContainer">
											<div class="input-group" style="width: 100%">
												<textarea class="form-control" name="codeNote" id="codeNote" rows="2"></textarea>
											</div>
										</div>
									</div>
                                </fieldset>

								<div class="form-actions" id="divAksi" style="display:none">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="btn btn-block btn-primary text-center" onclick="simpanEOB()">Simpan Opname Barang</a>
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
		</div>

    </div>
@endsection

@section('extra_script')
<script src="{{ asset('template_asset/js/MonthPicker.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>

    <script type="text/javascript">
        var appr, pend;
		var codeTable;
		var apprTab, pendTab;
		var speccode, expired;
		var idItem, idComp;

        $(document).ready(function(){

			codeTable = $('#codeTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : true,
				"paging": false,
				"info" : false
			});

            $('#nameItem').autocomplete({
				// "option", "appendTo", ".eventInsForm",
                source: baseUrl+'/penjualan/pemesanan-barang/get-item',
                minLength: 2,
                select: function(event, data){
                    $('#idItem').val(data.item.id);
                }
			})

            $('.osCompName').autocomplete({
                source: baseUrl+'/man-penjualan/rencana-penjualan/auto-comp',
                minLength: 2,
                select: function(event, data){
                    $('#osCompId').val(data.item.id);
                }
            })

            var input = document.getElementById("nameItem");
			input.addEventListener("keyup", function(event) {
				event.preventDefault();
				if (event.keyCode === 13) {
					cariTambah();
				}
			});

            var id = $('#idOpname').val();
            axios.get(baseUrl+'/inventory/opname-barang/get-edit?id='+id).then((response) => {

				$('#idItem').val(response.data.edit[0].od_item);
				$('#nameItem').val(response.data.edit[0].i_nama);
                $('#idComp').val(response.data.edit[0].o_comp);
                $('#osHpp').val(accounting.formatMoney(response.data.hpp.sm_hpp, "", 0, ".", ","));
                $('#osHpp').maskMoney({precision: 0, thousands: '.'});
                $('#hppNote').val(accounting.formatMoney(response.data.hpp.sm_hpp, "", 0, ".", ","));
                $('#osQtyS').val(response.data.hpp.s_qty+' Unit');
                $('#osQtyR').maskMoney({precision: 0, thousands: '.', suffix: ' Unit'});

				document.getElementById("nameItem").readOnly = true;

                $('#idS').val(id);

                speccode = response.data.edit[0].i_specificcode;
				expired = response.data.edit[0].i_expired;

				if(response.data.edit[0].o_action == 'REAL'){
					$('#aksiSelect').val('2');
				}else if(response.data.edit[0].o_action == 'SYSTEM'){
					$('#aksiSelect').val('1');
				}

                if(response.data.edit[0].i_specificcode == 'Y'){
                    $('.qtyR').css("display", "none");

                    codeTable.clear();
                    $('#codeTable').css("display", "block");

                    for(var i = 0; i < response.data.edit.length; i++){

                        if(i == 0){

                            codeTable.row.add([
                                '<td><input type="text" class="form-control imeiR" name="imeiR[]" style="width:100%; text-transform: uppercase" onkeypress="handleEnterC(event)" value="'+response.data.edit[0].od_specificcode+'"></td>',
                                '<td><a class="btn btn-success" onclick="addRowCode()" style="width:100%"><i class="fa fa-plus"></i></a></td>'
                            ]).draw(false);

                        }else{

                            codeTable.row.add([
                                '<td><input type="text" class="form-control imeiR" name="imeiR[]" style="width:100%; text-transform: uppercase" onkeypress="handleEnterC(event)" value="'+response.data.edit[i].od_specificcode+'"></td>',
                                '<td><a class="btn btn-success" onclick="addRowCode()" style="width:47%; margin-right: 6%"><i class="fa fa-plus"></i></a><a class="btn btn-danger btnhapus" style="width:47%"><i class="fa fa-minus"></i></a></td>'
                            ]).draw(false);
                        }

                    }

                }else{

                    $('#codeTable').css("display", "none");
                    $('#osQtyR').val(response.data.edit[0].od_qty_real+' Unit');
                    $('.qtyR').css("display", "block");
                }

                $('#divQtyHpp').css("display", "block");
				$('#divAksi').css("display", "block");

			});

		});


		function addRowCode(){

			codeTable.row.add([
				'<td><input type="text" class="form-control imeiR" name="imeiR[]" style="width:100%; text-transform: uppercase" onkeypress="handleEnterC(event)"></td>',
				'<td><a class="btn btn-success" onclick="addRowCode()" style="width:47%; margin-right: 6%"><i class="fa fa-plus"></i></a><a class="btn btn-danger btnhapus" style="width:47%"><i class="fa fa-minus"></i></a></td>'
			]).draw(false);
            $('tbody#codeshowdata tr:last td:first input').focus();

		}

        function handleEnterC(e){
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                addRowCode();
                // $(this).next('input').focus();
            }
        }

		$('.codeTable tbody').on( 'click', 'a.btnhapus', function () {
			codeTable.row( $(this).parents('tr') ).remove().draw();
            $('tbody#codeshowdata tr:last td:first input').focus();
		});

		{{-- $('#aksiSelect').on('change', function (e) {
			if($('#aksiSelect').val() == '1'){
				$('#divCodeTable').css("display", "none");
			}else{
				cariTambah();
			}
        }); --}}
        

		function simpanEOB(){

            $('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Menyimpan Data...');

            var id = $('#idOpname').val();
			var QtyS = $('#osQtyS').val();
			var QtyR = $('#osQtyR').val();
			var idItem = $('#idItem').val();
			var idComp = $('#idComp').val();
			var aksi = $('#aksiSelect').val();
            var hpp = $('#osHpp').val();
			var note = '';

			var ar = $();
			var dataTab = '';
			if(speccode == 'Y'){
				for (var i = 0; i < codeTable.rows()[0].length; i++) {
					ar = ar.add(codeTable.row(i).node())
				}
				note = $('#noteC').val();
                var dataTab = ar.find('select,input,textarea').serialize();
			}

			var data = ar.find('select,input,textarea').serialize() +'&qtyR='+QtyR+'&qtyS='+QtyS+'&idItem='+idItem+'&idComp='+idComp+'&aksi='+aksi+'&note='+note+'&sc='+speccode+'&ex='+expired+'&hpp='+hpp+'&id='+id;

			axios.post(baseUrl+'/inventory/opname-barang/edit', data)
			.then((response) => {

				if(response.data.status == 'eobSukses'){
					$('#tambahModal').modal('hide');
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Data Opname Barang Berhasil Disimpan...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
                    });
                    location.reload();
				}else{
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Maaf, Opname Barang Gagal Disimpan ",
						color : "#A90329",
						timeout: 4000,
						icon : "fa fa-times bounce animated"
					});
				}

			});

        }

    </script>
@endsection
