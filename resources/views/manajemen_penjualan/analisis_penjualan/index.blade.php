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
                            <h2><strong>Analisis Penjualan</strong></h2>
                        </header>

                        <div>
                            <div class="widget-body no-padding">

                                <div class="col-md-4">
                                    <div id="pie-chart" class="chart"></div>
                                </div>

                                <div class="col-md-8">
                                    <div class="tab-content padding-10">
                                        <div>
                                            <form id="byForm">
                                                {{ csrf_field() }}
                                                <div class="padding-bottom-10">
                                                    <label for="bySelect">Analisa Berdasarkan : </label>
                                                    <select name="bySelect" id="bySelect" class="form-input">
                                                        <option value="">== Kategori ==</option>
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
                                        </div>
                                        
                                        <div class="tab-pane fade in active" id="hr1">
                                            <table id="analisisTable" class="table table-striped table-bordered table-hover" width="100%">
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

    <script src="js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            pageSetUp();

            $('#analisisTable').DataTable({"language" : dataTableLanguage});

        });

        $('select').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;

            axios.post(baseUrl+'/man-penjualan/analisis-penjualan/analyze', {nilai:valueSelected}).then((response) => {
                $('#analisisTable').DataTable().clear();
                for(var i = 0; i < response.data.data.length; i++){
                    $('#analisisTable').DataTable().row.add([
                        response.data.data[i].cat,
                        response.data.data[i].qty,
                        response.data.data[i].net
                    ]).draw(false);
                }

                /* pie chart */

                var data_pie = [];
                var series = response.data.data.length;
                for (var i = 0; i < series; i++) {
                    data_pie[i] = {
                        label : response.data.data[i].cat,
                        data : response.data.data[i].qty
                    }
                }

                $.plot($("#pie-chart"), data_pie, {
                    series : {
                        pie : {
                            show : true,
                            innerRadius : 0.5,
                            radius : 1,
                            label : {
                                show : false,
                                radius : 2 / 3,
                                formatter : function(label, series) {
                                    return '<div style="font-size:11px;text-align:center;padding:4px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
                                },
                                threshold : 0.1
                            }
                        }
                    },
                    legend : {
                        show : true,
                        noColumns : 1, // number of colums in legend table
                        labelFormatter : null, // fn: string -> string
                        labelBoxBorderColor : "#000", // border color for the little label boxes
                        container : null, // container (as jQuery object) to put legend in, null means default on top of graph
                        position : "ne", // position of default legend container within plot
                        margin : [5, 10], // distance from grid edge to default legend container within plot
                        backgroundColor : "#efefef", // null means auto-detect
                        backgroundOpacity : 1 // set to 0 to avoid background
                    },
                    grid : {
                        hoverable : true,
                        clickable : true
                    },
                });

                /* end pie chart */
            })
        });

    </script>
@endsection
