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
                                    @foreach($getDataSupp as $supp) 
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="" class="col-md-4">Nama Supplier</label>
                                            <div class="col-md-8">
                                                <input type="hidden" id="idSupp" value="{{ $supp->s_id }}">
                                                <input type="text" id="namaSupp" class="form-control" value="{{ $supp->s_company }}" readonly>
                                            </div>
                                        </div>
    
                                        <div class="col-md-12 margin-top-10">
                                            <label for="" class="col-md-4">No. Telp</label>
                                            <div class="col-md-8">
                                                <input type="text" id="telpSupp" class="form-control" value="{{ $supp->s_phone }}" readonly>
                                            </div>
                                        </div>                                
    
                                        <div class="col-md-12 margin-top-10">
                                            <label for="" class="col-md-4">No Fax</label>
                                            <div class="col-md-8">
                                                <input type="text" id="faxSupp" class="form-control" value="{{ $supp->s_fax }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
    
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
    
                                        <div class="col-md-12">
                                            <label for="" class="col-md-4">Tipe Pembayaran</label>
                                            <div class="col-md-8">
                                                <select id="payment" class="form-control" onchange="changePayment()">
                                                    <option value="">== PILIH TIPE PEMBAYARAN ==</option>
                                                    <option value="T">Tempo</option>
                                                    <option value="C">Cash</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 margin-top-10">
                                            <label for="" class="col-md-4">Jatuh Tempo</label>
                                            <div class="col-md-8">
                                                <input type="hidden" id="hiddenTempo" value="{{ $getTempo }}">
                                                <input type="text" id="tempo" class="form-control" value="{{ $getTempo }}" disabled>
                                            </div>
                                        </div>  
    
                                    </div>
                            </div>
                            <form id="idNota">
                                @foreach($check as $cek)
                                <input type="hidden" value="{{ $cek }}" name="idNota[]">
                                @endforeach
                            </form>
                            <!-- widget body text-->
                            <div class="tab-content padding-10">
                                <div class="tab-pane fade in active">
                                    <table id="dt_co" class="table table-striped table-bordered table-hover"
                                           width="100%">
                                        <thead class="table-responsive">
                                            <tr>
                                                <th width="30%">Nama Barang</th>
                                                <th width="10%">Qty</th>
                                                <th width="17%">Harga Barang</th>
                                                <th width="10%">Diskon %</th>
                                                <th width="15%">Diskon Value</th>
                                                <th width="18%">Sub Total</th>
                                            </tr>
                                        </thead>

                                        <tbody id="dtcoBody">
                                            @foreach ($getDataDT as $dt)
                                            <tr>
                                                <td><input type="hidden" name="idItem[]" value="{{ $dt->pcd_item }}">{{ $dt->i_nama }}</td>
                                                <td><input type="text" name="qty[]" id="qty{{ $dt->pcd_purchaseconfirm }}" class="form-control text-align-right qty" style="width:100%" value="{{ $dt->pcd_qty }}" readonly></td>
                                                <td><input type="text" name="price[]" id="price{{ $dt->pcd_purchaseconfirm }}" class="form-control text-align-right price" style="width:100%" onkeyup="cekprice({{ $dt->pcd_purchaseconfirm }})"></td>
                                                <td><input type="text" name="diskP[]" id="diskP{{ $dt->pcd_purchaseconfirm }}" class="form-control text-align-right diskP" style="width:100%" onkeyup="cekpersen({{ $dt->pcd_purchaseconfirm }})"></td>
                                                <td><input type="text" name="diskV[]" id="diskV{{ $dt->pcd_purchaseconfirm }}" class="form-control text-align-right diskV" style="width:100%" onkeyup="cekvalue({{ $dt->pcd_purchaseconfirm }})"></td>
                                                <td><input type="text" name="subTotal[]" id="subTotal{{ $dt->pcd_purchaseconfirm }}" class="form-control text-align-right subTotal" style="width:100%" readonly></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn-lg btn-block btn-primary text-center"
                                                onclick="simpanPO()">Simpan Purchase Order
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
    <script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            $('#dt_co').DataTable({
                "language": dataTableLanguage,
                "order": []
            });

            $('#tempo').datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true,
                todayHighlight: true
            });

            $('.price').maskMoney({thousands: '.', precision: 0});
            $('.diskV').maskMoney({thousands: '.', precision: 0});

        })

        function cekpersen(id){
            if($('#diskP'+id).val() >= 100){
                $('#diskP'+id).val(100);
            }
            getSubTotal(id);
        }

        function cekprice(id){
            getSubTotal(id);
        }

        function cekvalue(id){
            getSubTotal(id);
        }

        $(".diskP").on("keypress",function (event) {
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
            if ($(this).val() != null || $(this).val() != ""){
                $('#simpan').attr("disabled", false);
            } else {
                $('#simpan').attr("disabled", true);
            }
            if (event.which == 13){
                simpan();
            }

        });

        function getSubTotal(id){

            if($('#qty'+id).val() == ''){
                qty = 0;
            }else{
                cnqty = $('#qty'+id).val();
                strqty = cnqty.replace(/[^0-9\-]+/g,"");
                qty = parseInt(strqty);
            }

            if($('#price'+id).val() == ''){
                price = 0;
            }else{
                cnprice = $('#price'+id).val();
                strprice = cnprice.replace(/[^0-9\-]+/g,"");
                price = parseInt(strprice);
            }

            if($('#diskP'+id).val() == ''){
                diskP = 0;
            }else{
                cndiskP = $('#diskP'+id).val();
                strdiskP = cndiskP.replace(/[^0-9\-]+/g,"");
                diskP = parseInt(strdiskP);
            }

            if($('#diskV'+id).val() == ''){
                diskV = 0;
            }else{
                cndiskV = $('#diskV'+id).val();
                strdiskV = cndiskV.replace(/[^0-9\-]+/g,"");
                diskV = parseInt(strdiskV);
            }


            var subTotal = (( qty * price ) * (( 100 - diskP ) / 100)) - diskV;
            console.log(price);
            console.log(subTotal);

            $('#subTotal'+id).val(accounting.formatMoney(subTotal, "", 0, ".", ","));
        }

        function changePayment(){
            if($('#payment').val() == 'T'){
                $('#tempo').prop('disabled', false);
                var tempo = $('#hiddenTempo').val();
                $('#tempo').val(tempo);
            }else{
                $('#tempo').prop('disabled', true);
                $('#tempo').val('');
            }
        }

        function simpanPO(){

            if($('#payment').val() == ''){
                $.smallBox({
                    title: "Perhatian",
                    content: 'Silahkan Pilih Tipe Pembayaran Terlebih Dahulu',
                    color: "#C46A69",
                    timeout: 3000,
                    icon: "fa fa-warning bounce animated"
                });
                return false;
            }

            var idSupp = $('#idSupp').val();
            var tipe = $('#payment').val();
            var tempo = $('#tempo').val();

            var ar = $();
            for (var i = 0; i < $('#dt_co').DataTable().rows()[0].length; i++) {
                ar = ar.add($('#dt_co').DataTable().row(i).node());
            }
            var data = ar.find('input').serialize()+'&id='+idSupp+'&tipe='+tipe+'&tempo='+tempo+'&'+$('#idNota').serialize();

            axios.post(baseUrl+'/pembelian/purchase-order/tambah', data).then((response) => {

                if(response.data.status == 'tpoSukses'){
                    $.smallBox({
                        title: "Berhasil",
                        content: 'Purchase Order Berhasil Dibuat...!',
                        color: "#739E73",
                        timeout: 3000,
                        icon: "fa fa-check bounce animated"
                    });

                    {{--  window.open("{{url('/pembelian/konfirmasi-pembelian/print')}}"+"/"+data.pcId[i].idpc);  --}}
                    window.location.href = baseUrl+'/pembelian/purchase-order/tambah';

                } else {
                    $.smallBox({
                        title: "Gagal",
                        content: 'Purchase Order Gagal Dibuat, Silahkan coba beberapa saat lagi..',
                        color: "#C46A69",
                        timeout: 3000,
                        icon: "fa fa-check bounce animated"
                    });
                }
            })

        }


    </script>

@endsection
