<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
    <title>Nomor Nota: {{$datas[0]->nota_service}}</title>
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
    .ket {
        float: right;
        width: 50%;
        margin-top: 0px;
    }
    .row {
        position: relative;
    }
    .text-center {
        text-align: center;
    }
    .text-left {
        text-align: left;
    }
    .width-10 {
        width: 10%;
    }
    .width-20 {
        width: 20%;
    }
    .width-30 {
        width: 30%;
    }
    .width-40 {
        width: 40%;
    }
    .width-50 {
        width: 50%;
    }
    .width-90 {
        width: 90%;
    }
    table {
        width: 100%;
    }

</style>
<div class="judulPerusahaan">
    <p style="text-align: center;">************************************************************************************</p>
    <p style="text-align: center;">{{$datas[0]->outlet}}</p>
    <p style="text-align: center;">{{$datas[0]->outlet_address}}</p>
    <p style="text-align: center;">************************************************************************************</p>
</div>

<div class="header1" style="margin-top: 15px">
    <span>Customer</span>
</div>

<div class="header1" style="margin-top: 10px">
    <span>Nama: {{$datas[0]->buyer}}</span>
</div>

<div class="header1" style="margin-top: 5px">
    <span>Telp: {{$datas[0]->telp}}</span>
</div>

<div class="header1" style="margin-top: 5px">
    <span>Tanggal: {{date("d-m-Y", strtotime($datas[0]->date))}}</span>
</div>

<div class="header1" style="margin-top: 20px">
    <span>Nota Service: {{ $datas[0]->nota_service }}</span>
</div>

<div class="header1" style="margin-top: 5px">
    <span>Nota Penjualan: {{ $datas[0]->nota_sales }}</span>
</div>

<div class="header1" style="margin-top: 15px">
    <span>Petugas: {{ $datas[0]->officer }}</span>
</div>

<div style="border: .6px dashed; margin-top: 15px"></div>
<table>
    <tr>
        <td class="text-center width-10">Jumlah</td>
        <td class="text-left width-40">Nama Barang</td>
        <td class="text-left width-50">Keterangan</td>
    </tr>
</table>
<div style="border: .6px dashed;"></div>
<table>
    @foreach($datas as $index=>$data)
        @if ($data->code != null)
            <tr>
                <td class="text-center width-10">{{ $data->qty }}</td>
                <td class="text-left width-40">{{ $data->code }} - {{ $data->item }}</td>
                <td class="text-left width-50">{{ $data->note }}</td>
            </tr>
        @else
            <tr>
                <td class="text-center width-10">{{ $data->qty }}</td>
                <td class="text-left width-40">{{ $data->item }} {{ $data->specificcode }}</td>
                <td class="text-left width-50">{{ $data->note }}</td>
            </tr>
        @endif
    @endforeach
</table>
<div style="border: .6px dashed;"></div>

<div class="footer" style="width: 100%;">
    <p style="text-align:center">PLASMAFONE</p>
</div>
</body>
</html>

<script type="text/javascript">
    window.print();
</script>
