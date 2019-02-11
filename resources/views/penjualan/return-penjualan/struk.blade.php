<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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

<div style="border: .6px dashed; margin-top: 15px">
</div>
<div class="header1">
    <div class="tanggal">
        <span style="float: left; width: 10%;">Jumlah</span>
        <span style="width: 60%">Nama Barang</span>
        <span style="width: 30%; margin-left: 260px;">Keterangan</span>
    </div>
</div>
<div style="border: .6px dashed;"></div>
@foreach($datas as $index=>$data)
    @if ($data->rpd_code != null)
        <div class="header1" style="margin-top: 10px">
            <div class="tanggal">
                <span style="float: left; width: 10%; margin-left: 10px;">{{ $data->rpd_qty }}</span>
                <span style="width: 60%; margin-left: -10px">{{ $data->rpd_code }} - {{ $data->rpd_item }}</span>
                <span style="width: 30%; margin-left: 60px">{{ $data->rpd_note }}</span>
            </div>
        </div>
    @else
        <div class="header1" style="margin-top: 10px">
            <div class="tanggal">
                <span style="float: left; width: 10%; margin-left: 10px;">{{ $data->rpd_qty }}</span>
                <span style="width: 60%; margin-left: -10px">{{ $data->rpd_item }} {{ $data->rpd_specificcode }}</span>
            </div>
        </div>
    @endif
@endforeach
<div style="border: .6px dashed;"></div>

@if ($datas[0]->jenis_return != "GU")
    <div class="header1" style="margin-top: 15px">
        <span><i><strong>BARANG PENGGANTI</strong></i></span>
    </div>
    <div style="border: .6px dashed; margin-top: 15px">
    </div>
    <div class="header1">
        <div class="tanggal">
            <span style="float: left; width: 10%;">Jumlah</span>
            <span style="width: 90%">Nama Barang</span>
        </div>
    </div>
    <div style="border: .6px dashed;"></div>
    @foreach($datas as $index=>$data)
        @if ($data->rpg_code != null)
            <div class="header1" style="margin-top: 10px">
                <div class="tanggal">
                    <span style="float: left; width: 10%; margin-left: 10px;">{{ $data->rpg_qty }}</span>
                    <span style="width: 60%; margin-left: -10px">{{ $data->rpg_code }} - {{ $data->rpg_item }}</span>
                </div>
            </div>
        @else
            <div class="header1" style="margin-top: 10px">
                <div class="tanggal">
                    <span style="float: left; width: 10%; margin-left: 10px;">{{ $data->rpg_qty }}</span>
                    <span style="width: 60%; margin-left: -10px">{{ $data->rpg_item }} {{ $data->rpg_specificcode }}</span>
                </div>
            </div>
        @endif
    @endforeach
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
