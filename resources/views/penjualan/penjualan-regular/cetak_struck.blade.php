<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Nota Penjualan</title>
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
                position: fixed;
                left: 0px; 
                right: 0px;
                text-align: center;
                margin-top: -60px;
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
        </style>
        <div id="header">
            <div style="">
                <center><p><strong>RIZQY Mobile & Comp</strong></p></center>
                <center><p style="margin-right: 10px; margin-left: 10px">{{ $alamat }}</p></center>
            </div>

            <br>

            <div style="border-bottom: solid 1px black;">
                <p>No. Nota : {{ $informasi[0]->s_nota }}{{ $notaUlang }}</p>
            </div>
        </div>

        <div id="footer">
            <p class="page"><strong>Rizqy Mobile</strong></p>
        </div>

        <div id="halaman">
            <p></p>
        </div>

        <div id="konten">
            <div>
                <p>{{ $nama }}</p>
            </div>

            <div>
                <p>Customer</p>
            </div>

            <div style="margin-left: 5px">
                <p>Nama: {{ $informasi[0]->m_name }}</p>
            </div>

            <div style="margin-left: 5px">
                <p>Telepon: {{ $informasi[0]->mhp_hp }}</p>
            </div>

            <div style="margin-left: 5px">
                <p>Tanggal: {{ Carbon\Carbon::parse($informasi[0]->s_date)->format('d-M-Y') }}</p>
            </div>

            @if($jatuhtempo != null)
                <div style="margin-top: 2px; margin-left: 5px">
                    <p>Jatuh Tempo: {{ Carbon\Carbon::parse($jatuhtempo)->format('d-M-Y') }}</p>
                </div>
            @endif
        </div>
        <table style="page-break-inside: auto; border-bottom: border-top: .6px dashed; margin-top: 15px; width: 100%;">
          <thead style="border-top: .6px dashed; border-bottom: .6px dashed;">
            <tr>
                <th class="judul border-kiri">Jumlah</th>
                <th class="judul">Nama Barang</th>
                <th class="judul">Harga</th>
                <th class="judul border-kanan">Total</th>
            </tr>
          </thead> 
        @foreach($informasi as $index=>$data)
            @if($data->sd_sales != null)
            <tbody>
                <tr>
                    <td class="border-kiri" align="center">{{ $data->sd_qty }}</td>
                    <td>{{ $data->i_jenis }} {{ $data->i_jenissub }} {{ $data->i_class }} {{ $data->i_classsub }} {{ $data->sd_specificcode }}</td>
                    <td align="right" style="width: 30%;">Rp. {{ number_format($data->i_price, 0, '', '.').',-' }}</td>
                    <td class="border-kanan" align="right" style="width: 30%;">Rp. {{ number_format( $data->sd_qty * $data->i_price, 0 , '' , '.' ) . ',-' }}</td>
                </tr>
            </tbody>
            @endif
        @endforeach
        </table>

        <div style="float: right; page-break-inside: avoid;">
            <table style="float: right;">
            {{-- @if($informasi[0]->s_disc_value != 0)
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Diskon</th>
                    <td class="border" align="right">Rp. {{ number_format($informasi[0]->s_disc_value, 0, '', '.').',-' }}</td>
                </tr>
            @elseif($informasi[0]->s_disc_percent != 0)
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Diskon</th>
                    <td class="border" align="right">{{ $informasi[0]->s_disc_percent }}%</td>
                </tr>
            @else
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Diskon</th>
                    <td class="border" align="right">Rp. 0,-</td>
                </tr>
            @endif
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Pajak</th>
                    <td class="border" align="right">{{ $informasi[0]->s_pajak }}%</td>
                </tr> --}}
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Total</th>
                    <td class="border" align="right">Rp. {{ number_format($informasi[0]->s_total_net, 0, '', '.').',-' }}</td>
                </tr>
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Bayar Cash</th>
                    <td class="border" align="right">Rp. {{ number_format($bayar, 0, '', '.').',-' }}</td>
                </tr>
            @if($bca != '0')
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Melalui Bank BCA</th>
                    <td class="border" align="right">Rp. {{ number_format($bca, 0, '', '.').',-' }}</td>
                </tr>
            @endif
            @if($permata != '0')
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Melalui Bank Permata</th>
                    <td class="border" align="right">Rp. {{ number_format($permata, 0, '', '.').',-' }}</td>
                </tr>
            @endif
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan kiri" colspan="1" style="text-align: left;">Total Pembayaran</th>
                    <td class="border" align="right">Rp. {{ number_format($total, 0, '', '.').',-' }}</td>
                </tr>
                <tr>
                    <td class="border-atas border-bawah border-kiri"></td>
                    <td></td>
                    <th class="border-atas border-kanan border-bawah kiri" colspan="1" style="text-align: left;">Kembali</th>
                    <td class="border" align="right">Rp. {{ number_format($kembali, 0, '', '.').',-' }}</td>
                </tr>
            </table>
        </div>
        {{-- <div class="footer" style="float: left; position: absolute; bottom: 0"><strong><p>RIZQY MOBILE</p></strong></div> --}}
        
    </body>
</html>
