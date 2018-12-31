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
            .trtb{
                border-bottom: 1px solid black;
                border-top: 1px solid black
            }
            .trbottom{
                border-top: 1px solid black
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
            
            <div style="padding-top: 20px; text-align: left; width:100%">
                <p><span style="width: 30%">No. Nota </span><span>: {{ $print->i_nota }}</span></p>
                <p class="mt-10"><span>Nama Customer </span><span>: {{ $print->m_name }}</span></p>
                <p class="mt-10"><span>Id Member </span><span>: {{ $print->m_idmember }}</span></p>
                <p class="mt-10"><span>No. Telp </span><span>: {{ $print->m_telp }}</span></p>
            </div>

            <div class="pt20">
                <table style="text-align: center; width: 100%">
                    <tr class="trtb">
                        <td style="width: 70%"><b>Nama Barang</b></td>
                        <td style="width: 30%"><b>Jumlah Barang</b></td>
                    </tr>
                    @foreach ($dtData as $dtItem)
                        <tr>
                            <td style="text-align:left; padding-left: 5px;">{{ $dtItem->i_nama }}</td>
                            <td>{{ $dtItem->id_qty }} Unit</td>
                        </tr>
                    @endforeach
                    <tr class="trbottom">
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        @endforeach


        <script src="{{ asset('template_asset/js/libs/jquery-2.1.1.min.js') }}"></script>
		<script src="{{ asset('template_asset/js/libs/jquery-ui-1.10.3.min.js') }}"></script>	
        <script type="text/javascript">
            $(document).ready(function(){
                window.print();
            });
        </script>
    </body>
</html>