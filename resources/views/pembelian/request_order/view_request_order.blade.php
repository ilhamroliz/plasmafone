@extends('main')

@section('title', 'Request Order')

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
            <li>Pembelian</li>
            <li>Request Order</li>
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
                    <i class="fa-fw fa fa-credit-card"></i>
                    Pembelian
                    <span>
						<i class="fa fa-angle-double-right"></i>
						 Request Order
					</span>
                </h1>
            </div>
            @if(Access::checkAkses(45, 'insert') == true)
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                    <div class="page-title">

                        <a href="{{ url('/pembelian/request-pembelian/tambah') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah
                            Data</a>

                    </div>

                </div>
            @endif
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
                        <header>
                            <ul id="widget-tab-1" class="nav nav-tabs pull-left">
                                <li class="active">
                                    <a data-toggle="tab" href="#hr1"> <i style="color: #739E73;"
                                                                         class="fa fa-lg fa-rotate-right fa-spin"></i> <span
                                            class="hidden-mobile hidden-tablet"> Menunggu </span> </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #C79121;"
                                                                         class="fa fa-lg fa-check"></i> <span
                                            class="hidden-mobile hidden-tablet"> DiProses </span></a>
                                </li>
                                
                            </ul>
                        </header>
                        <!-- widget div-->
                        <div>
                        
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <!-- widget body text-->
                                <div class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="hr1">
                                        <table id="waitingReq_table" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th data-hide="phone,tablet" >No</th>
                                                <th >Nama Outlet</th>
                                                <th data-hide="phone,tablet" width="35%">Nama Barang</th>
                                                <th data-hide="phone,tablet" >Qty</th>
                                                <th data-hide="phone,tablet" width="15%">Status</th>
                                                <th data-hide="phone,tablet" >Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade" id="hr2">
                                        <table id="dt_all" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th data-hide="phone,tablet" >No</th>
                                                <th >Nama Outlet</th>
                                                <th data-hide="phone,tablet" width="35%">Nama Barang</th>
                                                <th data-hide="phone,tablet" >Qty</th>
                                                <th data-hide="phone,tablet" width="15%">Status</th>
                                                <th data-hide="phone,tablet" >Aksi</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
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

    <!-- PAGE RELATED PLUGIN(S) -->
	<script src="{{ asset('template_asset/js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('template_asset/js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>

	<script type="text/javascript">
		var menunggu, diproses, semua,inaktif;

		$('#overlay').fadeIn(200);
		$('#load-status-text').text('Sedang Menyiapkan...');
		
		var baseUrl = '{{ url('/') }}';

		/* BASIC ;*/
			var responsiveHelper_dt_basic = undefined;
			var responsiveHelper_datatable_fixed_column = undefined;
			var responsiveHelper_datatable_col_reorder = undefined;
			var responsiveHelper_datatable_tabletools = undefined;
			
			var breakpointDefinition = {
				tablet : 1024,
				phone : 480
			};

     $(document).ready(function(){

            $('#overlay').fadeIn(200);
            $('#load-status-text').text('Sedang Menyiapkan...');

            // $('#tabs').tabs();

            let selected = [];

            /* BASIC ;*/
            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet : 1024,
                phone : 480
            };

            setTimeout(function () {

            semua = $('#dt_all').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/pembelian/request-pembelian/a') }}",
                "columns":[
                    {"data": "id_purchaseReq"},
                    {"data": "c_name"},
                    {"data": "i_nama"},
                    {"data": "qtyReq"},
                    {"data": "status"},
                    {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_all'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
             $('#overlay').fadeOut(200);
            }, 1000);


            setTimeout(function () {

            menunggu = $('#waitingReq_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('/pembelian/request-pembelian/t') }}",
                "columns":[
                    {"data": "id_purchaseReq"},
                    {"data": "c_name"},
                    {"data": "i_nama"},
                    {"data": "qtyReq"},
                    {"data": "status"},
                    {"data": "aksi"}
                ],
                "autoWidth" : true,
                "language" : dataTableLanguage,
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+"t"+
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6 pull-right'p>>",
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#waitingReq_table'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });
            $('#overlay').fadeOut(200);
            }, 500);


            

        })
                
		/* END BASIC */

		function refresh_tab(){
		    menunggu.api().ajax.reload();
		    diproses.api().ajax.reload();
		    semua.api().ajax.reload();
		}

		function hapus(val){

			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan manghapus data member ini ?',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Menghapus...');

					axios.get(baseUrl+'/master/member/delete/'+val).then((response) => {

						if(response.data.status == 'hapusberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data member berhasil dihapus...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda hapus sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal menghapus data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}

					}).catch((err) => {
						out();
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal menghapus data...! Coba lagi dengan mulai ulang halaman",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});
						
					}).then(function(){
						$('#overlay').fadeOut(200);
					})

				}
	
			});

		}

		function edit(val){

			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Memproses...');

			window.location = baseUrl+'/master/member/simpan-edit/'+val;

		}

		function detail(id){
			$('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Mengambil data...');

			var status;

			axios.get(baseUrl+'/master/member/detail/'+id).then(response => {

				if (response.data.status == 'ditolak') {

					$('#overlay').fadeOut(200);
					$.smallBox({
						title : "Gagal",
						content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
						color : "#A90329",
						timeout: 5000,
						icon : "fa fa-times bounce animated"
					});

				} else {

					$('#title_detail').html('<strong>Detail Member "'+response.data.data.m_name+'"</strong>');
					$('#dt_nik').text(response.data.data.m_nik);
					$('#dt_name').text(response.data.data.m_name);
					$('#dt_phone').text(response.data.data.m_telp);
					$('#dt_address').text(response.data.data.m_address);

					if(response.data.data.m_status == "AKTIF"){

						status = "AKTIF";

					}else{

						status = "NON AKTIF";

					}

					$('#dt_isactive').text(status);
					$('#dt_created').text(response.data.data.m_insert);
					$('#overlay').fadeOut(200);
					$('#myModal').modal('show');

				}

			});
		}

		function statusactive(id){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan mengaktifkan data member ini ? ',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/member/active/'+id).then((response) => {

						if (response.data.status == 'ditolak') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'aktifberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data member <i>"'+response.data.name+'"</i> berhasil diaktifkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda aktifkan sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							// console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal mengaktifkan data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});
						}
					}).catch((err) => {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal mengaktifkan data...! Coba lagi dengan mulai ulang halaman",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});
						
					}).then(function(){
						$('#overlay').fadeOut(200);
					})

				}
	
			});
		}

		function statusnonactive(id){
			$.SmartMessageBox({
				title : "Pesan!",
				content : 'Apakah Anda yakin akan menonaktifkan data member ini ? ',
				buttons : '[Batal][Ya]'
			}, function(ButtonPressed) {
				if (ButtonPressed === "Ya") {

					$('#overlay').fadeIn(200);
					$('#load-status-text').text('Sedang Memproses...');

					axios.get(baseUrl+'/master/member/nonactive/'+id).then((response) => {

						if (response.data.status == 'ditolak') {

							$('#overlay').fadeOut(200);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Anda tidak diizinkan untuk mengakses data ini",
								color : "#A90329",
								timeout: 5000,
								icon : "fa fa-times bounce animated"
							});

						}else if(response.data.status == 'nonaktifberhasil'){
							refresh_tab();
							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Berhasil",
								content : 'Data member <i>"'+response.data.name+'"</i> berhasil dinonaktifkan...!',
								color : "#739E73",
								timeout: 4000,
								icon : "fa fa-check bounce animated"
							});

						}else if(response.data.status == 'tidak ada'){

							$('#overlay').fadeOut(200);

							$.smallBox({
								title : "Gagal",
								content : "Upsss. Data yang ingin Anda nonaktifkan sudah tidak ada...!",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}else{
							$('#overlay').fadeOut(200);
							console.log(response);
							$.smallBox({
								title : "Gagal",
								content : "Upsss. Gagal menonaktifkan data...! Coba lagi dengan mulai ulang halaman",
								color : "#A90329",
								timeout: 4000,
								icon : "fa fa-times bounce animated"
							});

						}

					}).catch((err) => {
						$('#overlay').fadeOut(200);
						$.smallBox({
							title : "Gagal",
							content : "Upsss. Gagal menonaktifkan data...! Coba lagi dengan mulai ulang halaman",
							color : "#A90329",
							timeout: 4000,
							icon : "fa fa-times bounce animated"
						});
						
					}).then(function(){
						$('#overlay').fadeOut(200);
					})

				}
	
			});
		}

	</script>

    
    <!-- <script type="text/javascript">

        var  table_requestOrder;
       

            $(document).ready(function () {
                load_table_request_order();
                
            });

            function load_table_request_order(){
                table_requestOrder= $('#requestOrder_table').DataTable({
                    "ajax": {
                                "url": '{{url('/pembelian/request-pembelian/tampilData')}}',
                                "type": 'GET',  
                                "data": function ( data ) {
                                },
                            },
                    } );
               
            };

            function reload_table_requestOrder(){
                table_requestOrder.ajax.reload(null, false);
                
            };

            function getKelompok_item(){
                $.ajax({
                          url : '{{url('/pembelian/request-pembelian/getKelompok_item')}}',
                          type: "GET",
                          data: { 
                           
                          },
                          dataType: "JSON",
                          success: function(data)
                          {
                            $('#item_kelompok').empty(); 
                            row = "<option selected='' value='0'>Pilih Kelompok</option>";
                            $(row).appendTo("#item_kelompok");
                            $.each(data, function(k, v) {
                              row = "<option value='"+v.ID_KAB+"'>"+v.NAMA_KABUPATEN+"</option>";
                              $(row).appendTo("#item_kelompok");
                            });
                          },
                          
                      });  
            }

            function getItem(){
                $.ajax({
                          url : '{{url('/pembelian/request-pembelian/getItem')}}',
                          type: "GET",
                          data: { 
                            "kelompok" : $('#item_kelompok').val() 
                          },
                          dataType: "JSON",
                          success: function(data)
                          {
                            $('#item_id').empty(); 
                            row = "<option selected='' value='0'>Pilih Item</option>";
                            $(row).appendTo("#item_id");
                            $.each(data, function(k, v) {
                              row = "<option value='"+v.ID_KAB+"'>"+v.NAMA_KABUPATEN+"</option>";
                              $(row).appendTo("#item_id");
                            });
                          },
                          
                      });  
            }

            function showItem(){
                $.ajax({
                          url : '{{url('/pembelian/request-pembelian/showItem')}}',
                          type: "GET",
                          data: { 
                            "item_id" : $('#item_id').val() 
                          },
                          dataType: "JSON",
                          success: function(data)
                          {

                            $('#item_id').val(data.MERK); 
                           
                          },
                          
                      });  
            }
    </script> -->

@endsection
