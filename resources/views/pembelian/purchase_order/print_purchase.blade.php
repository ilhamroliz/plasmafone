<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
        <title>Nomor Nota: {{ $datas[0]->p_nota }}</title>
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
            @page {
                size: 35.7cm 25cm;
                margin: 10mm 10mm 10mm 10mm; /* change the margins as you want them to be. */
            }
        </style>
        <div class="judulPerusahaan">
            <p style="text-align: center;">************************************************************************************</p>
            <p style="text-align: center;">PLASMAFONE PUSAT</p>
            <p style="text-align: center;">Jl. M.T. Haryono No.4, Krandegan, Banjarnegara</p>
            <p style="text-align: center;">************************************************************************************</p>
        </div>

        <div class="header1" style="margin-top: 15px">
            <span>SUPPLIER</span>
        </div>

        <div class="header1" style="margin-top: 10px">
            <span>Nama: {{ $datas[0]->s_company }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Telp: {{ $datas[0]->s_phone }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Tanggal: {{ date("d-m-Y H:i:s", strtotime($datas[0]->p_date)) }}</span>
        </div>

        <div class="header1" style="margin-top: 5px">
            <span>Nota: {{ $datas[0]->p_nota }}</span>
        </div>

        <div style="border: .6px dashed; margin-top: 15px">
        </div>

        <table class="table table-borderless" style="width: 100%">
            <tr>
                <td style="width: 25%">Nama Barang</td>
                <td style="width: 10%; text-align: center">Jumlah Barang</td>
                <td style="width: 15%; text-align: center">Harga per Unit</td>
                <td style="width: 10%; text-align: center">Diskon %</td>
                <td style="width: 15%; text-align: center">Diskon Value</td>
                <td style="width: 20%; text-align: center">Sub Total</td>
            </tr>
        </table>

        <div style="border: .6px dashed;"></div>

        <table class="table table-borderless" style="width: 100%">
    @foreach($datas as $index=>$data)
        <tr>
            <td style="width: 25%">{{ $data->i_nama }}</td>
            <td style="width: 10%; text-align: right">{{ $data->qty }}</td>
            <td style="width: 15%; text-align: right">Rp. {{ number_format($data->pd_value,2,',','.') }}</td>
            <td style="width: 10%; text-align: right">{{ number_format($data->pd_disc_persen,0,',','.') }} %</td>
            <td style="width: 15%; text-align: right">Rp. {{ number_format($data->disc_value,2,',','.') }}</td>
            <td style="width: 20%; text-align: right">Rp. {{ number_format($data->subTotal,2,',','.') }}</td>
        </tr>
    @endforeach
        </table>

		<div style="border: .6px dashed;"></div>
		
        <div class="hasil" style="margin-bottom: 20px; margin-top: 10px;">
            <span style="width: 70%; float: left;"></span>
            <span style="width: 10%; margin-left: 5px;">Sub Total Harga:</span>
            <span style="width: 20%; float: right; text-align: right">Rp. {{ number_format( $datas[0]->p_total_gross, 0 , '' , '.' ) . ',-' }}</span>
        </div>

        <div class="hasil">
            <span style="width: 70%; float: left;"></span>
            <span style="width: 10%; margin-left: 5px;">Diskon %:</span>
            <span style="width: 20%; float: right; ; text-align: right">{{ number_format( $datas[0]->p_disc_persen, 0 , '' , '.' ) }} %</span>
		</div>
		
		<div class="hasil">
            <span style="width: 70%; float: left;"></span>
            <span style="width: 10%; margin-left: 5px;">Diskon Value:</span>
            <span style="width: 20%; float: right; ; text-align: right">Rp. {{ number_format( $datas[0]->p_disc_value, 0 , '' , '.' ) . ',-' }}</span>
		</div>
		
		<div class="hasil">
            <span style="width: 70%; float: left;"></span>
            <span style="width: 10%; margin-left: 5px;">Pajak %:</span>
            <span style="width: 20%; float: right; ; text-align: right">{{ number_format( $datas[0]->pajak, 0 , '' , '.' ) }} %</span>
		</div>


		<div class="hasil">
            <span style="width: 70%; float: left;"></span>
			<span style="width: 10%; margin-left: 5px;">Tipe Pemayaran:</span>
            <span style="width: 20%; float: right; ; text-align: right">@if($datas[0]->p_type == 'C') CASH @else TEMPO @endif</span>
		</div> 
		
		<div class="hasil">
            <span style="width: 70%; float: left;"></span>
            <span style="width: 10%; margin-left: 5px;">Jatuh Tempo:</span>
            <span style="width: 20%; float: right; ; text-align: right">@if($datas[0]->p_type == 'C') - @else {{ date("d-m-Y", strtotime($datas[0]->p_due_date)) }} @endif</span>
        </div> 

        <div class="hasil">
            <span style="width: 70%; float: left;"></span>
            <span style="width: 10%; margin-left: 5px;">Total Harga:</span>
            <span style="width: 20%; float: right; ; text-align: right">Rp. {{ number_format( $datas[0]->p_total_net, 0 , '' , '.' ) . ',-' }}</span>
        </div> 
    <div class="footer" style="width: 100%;">
        <p style="text-align:center">PLASMAFONE</p>
    </div>       
    </body>
</html>

<script type="text/javascript">
    window.print();
</script>
