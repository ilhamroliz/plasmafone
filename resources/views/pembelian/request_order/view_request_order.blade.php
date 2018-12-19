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

                        <a href="{{ url('/pembelian/request-order/add') }}" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Tambah
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
                                            class="hidden-mobile hidden-tablet"> Table Request Order </span> </a>
                                </li>
                                <!-- <li>
                                    <a data-toggle="tab" href="#hr2"> <i style="color: #C79121;"
                                                                         class="fa fa-lg fa-check"></i> <span
                                            class="hidden-mobile hidden-tablet"> Diterima </span></a>
                                </li> -->
                                
                            </ul>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body no-padding">
                                <!-- widget body text-->
                                <div class="tab-content padding-10">
                                    <div class="tab-pane fade in active" id="table-waiting">
                                        <table id="requestOrder_table" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                            
                                                <th data-hide="phone,tablet" width="15%">Outlet</th>
                                                <th width="30%">Nama Barang</th>
                                                <th data-hide="phone,tablet" width="15%">Qty</th>
                                                <th data-hide="phone,tablet" width="15%">Aksi</th>
                                                <th data-hide="phone,tablet" width="15%">Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <div class="tab-pane fade" id="hr2">
                                        <table id="dt_all" class="table table-striped table-bordered table-hover"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th data-hide="phone,tablet" width="15%">Outlet</th>
                                                <th width="30%">Nama Barang</th>
                                                <th data-hide="phone,tablet" width="15%">Qty</th>
                                                <th data-hide="phone,tablet" width="15%">Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div> -->
                                    
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
                                    //  data.token = token;
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

            // $(function() {
            //     $("li").on("click",function() {
            //         reload_table_requestOrder();
                   
            //     });
            // });

    </script>

@endsection
