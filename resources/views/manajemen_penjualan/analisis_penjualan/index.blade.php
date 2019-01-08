@extends('main')

@section('title', 'Analisis Penjualan')

@section('extra_style')

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
        <li>Home</li><li>Manajemen Penjualan</li><li>Analisis Penjualan</li>
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
                    <i class="fa-fw fa fa-sliders"></i>
                    Manajemen Penjualan <span><i class="fa fa-angle-double-right"></i> Analisis Penjualan </span>
                </h1>
            </div>

        </div>

        <section id="widget-grid" class="">

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="jarviswidget" id="wid-id-11" 
                        data-widget-editbutton="false" 
                        data-widget-colorbutton="false" 
                        data-widget-deletebutton="false">

                        <header>
                            <h2><strong>Analisis</strong></h2>
                        </header>

                        <div>
                            <div class="widget-body no-padding">

                                <div class="col-md-4">
                                    <canvas id="pieChart" height="120"></canvas>
                                </div>

                                <div class="col-md-8">
                                    <div class="tab-content padding-10">
                                        <form id="byForm">
                                            <div class="padding-bottom-10">
                                                <select name="bySelect" id="bySelect" class="form-input">
                                                    <option value="1">Usia Pembeli</option>
                                                    <option value="2">Harga Item</option>
                                                    <option value="3">Merek Item</option>
                                                    <option value="4">Jenis Item</option>
                                                    <option value="5">Warna Item</option>
                                                    <option value="6">Outlet Pembelian</option>
                                                    <option value="7">Waktu Pembelian</option>
                                                    <option value="8">Sales</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="tab-pane fade in active" id="hr1">
                                            <table id="realtimeTable" class="table table-striped table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 40%"><i class="fa fa-fw fa-list txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Kategori</th>
                                                        <th style="width: 30%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Jumlah Unit</th>
                                                        <th style="width: 30%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Omset</th>
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

            </div>
        
        </section>
    
    </div>
@endsection

@section('extra_script')
    <script type="text/javascript">
        $(document).ready(function(){
            
        })
    </script>
@endsection
