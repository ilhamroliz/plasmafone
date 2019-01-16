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
            <p style="text-align: center;">{{ strtoupper($from->c_name) }}</p>
            <p style="text-align: center;">{{ strtoupper($from->c_address) }}</p>
            <p style="text-align: center;">************************************************************************************</p>
        </div>
        <div class="header1" style="margin-top: 15px">
            <span>Tanggal: {{ date('d-m-Y H:m:sa', strtotime($datas[0]->tanggal)) }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Nomor Nota: {{ $datas[0]->nota }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Tujuan: {{ $datas[0]->tujuan }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Dari: {{ $from->c_name }}</span>
        </div>

        <div style="margin-top: 5px;">
            <span>Petugas : {{ $datas[0]->petugas }}</span>
        </div>

        <div style="border: .6px dashed; margin-top: 15px">
        </div>
        <div class="header1">
            <div class="tanggal">
                <span style="float: left; width: 10%;">Jumlah</span>
                <span style="width: 70%">Barang</span>
            </div>
        </div>
        <div style="border: .6px dashed;"></div>
    @foreach($datas as $index=>$data) 
        <div class="header1" style="margin-top: 10px">
            <div class="tanggal">
                <span style="float: left; width: 10%; margin-left: 10px;">{{ $data->qty }}</span>
                <span style="width: 70%; margin-left: -10px">{{ $data->nama_barang }}</span>
            </div>
        </div>
    @endforeach
        <div style="border: .6px dashed;"></div>
    <div class="footer" style="width: 100%;">
        <table style="width: 100%; text-align: center; height: 100px;">
            <tr>
                <td style="width: 33%">Gudang</td>
                <td style="width: 33%">Pengirim</td>
                <td style="width: 33%">Penerima</td>
            </tr>
            <tr>
                <td style="width: 33%;">(====================)</td>
                <td style="width: 33%;">(====================)</td>
                <td style="width: 33%;">(====================)</td>
            </tr>
        </table>
    </div>       
    </body>
</html>

<script type="text/javascript">
    window.print();
</script>