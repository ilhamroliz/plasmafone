@extends('main')

@section('title', 'Purchase Order')

@section('extra_style')

    <style type="text/css">

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
            <li>Purchase Order</li>
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
						 Purchase Order
					</span>
                </h1>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-align-right">

                <div class="page-title">

                    <a href="{{ url('pembelian/request-pembelian') }}" class="btn btn-default"><i
                            class="fa fa-arrow-left"></i>&nbsp;Kembali</a>

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false"
                     data-widget-custombutton="false" data-widget-sortable="false" role="widget">

                    <header role="heading">
                        <div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);"
                                                                       class="button-icon jarviswidget-toggle-btn"
                                                                       rel="tooltip" title="" data-placement="bottom"
                                                                       data-original-title="Collapse"><i
                                    class="fa fa-minus "></i></a> <a href="javascript:void(0);"
                                                                     class="button-icon jarviswidget-fullscreen-btn"
                                                                     rel="tooltip" title="" data-placement="bottom"
                                                                     data-original-title="Fullscreen"><i
                                    class="fa fa-expand "></i></a>
                        </div>
                        <h2><strong>Tambah Purchase Order</strong></h2>

                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget content -->
                        <div class="widget-body">

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="" class="col-md-4">Nama Supplier</label>
                                            <div class="col-md-8">
                                                <select id="namaSupp" class="select2" onchange="getCO()">
                                                    <option value="">== PILIH SUPPLIER ==</option>
                                                    @foreach ($getDataSupp as $supp)
                                                        <option value="{{ $supp->pc_supplier }}">{{ $supp->s_company }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12 margin-top-10">
                                            <label for="" class="col-md-4">No. Telp</label>
                                            <div class="col-md-8">
                                                <input type="text" id="telpSupp" class="form-control" readonly>
                                            </div>
                                        </div>                                
    
                                        <div class="col-md-12 margin-top-10">
                                            <label for="" class="col-md-4">No Fax</label>
                                            <div class="col-md-8">
                                                <input type="text" id="faxSupp" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
    
                                <div class="col-md-6">
                                    
                                </div>
                            </div>

                            <!-- widget body text-->
                            <div class="tab-content padding-10">
                                <div class="tab-pane fade in active">
                                    <table id="dt_co" class="table table-striped table-bordered table-hover"
                                           width="100%">
                                        <thead class="table-responsive">
                                            <tr>
                                                <th width="10%"><div class="text-center"><input type="checkbox" id="cekParent" onclick="myCheck()"></div></th>
                                                <th width="75%">No. Nota</th>
                                                <th width="15%">Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody id="dtcoBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn-lg btn-block btn-primary text-center"
                                                onclick="toDetail()">Lanjutkan Input Harga
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end widget content -->
                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->
        </div>
    </div>

    </div>
    <!-- END MAIN CONTENT -->

@endsection

@section('extra_script')

    <script type="text/javascript">

        $(document).ready(function () {

            $('#dt_co').DataTable({
                "language": dataTableLanguage,
                "order": []
            });

        })


        function getCO(){
            if($('#namaSupp').val() != ''){
                var idSupp = $('#namaSupp').val();
                axios.post(baseUrl+'/pembelian/purchase-order/getCO?id='+idSupp).then((response) =>{

                    $('#telpSupp').val(response.data.dataSupp.s_phone);
                    $('#faxSupp').val(response.data.dataSupp.s_fax);
                    $('#addrSupp').val(response.data.dataSupp.s_address);

                    $('#dt_co').DataTable().clear();
                    for(var i = 0; i < response.data.dataDT.length; i++){

                        $('#dt_co').DataTable().row.add([
                            '<div class="text-center"><input type="checkbox" name="check[]" class="form-control checkB" value="'+response.data.dataDT[i].pc_id+'"></div>',
                            response.data.dataDT[i].pc_nota,
                            '<div class="text-center">'+
                                '<button class="btn btn-primary btn-circle" onclick="detil('+response.data.dataDT[i].pc_id+')"><i class="fa fa-list"></i></button>'+
                            '</div>'
                        ]).draw();

                    }

                })

            }
        }

        function myCheck(){
            var checkBox = document.getElementById("cekParent");
            if(checkBox.checked == true){
                $('.checkB').prop('checked', true);
            }else{
                $('.checkB').prop('checked', false);
            }
        }

        function toDetail(){

            if($('#dt_co input:checked').length == 0){

                $.smallBox({
                    title: "Perhatian",
                    content: 'Silahkan Pilih Nota sebelum Melanjutkan',
                    color: "#C46A69",
                    timeout: 3000,
                    icon: "fa fa-warning bounce animated"
                });
                return false;

            }

            var idSupp = $('#namaSupp').val();

            var ar = $();
            for (var i = 0; i < $('#dt_co').DataTable().rows()[0].length; i++) {
                ar = ar.add($('#dt_co').DataTable().row(i).node());
            }

            window.location.href = baseUrl+'/pembelian/purchase-order/tambah?id='+idSupp+'&a="1"&'+ar.find('input').serialize();

        }

    </script>

@endsection
