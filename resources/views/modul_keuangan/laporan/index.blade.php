@extends('main')

@section('title', 'Laporan Keuangan')

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

    <?php 

        // jurnal
            $tanggal = date('Y-m').'-01';

            $tanggalFirst = date('d/m/Y', strtotime($tanggal));
            $tanggalNext = date('d/m/Y', strtotime("+1 months", strtotime($tanggal)));

            $jurnalRequest = "_token=".csrf_token()."&d1=".$tanggalFirst."&d2=".$tanggalNext."&type=K&nama=true";

        // buku besar
            $bulan = date('Y-m');

            $bulanFirst = date('m/Y', strtotime($bulan));
            $bulanNext = date('m/Y', strtotime("+1 months", strtotime($bulan)));

            $buku_besar = "_token=".csrf_token()."&d1=".$bulanFirst."&d2=".$bulanNext."&semua=on&lawan=true";

        // Neraca Saldo
            $neraca_saldo = "_token=".csrf_token()."&d1=".$bulanFirst;

        // Neraca
            $neraca = "_token=".csrf_token()."&d1=".$bulanFirst."&type=bulan&tampilan=tabular&y1=";

        // laba_rugi
            $laba_rugi = "_token=".csrf_token()."&d1=".$bulanFirst."&type=bulan&tampilan=tabular&y1=";


        // hutang
            $hutang = "_token=".csrf_token()."&d1=".date('d/m/Y')."&jenis=rekap&type=Hutang_Supplier&semua=on";

        // Piutang
            $piutang = "_token=".csrf_token()."&d1=".date('d/m/Y')."&jenis=rekap&type=Piutang_Customer&semua=on";
    ?>

    <div class="col-md-12" style="background: none; margin-top: 20px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 content-title">
                    Laporan Keuangan
                </div>
            </div>  
        </div>

        <div class="col-md-12 table-content">
            <div class="row" style="padding: 10px 30px;">
                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('laporan.keuangan.jurnal_umum', $jurnalRequest) }}">
                                <i class="fa fa-clipboard" style="font-size: 42pt; color: #ffbb33;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ route('laporan.keuangan.jurnal_umum', $jurnalRequest) }}">
                                Jurnal Umum
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('laporan.keuangan.buku_besar', $buku_besar) }}">
                                <i class="fa fa-book" style="font-size: 42pt; color: #ffbb33;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ route('laporan.keuangan.buku_besar', $buku_besar) }}">
                                Buku Besar
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('laporan.keuangan.neraca_saldo', $neraca_saldo) }}">
                                <i class="fa fa-bar-chart" style="font-size: 42pt; color: #ffbb33;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('laporan.keuangan.neraca_saldo', $neraca_saldo) }}">
                                Neraca Saldo
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('laporan.keuangan.neraca', $neraca) }}">
                                <i class="fa fa-balance-scale" style="font-size: 42pt; color: #ffbb33;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('laporan.keuangan.neraca', $neraca) }}">
                                Neraca
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('laporan.keuangan.laba_rugi', $laba_rugi) }}">
                                <i class="fa fa-list-ul" style="font-size: 42pt; color: #ffbb33;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('laporan.keuangan.laba_rugi', $laba_rugi) }}">
                                Laba Rugi
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="#">
                                <i class="fa fa-random" style="font-size: 42pt; color: #ffbb33;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('laporan.keuangan.arus_kas', $laba_rugi) }}">
                                Arus Kas
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('laporan.keuangan.hutang', $hutang) }}">
                                <i class="fa fa-upload" style="font-size: 42pt; color: #33b5e5;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('laporan.keuangan.hutang', $hutang) }}">
                                Laporan Hutang
                            </a>
                        </div>    
                    </div>
                </div>

                <div class="col-md-3" style="padding: 10px 30px;">
                    <div class="row laporan-wrap">
                        <div class="col-md-12 text-center">
                            <a href="{{ Route('laporan.keuangan.piutang', $piutang) }}">
                                <i class="fa fa-download" style="font-size: 42pt; color: #33b5e5;"></i>
                            </a>
                        </div>

                        <div class="col-md-12 text-center text">
                            <a href="{{ Route('laporan.keuangan.piutang', $piutang) }}">
                                Laporan Piutang
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