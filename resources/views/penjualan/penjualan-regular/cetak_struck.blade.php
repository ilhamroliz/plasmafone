<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Nota Penjualan</title>
        <link rel="stylesheet" type"text/css" href="style.css" media="screen"> 
        <link rel="stylesheet" type"text/css" href="print.css" media="print">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/struk.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('template_asset/css/print.css') }}">
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
                margin-top: 5px;
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
        <div id="header">
            <div>
                <center><p><strong>PLASMAFONE</strong></p></center>
                <center><p style="margin-right: 10px; margin-left: 10px">Ini alamat</p></center>
            </div>

            <br>

            <div style="border-bottom: solid 1px black;">
                <p>No. Nota : Ini nomor nota</p>
            </div>
        </div>

        <div id="footer">
            <p class="page"><strong>Plasmafone</strong></p>
        </div>

        <div id="halaman">
            <p></p>
        </div>

        <div id="konten">
            <p>Ini nama Salesman</p>

            <p>Customer</p>

            <p>Nama: Ini nama member</p>

            <p>Telepon: Ini nomor telephone member</p>

            <p>Tanggal: Ini untuk saled date</p>
        </div>
        <table style="page-break-inside: auto; border-bottom: 1px solid; margin-top: 15px; width: 100%;">
          <thead style="border-top: .6px dashed; border-bottom: .6px dashed;">
            <tr">
                <th>Jumlah</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
          </thead> 
        {{--@foreach($informasi as $index=>$data)
            @if($data->sd_sales != null)--}}
            <tbody>
                <tr>
                    <td class="border-kiri" align="center">3</td>
                    <td>Acer</td>
                    <td align="right" style="width: 30%;">Rp. 1000</td>
                    <td class="border-kanan" align="right" style="width: 30%;">Rp. 1000</td>
                </tr>
            </tbody>
            {{--@endif
        @endforeach--}}
        </table>

        <div class="total-harga">
            <div style="margin-bottom: 25px;">
                <strong><p class="pull-left">Total</p></strong>
                <p class="pull-right">Rp.1000.000,00</p>
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
