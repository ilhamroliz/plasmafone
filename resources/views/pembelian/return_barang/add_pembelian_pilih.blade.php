@extends('main')

@section('title', 'Purchase Order')

@section('extra_style')

    <style type="text/css">
        .page-footer {
            padding-left: 10px !important;
        }
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

                    <a href="{{ url('pembelian/purchase-order') }}" class="btn btn-default"><i
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
                            @foreach($getPurchase as $purchase)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <label for="" class="col-md-4">Nomor Nota</label>
                                                <div class="col-md-8">
                                                    <input type="text" id="pNota" class="form-control"
                                                            value="{{ $purchase->p_nota }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12 margin-top-10">
                                                <label for="" class="col-md-4">Nama Supplier</label>
                                                <div class="col-md-8">
                                                    <input type="hidden" id="idSupp" value="{{ $purchase->s_id }}">
                                                    <input type="text" id="namaSupp" class="form-control"
                                                           value="{{ $purchase->s_company }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12 margin-top-10 margin-bottom-10">
                                                <label for="" class="col-md-4">No. Telp</label>
                                                <div class="col-md-8">
                                                    <input type="text" id="telpSupp" class="form-control"
                                                           value="{{ $purchase->s_phone }}" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
							@endforeach
                            <form id="id">
                                <input type="hidden" id="idP" value="{{ $getId }}" name="id">
                            </form>
                            <!-- widget body text-->
                            <div class="tab-content padding-10">
                                <div class="tab-pane fade in active">
                                    <table id="dt_co" class="table table-striped table-bordered table-hover"
                                           width="100%">
                                        <thead class="table-responsive">
                                            <tr>
                                                <th width="10%"></th>
                                                <th width="50%">Nama Barang</th>
                                                <th width="20%">Kode Spesifik / QTY</th>
                                                <th width="20%">Nota DO</th>
                                            </tr>
                                        </thead>

                                                <tbody id="dtcoBody">
                                                @for($i = 0; $i < count($getDataDT); $i++)
                                                    <tr>
                                                        @if($getDataDT[$i]->i_specificcode == 'Y' && $getDataDT[$i]->pd_specificcode == '')
                                                            <td><div class="text-center">
                                                                <input type="checkbox" name="check[]" class="checkB" disabled>
                                                            </div></td>
                                                        @else
                                                            <td><div class="text-center">
                                                                <input type="checkbox" id="cekbok-{{$i}}" name="check[{{$i}}]" class="checkB" value="{{ $getDataDT[$i]->pd_purchase.'=='.$getDataDT[$i]->pd_detailid.'=='.$getDataDT[$i]->i_specificcode}}">
                                                            </div></td>
                                                        @endif
                                                        <td>
                                                            <input type="hidden" name="item[]" value="{{$i.'=='.$getDataDT[$i]->i_id}}">
                                                            {{ $getDataDT[$i]->i_nama }}
                                                        </td>
                                                        @if($getDataDT[$i]->i_specificcode == 'Y')
                                                            <td>
                                                                <input type="hidden" name="qty[{{$i}}]">
                                                                <input type="hidden" name="kode[{{$i}}]" value="{{ $getDataDT[$i]->pd_specificcode }}">
                                                                {{ $getDataDT[$i]->pd_specificcode }}
                                                            </td>
                                                        @else
                                                            <td>
                                                              <div style="width: 100%">
                                                                  <input type="hidden" name="kode[{{$i}}]" value="{{ $getDataDT[$i]->pd_specificcode }}">
                                                                  <input type="text" id="qty-{{$i}}" name="qty[{{$i}}]" class="form-control" style="width: 70%">
                                                                  <span style="width: 30%">
                                                                    / {{ $getDataDT[$i]->pd_qty }}
                                                                  <span>
                                                              </div>
                                                            </td>
                                                        @endif
                                                        <td>

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
                                                        onclick="lanjutkan()">Lanjutkan Return
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

                dt_co = $('#dt_co').DataTable({
                    "language": dataTableLanguage,
                    "order": []
                });

            })

            function lanjutkan(){

                var idP = $('#idP').val();
                var pNota = $('#pNota').val();
                var namaSupp = $('#namaSupp').val();
                var telpSupp = $('#telpSupp').val();

                var ar = $();
                for (var i = 0; i < $('#dt_co').DataTable().rows()[0].length; i++) {
                    ar = ar.add($('#dt_co').DataTable().row(i).node());
                }

                window.location.href = baseUrl+'/pembelian/purchase-return/add?lanjut=yes&'+ar.find('input').serialize()+'&idP='+idP+'&pNota='+pNota+'&namaSupp='+namaSupp+'&telpSupp='+telpSupp;
            }

    </script>

@endsection
