<?php
$url = url()->current();
use App\Http\Controllers\PlasmafoneController as Access;
?>
<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as it -->
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				@if(auth()->user()->m_img != '' || auth()->user()->m_img != null)
                    <img src="{{ asset('img/user/'.auth()->user()->m_img) }}" alt="me" class="online"/>
                @else
                    <img src="{{ asset('img/user/default.jpg') }}" alt="me" class="online"/>
                @endif
                <span>
					{{ (!is_null(auth()->user()->id_karyawan)) ? auth()->user()->karyawan->m_username.' '.auth()->user()->karyawan->nama_lengkap : auth()->user()->m_name }}
				</span>
			</a>

		</span>
    </div>
    <!-- end user info -->

    <!-- NAVIGATION : This navigation is also responsive-->
    <?php $sidebar = App\Http\Controllers\PlasmafoneController::aksesSidebar(); //dd($sidebar['Penerimaan Barang Supplier']);?>
    <nav>
        <ul>
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span
                        class="menu-item-parent">Dashboard</span></a>
            </li>

            @if($sidebar['Data Master'] == 'Y')
                <li class="{{ Request::is('master/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-lg fa-fw fa-asterisk"></i> <span
                            class="menu-item-parent">Data Master</span></a>
                    <ul>
                        @if($sidebar['Master Supplier'] == 'Y')
                            <li class="{{ (Request::is('master/supplier/*') || Request::is('master/supplier')) ? 'active' : '' }}">
                                <a href="{{ url('master/supplier') }}">Master Supplier</a>
                            </li>
                        @endif

                        @if($sidebar['Master Barang'] == 'Y')
                            <li class="{{ (Request::is('master/barang/*') || Request::is('master/barang')) ? 'active' : '' }}">
                                <a href="{{ route('barang.index') }}">Master Barang</a>
                            </li>
                        @endif

                        @if($sidebar['Master Member'] == 'Y')
                            <li class="{{ (Request::is('master/member/*') || Request::is('master/member')) ? 'active' : '' }}">
                                <a href="{{ url('/master/member') }}">Master Member</a>
                            </li>
                        @endif

                        @if($sidebar['Master Outlet'] == 'Y')
                            <li class="{{ (Request::is('master/outlet/*') || Request::is('master/outlet')) ? 'active' : '' }}">
                                <a href="{{ url('/master/outlet') }}">Master Outlet</a>
                            </li>
                        @endif

                        @if($sidebar['Master Pembayaran'] == 'Y')
                            <li class="{{ (Request::is('master/pembayaran/*') || Request::is('master/pembayaran')) ? 'active' : '' }}">
                                <a href="{{ url('/master/pembayaran') }}">Master Pembayaran</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($sidebar['Pembelian'] == 'Y')
                <li class="{{ Request::is('pembelian/*') ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-lg fa-fw fa-credit-card"></i> <span
                            class="menu-item-parent">Pembelian</span></a>
                    <ul <?php if(preg_match("/request-order/i", $url) || preg_match("/rencana-pembelian/i", $url) || preg_match("/konfirmasi-pembelian/i", $url) || preg_match("/purchase-order/i", $url) || preg_match("/purchase-return/i", $url)) { ?> style="display: block;" <?php } ?>>

                        @if($sidebar['Request Order'] == 'Y')
                            <li <?php if(preg_match("/request-pembelian/i", $url)) { ?> class="active" <?php } ?>>
                                <a href="{{ url('/pembelian/request-pembelian') }}">Request Order</a>
                            </li>
                        @endif

                        @if($sidebar['Rencana Pembelian'] == 'Y')
                            <li <?php if(preg_match("/rencana-pembelian/i", $url)) { ?> class="active" <?php } ?>>
                                <a href="{{ url('/pembelian/rencana-pembelian') }}">Rencana Pembelian</a>
                            </li>
                        @endif

                        @if($sidebar['Konfirmasi Pembelian'] == 'Y')
                            <li <?php if(preg_match("/konfirmasi-pembelian/i", $url)) { ?> class="active" <?php } ?>>
                                <a href="{{ url('/pembelian/konfirmasi-pembelian') }}">Konfirmasi Pembelian</a>
                            </li>
                        @endif

                        @if($sidebar['Purchase Order'] == 'Y')
                            <li <?php if(preg_match("/purchase-order/i", $url)) { ?> class="active" <?php } ?>>
                                <a href="{{ url('/pembelian/purchase-order') }}">Purchase Order</a>
                            </li>
                        @endif

                        @if($sidebar['Return Barang'] == 'Y')
                            <li <?php if(preg_match("/purchase-return/i", $url)) { ?> class="active" <?php } ?>>
                                <a href="{{ url('/pembelian/purchase-return') }}">Return Barang</a>
                            </li>
                        @endif

                        @if($sidebar['Refund'] == 'Y')
                            <li class="{{ (Request::is('pembelian/refund') || Request::is('pembelian/refund/*')) ? 'active' : '' }}">
                                <a href="{{ url('pembelian/refund') }}">Refund</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($sidebar['Inventory'] == 'Y')
                <li>
                    <a href="#"><i class="fa fa-lg fa-fw fa-cube"></i> <span
                            class="menu-item-parent">Inventory</span></a>
                    <ul>
                        @if($sidebar['Penerimaan Barang Supplier'] != 'N' || $sidebar['Penerimaan Barang Pusat'] != 'N')
                            <li>
                                <a href="#">Penerimaan Barang</a>
                                <ul>
                                    @if($sidebar['Penerimaan Barang Supplier'] == 'Y')
                                        <li class="{{ (Request::is('inventory/penerimaan/supplier')) ? 'active' : '' }}">
                                            <a href="{{ url('/inventory/penerimaan/supplier') }}">Dari Supplier</a>
                                        </li>
                                    @endif
                                    @if($sidebar['Penerimaan Barang Pusat'] == 'Y')
                                        <li class="{{ (Request::is('inventory/penerimaan/distribusi')) ? 'active' : '' || (Request::is('inventory/penerimaan/distribusi/edit/*')) ? 'active' : '' }}">
                                            <a href="{{ url('/inventory/penerimaan/distribusi') }}">Dari Distribusi</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if($sidebar['Distribusi Barang'] == 'Y')
                            <li class="{{ (Request::is('distribusi-barang')) ? 'active' : '' }}{{ (Request::is('distribusi/tambah-distribusi')) ? 'active' : '' }}">
                                <a href="{{ url('/distribusi-barang') }}">Distribusi Barang</a>
                            </li>
                        @endif

                        @if($sidebar['Opname Barang'] != 'N' || $sidebar['Opname Barang Outlet'] != 'N')
                            <li>
                                <a href="#">Opname Barang</a>
                                <ul>
                                    @if($sidebar['Opname Barang'] == 'Y')
                                        <li class="{{ (Request::is('inventory/opname-barang/pusat')) ||  (Request::is('inventory/opname-barang/tambah')) ||  (Request::is('inventory/opname-barang/edit')) ? 'active' : '' }}">
                                            <a href="{{ url('/inventory/opname-barang/pusat') }}">Pusat</a>
                                        </li>
                                    @endif
                                    @if($sidebar['Opname Barang Outlet'] == 'Y')
                                        <li class="{{ (Request::is('inventory/opname-barang/outlet')) || (Request::is('inventory/opname-barang/tambahOutlet')) || (Request::is('inventory/opname-barang/editOutlet')) ? 'active' : '' }}">
                                            <a href="{{ url('/inventory/opname-barang/outlet') }}">Outlet</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if($sidebar['Manajemen Minimum Stock'] == 'Y')
                            <li class="{{ (Request::is('inventory/min-stock/*') || Request::is('inventory/min-stock')) ? 'active' : '' }}">
                                <a href="{{ url('/inventory/min-stock') }}">Minimum Stock</a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            @if($sidebar['Penjualan'] == 'Y')
                <li>
                    <a href="#"><i class="fa fa-lg fa-fw fa-handshake-o"></i> <span
                            class="menu-item-parent">Penjualan</span></a>
                    <ul>
                        @if($sidebar['Setting Harga'] == 'Y')
                            <li>
                                <a href="#">Setting Harga</a>
                                <ul>
                                    @if($sidebar['Setting Harga'] == 'Y')
                                        <li class="{{ (Request::is('penjualan/set-harga/outlet')) ? 'active' : '' }}">
                                            <a href="{{ url('/penjualan/set-harga/outlet') }}">Outlet</a>
                                        </li>
                                    @endif
                                    @if($sidebar['Setting Harga'] == 'Y')
                                        <li class="{{ (Request::is('penjualan/set-harga')) ? 'active' : '' }}">
                                            <a href="{{ url('/penjualan/set-harga') }}">Group</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if($sidebar['Penjualan Reguler'] == 'Y')
                            <li class="{{ (Request::is('penjualan-reguler') || Request::is('penjualan-reguler/*')) ? 'active' : '' }}">
                                <a href="{{ url('penjualan-reguler') }}">Penjualan Reguler</a>
                            </li>
                        @endif

                        @if($sidebar['Penjualan Tempo'] == 'Y')
                            <li class="{{ (Request::is('penjualan-tempo') || Request::is('penjualan-tempo/*')) ? 'active' : '' }}">
                                <a href="{{ url('penjualan-tempo') }}">Penjualan Tempo</a>
                            </li>
                        @endif

                        @if($sidebar['Pemesanan Barang'] == 'Y')
                            <li class="{{ (Request::is('penjualan/pemesanan-barang/*') || Request::is('penjualan/pemesanan-barang')) ? 'active' : '' }}">
                                <a href="{{ url('/penjualan/pemesanan-barang') }}">Pemesanan Barang</a>
                            </li>
                        @endif

                        @if($sidebar['Onlineshop'] == 'Y')
                            <li>
                                <a href="flot.html">Onlineshop</a>
                            </li>
                        @endif

                        @if($sidebar['Return Penjualan'] == 'Y')
                            <li class="{{ (Request::is('penjualan/return-penjualan/*') || Request::is('penjualan/return-penjualan')) ? 'active' : '' }}">
                                <a href="{{ url('penjualan/return-penjualan') }}">Return Penjualan</a>
                            </li>
                        @endif

                        @if($sidebar['Service Barang'] == 'Y')
                            <li>
                                <a href="">Service Barang</a>
                            </li>
                        @endif

                        @if($sidebar['Pengelolaan Member'] == 'Y')
                            <li>
                                <a href="flot.html">Pengelolaan Member</a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

            @if($sidebar['Layanan Perbaikan'] == 'Y')
                <li class="{{ (Request::is('layanan-perbaikan/*') || Request::is('layanan-perbaikan')) ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-lg fa-fw fa-wrench"></i>
                        <span class="menu-item-parent">Layanan Perbaikan</span>
                    </a>
                    <ul>
                        @if($sidebar['Perbaikan Barang'] == 'Y')
                            <li class="{{ Request::is('layanan-perbaikan') || Request::is('layanan-perbaikan/*') ? 'active' : '' }}">
                                <a href="{{ url('layanan-perbaikan') }}">Perbaikan Barang</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($sidebar['Manajemen Penjualan'] == 'Y')
                <li>
                    <a href="#">
                        <i class="fa fa-lg fa-fw fa-sliders"></i>
                        <span class="menu-item-parent">Manajemen Penjualan</span>
                    </a>
                    <ul>
                        @if($sidebar['Pembuatan Rencana Penjualan'] == 'Y')
                            <li class="{{ (Request::is('man-penjualan/rencana-penjualan/*') || Request::is('man-penjualan/rencana-penjualan')) ? 'active' : '' }}">
                                <a href="{{ url('/man-penjualan/rencana-penjualan') }}">Pembuatan Rencana Penjualan</a>
                            </li>
                        @endif

                        @if($sidebar['Monitoring Penjualan'] == 'Y')
                            <li class="{{ (Request::is('man-penjualan/monitoring-penjualan/*') || Request::is('man-penjualan/monitoring-penjualan')) ? 'active' : '' }}">
                                <a href="{{ url('/man-penjualan/monitoring-penjualan') }}">Monitoring Penjualan</a>
                            </li>
                        @endif

                        @if($sidebar['Analisis Penjualan'] == 'Y')
                            <li class="{{ (Request::is('man-penjualan/analisis-penjualan/*') || Request::is('man-penjualan/analisis-penjualan')) ? 'active' : '' }}">
                                <a href="{{ url('/man-penjualan/analisis-penjualan') }}">Analisis Penjualan</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($sidebar['Manajemen Keuangan'] == 'Y')
                <li>
                    <a href="#"><i class="fa fa-lg fa-fw fa-money"></i> <span class="menu-item-parent">Manajemen Keuangan</span></a>
                    <ul>
                        @if($sidebar['Master Akun Keuangan'] == 'Y')
                            <li>
                                <a href="#">Master Akun Keuangan</a>
                                <ul>
                                    <li>
                                        <a href="{{ url('/keuangan/coa/jenis') }}">Master COA</a>
                                    </li>
                                    <li>
                                        <a href="flot.html">Setting Parameter</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if($sidebar['Master Transaksi'] == 'Y')
                            <li>
                                <a href="flot.html">Master Transaksi</a>
                            </li>
                        @endif

                        @if($sidebar['Penganggaran'] == 'Y')
                            <li>
                                <a href="flot.html">Penganggaran</a>
                            </li>
                        @endif

                        @if($sidebar['Dashboard Finansial'] == 'Y')
                            <li>
                                <a href="flot.html">Dashboard Finansial</a>
                            </li>
                        @endif

                        @if($sidebar['Pencatatan Transaksi Harian'] == 'Y')
                            <li>
                                <a href="flot.html">Pencatatan Transaksi Harian</a>
                            </li>
                        @endif

                        @if($sidebar['Pengelolaan Akun Payable'] == 'Y')
                            <li>
                                <a href="flot.html">Pengelolaan Akun Payable</a>
                            </li>
                        @endif

                        @if($sidebar['Pengelolaan Akun Receivable'] == 'Y')
                            <li>
                                <a href="flot.html">Pengelolaan Akun Receivable</a>
                            </li>
                        @endif

                        @if($sidebar['Pengelolaan Pajak'] == 'Y')
                            <li>
                                <a href="flot.html">Pengelolaan Pajak</a>
                            </li>
                        @endif

                        @if($sidebar['Pembuatan Laporan Keuangan'] == 'Y')
                            <li>
                                <a href="flot.html">Pembuatan Laporan Keuangan</a>
                            </li>
                        @endif

                        @if($sidebar['Pembuatan Index Finansial'] == 'Y')
                            <li>
                                <a href="flot.html">Pembuatan Index Finansial</a>
                            </li>
                        @endif

                        @if($sidebar['Analisis Keuangan'] == 'Y')
                            <li>
                                <a href="flot.html">Analisis Keuangan</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if($sidebar['Manajemen Aplikasi'] == 'Y')
                <li>
                    <a href="#">
                        <i class="fa fa-lg fa-fw fa-cog"></i>
                        <span class="menu-item-parent">Manajemen Aplikasi</span>
                    </a>
                    <ul>
                        @if($sidebar['Pengelolaan Pengguna'] == 'Y')
                            <li class="{{ (Request::is('pengaturan/akses-pengguna/*') || Request::is('pengaturan/kelola-pengguna/*') || Request::is('pengaturan/akses-pengguna')) ? 'active' : '' }}">
                                <a href="{{ url('/pengaturan/akses-pengguna') }}">Pengelolaan Pengguna</a>
                            </li>
                        @endif

                        @if($sidebar['Log Kegiatan Pengguna'] == 'Y')
                            <li class="{{ (Request::is('pengaturan/log-kegiatan/*') || Request::is('pengaturan/log-kegiatan')) ? 'active' : '' }}">
                                <a href="{{ url('/pengaturan/log-kegiatan') }}">Log Kegiatan Pengguna</a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif

        </ul>
    </nav>
    <span class="minifyme" data-action="minifyMenu">
		<i class="fa fa-arrow-circle-left hit"></i>
	</span>

</aside>
