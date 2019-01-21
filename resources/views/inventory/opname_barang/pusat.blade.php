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

            @if(Plasma::checkAkses(11, 'insert') == true)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right padding-top-10">
                <button class="btn btn-success" onclick="tambah()"><i class="fa fa-plus"></i>&nbsp;Tambah Opname Pusat</button>
            </div>
            @endif

        </div>

        <section id="widget-grid" class="">

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

                        <header>
							<ul id="widget-tab-1" class="nav nav-tabs pull-left">
								<li class="active">
									<a data-toggle="tab" href="#hr1"> <i style="color: #C79121;" class="fa fa-lg fa-align-justify"></i> <span class="hidden-mobile hidden-tablet"> Pending </span></a>
                                </li>

								<li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #739E73;" class="fa fa-lg fa-check-square"></i> <span class="hidden-mobile hidden-tablet"> Approved </span> </a>
								</li>
							</ul>
                        </header>

                        <div>
                            <div class="widget-body no-padding">
								<form id="cariMPForm">
									<div class="col-md-12 no-padding padding-top-15">
										<div class="col-md-4">

											<div>
												<div class="input-group input-daterange" id="date-range">
													<input type="text" class="form-control" id="tglAwal" name="tglAwal" placeholder="Tanggal Awal" data-dateformat="dd/mm/yy" value="{{ $date }}">
													<span class="input-group-addon bg-custom text-white b-0">to</span>
													<input type="text" class="form-control" id="tglAkhir" name="tglAkhir" placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy" value="{{ $date }}">
												</div>
											</div>

										</div>

										<div class="col-md-4">
											<div class="form-group">
												<input type="hidden" id="osItemId" name="osItemId">
												<input type="text" class="form-control osItemName" placeholder="Masukkan Nama Barang" style="text-transform: uppercase">
											</div>
                                        </div>

                                        <div class="col-md-3">
											<div class="form-group">
												<input type="hidden" id="osCompId" name="osCompId" value="{{ Auth::user()->m_comp }}">
												<input type="text" class="form-control osCompName" value="PLASMAFONE PUSAT" readonly>
											</div>
										</div>

										<div class="col-md-1">
											<a class="btn btn-primary" onclick="cari()" style="width:100%"><i class="fa fa-search"></i></a>
										</div>
									</div>
								</form>

                                <div class="tab-content padding-10">

                                    <div class="tab-pane fade in active" id="hr1">
										<table id="pendTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th style="width: 15%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Opname</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Cabang</th>
													<th style="width: 35%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th style="width: 15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="pendshowdata">
											</tbody>

                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="hr2">

                                        <table id="apprTable" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 15%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;No. Nota</th>
													<th style="width: 15%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Opname</th>
                                                    <th style="width: 20%"><i class="fa fa-fw fa-building txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Cabang</th>
													<th style="width: 35%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Nama Item</th>
													<th style="width: 15%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
												</tr>
											</thead>

											<tbody id="apprshowdata">
											</tbody>

										</table>
									</div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </section>



		<!-- Modal untuk Detil Opname Barang -->
		<div class="modal fade" id="detilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Detail Opname Barang Pusat</h4>

					</div>

					<div class="modal-body">
						<div class="row">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-greenLight" id="wid-id-3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2 id="title_detail"></h2>
								</header>

								<!-- widget div-->
								<div>

									<!-- widget content -->
									<div class="widget-body no-padding">
										<div class="table-responsive">

											<div class="col-md-12 padding-top-10 ">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>No. Nota</strong></label>
													<label class="col-md-1">:</label>
													<label class="col-md-8" id="obNota"></label>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>Lokasi Barang</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obCabang"></label>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>Nama Barang</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obBarang"></label>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>Qty Sistem</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obQtyS"></label>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>Qty Real</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obQtyR"></label>
													</div>
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group">
													<label class="col-md-3" style="float:left"><strong>AKSI</strong></label>
													<label class="col-md-1">:</label>
													<div class="col-md-8">
														<label id="obAksi"></label>
													</div>
												</div>
											</div>

										</div>

										<!-- Tabel untuk detil opname barang-->
										<!-- TABEL C-->
										<div class="col-md-12">
											<table
												id="dobCTable"
												class="table table-striped table-bordered table-hover margin-top-10"
												style="display:none; margin-top: 20px;">

												<thead id="dobCHead">
													<th>No.</th>
													<th>Kode Spesifik</th>
												</thead>

												<tbody id="dobCBody">
												</tbody>

											</table>
										</div>

									</div>
									<!-- end widget content -->
								</div>
								<!-- end widget div -->
							</div>
							<!-- end widget -->
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
        <!-- /.modal -->



        <!-- Modal untuk Form Tambah Opname -->
		<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ui-front" id="modalWidth" style="width: 70%">
				<div class="modal-content" >
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Form Tambah Opname Barang Pusat</h4>

					</div>

					<div class="modal-body">
                        <div class="row no-padding margin-bottom-10 padding-bottom-10">
							<form id="formOsTambah">

							<div class="col-md-12">
								<label class="col-md-5">Lokasi Barang</label>

								<label class="col-md-7">Nama Barang</label>
							</div>

                            <div class="col-md-12">
								<div class="col-md-5">
									<input type="hidden" id="idComp" name="idComp" value="{{Auth::user()->m_comp}}">
									<input type="text" class="form-control" id="nameComp" name="nameComp" value="Plasmafone Pusat" style="text-transform: uppercase" readonly>
								</div>

								<div class="col-md-6">
                                    <input type="hidden" id="idItem" name="idItem">
                                    <input type="text" class="form-control" id="nameItem" name="nameItem" placeholder="Masukkan Nama Item" style="text-transform: uppercase">
                                </div>

                                <div class="col-md-1">
                                    <a class="btn btn-primary" onclick="cariTambah()" style="width: 100%"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                        </div>

						<!-- ////////////////////////////////////////////////////////////////////////////////////////
						== BAGIAN QTY HPP dll ==-->

                        <div
                            id="divQtyHpp"
                            class="row no-padding margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15"
                            style="border-top: 1px solid black; display: none">

                            <div class="col-md-6">
								<label class="col-md-4">Qty Sistem</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-align-right" id="osQtyS" name="osQtyS" readonly>
								</div>

								@if(Auth::user()->m_level < 5)
									<label class="col-md-4 margin-top-5">AKSI</label>
									<div class="col-md-8 margin-top-5">
										<select name="aksiSelect" id="aksiSelect" class="form-control">
											<option value="" selected disabled>== PILIH AKSI ==</option>
											<option value="1">Samakan dengan SISTEM</option>
											<option value="2">Samakan dengan REAL</option>
										</select>
									</div>
								@endif
                            </div>

							<div class="col-md-6">
								<label class="col-md-4 margin-bottom-5 qtyR" style="display:none">Qty Real</label>
                                <div class="col-md-8 margin-bottom-5 qtyR" style="display:none">
                                    <input type="text" class="form-control text-align-right" id="osQtyR" name="osQtyR">
								</div>

								<label class="col-md-4">HPP</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-align-right" id="osHpp" name="osHpp">
								</div>

								<div class="col-md-4"></div>
								<div class="col-md-8">
									<div class="note">
										HPP Terakhir adalah Rp. <strong id="hppNote"></strong>
									</div>
								</div>
                            </div>

                        </div>

						<!-- //////////////////// -->
						<!-- Bagian untuk TABLE's -->
                        <div
                            id="divTableExp"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions"
                            style="border-top: 1px solid black; display: none; ">

							<div class="col-md-8">
								<table id="expTable" class="table table-striped table-bordered table-hover expTable">
									<thead>
										<tr>
											<th style="width: 60%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Kadaluarsa</th>
											<th style="width: 15%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Jumlah Unit</th>
											<th style="width: 25%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
										</tr>
									</thead>

									<tbody id="expshowdata">
										<tr>
											<td class="text-align-left">
												<select name="" id="" style="width: 20%; float: left" class="form-control">
													<option value="" selected disabled>TGL</option>
												</select>
												<select name="" id="" style="width: 40%; float: left; margin-left: 4%" class="form-control">
													<option value="" selected disabled>BULAN</option>
												</select>
												<select name="" id="" style="width: 30%; float: left; margin-left: 4%" class="form-control">
													<option value="" selected disabled>TAHUN</option>
												</select>
											</td>
											<td>
												<input type="text" class="form-control qty" name="qty[]" style="width: 100%">
											</td>
											<td>
												<div class="text-center">
													<a class="btn btn-success" style="width: 100%" onclick="addRow()"><i class="fa fa-plus"></i></a>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-md-4 no-padding">
								<label class="col-md-12 text-align-left">Catatan</label>
								<div class="col-md-12">
									<textarea class="form-control" name="noteE" id="noteE" rows="5"></textarea>
								</div>
							</div>

						</div>

						<div
							id="divTableCode"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions"
							style="border-top: 1px solid black; display: none">


							<div class="col-md-6">
								<label class="col-md-12 no-padding text-align-left">Table Input IMEI</label>
								<table id="codeTable" class="table table-striped table-bordered table-hover codeTable">
									<thead>
										<tr>
											<th style="width: 50%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;IMEI Input</th>
											<th style="width: 20%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Aksi</th>
										</tr>
									</thead>

									<tbody id="codeshowdata">
									</tbody>
								</table>
							</div>

							<div class="col-md-6">
								<label class="col-md-12 text-align-left">Catatan</label>
								<div class="col-md-12">
									<textarea class="form-control" name="noteC" id="noteC" rows="5"></textarea>
								</div>
							</div>

						</div>


						<div
							id="divTableCodeExp"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions"
							style="border-top: 1px solid black; display: none">

							<div class="col-md-9">
								<table id="codeExpTable" class="table table-striped table-bordered table-hover codeExpTable">
									<thead>
										<tr>
											<th style="width: 20%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;IMEI Input</th>
											<th style="width: 50%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Kadaluarsa</th>
											<th style="width: 30%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Aksi</th>
										</tr>
									</thead>

									<tbody id="codeexpshowdata">

									</tbody>
								</table>
							</div>

							<div class="col-md-3 no-padding">
								<label class="col-md-12 text-align-left">Catatan</label>
								<div class="col-md-12">
									<textarea class="form-control" name="noteCE" id="noteCE" rows="5"></textarea>
								</div>
							</div>

						</div>

						</form>

                        <div
                            id="divBtnAksi"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions"
                            style="border-top: 1px solid black; display: none">

                            <button class="btn btn-primary" onclick="simpanOs()"><i class="fa fa-floppy-o"></i>&nbsp;Simpan</button>
                        </div>

					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->


		 <!-- Modal untuk Form EDIT Opname -->
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog ui-front" id="modalWidth" style="width: 70%">
				<div class="modal-content" >
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Form Edit Opname Barang Pusat</h4>

					</div>

					<div class="modal-body">
                        <div class="row no-padding margin-bottom-10 padding-bottom-10">
							<form id="formOsTambah">
                                <input type="hidden" id="idS">

							<div class="col-md-12">
								<label class="col-md-5">Lokasi Barang</label>

								<label class="col-md-7">Nama Barang</label>
							</div>

                            <div class="col-md-12">
								<div class="col-md-5">
									<input type="hidden" id="eobIdComp" name="eobIdComp" value="{{Auth::user()->m_comp}}">
									<input type="text" class="form-control" id="eobNameComp" name="eobNameComp" value="Plasmafone Pusat" style="text-transform: uppercase" readonly>
								</div>

								<div class="col-md-6">
                                    <input type="hidden" id="eobIdItem" name="eobIdItem">
                                    <input type="text" class="form-control" id="eobNameItem" name="eobNameItem" placeholder="Masukkan Nama Item" style="text-transform: uppercase">
                                </div>

                                <div class="col-md-1">
                                    <a class="btn btn-primary" onclick="cariTambah()" style="width: 100%"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                        </div>

						<!-- ////////////////////////////////////////////////////////////////////////////////////////
						== BAGIAN QTY HPP dll ==-->

                        <div
                            id="eobQtyHpp"
                            class="row no-padding margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15"
                            style="border-top: 1px solid black">

                            <div class="col-md-6">
								<label class="col-md-4">Qty Sistem</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-align-right" id="eobQtyS" name="eobQtyS" readonly>
								</div>

								@if(Auth::user()->m_level < 5)
									<label class="col-md-4 margin-top-5">AKSI</label>
									<div class="col-md-8 margin-top-5">
										<select name="eobAksiSelect" id="eobAksiSelect" class="form-control">
											<option value="" selected disabled>== PILIH AKSI ==</option>
											<option value="1">Samakan dengan SISTEM</option>
											<option value="2">Samakan dengan REAL</option>
										</select>
									</div>
								@endif
                            </div>

							<div class="col-md-6">
								<label class="col-md-4 margin-bottom-5 eobQtyR">Qty Real</label>
                                <div class="col-md-8 margin-bottom-5 eobQtyR">
                                    <input type="text" class="form-control text-align-right" id="eobQtyR" name="eobQtyR">
								</div>

								<label class="col-md-4">HPP</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control text-align-right" id="eobHpp" name="eobHpp">
								</div>

								<div class="col-md-4"></div>
								<div class="col-md-8">
									<div class="note">
										HPP Terakhir adalah Rp. <strong id="eobHppNote"></strong>
									</div>
								</div>
                            </div>

                        </div>

						<!-- //////////////////// -->
						<!-- Bagian untuk TABLE's -->
                        <div
                            id="divTableExp"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions"
                            style="border-top: 1px solid black; display: none; ">

							<div class="col-md-8">
								<table id="eoBxpTable" class="table table-striped table-bordered table-hover eobExpTable">
									<thead>
										<tr>
											<th style="width: 60%"><i class="fa fa-fw fa-calendar txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Kadaluarsa</th>
											<th style="width: 15%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Jumlah Unit</th>
											<th style="width: 25%" class="text-center"><i class="fa fa-fw fa-wrench txt-color-blue"></i>&nbsp;Aksi</th>
										</tr>
									</thead>

									<tbody id="eobexpshowdata">
										<tr>
											<td class="text-align-left">
												<select name="" id="" style="width: 20%; float: left" class="form-control">
													<option value="" selected disabled>TGL</option>
												</select>
												<select name="" id="" style="width: 40%; float: left; margin-left: 4%" class="form-control">
													<option value="" selected disabled>BULAN</option>
												</select>
												<select name="" id="" style="width: 30%; float: left; margin-left: 4%" class="form-control">
													<option value="" selected disabled>TAHUN</option>
												</select>
											</td>
											<td>
												<input type="text" class="form-control qty" name="qty[]" style="width: 100%">
											</td>
											<td>
												<div class="text-center">
													<a class="btn btn-success" style="width: 100%" onclick="addRow()"><i class="fa fa-plus"></i></a>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="col-md-4 no-padding">
								<label class="col-md-12 text-align-left">Catatan</label>
								<div class="col-md-12">
									<textarea class="form-control" name="eobNoteE" id="eobNoteE" rows="5"></textarea>
								</div>
							</div>

						</div>

						<div
							id="eobTableCode"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions"
							style="border-top: 1px solid black; display: none">


							<div class="col-md-6">
								<label class="col-md-12 no-padding text-align-left">Table Input IMEI</label>
								<table id="eobCodeTable" class="table table-striped table-bordered table-hover eobCodeTable">
									<thead>
										<tr>
											<th style="width: 50%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;IMEI Input</th>
											<th style="width: 20%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Aksi</th>
										</tr>
									</thead>

									<tbody id="eobcodeshowdata">
									</tbody>
								</table>
							</div>

							<div class="col-md-6">
								<label class="col-md-12 text-align-left">Catatan</label>
								<div class="col-md-12">
									<textarea class="form-control" name="eobNoteC" id="eobNoteC" rows="5"></textarea>
								</div>
							</div>

						</div>


						<div
							id="eobTableCodeExp"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions"
							style="border-top: 1px solid black; display: none">

							<div class="col-md-9">
								<table id="eobCodeExpTable" class="table table-striped table-bordered table-hover eobCodeExpTable">
									<thead>
										<tr>
											<th style="width: 20%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;IMEI Input</th>
											<th style="width: 50%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Tanggal Kadaluarsa</th>
											<th style="width: 30%"><i class="fa fa-fw fa-barcode txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Aksi</th>
										</tr>
									</thead>

									<tbody id="eobcodeexpshowdata">

									</tbody>
								</table>
							</div>

							<div class="col-md-3 no-padding">
								<label class="col-md-12 text-align-left">Catatan</label>
								<div class="col-md-12">
									<textarea class="form-control" name="eobNoteCE" id="eobNoteCE" rows="5"></textarea>
								</div>
							</div>

						</div>

						</form>

                        <div
                            id="eobBtnAksi"
                            class="row margin-bottom-10 margin-top-10 padding-bottom-10 padding-top-15 form-actions"
                            style="border-top: 1px solid black">

                            <button class="btn btn-primary" onclick="simpanEOB()"><i class="fa fa-floppy-o"></i>&nbsp;Simpan</button>
                        </div>

					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->

    </div>
