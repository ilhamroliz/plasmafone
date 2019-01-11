<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Nota Penjualan</title>
        <link rel="stylesheet" type"text/css" href="style.css" media="screen"> 
        <link rel="stylesheet" type"text/css" href="print.css" media="print">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/struk.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/print.css') }}">
        <script type="text/javascript">window.print();</script>
    </head>
    <body>
        <style type="text/css">
            @page{                
                margin-top: 65px;
                margin-left: 3px;
                margin-right: 3px;
                margin-bottom: 10px;
                font-family: "Courier New", Courier, monospace;
                font-size: 8px;
            }
            #header { 
                /*position: fixed;*/
                left: 0px; 
                right: 0px;
                text-align: center;
                margin-bottom: 5px;
            }
            #konten{
                 margin-top: 5px;
            }
            #konten p{
                margin-bottom: 5px;
            }
            #footer { 
                position: fixed;
                left: 0px; 
                right: 0px; 
                bottom: 10;
            }
            p {
                margin: 1px;
            }
            #halaman { 
                position: fixed;
                left: 0px; 
                right: 0px; 
                bottom: 10;
            }
            #halaman .page:after { 
                text-align: right;
                content: counter(page, upper-roman); 
            }
            .total-harga{
                float: right;
                margin-top: 10px;
                width: 35%;
                padding: 5px;
            }
            .pull-left {
                float: left;
            }
            .pull-right {
                float: right;
            }
            table tr td {
                padding: 5px;
            }
        </style>

        <?php 
        function tgl_indo($tanggal){
            $bulan = array (
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);
            
            // variabel pecahkan 0 = tanggal
            // variabel pecahkan 1 = bulan
            // variabel pecahkan 2 = tahun
        
            return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
        }
        ?>

        <div id="header">
            <div>
                <center><p><strong>{{ $datas[0]->nama_outlet }}</strong></p></center>
                <center><p style="margin-right: 10px; margin-left: 10px">{{ $datas[0]->alamat_outlet }}</p></center>
            </div>

            <br>

            <div style="border-bottom: solid 1px black;">
                <p>No. Nota : {{ $datas[0]->nota }}</p>
            </div>
        </div>

        <div id="footer">
            <p class="page"><strong>{{ $datas[0]->nama_outlet }}</strong></p>
        </div>

        <div id="halaman">
            <p></p>
        </div>

        <div id="konten">
            <p>{{ strtoupper($salesman) }}</p>

            <p>Customer</p>

            <p>Nama: {{ $datas[0]->nama_member }}</p>

            <p>Telepon: {{ $datas[0]->telp_member }}</p>

            <p>Tanggal: {{ date("d-m-Y h:i:sa", strtotime($datas[0]->tanggal)) }}</p>
        </div>
        <table style="page-break-inside: auto; border-bottom: 1px solid; margin-top: 15px; width: 100%;">
          <thead style="border-top: .6px dashed; border-bottom: .6px dashed;">
            <tr>
                <th>Jumlah</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
          </thead> 
        @foreach($datas as $index=>$data)
            <tbody>
                <tr>
                    <td class="border-kiri" align="center">{{ $data->qty }}</td>
                    <td>{{ $data->nama_item }}</td>
                    <td align="right" style="width: 30%;">Rp.{{ number_format($data->total_item,2,',','.') }}</td>
                    <td class="border-kanan" align="right" style="width: 30%;">Rp.{{ number_format($data->total,2,',','.') }}</td>
                </tr>
            </tbody>
        @endforeach
        </table>

        <div class="total-harga">
            <div style="margin-bottom: 25px;">
                <strong><p class="pull-left">Total</p></strong>
                <p class="pull-right">Rp.{{ number_format($datas[0]->total,2,',','.') }}</p>
            </div>
            
            <div style="margin-bottom: 48px;">
                <strong><p class="pull-left">Bayar Cash</p></strong>
                <p class="pull-right">Rp.1000.000,00</p>
            </div>
            
            <div style="margin-bottom: 70px;">
                <strong><p class="pull-left">Total Pembayaran</p></strong>
                <p class="pull-right">Rp.1000.000,00</p>
            </div>

            <div style="margin-bottom: 90px;">
                <strong><p class="pull-left">Kembali</p></strong>
                <p class="pull-right">Rp.1000.000,00</p>
            </div>
        </div>
        
    </body>
</html>
