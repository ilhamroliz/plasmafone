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
        </style>
        <div class="judulPerusahaan">
            <p style="text-align: center;">************************************************************************************</p>
            <p style="text-align: center;">PLASMAFONE PUSAT</p>
            <p style="text-align: center;">Jl. M.T. Haryono No.4, Krandegan, Banjarnegara</p>
            <p style="text-align: center;">************************************************************************************</p>
        </div>

        <div class="header1" style="margin-top: 15px">
            <span>Supplier</span>
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
        <div class="header1">
            <div class="tanggal">
				<span style="width: 40%">Nama Barang</span>
				<span style="width: 10%">Jumlah Barang</span>
				<span style="width: 15%">Harga per Unit</span>
				<span style="width: 5%">Diskon %</span>
				<span style="width: 10%">Diskon Value</span>
                <span style="width: 15%; float: right;">Sub Total</span>
            </div>
        </div>
        <div style="border: .6px dashed;"></div>
    @foreach($datas as $index=>$data)
		<div class="header1" style="margin-top: 10px">
			<div class="tanggal">
				<span style="float: left; width: 40%">{{ $data->i_nama }}</span>
				<span style="width: 10%">{{ $data->pd_qty }}</span>
				<span style="width: 15%">Rp. {{ number_format($data->pd_value,2,',','.') }}</span>
				<span style="width: 5%">{{ $data->pd_disc_persen }} %</span>
				<span style="width: 10%">Rp. {{ number_format($data->pd_disc_value,2,',','.') }}</span>
				<span style="width: 15%; float: right;">Rp. 0</span>
			</div>
		</div>
    @endforeach
		<div style="border: .6px dashed;"></div>
		
        <div class="hasil" style="margin-bottom: 20px">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Sub Total Harga:</span>
            <span style="width: 20%; float: right;">Rp. {{ number_format( $datas[0]->p_total_gross, 0 , '' , '.' ) . ',-' }}</span>
        </div>

        <div class="hasil">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Diskon %:</span>
            <span style="width: 20%; float: right;">{{ $datas[0]->p_disc_persen }}</span>
		</div>
		
		<div class="hasil">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Diskon Value:</span>
            <span style="width: 20%; float: right;">Rp. {{ number_format( $datas[0]->p_disc_value, 0 , '' , '.' ) . ',-' }}</span>
		</div>
		
		<div class="hasil">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Pajak %:</span>
            <span style="width: 20%; float: right;">{{ $datas[0]->p_pajak }}</span>
		</div>


		<div class="hasil">
            <span style="width: 60%; float: left;"></span>
			<span style="width: 20%; margin-left: 5px;">Tipe Pemayaran:</span>
            <span style="width: 20%; float: right;">@if($datas[0]->p_type == 'C') CASH @else TEMPO @endif</span>
		</div> 
		
		<div class="hasil">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Jatuh Tempo:</span>
            <span style="width: 20%; float: right;"@if($datas[0]->p_type == 'C') date("d-m-Y", strtotime($datas[0]->p_due_date)) @else - @endif</span>
        </div> 

        <div class="hasil">
            <span style="width: 60%; float: left;"></span>
            <span style="width: 20%; margin-left: 5px;">Total Harga:</span>
            <span style="width: 20%; float: right;">Rp. {{ number_format( $datas[0]->p_total_net, 0 , '' , '.' ) . ',-' }}</span>
        </div> 
    <div class="footer" style="width: 100%;">
        <p style="text-align:center">PLASMAFONE</p>
    </div>       
    </body>
</html>

<script type="text/javascript">
    window.print();
</script>