@endsection

@section('extra_script')
<script src="{{ asset('template_asset/js/MonthPicker.js') }}"></script>
<script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>

    <script type="text/javascript">
        var appr, pend;
		var expTable, codeTable, codeExpTable, dobCTable, eobCodeTable;
		var apprTab, pendTab;
		var speccode, expired;
		var idItem, idComp;

        $(document).ready(function(){
			$( "#date-range" ).datepicker({
				language: "id",
				format: 'dd/mm/yyyy',
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
				autoclose: true,
				todayHighlight: true
			});

            eobCodeTable = $('#eobCodeTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : false,
				"scrollY": "100px",
				"paging": false,
				"info" : false,
			});

			dobCTable = $('#dobCTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : true,
				"pageLength" : 5,
				"info" : false,
			});

			expTable = $('#expTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : false,
				"scrollY": "100px",
				"paging": false,
				"info" : false,
			});

			codeTable = $('#codeTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : false,
				"scrollY": "100px",
				"paging": false,
				"info" : false
			});

			codeExpTable = $('#codeExpTable').DataTable({
				"order" : [],
				"searching": false,
				"autoWidth" : false,
				"scrollY": "100px",
				"paging": false,
				"info" : false,
			});

            $('#monthPick').MonthPicker({
                Button: false
            });

            $('#nameItem').autocomplete({
				// "option", "appendTo", ".eventInsForm",
                source: baseUrl+'/penjualan/pemesanan-barang/get-item',
                minLength: 2,
                select: function(event, data){
                    $('#idItem').val(data.item.id);
                }
			})

			$('.osItemName').autocomplete({
				// "option", "appendTo", ".eventInsForm",
                source: baseUrl+'/penjualan/pemesanan-barang/get-item',
                minLength: 2,
                select: function(event, data){
                    $('#osItemId').val(data.item.id);
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


            setTimeout(function () {

				pendTab = $('#pendTable').DataTable({
					"processing": true,
					"serverSide": true,
					"order": [],
					"ajax": "{{ url('/inventory/opname-barang/pend') }}",
					"columns":[
						{"data": "o_reff"},
						{"data": "o_date"},
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#pendTable'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			}, 500);

			setTimeout(function () {

				apprTab = $('#apprTable').DataTable({
					"processing": true,
					"serverSide": true,
					"order": [],
					"ajax": "{{ url('/inventory/opname-barang/appr') }}",
					"columns":[
						{"data": "o_reff"},
						{"data": "o_date"},
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#apprTable'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			}, 1000);

		});

		function addRowCodeExp(){
			codeExpTable.row.add([
				'<td><input type="text" class="form-control qty" name="qty[]"></td>',
				'<td><select name="" id="" style="width: 20%; float: left" class="form-control"><option value="" selected disabled>TGL</option></select><select name="" id="" style="width: 40%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>BULAN</option></select><select name="" id="" style="width: 30%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>TAHUN</option></select></td>',
				'<td><div class="text-center"><a class="btn btn-success" onclick="addRowCodeExp()"><i class="fa fa-plus"></i></a> <a class="btn btn-danger btnhapus"><i class="fa fa-minus"></i></a></div></td>'
			]).draw(false);
		}

		function addRowCode(){
			// var id = codeTable.rows().count() + 1;
			codeTable.row.add([
				'<td><input type="text" class="form-control imeiR" name="imeiR[]" style="width:100%" onkeypress="handleEnterC(event)"></td>',
				'<td><a class="btn btn-success" onclick="addRowCode()" style="width:47%; margin-right: 6%"><i class="fa fa-plus"></i></a><a class="btn btn-danger btnhapus" style="width:47%"><i class="fa fa-minus"></i></a></td>'
			]).draw(false);
            // $(this).parents('tr').find('input').focus();
            $('tbody#codeshowdata tr:last td:first input').focus();
			// $('#'+id).focus();

		}

		function addRowExp(){
			// var id = codeTable.rows().count() + 1;
			expTable.row.add([
				'<td class="text-align-left"><select name="tgl[]" style="width: 20%; float: left" class="form-control"><option value="" selected disabled>TGL</option></select><select name="bln[]" style="width: 40%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>BULAN</option></select><select name="thn[]" style="width: 30%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>TAHUN</option></select></td>',
				'<td><input type="text" class="form-control qty" name="qty[]"></td>',
				'<td><a class="btn btn-success" onclick="addRowExp()"><i class="fa fa-plus"></i></a><a class="btn btn-danger btnhapus"><i class="fa fa-minus"></i></a></td>'
			]).draw(false);
			// $('#'+id).focus();

		}

        function addRowEOBCode(){
			// var id = codeTable.rows().count() + 1;
			eobCodeTable.row.add([
				'<td><input type="text" class="form-control imeiR" name="imeiR[]" style="width:100%" onkeypress="handleEnter(event)"></td>',
				'<td><a class="btn btn-success" onclick="addRowEOBCode()" style="width:47%; margin-right: 6%"><i class="fa fa-plus"></i></a><a class="btn btn-danger btnhapus" style="width:47%"><i class="fa fa-minus"></i></a></td>'
			]).draw(false);
            $('tbody#eobcodeshowdata tr:last td:first input').focus();
			// $('#'+id).focus();

		}

        // handle enter plain javascript
        function handleEnter(e){
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                addRowEOBCode();
            }
        }

        function handleEnterC(e){
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                addRowCode();
                // $(this).next('input').focus();
            }
        }

		$('.expTable tbody').on( 'click', 'a.btnhapus', function () {
			expTable.row( $(this).parents('tr') ).remove().draw();
		});

		$('.codeTable tbody').on( 'click', 'a.btnhapus', function () {
			codeTable.row( $(this).parents('tr') ).remove().draw();
            $('tbody#codeshowdata tr:last td:first input').focus();
		});

		$('.codeExpTable tbody').on( 'click', 'a.btnhapus', function () {
			codeExpTable.row( $(this).parents('tr') ).remove().draw();
		});

        $('.eobCodeTable tbody').on( 'click', 'a.btnhapus', function () {
			eobCodeTable.row( $(this).parents('tr') ).remove().draw();
            $('tbody#eobcodeshowdata tr:last td:first input').focus();
		});

		function detail(id){
			axios.post(baseUrl+'/inventory/opname-barang/detail?id='+id).then((response) => {

				$('#obNota').html(response.data.data[0].o_reff);
				$('#obCabang').html(response.data.data[0].c_name);
				$('#obBarang').html(response.data.data[0].i_nama);
				if(response.data.data[0].o_action == 'REAL'){
					$('#obAksi').html('Menyesuaikan Qty Real')
				}else if(response.data.data[0].o_action == 'SYSTEM'){
					$('#obAksi').html('Menyesuaikan Qty System')
				}

				$qtyR = 0;
				$qtyS = 0;

				dobCTable.clear();

				for($ob = 0; $ob < response.data.data.length; $ob++){
					$qtyR = $qtyR + parseInt(response.data.data[$ob].od_qty_real);
					$qtyS = $qtyS + parseInt(response.data.data[$ob].od_qty_system);

					$sc = response.data.data[$ob].i_specificcode;
					$ex = response.data.data[$ob].i_expired;

					if($sc == 'Y' && $ex == 'N'){

						dobCTable.row.add([
							($ob+1),
							response.data.data[$ob].od_specificcode
						]).draw(false);

					}

				}
				$('#dobCTable').css("display", "block");

				$('#obQtyS').html($qtyS+' Unit');
				$('#obQtyR').html($qtyR+' Unit');

			})

			$('#detilModal').modal('show');
		}

		function cari(){

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mencari Data ...');

			var status;
			var awal = $('#tglAwal').val();
			var akhir = $('#tglAkhir').val();
			var idItem = $('#osItemId').val();
			var idComp = $('#osCompId').val();

			if($('#hr2').hasClass("active") == true){

				$('#apprTable').DataTable().destroy();

				$('#apprTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"?cb=pus&x=a&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
					"columns":[
						{"data": "o_reff"},
						{"data": "o_date"},
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#apprTable'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			}else if($('#hr1').hasClass("active") == true){

				$('#pendTable').DataTable().destroy();

				$('#pendTable').DataTable({
					"processing": true,
					"serverSide": true,
					"ajax": "{{ url('/inventory/opname-barang/pencarian') }}"+"?cb=pus&x=p&awal="+awal+"&akhir="+akhir+'&ii='+idItem+'&ic='+idComp,
					"columns":[
						{"data": "o_reff"},
						{"data": "o_date"},
						{"data": "c_name"},
						{"data": "i_nama"},
						{"data": "aksi"}
					],
					"autoWidth" : true,
					"language" : dataTableLanguage,
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
					"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#pendTable'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});

			}
			$('#osItemId').val('');
			$('#osCompId').val('');
			$('#overlay').fadeOut(200);
		}

		function cariTambah(){

			idItem = $('#idItem').val();
			idComp = $('#idComp').val();

			axios.post(baseUrl+'/inventory/opname-barang/cariItemStock', {idItem: idItem, idComp: idComp}).then((response) => {
                // alert(response.data.hpp.length);

                if(response.data.hpp[0].hpp == null){
                    $('#osHpp').maskMoney({precision: 0, thousands: '.'});
				    $('#osHpp').val(accounting.formatMoney(0, "", 0, ".", ","));
                    $('#hppNote').text(accounting.formatMoney(0, "", 0, ".", ","));
                }else{
                    $('#osHpp').maskMoney({precision: 0, thousands: '.'});
                    $('#osHpp').val(accounting.formatMoney(response.data.hpp[0].hpp, "", 0, ".", ","));
                    $('#hppNote').text(accounting.formatMoney(response.data.hpp[0].hpp, "", 0, ".", ","));
                }

                if(response.data.data.length == 0){
                    $('#osQtyS').val(accounting.formatMoney(0, "", 0, ".", ",")+' Unit');
                }else{
                    $('#osQtyS').val(accounting.formatMoney(response.data.data[0].qty, "", 0, ".", ",")+' Unit');
                }

				// $('#osQtyR').maskMoney({precision: 0, thousands: '.'});

				speccode = response.data.ce[0].i_specificcode;
				expired = response.data.ce[0].i_expired;

				$('#divTableCode').css("display", "none");
				$('#divTableExp').css("display", "none");
				$('#divTableCodeExp').css("display", "none");

				codeTable.clear();
				expTable.clear();
				codeExpTable.clear();

				if(speccode == 'Y' && expired == 'N'){

					$('#divTableCode').css("display", "block");

					codeTable.row.add([
						'<td><input type="text" class="form-control imeiR" name="imeiR[]" style="width:100%" onkeypress="handleEnterC(event)"></td>',
						'<td><a class="btn btn-success" onclick="addRowCode()" style="width:100%"><i class="fa fa-plus"></i></a></td>'
					]).draw(false);

				// }else if(speccode == 'Y' && expired == 'Y'){
				// 	$('#divTableCodeExp').css("display", "block");

				// 	codeExpTable.row.add([
				// 		'<td><input type="text" class="form-control imeiI" name="imeiI[]"></td>',
				// 		'<td class="text-align-left"><select name="tgl[]" style="width: 20%; float: left" class="form-control"><option value="" selected disabled>TGL</option></select><select name="bln[]" style="width: 40%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>BULAN</option></select><select name="thn[]" style="width: 30%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>TAHUN</option></select></td>',
				// 		'<td><a class="btn btn-success" onclick="addRowCodeExp()" style="width:100%"><i class="fa fa-plus"></i></a></td>'
				// 	]).draw(false);

				// }else if(speccode == 'N' && expired == 'Y'){
				// 	$('#divTableExp').css("display", "block");

				// 	expTable.row.add([
				// 		'<td class="text-align-left"><select name="tgl[]" style="width: 20%; float: left" class="form-control"><option value="" selected disabled>TGL</option></select><select name="bln[]" style="width: 40%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>BULAN</option></select><select name="thn[]" style="width: 30%; float: left; margin-left: 4%" class="form-control"><option value="" selected disabled>TAHUN</option></select></td>',
				// 		'<td><input type="text" class="form-control qty" name="qty[]"></td>',
				// 		'<td><a class="btn btn-success" onclick="addRowExp()" style="width:100%"><i class="fa fa-plus"></i></a></td>'
				// 	]).draw(false);
				}else{
					$(".qtyR").css("display", "block");
					$("#osQtyR").maskMoney({precision: 0, thousands: '.', suffix: ' Unit'});
				}

				$('#divQtyHpp').css("display", "block");
				$('#divBtnAksi').css("display", "block");

			});

		}

		$('#aksiSelect').on('change', function (e) {
			if($('#aksiSelect').val() == '1'){

				$('#divTableCode').css("display", "none");
				$('#divTableExp').css("display", "none");
				$('#divTableCodeExp').css("display", "none");

			}else{

				cariTambah();

			}

		});

		$('#tambahModal').on('hidden.bs.modal', function () {
			$('#idItem').val('');
			$('#nameItem').val('');
			$('#aksiSelect').val('');
			$('#osQtyS').val('');
			$('#osQtyR').val('');

			$('#divQtyHpp').css("display", "none");
			$('#divBtnAksi').css("display", "none");
			$('#divTableCode').css("display", "none");
			$('#divTableExp').css("display", "none");
			$('#divTableCodeExp').css("display", "none");
		});

        function tambah(){
            location.href = ('{{ url('/inventory/opname-barang/tambah') }}');
        }

		function simpanOs(){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Menyimpan Data...');

			var QtyS = $('#osQtyS').val();
			var QtyR = $('#osQtyR').val();
			var idItem = $('#idItem').val();
			var idComp = $('#idComp').val();
			var aksi = $('#aksiSelect').val();
            var hpp = $('#osHpp').val();
			var note = '';

			var ar = $();
			var data = '';
			if(speccode == 'Y' && expired == 'N'){
				for (var i = 0; i < codeTable.rows()[0].length; i++) {
					ar = ar.add(codeTable.row(i).node())
				}
				note = $('#noteC').val();
			}else if(speccode == 'N' && expired == 'Y'){
				for (var i = 0; i < expTable.rows()[0].length; i++) {
					ar = ar.add(expTable.row(i).node())
				}
				note = $('#noteE').val();
			}else if(speccode == 'Y' && expired == 'Y'){
				for (var i = 0; i < codeExpTable.rows()[0].length; i++) {
					ar = ar.add(codeExpTable.row(i).node())
				}
				note = $('#noteCE').val();
			}


			var data = ar.find('select,input,textarea').serialize() +'&qtyR='+QtyR+'&qtyS='+QtyS+'&idItem='+idItem+'&idComp='+idComp+'&aksi='+aksi+'&note='+note+'&sc='+speccode+'&ex='+expired+'&hpp='+hpp;

			axios.post(baseUrl+'/inventory/opname-barang/tambah', data)
			.then((response) => {

				if(response.data.status == 'obSukses'){
					$('#tambahModal').modal('hide');
					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Berhasil",
						content : 'Data Opname Barang Berhasil Disimpan...!',
						color : "#739E73",
						timeout: 4000,
						icon : "fa fa-check bounce animated"
					});
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

        function edit(id){

            location.href = ('{{ url('/inventory/opname-barang/edit?id=') }}' + id);

        }

		function appr(id){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin ingin melakukan Approval pada Opname Barang ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {
					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

					axios.post(baseUrl+'/inventory/opname-barang/approve?id='+id).then((response) => {

						if(response.data.status == 'eobSukses'){
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Berhasil",
								content : 'Approval Berhasil Dilakukan !',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});
							location.reload();
						}else{
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Maaf, Approval Gagal Dilakukan ",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});
						}

					})
				}
			})

		}

		function hapus(id){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan manghapus data Opname Barang ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menyimpan Perubahan Data...');

					axios.post(baseUrl+'/inventory/opname-barang/hapus?id='+id).then((response) => {
						if(response.data.status == 'hobSukses'){
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Berhasil",
								content : 'Data Opname Barang '+response.data.data+' Berhasil Dihapus !',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});
							location.reload();
						}else{
							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Maaf, Data Opname Barang "+response.data.data+" Gagal Dihapus ",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});
						}
					});
				}
			});
		}
    </script>
@endsection
