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

                                <div class="col-md-12">
                                    <div id="bar-chart" class="chart"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="tab-content padding-10">
                                        <div>
                                            <form id="byForm">
                                                {{ csrf_field() }}
                                                <div class="col-md-7 no-padding padding-bottom-10">
                                                    <label for="bySelect" class="col-md-4 no-padding">Analisa Berdasarkan</label>
                                                    <div class="col-md-8 no-padding">
                                                        <select name="bySelect" id="bySelect" class="form-input">
                                                            <option value="">== Kategori ==</option>
                                                            <option value="1">Usia Pembeli</option>
                                                            <option value="2">Harga Item</option>
                                                            <option value="3">Merek Item</option>
                                                            <option value="4">Jenis Item</option>
                                                            <option value="5" disabled>Warna Item</option>
                                                            <option value="6">Outlet Pembelian</option>
                                                            <option value="7" disabled>Waktu Pembelian</option>
                                                            <option value="8">Sales</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="spesifikCari" style="display: block" class="col-md-7 no-padding">
                                                    <label for="spesifik" class="col-md-4 no-padding">Pencarian Spesifik</label>
                                                    <div class="col-md-8 no-padding">
                                                        <input type="text" id="spesifik" class="form-control" style="width: 100%">
                                                    </div>
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
    <!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
    <script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.cust.min.js') }}"></script>
    <script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.resize.min.js') }}"></script>
    <script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.fillbetween.min.js') }}"></script>
    <script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.orderBar.min.js') }}"></script>
    <script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.pie.min.js') }}"></script>
    <script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.time.min.js') }}"></script>
    <script src="{{ asset('template_asset/js/plugin/flot/jquery.flot.tooltip.min.js') }}"></script>

    <script src="{{ asset('template_asset/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>
    <script src="{{ asset('template_asset/js/plugin/accounting/accounting.js') }}"></script>

    <script type="text/javascript">
        var $chrt_border_color = "#efefef";
        var $chrt_grid_color = "#DDD"
        var $chrt_main = "#E24913";
        /* red       */
        var $chrt_second = "#6595b4";
        /* blue      */
        var $chrt_third = "#FF9F01";
        /* orange    */
        var $chrt_fourth = "#7e9d3a";
        /* green     */
        var $chrt_fifth = "#BD362F";
        /* dark red  */
        var $chrt_mono = "#000";

        $(document).ready(function(){

            pageSetUp();

            $('#analisisTable').DataTable({
                "order": [],
                "language" : dataTableLanguage});

        });

        $('select').on('change', function (e) {
            $('#analisisTable').DataTable().clear();

            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var total = 0;

            axios.post(baseUrl+'/man-penjualan/analisis-penjualan/analyze', {nilai:valueSelected}).then((response) => {
                for(var i = 0; i < response.data.data.length; i++){
                    $('#analisisTable').DataTable().row.add([
                        response.data.data[i].cat,
                        '<div class="text-align-right">'+response.data.data[i].sd_qty+' Unit</div>',
                        '<div><span style="float: left">Rp. </span><span style="float: right">'+accounting.formatMoney(response.data.data[i].sd_total_net, "", 2, ".", ",")+'</span></div>'
                    ]).draw(false);
                    total = total + parseInt(response.data.data[i].sd_qty);
                }

                ///== BAR CHART

                var data1 = []; /// Deklarasi var data+i
                for (var i = 0; i <= 12; i += 1)
                    data1.push([i, parseInt(Math.random() * 30)]);

                var data2 = [];
                for (var i = 0; i <= 12; i += 1)
                    data2.push([i, parseInt(Math.random() * 30)]);

                var data3 = [];
                for (var i = 0; i <= 12; i += 1)
                    data3.push([i, parseInt(Math.random() * 30)]);

                var ds = new Array();

                ds.push({
                    data : data1,
                    bars : {
                        show : true,
                        barWidth : 0.1,
                        order : 1, /// Diganti i+1
                    }
                });
                ds.push({
                    data : data2,
                    bars : {
                        show : true,
                        barWidth : 0.1,
                        order : 2
                    }
                });
                ds.push({
                    data : data3,
                    bars : {
                        show : true,
                        barWidth : 0.1,
                        order : 3
                    }
                });

                //Display graph
                $.plot($("#bar-chart"), ds, {
                    colors : [$chrt_second, $chrt_fourth, "#666", "#BBB"],
                    grid : {
                        show : true,
                        hoverable : true,
                        clickable : true,
                        tickColor : $chrt_border_color,
                        borderWidth : 0,
                        borderColor : $chrt_border_color,
                    },
                    legend : true,
                    tooltip : true,
                    tooltipOpts : {
                        content : "<b>%x</b> = <span>%y</span>",
                        defaultTheme : false
                    }

                });

				/* end bar chart */


                ///== End BAR CHART

                // /* pie chart */

                // var data_pie = [];
                // var series = response.data.data.length;
                // for (var i = 0; i < series; i++) {
                //     data_pie[i] = {
                //         label : response.data.data[i].cat,
                //         data : response.data.data[i].sd_qty
                //     }
                // }

                // $.plot($("#pie-chart"), data_pie, {
                //     series : {
                //         pie : {
                //             show : true,
                //             innerRadius : 0.5,
                //             radius : 1,
                //             label : {
                //                 show : false,
                //                 radius : 2 / 3,
                //                 formatter : function(label, series) {
                //                     return '<div style="font-size:11px;text-align:center;padding:4px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
                //                 },
                //                 threshold : 0.1
                //             }
                //         }
                //     },
                //     legend : {
                //         show : true,
                //         noColumns : 1, // number of colums in legend table
                //         labelFormatter : null, // fn: string -> string
                //         labelBoxBorderColor : "#000", // border color for the little label boxes
                //         container : null, // container (as jQuery object) to put legend in, null means default on top of graph
                //         position : "ne", // position of default legend container within plot
                //         margin : [5, 5], // distance from grid edge to default legend container within plot
                //         backgroundColor : "#efefef", // null means auto-detect
                //         backgroundOpacity : 1 // set to 0 to avoid background
                //     },
                //     grid : {
                //         hoverable : true,
                //         clickable : true
                //     },
                //     tooltip : true,
                //     tooltipOpts : {
                //         content : "<span>%y/"+total+"</span>",
                //         defaultTheme : false
                //     }
                // });

                // /* end pie chart */
            })
        });

    </script>
@endsection
