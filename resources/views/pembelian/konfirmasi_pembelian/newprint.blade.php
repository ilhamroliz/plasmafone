<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
        <title>Cetak Pemesanan Barang</title>
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
            <p style="text-align: center;">PLASMAFONE PUSAT</p>
            <p style="text-align: center;">Alamat : Jl. M.T. Haryono No.4, Krandegan, Banjarnegara</p>
            <p style="text-align: center;">No.Telp : (0286) 591567</p>
            <p style="text-align: center;">************************************************************************************</p>
        </div>

        @foreach ($confirm as $print)
        <div class="header1" style="margin-top: 15px">
            <span>Supplier</span>
        </div>

        <div class="header1" style="margin-top: 10px">
            <span>No. Nota : {{ $print->pc_nota }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Nama Supplier : {{ $print->s_company }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Alamat Supplier : {{ $print->s_address }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>No. Telp : {{ $print->s_phone }}</span>
        </div>
        @endforeach
        <div style="border: .6px dashed; margin-top: 15px">
        </div>
        <div class="header1">
            <div class="tanggal">
                <span style="float: left; width: 70%; margin-left: 10px;">Nama Barang</span>
                <span style="width: 30%">Jumlah Barang</span>
            </div>
        </div>
        <div style="border: .6px dashed;"></div>
        @foreach($confirmDT as $dtItem) 
        <div class="header1" style="margin-top: 10px">
            <div class="tanggal">
                <span style="float: left; width: 70%; margin-left: 10px;">{{ $dtItem->i_nama }}</span>
                <span style="width: 30%">{{ $dtItem->pcd_qty }}</span>
            </div>
        </div>
        @endforeach
        <div style="border: .6px dashed;"></div>
        <div class="footer" style="width: 100%;">
            <p style="text-align:center">PLASMAFONE</p>
        </div>   
    
        <script type="text/javascript">
            window.print();
        </script>
    </body>
</html>