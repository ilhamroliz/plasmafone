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
                                    <div id="bar-chart" class="chart" style="display: none"></div>
                                </div>

                                <div class="col-md-12">
                                    <div class="tab-content padding-10">
                                        <div>
                                            <form id="byForm">
                                                {{ csrf_field() }}
                                                <div class="col-md-12 no-padding padding-bottom-10">
                                                    <label for="bySelect" class="col-md-2 no-padding">Analisa Berdasarkan</label>
                                                    <div class="col-md-4 no-padding">
                                                        <select name="bySelect" id="bySelect" class="form-control">
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
                                                

                                                <div id="spes1" style="display: none" class="col-md-2 no-padding spesifik">
                                                    <label>Pencarian Spesifik</label>
                                                </div>
                                                <div id="spes2" style="display: none" class="col-md-4 no-padding spesifik">
                                                    <div class="input-group input-daterange" id="date-range" style="">
                                                        <input type="text" class="form-control" id="tglAwal" name="tglAwal" value="" placeholder="Tanggal Awal" data-dateformat="dd/mm/yy">
                                                        <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                        <input type="text" class="form-control" id="tglAkhir" name="tglAkhir" value="" placeholder="Tanggal Akhir" data-dateformat="dd/mm/yy">
                                                    </div>
                                                </div>
                                                <div id="spes3" style="display: none" class="col-md-1 spesifik">
                                                    <a class="btn btn-primary" style="width: 100%" onclick="cariWaktu()"><i class="fa fa-search"></i></a>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div id="chartContainer" class="text-center" style="height: 300px; width: 100%;"></div>
                                </div>

                                <div class="col-md-12 padding-bottom-10" id="divTabChart" style="padding-right: 0px; display: none">
                                    <div class="tab-content padding-10">

                                        <div class="col-md-4 no-padding">
                                            <div id="pie-chart" class="chart"></div>
                                        </div>
                                        
                                        <div class="tab-pane fade in active col-md-8" id="hr1">
                                            <table id="analisisTable" class="table table-striped table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 40%"><i class="fa fa-fw fa-list txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Kategori</th>
                                                        <th style="width: 30%"><i class="fa fa-fw fa-shopping-cart txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Jumlah Unit</th>
                                                        <th style="width: 30%"><i class="fa fa-fw fa-money txt-color-blue hidden-md hidden-sm hidden-xs"></i>&nbsp;Total Omset</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="showdata">
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

    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>

    {{-- <script>
        window.onload = function () {
        
        var options = {
            title: {
                text: "Analisis Penjualan Bulan Ini"
            },
            animationEnabled: true,
            data: [{
                type: "pie",
                startAngle: 40,
                toolTipContent: "<b>{label}</b>: {y}%",
                showInLegend: "true",
                legendText: "{label}",
                indexLabelFontSize: 16,
                indexLabel: "{label} - {y}%",
                dataPoints: [
                    { y: 20.36, label: "Windows 7" },
                    { y: 10.85, label: "Windows 10" },
                    { y: 1.49, label: "Windows 8" },
                    { y: 6.98, label: "Windows XP" },
                    { y: 6.53, label: "Windows 8.1" },
                    { y: 2.45, label: "Linux" },
                    { y: 3.32, label: "Mac OS X 10.12" },
                    { y: 4.03, label: "Others" }
                ]
            }]
        };
        $("#chartContainer").CanvasJSChart(options);
        
        }
    </script> --}}

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
                "searching" : false,
                "language" : dataTableLanguage    
            });

        });

        $('#bySelect').on('change', function (e) {
            $('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Memproses...');
    		$('#showdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');


            $( "#date-range" ).datepicker({
                language: "id",
                format: 'dd/mm/yyyy',
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                autoclose: true,
                todayHighlight: true
            });

            document.getElementById("bar-chart").style.display = "none";
            if($('#bySelect').val() != '7'){
                document.getElementById("spes1").style.display = "block";
                document.getElementById("spes2").style.display = "block";
                document.getElementById("spes3").style.display = "block";
            } 

            // document.getElementByClassName("spesifik").style.display = "block";

            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var total = 0;

            axios.post(baseUrl+'/man-penjualan/analisis-penjualan/analyze', {nilai:valueSelected}).then((response) => {
                $('#analisisTable').DataTable().clear();

                if(response.data.data.length > 0){
                    $('#divTabChart').css("display","block");
                }else{

                }

                for(var i = 0; i < response.data.data.length; i++){
                    $('#analisisTable').DataTable().row.add([
                        response.data.data[i].cat,
                        '<div class="text-align-right">'+response.data.data[i].sd_qty+' Unit</div>',
                        '<div><span style="float: left">Rp. </span><span style="float: right">'+accounting.formatMoney(response.data.data[i].sd_total_net, "", 2, ".", ",")+'</span></div>'
                    ]).draw(false);
                    total = total + parseInt(response.data.data[i].sd_qty);
                }

                /* pie chart */

                var data_pie = [];
                var series = response.data.data.length;
                for (var i = 0; i < series; i++) {
                    data_pie[i] = {
                        label : response.data.data[i].cat,
                        data : response.data.data[i].sd_qty
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
                        margin : [0, 0], // distance from grid edge to default legend container within plot
                        backgroundColor : "#efefef", // null means auto-detect
                        backgroundOpacity : 1 // set to 0 to avoid background
                    },
                    grid : {
                        hoverable : true,
                        clickable : true
                    },
                    tooltip : true,
                    tooltipOpts : {
                        content : "<span>%y/"+total+"</span>",
                        defaultTheme : false
                    }
                });

                /* end pie chart */
            })

            $('#overlay').fadeOut(200);
        });

        $('#forSelect').on('change', function (e) {
            document.getElementById("bar-chart").style.display = "block";

            ///== BAR CHART
            var ds = new Array();
            for(var i = 0; i < response.data.data.length; i++){
                var data1 = []; /// Deklarasi var data+i
                for (var j = 0; j < 12; j++){
                    data1.push([j, parseInt(response.data.data[i].sd_qty)])
                }
                
                ds.push({
                    data : data1,
                    bars : {
                        content : response.data.data[i].cat,
                        show : true,
                        barWidth : 0.1,
                        order : i + 1, 
                    }
                });
            }

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
        });

        function cariWaktu(){
            $('#overlay').fadeIn(200);
			$('#load-status-text').text('Sedang Memproses...');

    		$('#showdata').html('<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">Tidak ada data</td></tr>');

            var total = 0;
            var nilai = $('#bySelect').val();
            var tglAwal = $('#tglAwal').val();
            var tglAkhir = $('#tglAkhir').val();

            axios.post(baseUrl+'/man-penjualan/analisis-penjualan/analyze', {nilai: nilai, tglAwal: tglAwal, tglAkhir: tglAkhir}).then((response) => {
                $('#analisisTable').DataTable().clear();
                
                for(var i = 0; i < response.data.data.length; i++){
                    $('#analisisTable').DataTable().row.add([
                        response.data.data[i].cat,
                        '<div class="text-align-right">'+response.data.data[i].sd_qty+' Unit</div>',
                        '<div><span style="float: left">Rp. </span><span style="float: right">'+accounting.formatMoney(response.data.data[i].sd_total_net, "", 2, ".", ",")+'</span></div>'
                    ]).draw(false);
                    total = total + parseInt(response.data.data[i].sd_qty);
                }

                /* pie chart */

                var data_pie = [];
                var series = response.data.data.length;
                for (var i = 0; i < series; i++) {
                    data_pie[i] = {
                        label : response.data.data[i].cat,
                        data : response.data.data[i].sd_qty
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
                        margin : [0, 0], // distance from grid edge to default legend container within plot
                        backgroundColor : "#efefef", // null means auto-detect
                        backgroundOpacity : 1 // set to 0 to avoid background
                    },
                    grid : {
                        hoverable : true,
                        clickable : true
                    },
                    tooltip : true,
                    tooltipOpts : {
                        content : "<span>%y/"+total+"</span>",
                        defaultTheme : false
                    }
                });

                /* end pie chart */
            });
            $('#overlay').fadeOut(200);

        }

    </script>
@endsection
