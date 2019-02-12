@extends('main')

@section('title', 'Analisa Keuangan')

@section(modulSetting()['extraStyles'])

	<link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.css') }}">
    
    <style type="text/css">
        .laporan-wrap{
            box-shadow: 0px 0px 5px #aaa;
            border: 0px solid #ccc;
            padding: 20px;
        }

        .laporan-wrap .text{
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-weight: 600;
        }

        .laporan-wrap a{
            color: #777;
            text-decoration: none;
        }

        .laporan-wrap a:hover{
            color: #000;
        }
    </style>

@endsection


@section('main_content')

    <div class="col-md-12" style="background: none; margin-top: 20px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 content-title">
                    Analisa Keuangan
                </div>
            </div>  
        </div>

        <div class="col-md-12 table-content">
            <div class="row" style="padding: 10px 30px;">
                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('analisa.keuangan.npo', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                <i class="fa fa-line-chart" style="font-size: 42pt; color: #00C851;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('analisa.keuangan.npo', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                Analisa Net Profit/OCF
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('analisa.keuangan.hutang_piutang', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                <i class="fa fa-line-chart" style="font-size: 42pt; color: #00C851;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('analisa.keuangan.hutang_piutang', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                Analisa Hutang Piutang
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('analisa.keuangan.pertumbuhan_aset', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                <i class="fa fa-line-chart" style="font-size: 42pt; color: #00C851;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('analisa.keuangan.pertumbuhan_aset', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                Pertumbuhan Aset
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('analisa.keuangan.aset_ekuitas', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                <i class="fa fa-line-chart" style="font-size: 42pt; color: #00C851;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('analisa.keuangan.aset_ekuitas', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                Aset Terhadap Ekuitas
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('analisa.keuangan.common_size', '_token='.csrf_token().'&type=neraca&d1='.date('Y')) }}">
                                <i class="fa fa-line-chart" style="font-size: 42pt; color: #00C851;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('analisa.keuangan.common_size', '_token='.csrf_token().'&type=neraca&d1='.date('Y')) }}">
                                Common Size & Index
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('analisa.keuangan.cashflow', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                <i class="fa fa-line-chart" style="font-size: 42pt; color: #00C851;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('analisa.keuangan.cashflow', '_token='.csrf_token().'&type=bulan&d1='.date('Y')) }}">
                                Analisa Cashflow
                            </a>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section(modulSetting()['extraScripts'])
	
	<script src="{{ asset('modul_keuangan/js/options.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/toast/dist/jquery.toast.min.js') }}"></script>
	<script src="{{ asset('modul_keuangan/js/vendors/bootstrap_datatable_v_1_10_18/datatables.min.js') }}"></script>
    <script src="{{ asset('modul_keuangan/js/vendors/axios_0_18_0/axios.min.js') }}"></script>

@endsection