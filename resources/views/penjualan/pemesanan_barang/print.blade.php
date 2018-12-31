<html>
    <head>
        <style>
            .mt-10{
                margin-top: -10px
            }
            .pt20{
                padding-top: 20px
            }
            table{
                border-collapse: collapse
            }
            td{
                padding: 5px
            }
        </style>
    </head>
    <body>
        @foreach ($data as $print)
            <div style="text-align: center">
                <p><h3><b>{{ strtoupper($print->c_name) }}</b></h3></p>
                <p>Alamat : {{ $print->c_address }}</p>
                <p style="margin-top: -10px">No.Telp : {{ $print->c_tlp }}</p>
            </div>    
            
            <div style="padding-top: 20px; text-align: left">
                <p><span>No. Nota</span><span>: {{ $print->i_nota }}</span></p>
                <p class="mt-10"><span>Nama Customer</span><span>: {{ $print->m_name }}</span></p>
                <p class="mt-10"><span>Id Member</span><span>: </span></p>
                <p class="mt-10"><span>No. Telp</span><span>: {{ $print->m_telp }}</span></p>
            </div>

            <div class="pt20">
                <table style="text-align: center">
                    <tr>
                        <td style="width: 400px"><b>Nama Barang</b></td>
                        <td style="width: 150px"><b>Jumlah Barang</b></td>
                    </tr>
                    @foreach ($dtData as $dtItem)
                        <tr>
                            <td style="text-align:left; padding-left: 5px;">{{ $dtItem->i_nama }}</td>
                            <td>{{ $dtItem->id_qty }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </body>
</html>