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

                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                    </header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget content -->
                        <div class="widget-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="" class="col-md-4">Nota PO</label>
                                            <div class="col-md-8">
                                                <input type="text" id="namaSupp" class="form-control" value="{{ $p_nota }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-12 margin-top-10">
                                            <label for="" class="col-md-4">Nama Supplier</label>
                                            <div class="col-md-8">
                                                <input type="hidden" id="idP" value="{{ $id }}">
                                                <input type="text" id="namaSupp" class="form-control" value="{{ $s_company }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-12 margin-top-10">
                                            <label for="" class="col-md-4">No. Telp</label>
                                            <div class="col-md-8">
                                                <input type="text" id="telpSupp" class="form-control" value="{{ $s_phone }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- widget body text-->
                            <div class="tab-content padding-10">
                                <div class="tab-pane fade in active">
                                    <table id="dt_co" class="table table-striped table-bordered table-hover" width="100%">
                                        <thead class="table-responsive">
                                            <tr>
                                                <th width="40%">Nama Barang</th>
                                                <th width="30%">Kode Spesifik / QTY</th>
                                                <th width="30%">Status Return</th>
                                            </tr>
                                        </thead>

                                        <tbody id="dtcoBody">
                                            @for($i = 0; $i < count($getDataDT); $i++)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="idnd[]" value="{{ $id.'=='.$getDataDT[$i]->detailid }}">
                                                    <input type="hidden" name="idItem[]" value="{{ $arayPRList[$i]['idItem'] }}">
                                                    {{ $arayPRList[$i]['namaItem'] }}
                                                </td>
                                                <td>
                                                    @if($arayPRList[$i]['i_specificcode'] == 'Y')
                                                        {{ $arayPRList[$i]['specificcode'] }}
                                                        <input type="hidden" name="kodeqty[]" value="{{ $arayPRList[$i]['i_specificcode'].'=='.$arayPRList[$i]['specificcode'] }}">
                                                    @else
                                                        {{ $arayPRList[$i]['qty'] }}
                                                        <input type="hidden" name="kodeqty[]" value="{{ $arayPRList[$i]['i_specificcode'].'=='.$arayPRList[$i]['qty'] }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    <select name="statusReturn[]" id="" class="form-control statusReturn">
                                                        <option value="">=== Pilih Status Return ===</option>
                                                        <option value="BB">Ganti Barang Baru</option>
                                                        <option value="PT">Potong Tagihan</option>
                                                        <option value="GU">Ganti Uang</option>
                                                        <option value="PN">Potong Nota Berikutnya</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            @endfor
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

        })

        function simpanPO(){

            var inputs = document.getElementsByClassName( 'statusReturn' ),
            names  = [].map.call(inputs, function( select ) {
                return select.value;
            });

            if(names.includes('') == true){
                $.smallBox({
                    title : "Perhatian",
                    content : "Status Return Setiap Item Harus Dipilih !!!",
                    color : "#A90329",
                    timeout: 3000,
                    icon : "fa fa-times bounce animated"
                });
                return false;
            }

            var idP = $('#idP').val();

            var ar = $();
            for (var i = 0; i < $('#dt_co').DataTable().rows()[0].length; i++) {
                ar = ar.add($('#dt_co').DataTable().row(i).node());
            }
            var data = ar.find('input').serialize()+'&id='+idP+'&'+ar.find('select').serialize();

            axios.post(baseUrl+'/pembelian/purchase-return/add', data).then((response) => {

                if(response.data.status == 'sukses'){
                    $.smallBox({
                        title: "Berhasil",
                        content: 'Return Barang Berhasil Dibuat...!',
                        color: "#739E73",
                        timeout: 3000,
                        icon: "fa fa-check bounce animated"
                    });

                    // window.open("{{url('/pembelian/purchase-order/print')}}"+"/"+response.data.id);
                    // window.location.href = baseUrl+'/pembelian/purchase-order/tambah';

                } else {
                    $.smallBox({
                        title: "gagal",
                        content: 'Return Barang Gagal Dibuat, Silahkan coba beberapa saat lagi..',
                        color: "#C46A69",
                        timeout: 3000,
                        icon: "fa fa-check bounce animated"
                    });
                }
            })

        }


    </script>

@endsection
