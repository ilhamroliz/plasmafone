<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template_asset/img/favicon/favicon.ico') }}" type="image/x-icon">
    <title>Nomor Nota: {{$datas[0]->nota_return}}</title>
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
    <p style="text-align: center;">{{$datas[0]->nama_outlet}}</p>
    <p style="text-align: center;">{{$datas[0]->alamat_outlet}}</p>
    <p style="text-align: center;">************************************************************************************</p>
</div>

<div class="header1" style="margin-top: 15px">
    <span>Customer</span>
</div>

<div class="header1" style="margin-top: 10px">
    <span>Nama: {{$datas[0]->nama_member}}</span>
</div>

<div class="header1" style="margin-top: 5px">
    <span>Telp: {{$datas[0]->telp_member}}</span>
</div>

<div class="header1" style="margin-top: 5px">
    <span>Tanggal: {{date("d-m-Y", strtotime($datas[0]->tgl_return))}}</span>
</div>

<div class="header1" style="margin-top: 20px">
    <span>Nota Return: {{ $datas[0]->nota_return }}</span>
</div>

<div class="header1" style="margin-top: 5px">
    <span>Nota Penjualan: {{ $datas[0]->nota_penjualan }}</span>
</div>

<div class="header1" style="margin-top: 5px">
    <span>Jenis Return: @if ($datas[0]->jenis_return == "GBS") Ganti Barang Sejenis @elseif ($datas[0]->jenis_return == "GBL") Ganti Barang Lain @elseif ($datas[0]->jenis_return == "GU") Ganti Uang @endif</span>
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
        @if ($data->rpd_code != null)
            <tr>
                <td class="text-center width-10">{{ $data->rpd_qty }}</td>
                <td class="text-left width-40">{{ $data->rpd_code }} - {{ $data->rpd_item }}</td>
                <td class="text-left width-50">{{ $data->rpd_note }}</td>
            </tr>
        @else
            <tr>
                <td class="text-center width-10">{{ $data->rpd_qty }}</td>
                <td class="text-left width-40">{{ $data->rpd_item }} {{ $data->rpd_specificcode }}</td>
                <td class="text-left width-50">{{ $data->rpd_note }}</td>
            </tr>
        @endif
    @endforeach
</table>
<div style="border: .6px dashed;"></div>

@if ($datas[0]->jenis_return != "GU")
    <div style="margin-top: 15px">
        <span><i><strong>BARANG PENGGANTI</strong></i></span>
    </div>

    <div style="border: .6px dashed; margin-top: 15px"></div>
    <table>
        <tr>
            <td class="text-center width-10">Jumlah</td>
            <td class="text-left width-90">Nama Barang</td>
        </tr>
    </table>
    <div style="border: .6px dashed;"></div>
    <table>
        @foreach($datas as $index=>$data)
            @if ($data->rpg_code != null)
                <tr>
                    <td class="text-center width-10">{{ $data->rpg_qty }}</td>
                    <td class="text-left width-90">{{ $data->rpg_code }} - {{ $data->rpg_item }}</td>
                </tr>
            @else
                <tr>
                    <td class="text-center width-10">{{ $data->rpg_qty }}</td>
                    <td class="text-left width-90">{{ $data->rpg_item }} {{ $data->rpg_specificcode }}</td>
                </tr>
            @endif
        @endforeach
    </table>
    <div style="border: .6px dashed;"></div>
@endif


<div class="footer" style="width: 100%;">
    <p style="text-align:center">PLASMAFONE</p>
</div>
</body>
</html>

<script type="text/javascript">
    window.print();
</script>
