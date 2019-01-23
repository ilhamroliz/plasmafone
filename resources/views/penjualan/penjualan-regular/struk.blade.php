<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
        <title>Nomor Nota: {{ $datas[0]->nota }}</title>
    </head>
    <body>
        <style type="text/css">
            *{
                margin: 1px;
                font-family: "Courier New", Courier, monospace;
                font-size: 12px;
            }
            .hasil {
                margin-top: 3px;
            }
            .footer {
                position: fixed; 
                bottom: 0;
                left: 0;
                right: 0;
                height: 150px;
            }
        </style>
        <div class="judulPerusahaan">
            <p style="text-align: center;">************************************************************************************</p>
            <p style="text-align: center;">{{ $datas[0]->nama_outlet }}</p>
            <p style="text-align: center;">{{ $datas[0]->alamat_outlet }}</p>
            <p style="text-align: center;">************************************************************************************</p>
        </div>

        <div class="header1">
            <span>Salesman: {{ strtoupper($salesman) }}</span>
        </div>

        <div class="header1" style="margin-top: 15px">
            <span>Customer</span>
        </div>

        <div class="header1" style="margin-top: 10px">
            <span>Nama: {{ $datas[0]->nama_member }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Telp: {{ $datas[0]->telp_member }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Tanggal: {{ date("d-m-Y H:i:s", strtotime($datas[0]->tanggal)) }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Nota: {{ $datas[0]->nota }}</span>
        </div>

        <div style="border: .6px dashed; margin-top: 15px">
        </div>
        <div class="header1">
            <div class="tanggal">
                <span style="float: left; width: 10%;">Jumlah</span>
                <span style="width: 60%">Nama Barang</span>
                {{--<span style="width: 20%; float: right;">Harga(*)</span>--}}
                <span style="width: 20%; float: right;">Total Harga</span>
            </div>
        </div>
        <div style="border: .6px dashed;"></div>
    @foreach($datas as $index=>$data) 
        <div class="header1" style="margin-top: 10px">
            <div class="tanggal">
                <span style="float: left; width: 10%; margin-left: 10px;">{{ $data->qty }}</span>
                <span style="width: 60%; margin-left: -10px">{{ $data->nama_item }} {{ $data->specificcode }}</span>
                {{--<span style="margin-left: 90px;">Rp. {{ number_format($data->total_item,2,',','.') }}</span>--}}
                <span style="width: 20%; margin-left: 5px; float: right;">Rp. {{ number_format($data->total,2,',','.') }}</span>
            </div>
        </div>
    @endforeach
        <div style="border: .6px dashed;"></div>
        <div class="hasil">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Total Harga:</span>
            <span style="width: 20%; float: right;">Rp. {{ number_format( $totHarga, 0 , '' , '.' ) . ',-' }}</span>
        </div>
        <div class="hasil">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Dibayar:</span>
            <span style="width: 20%; float: right;">Rp. {{ number_format( $dibayar, 0 , '' , '.' ) . ',-' }}</span>
        </div>
        <div class="hasil">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Kembali:</span>
            <span style="width: 20%; float: right;">Rp. {{ number_format( $kembali, 0 , '' , '.' ) . ',-' }}</span>
        </div> 
    <div class="footer" style="width: 100%;">
        <p style="text-align:center">PLASMAFONE</p>
    </div>       
    </body>
</html>

<script type="text/javascript">
    window.print();
</script>
