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
        @foreach ($data as $print)
        <div class="judulPerusahaan">
            <p style="text-align: center;">************************************************************************************</p>
            <p style="text-align: center;">{{ strtoupper($print->c_name) }}</p>
            <p style="text-align: center;">Alamat : {{ $print->c_address }}</p>
            <p style="text-align: center;">No.Telp : {{ $print->c_tlp }}</p>
            <p style="text-align: center;">************************************************************************************</p>
        </div>


        <div class="header1" style="margin-top: 15px">
            <span>Customer</span>
        </div>

        <div class="header1" style="margin-top: 10px">
            <span>No. Nota : {{ $print->i_nota }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Nama Customer : {{ $print->m_name }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Id Member : {{ $print->m_idmember }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>No. Telp : {{ $print->m_telp }}</span>
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
        @foreach($dtData as $dtItem) 
        <div class="header1" style="margin-top: 10px">
            <div class="tanggal">
                <span style="float: left; width: 70%; margin-left: 10px;">{{ $dtItem->i_nama }}</span>
                <span style="width: 30%">{{ $dtItem->id_qty }}</span>
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