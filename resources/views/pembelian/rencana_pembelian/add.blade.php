@extends('main')

@section('title', 'Master Barang')

<?php
	use App\Http\Controllers\PlasmafoneController as Access;

	function rupiah($angka){
		$hasil_rupiah = "Rp" . number_format($angka,2,',','.');
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

			<span id="refresh" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Refresh Halaman? Semua Perubahan Yang Belum Tersimpan Akan Hilang.." data-html="true" onclick="location.reload()">

				<i class="fa fa-refresh"></i>

			</span>

		</span>

		<!-- breadcrumb -->
		<ol class="breadcrumb">

			<li>Home</li><li>Pembelian</li><li>Rencana Pembelian</li>

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
						 Rencana Pembelian
					</span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ url('pembelian/rencana-pembelian') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

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
						<h4 class="alert-heading">&nbsp;<i class="fa fa-thumbs-up"></i> &nbsp;Pemberitahuan Berhasil</h4>
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

					<div class="jarviswidget" id="wid-id-11" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">

                    <header role="heading">

                        <h2><strong>Tambah Rencana Pembelian</strong></h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

						<!-- widget div-->
						<div>

							<!-- widget content -->

							<div class="widget-body no-padding">

								<!-- widget body text-->

								<div class="tab-content padding-10">

									<div class="tab-pane fade in active" id="hr1">

										<table id="dt_tambah" class="table table-striped table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th style="width: 15%;">Tanggal Request</th>
                                                    <th>Nama Outlet</th>
                                                    <th>Nama Barang</th>
                                                    <th>Keterangan</th>
                                                    <th class="text-center" style="width: 5%;">Qty</th>
													<th class="text-center" style="width: 5%;">Qty App</th>
                                                    <th class="text-center" style="width: 10%;">Aksi</th>
												</tr>
											</thead>

											<tbody>
												@foreach($request as $req)
												<tr>
													<td>{{$req->date}}</td>
													<td>{{$req->c_name}}</td>
													<td>{{$req->i_nama}}</td>
													@if($req->nama == 'indent')
														<td>Indent</td>
													@else
														<td>Request</td>
													@endif
													<td>{{$req->qty}}</td>
													<td>
														<div class="text-center">
															@if($req->nama == 'indent')
																<input type="hidden" name="ind_id[]" value="{{$req->item}}">
																<input type="hidden" name="item_id[]" value="{{$req->item}}">
																<input type="number" min="1" class="form-control" name="qtyAppInd[]" id="qty-{{$req->id}}" placeholder="QTY"  style="text-transform: uppercase; width: 80px;" onblur="setQty('qty-{{$req->id}}')" value="{{$req->qty}}"/>
															@else
																<input type="hidden" name="req_id[]" value="{{$req->id_table}}">
																<input type="hidden" name="item_idReq[]" value="{{$req->item}}">
																<input type="number" min="1" class="form-control" name="qtyAppReq[]" id="qty-{{$req->id}}" placeholder="QTY"  style="text-transform: uppercase; width: 80px;" onblur="setQty('qty-{{$req->id}}')" value="{{$req->qty}}"/>
															@endif
														</div>
													</td>
													<td>
														<div class="text-center">
															<button class="btn btn-xs btn-hapus btn-danger btn-circle" data-toggle="tooltip" data-placement="top" title="Tolak Request" onclick="tolakRequest('{{$req->id}}')">
																<i class="fa fa-times"></i>
															</button>
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
                                       	 		<button class="btn-lg btn-block btn-primary text-center" onclick="simpanRencana()">Setujui Semua Rencana</button>
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

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>

						<h4 class="modal-title" id="myModalLabel">Detail Barang</h4>

					</div>

					<div class="modal-body">

						<div style="margin-bottom: 15px;" class="preview thumbnail">

							<img id="dt_image" src="">

						</div>

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

											<table class="table">
												<tbody>

													<tr class="success">
														<td><strong>Kelompok</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_kelompok"></td>
													</tr>

													<tr class="danger">
														<td><strong>Group</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_group"></td>
													</tr>

													<tr class="warning">
														<td><strong>Sub Group</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_subgroup"></td>
													</tr>

													<tr class="info">
														<td><strong>Merk</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_merk"></td>
													</tr>

													<tr class="success">
														<td><strong>Nama</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_nama"></td>
													</tr>

													<tr class="danger">
														<td><strong>Spesifik Kode</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_specificcode"></td>
													</tr>

													<tr class="warning">
														<td><strong>Kode</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_code"></td>
													</tr>

													<tr class="info">
														<td><strong>Status</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_isactive"></td>
													</tr>

													<tr class="success">
														<td><strong>Min Stock</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_minstock"></td>
													</tr>

													<tr class="danger">
														<td><strong>Berat (Gram)</strong></td>
														<td><strong>:</strong></td>
														<td id="dt_berat"></td>
													</tr>

													<tr class="warning">
														<td><strong>Harga</strong></td>
														<td><strong>:</strong></td>
														<td ><label id="dt_price"></label></td>
													</tr>
													<tr class="info" id="in_sup">
														<td><strong>Suplier</strong></td>
														<td><strong>:</strong></td>
														<td >
															<div class="form-group">
																<select class="form-control" name="" id="dt_supplier" >
																	<!-- <option selected="" value="00"></option> -->
																</select>
															</div>
								  						</td>
													</tr>
													<tr class="info" id="in_qty">
														<td><strong>QTY APPROVE</strong></td>
														<td><strong>:</strong></td>
														<td >
															<div class="form-group">

																<input type="text" class="form-control" id="dt_qtyApp"  placeholder="QTY" style="width: 100%" >
															</div>
								  						</td>
													</tr>
													<tr hidden="">
														<td><input type="text" id="pr_idReq"></td>
														<td><input type="text"  id="pr_itemPlan"></td>
														<td ><input type="text"  id="pr_qt"></label></td>
													</tr>
													<tr hidden="">
														<td><input type="text" id="pr_dateRequest"></td>
														<td><input type="text" id="dt_comp" ></td>
														<td ><input type="text"  ></label></td>
													</tr>


												</tbody>

											</table>

										</div>

									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
							<!-- end widget -->
                            <div class="form-group col-md-12 text-right">

                                            <button class="btn btn-primary" onclick="batal()" id="btnBatal">Batal</button>
                                            <button class="btn btn-primary" onclick="tambah()" id="btnTambah">Tambah</button>
                                            <button class="btn btn-primary" onclick="tolak()" id="btnTolak">Tolak</button>
                                        </div>
						</div>


					</div>

				</div><!-- /.modal-content -->

			</div><!-- /.modal-dialog -->

		</div>
		<!-- /.modal -->

	</div>
	<!-- END MAIN CONTENT -->
@endsection

@section('extra_script')


	<script type="text/javascript">
		var tambahRencana;
		var tambahRencana_dumy;

        $(document).ready(function () {
			$( "#tpMemberNama" ).autocomplete({
				source: baseUrl+'/pembelian/request-pembelian/cariItem',
				minLength: 2,
				select: function(event, data) {
					$('#tpMemberId').val(data.item.id);
					$('#tpMemberNama').val(data.item.label);
				}
			});

			$.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

			semua = $('#dt_tambah').DataTable({
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_tambah'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
   //           $('#dt_tambah').on( 'click', '.btn-hapus', function () {
			// 	    semua
			// 	        .row( $(this).parents('tr') )
			// 	        .remove()
			// 	        .draw(false);
			// } );


			getMember();

        });


        function setQty(id)
        {
        	var qty = $('#'+id).val();
        	if (qty == "" || qty == 0) {
        		$('#'+id).val(1);
        	}

        }



		function tambah2(){
			$.ajax({
				url : '{{url('/pembelian/request-pembelian/addDumyReq')}}',
				type: "POST",
				data: {
					'qty'  : $('#qty').val(),
					'item' : $('#tpMemberId').val(),
					_token : '{{ csrf_token() }}'
				},
				dataType: "JSON",
				success: function(data)
				{
					$.smallBox({
							title : "Berhasil",
							content : 'Data telah ditambahkan...!',
							color : "#739e73",
							timeout: 4000,
							icon : "fa fa-check bounce animated"
							});
							$('#dt_tambah').DataTable().ajax.reload();
					// reload_table();
				},

		});
		}

		function simpanRencana()
		{
			$.SmartMessageBox({
					title : "Pesan!",
					content : "Apakah Anda Yakin Akan Mengajukan Rencana Pembelian ?",
					buttons : '[Tidak][Ya]'
				}, function(ButtonPressed) {
					if (ButtonPressed === "Ya") {
						var ar = $();
					    for (var i = 0; i < semua.rows()[0].length; i++) {
					        ar = ar.add(semua.row(i).node());
					    }
					    $.ajaxSetup({
					    headers: {
					            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					            }
					    });
					    $.ajax({
					        url: baseUrl + '/pembelian/rencana-pembelian/tambahRencana',
					        type: 'get',
					        data: ar.find('input').serialize(),
					        dataType: 'json',
					        success: function (data) {

					        	if(data.status =='sukses'){
									$.smallBox({
										title  : "Berhasil",
										content: 'Data telah ditambahkan...!',
										color  : "#739e73",
										timeout: 4000,
										icon   : "fa fa-check bounce animated"
									});
									window.location.href="{{url('pembelian/rencana-pembelian')}}";
								}else{
									$.smallBox({
										title  : "GAGAL",
										content: 'Data GAGAL ditambahkan...!',
										color  : "#c46a69",
										timeout: 4000,
										icon   : "fa fa-check bounce animated"
									});
								}
					        }
					    });
					}
					if (ButtonPressed === "Tidak") {
						$.smallBox({
							title : "Peringatan...!!!",
							content : "<i class='fa fa-clock-o'></i> <i>Anda Tidak Melakukan Pengajuan</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
					}

				});
				e.preventDefault();

		}



		function apply(id){
			var input = $('#i_nama'+id).val();
			$.ajax({
						url : '{{url('/pembelian/rencana-pembelian/editDumy')}}',
						type: "GET",
						data: {
							'id' : id,
							'qty' : input,

						},
						dataType: "JSON",
						success: function(data)
						{
							$('#dt_tambah').DataTable().ajax.reload();

						},

				});

		}

		function editTable(id)
		{
			var input = $('#i_nama'+id).val();
			$.ajax({
						url : '{{url('/pembelian/rencana-pembelian/editDumy')}}',
						type: "POST",
						data: {
							'id' : id,
							'qty' : input,
							_token : '{{ csrf_token() }}'

						},
						dataType: "JSON",
						success: function(data)
						{
							reload_table_dumy();
							// $('#dt_tambah').DataTable().ajax.reload();
						},

				});
		}


        function edit(id){

            $.ajax({
                url : '{{url('/pembelian/rencana-pembelian/getRequest_id')}}',
                type: "GET",
                data: {
					id : id,
                },
                dataType: "JSON",
                success: function(data)
                {

				// pr_idReq = data.data.pr_id;
				// pr_itemPlan = data.data.i_id;
				// pr_qtyReq = data.data.pr_qtyReq;
				// pr_dateRequest = data.data.pr_dateReq;

					if (data.data.i_img == "") {

							$('img#dt_image').attr("src", "{{asset('img/image-not-found.png')}}");

						}else{

							$('img#dt_image').attr("src", "{{asset('img/items/')}}"+"/"+data.data.i_img);

						}


					$('#dt_kelompok').text(data.data.i_kelompok);
					$('#dt_group').text(data.data.i_group);
					$('#dt_subgroup').text(data.data.i_sub_group);
					$('#dt_merk').text(data.data.i_merk);
					$('#dt_specificcode').text(data.data.i_specificcode);
					$('#dt_isactive').text(data.data.i_isactive);
					$('#dt_code').text(data.data.i_code);
					$('#dt_minstock').text(data.data.i_minstock);
					$('#dt_price').text(data.data.i_price);
					$('#dt_berat').text(data.data.i_berat);
					$('#dt_nama').text(data.data.i_nama);

					$('#pr_idReq').val(data.data.pr_id);
					$('#pr_itemPlan').val(data.data.i_id);
					$('#pr_qt').val(data.data.pr_qtyReq);
					$('#pr_dateRequest').val(data.data.pr_dateReq);
                    $('#dt_comp').val(data.data.pr_compReq);




					$('#myModalLabel').text('FORM RENCANA PEMBELIAN');
					$('#myModal').modal('show');
                    $('#btnTambah').show();
                    $('#btnTolak').hide();
                    $('#btnBatal').show();
                },

            });

			suplier();

        }

        function getTolak(id){

            $.ajax({
                url : '{{url('/pembelian/rencana-pembelian/getRequest_id')}}',
                type: "GET",
                data: {
					id : id,
                },
                dataType: "JSON",
                success: function(data)
                {

				// pr_idReq = data.data.pr_id;
				// pr_itemPlan = data.data.i_id;
				// pr_qtyReq = data.data.pr_qtyReq;
				// pr_dateRequest = data.data.pr_dateReq;

					if (data.data.i_img == "") {

							$('img#dt_image').attr("src", "{{asset('img/image-not-found.png')}}");

						}else{

							$('img#dt_image').attr("src", "{{asset('img/items/')}}"+"/"+data.data.i_img);

						}


					$('#dt_kelompok').text(data.data.i_kelompok);
					$('#dt_group').text(data.data.i_group);
					$('#dt_subgroup').text(data.data.i_sub_group);
					$('#dt_merk').text(data.data.i_merk);
					$('#dt_specificcode').text(data.data.i_specificcode);
					$('#dt_isactive').text(data.data.i_isactive);
					$('#dt_code').text(data.data.i_code);
					$('#dt_minstock').text(data.data.i_minstock);
					$('#dt_price').text(data.data.i_price);
					$('#dt_berat').text(data.data.i_berat);
					$('#dt_nama').text(data.data.i_nama);

					$('#pr_idReq').val(data.data.pr_id);
					$('#pr_itemPlan').val(data.data.i_id);
					$('#pr_qt').val(data.data.pr_qtyReq);
					$('#pr_dateRequest').val(data.data.pr_dateReq);
                    $('#dt_comp').val(data.data.pr_compReq);




					$('#myModalLabel').text('FORM RENCANA PEMBELIAN');
					$('#myModal').modal('show');
                    $('#btnTambah').hide();
                    $('#btnTolak').show();
                    $('#in_sup').hide();
                    $('#in_qty').hide();
                    $('#btnBatal').show();
                },

            });



        }

		// function suplier(){
		// 	$.ajax({
        //         url : '{{url('/pembelian/rencana-pembelian/itemSuplier')}}',
        //         type: "GET",
        //         data: {

        //         },
        //         dataType: "JSON",
        //         success: function(data)
        //         {
        //             $('#dt_supplier').empty();
		// 			row = "<option selected='' value='0'>Pilih Suplier</option>";
		// 			$(row).appendTo("#dt_supplier");
		// 			$.each(data, function(k, v) {
		// 				row = "<option value='"+v.s_id+"'>"+v.s_company+"</option>";
		// 				$(row).appendTo("#dt_supplier");
		// 			});
        //         },

        //     });
		// }

        function batal(){
            $('#myModal').modal('hide');
        }

	function load_table_registrasi_new(){
      // table_registrasi.ajax.reload(null, false);
	  tambahRencana = $('#dt_tambah').DataTable({

          "ajax": {
                    "url": "{{ url('/pembelian/rencana-pembelian/view_tambahRencana') }}",
                    "type": "POST",
                    "data": function ( data ) {
						data.comp = $('#dt_supplier').val();
						data._token = '{{ csrf_token() }}';
                    },
                },
		"language": {
					"emptyTable": "Data Sedang Di proses Oleh User Lain"
					},
        } );
	 }

	function load_table_registrasi_reload(){
      // table_registrasi.ajax.reload(null, false);
	  tambahRencana_dumy= $('#dt_tambah').DataTable({

          "ajax": {
                    "url": "{{ url('/pembelian/rencana-pembelian/view_tambahRencana_dumy') }}",
                    "type": "POST",
                    "data": function ( data ) {
						data.comp = $('#dt_supplier').val();
						data._token = '{{ csrf_token() }}';
                    },
                },
		"language": {
			"emptyTable": "Data Sedang Di proses Oleh User Lain"
			},
        });
    }

	function reload_table_dumy(){
		tambahRencana_dumy.ajax.reload(null, false);

			}

	function reload_table(){
			tambahRencana.ajax.reload(null, false);

   		 }


		// function load_table()
		// {
		// 	var tambahRencana;
		// 	var responsiveHelper_dt_basic = undefined;
        //     var responsiveHelper_datatable_fixed_column = undefined;
        //     var responsiveHelper_datatable_col_reorder = undefined;
        //     var responsiveHelper_datatable_tabletools = undefined;

        //     var breakpointDefinition = {
        //         tablet : 1024,
        //         phone : 480
        //     };

        //     setTimeout(function () {

        //     tambahRencana = $('#dt_tambah').dataTable({
        //         "processing": true,
        //         "serverSide": true,
		// 		// "data" : {
		// 		// 	"comp" : $('#dt_supplier').val(),
		// 		// },
        //         "ajax": "{{ url('/pembelian/rencana-pembelian/view_tambahRencana') }}",
        //         "fnCreatedRow": function (row, data, index) {
        //             $('td', row).eq(0).html(index + 1);
        //             },
        //         "columns":[
        //             {"data": "pr_id"},
        //             {"data": "c_name"},
        //             {"data": "i_nama"},
        //             {"data": "pr_qtyReq"},
		// 			{"data": "input"},
        //             {"data": "aksi"}
        //         ],
        //         "autoWidth" : true,
        //         "language" : dataTableLanguage,
        //         "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
        //         "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        //         "preDrawCallback" : function() {
        //             // Initialize the responsive datatables helper once.
        //             if (!responsiveHelper_dt_basic) {
        //                 responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_tambah'), breakpointDefinition);
        //             }
        //         },
        //         "rowCallback" : function(nRow) {
        //             responsiveHelper_dt_basic.createExpandIcon(nRow);
        //         },
        //         "drawCallback" : function(oSettings) {
        //             responsiveHelper_dt_basic.respond();
        //         }
        //     });
        //      $('#overlay').fadeOut(200);
        //     }, 1000);
		// }



        function tambah(){
            $.ajax({
                url : '{{url('/pembelian/rencana-pembelian/tambahRencana')}}',
                type: "GET",
                data: {
					pr_idReq         : $('#pr_idReq').val(),
					pr_itemPlan      : $('#pr_itemPlan').val(),
					pr_qtyReq        : $('#pr_qt').val(),
					pr_dateRequest   : $('#pr_dateRequest').val(),
                    qty              : $('#dt_qtyApp').val(),
                    supplier         : $('#dt_supplier').val(),
                    comp             : $('#dt_comp').val(),
                },
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status == 'GAGAL'){
						$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. data Gagal di tambahkan",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});
					}else{
						var rel = $('#dt_tambah').DataTable().ajax.reload();
							$('#dt_tambah').DataTable().ajax.reload();
							if(!rel)
							{
								$.smallBox({
								title : "Berhasil",
								content : 'Data gagal direload...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
								});
							}else{
								$.smallBox({
								title : "Berhasil",
								content : 'Data telah ditambahkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
								});
								$('#myModal').modal('hide');
							}


					}
                },

            });
        }

		function getMember(){
			$.ajax({
				url : '{{url('/pembelian/rencana-pembelian/getComp_plan')}}',
				type: "GET",
				data: {
				},
				dataType: "JSON",
				success: function(data)
				{
				$('#dt_supplier').empty();
				row = "<option selected='' value='semua'>----Pilih Semua Outlet----</option>";
				$(row).appendTo("#dt_supplier");
				$.each(data, function(k, v) {
					row = "<option value='"+v.pr_compReq+"'>"+v.c_name+"</option>";
					$(row).appendTo("#dt_supplier");
				});
				},

			});
		}

        function tolakRequest(req_id){
            $.SmartMessageBox({
					title : "Pesan!",
					content : "Apakah Anda Yakin Akan Menolak Rencana Pembelian ?",
					buttons : '[Tidak][Ya]'
				}, function(ButtonPressed) {
					if (ButtonPressed === "Ya") {
					    $.ajaxSetup({
					    headers: {
					            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					            }
					    });
					    $.ajax({
					        url: baseUrl + '/pembelian/rencana-pembelian/tolakRequest',
					        type: 'get',
					        data: {
								id : req_id,
							},
					        dataType: 'json',
					        success: function (data) {

					        	if(data.status =='sukses'){
									$.smallBox({
										title  : "Berhasil",
										content: 'Penolakan request pembelian berhasil...!',
										color  : "#739e73",
										timeout: 4000,
										icon   : "fa fa-check bounce animated"
									});
									window.location.href="{{url('pembelian/rencana-pembelian/tambah')}}";
								}else{
									$.smallBox({
										title  : "GAGAL",
										content: 'Data telah GAGAL ditambahkan...!',
										color  : "#c46a69",
										timeout: 4000,
										icon   : "fa fa-check bounce animated"
									});
								}
					        }
					    });
					}
					if (ButtonPressed === "Tidak") {
						$.smallBox({
							title : "Peringatan...!!!",
							content : "<i class='fa fa-clock-o'></i> <i>Anda Tidak Jadi Menolak Request Pembelian!</i>",
							color : "#C46A69",
							iconSmall : "fa fa-times fa-2x fadeInRight animated",
							timeout : 4000
						});
					}

				});
		}

		var app = new Vue({
		el 		: '#content',
		data 	: {
			kelompok : 'select',
			group : 'select',
			sub_group : 'select',
			merk : 'select',
			btn_save_disabled 	: false,

			data_I_kelompok: [],
			data_I_group: [],
			data_I_sub_group: [],
			data_I_merk: [],

			form_data : {
				i_kelompok: '',
				i_group: '',
				i_sub_group: '',
				i_merk: '',
				i_nama: '',
				i_code: '',
				i_img: '',
				i_minstock: '',
				i_berat: '',
				i_specificcode: 'Y',
				i_isactive: 'Y'

			}

		},



		methods: {

			switch_kelompok: function(){
				if(this.kelompok == 'select'){
					this.kelompok = 'input';
					$('#select_kelompok').hide();
					$("#input_kelompok").show();
				}else{
					this.kelompok = 'select';
					this.form_data.i_kelompok = '';
					$('#data-form').data('bootstrapValidator').resetForm();
					$('#input_kelompok').hide();
					$("#select_kelompok").show();
				}
			},

			switch_group: function(){
				if(this.group == 'select'){
					this.group = 'input';
					$('#select_group').hide();
					$("#input_group").show();
				}else{
					this.group = 'select';
					this.form_data.i_group = '';
					$('#data-form').data('bootstrapValidator').resetForm();
					$('#input_group').hide();
					$("#select_group").show();
				}
			},



			i_kelompok_change: function(v){
				this.form_data.i_kelompok = v;
			},

			i_group_change: function(v){
				this.form_data.i_group = v;
			},



		}
	});

	</script>

@endsection
