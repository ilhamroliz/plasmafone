<?php $url = url()->current(); ?>
<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
			
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<img src="{{ asset('template_asset/img/avatars/sunny.png') }}" alt="me" class="online" /> 
				<span>
					{{ (!is_null(auth()->user()->id_karyawan)) ? auth()->user()->karyawan->m_username.' '.auth()->user()->karyawan->nama_lengkap : auth()->user()->m_username }}
				</span>
			</a> 
			
		</span>
	</div>
	<!-- end user info -->

	<!-- NAVIGATION : This navigation is also responsive-->
	<nav>
		<ul>
			<li class="{{ Request::is('dashboard') ? 'active' : '' }}">
				<a href="index.html" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
			</li>
			<li class="{{ Request::is('master/*') ? 'active' : '' }}">
				<a href="#"><i class="fa fa-lg fa-fw fa-asterisk"></i> <span class="menu-item-parent">Data Master</span></a>
				<ul>
					<li class="{{ (Request::is('master/suplier/suplier/*') || Request::is('master/suplier/suplier')) ? 'active' : '' }}">
						<a href="{{ url('master/suplier/suplier') }}">Master Supplier</a>
					</li>

					<li class="{{ (Request::is('master/gudang/*') || Request::is('master/gudang')) ? 'active' : '' }}">
						<a href="{{ route('gudang.index') }}">Master Gudang</a>
					</li>

					<li class="{{ (Request::is('master/jenis-barang/*') || Request::is('master/jenis-barang')) ? 'active' : '' }}">
						<a href="{{ route('jenis-barang.index') }}">Master Jenis Barang</a>
					</li>

					<li class="{{ (Request::is('master/class-barang/*') || Request::is('master/class-barang')) ? 'active' : '' }}">
						<a href="{{ route('class-barang.index') }}">Master Class Barang</a>
					</li>

					<li class="{{ (Request::is('master/satuan-barang/*') || Request::is('master/satuan-barang')) ? 'active' : '' }}">
						<a href="{{ route('satuan-barang.index') }}">Master Satuan Barang</a>
					</li>

					<li class="{{ (Request::is('master/barang/*') || Request::is('master/barang')) ? 'active' : '' }}">
						<a href="{{ route('barang.index') }}">Master Barang</a>
					</li>

					<li class="{{ (Request::is('master/karyawan/*') || Request::is('master/karyawan')) ? 'active' : '' }}">
						<a href="{{ route('karyawan.index') }}">Master karyawan</a>
					</li>

					<li class="{{ (Request::is('/master/jabatan*') || Request::is('/master/jabatan')) ? 'active' : '' }}">
						<a href="{{ url('/master/jabatan') }}">Master Jabatan</a>
					</li>

					<li class="{{ (Request::is('/master/posisi*') || Request::is('/master/posisi')) ? 'active' : '' }}">
						<a href="{{ url('/master/posisi') }}">Master Posisi</a>
					</li>

					<li>
						<a href="flot.html">Master Member</a>
					</li>

					<li>
						<a href="{{ url('/master/outlet') }}">Master Outlet</a>
					</li>

					<li>
						<a href="#">Master Keuangan</a>
						<ul>
							<li>
								<a href="glyph.html">Akun Keuangan</a>
							</li>	
							<li>
								<a href="flags.html">Transaksi keuangan</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="flot.html">Master Hak Akses</a>
					</li>
				</ul>
			</li>

			<li <?php if(preg_match("/request-order/i", $url)) { ?> class="active open" <?php } ?>>
				<a href="#"><i class="fa fa-lg fa-fw fa-credit-card"></i> <span class="menu-item-parent">Pembelian</span></a>
				<ul <?php if(preg_match("/request-order/i", $url) || preg_match("/rencana-pembelian/i", $url) || preg_match("/konfirmasi-pembelian/i", $url) || preg_match("/purchase-order/i", $url) || preg_match("/purchase-return/i", $url)) { ?> style="display: block;" <?php } ?>>
					<li <?php if(preg_match("/request-order/i", $url)) { ?> class="active" <?php } ?>>
						<a href="{{ url('/pembelian/request-order') }}">Request Order</a>
					</li>
					<li <?php if(preg_match("/rencana-pembelian/i", $url)) { ?> class="active" <?php } ?>>
						<a href="{{ url('/pembelian/rencana-pembelian') }}">Rencana Pembelian</a>
					</li>

					<li <?php if(preg_match("/konfirmasi-pembelian/i", $url)) { ?> class="active" <?php } ?>>
						<a href="{{ url('/pembelian/konfirmasi-pembelian') }}">Konfirmasi Pembelian</a>
					</li>

					<li <?php if(preg_match("/purchase-order/i", $url)) { ?> class="active" <?php } ?>>
						<a href="{{ url('/pembelian/purchase-order') }}">Purchase Order</a>
					</li>

					<li <?php if(preg_match("/purchase-return/i", $url)) { ?> class="active" <?php } ?>>
						<a href="{{ url('/pembelian/purchase-return') }}">Return Barang</a>
					</li>

					<li>
						<a href="#">Refund</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-cube"></i> <span class="menu-item-parent">Inventory</span></a>
				<ul>
					<li>
						<a href="#">Penerimaan Barang</a>
						<ul>
							<li>
								<a href="{{ url('/inventory/penerimaan/supplier') }}">Dari Supplier</a>
							</li>	
							<li>
								<a href="{{ url('/inventory/penerimaan/pusat') }}">Kiriman Pusat</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="{{ url('/inventory/distribusi') }}">Distribusi Barang</a>
					</li>

					<li>
						<a href="flot.html">Opname Barang</a>
					</li>

					<li>
						<a href="flot.html">Minumun Stok</a>
					</li>

				</ul>
			</li>

			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-handshake-o"></i> <span class="menu-item-parent">Penjualan</span></a>
				<ul>
					<li>
						<a href="flot.html">Rencana Penjualan</a>
					</li>

					<li>
						<a href="#">Aktivitas Penjualan</a>
						<ul>
							<li>
								<a href="glyph.html">Proses Penjualan</a>
							</li>	
							<li>
								<a href="flags.html">Pemesanan Barang</a>
							</li>
							<li>
								<a href="flags.html">Pembelian Via Website</a>
							</li>
							<li>
								<a href="flags.html">Return Penjualan</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="flot.html">Monitoring Penjualan</a>
					</li>

					<li>
						<a href="flot.html">Analisa Penjualan</a>
					</li>

				</ul>
			</li>

			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-money"></i> <span class="menu-item-parent">Keuangan</span></a>
				<ul>
					<li>
						<a href="flot.html">Dashboard Keuangan</a>
					</li>

					<li>
						<a href="#">Transaksi Keuangan</a>
						<ul>
							<li>
								<a href="glyph.html">Transaksi Kas</a>
							</li>	
							<li>
								<a href="flags.html">Transaksi Bank</a>
							</li>
							<li>
								<a href="flags.html">Transaksi Memorial</a>
							</li>
						</ul>
					</li>

					<li>
						<a href="flot.html">Akun Hutang</a>
					</li>

					<li>
						<a href="flot.html">Akun Piutang</a>
					</li>

					<li>
						<a href="flot.html">Pengelolaan Pajak</a>
					</li>

					<li>
						<a href="#">Analisa Keuangan</a>
						<ul>
							<li>
								<a href="glyph.html">Sub Menu 1</a>
							</li>
						</ul>
					</li>

				</ul>
			</li>

			<li>
				<a href="#">
					<i class="fa fa-lg fa-fw fa-file-text"></i> 
					<span class="menu-item-parent">Laporan</span>
				</a>
				<ul>
					<li>
						<a href="#">Laporan Keuangan</a>
						<ul>
							<li>
								<a href="glyph.html">Laporan Neraca</a>
							</li>	
							<li>
								<a href="flags.html">Laporan Laba Rugi</a>
							</li>
							<li>
								<a href="flags.html">Laporan Arus Kas</a>
							</li>
						</ul>
					</li>

				</ul>
			</li>

			<li>
				<a href="#">
					<i class="fa fa-lg fa-fw fa-cog"></i> 
					<span class="menu-item-parent">Manajemen Aplikasi</span>
				</a>
				<ul>
					<li <?php if(preg_match("/akses-pengguna/i", $url)) { ?> class="active" <?php } ?>>
						<a href="{{ url('/pengaturan/akses-pengguna') }}">Pengelolaan Pengguna</a>
						
					</li>

				</ul>
			</li>

			<li>
				<a href="#" style="color: #00C851"><i class="fa fa-lg fa-fw fa-exchange"></i> <span class="menu-item-parent">Log Activity</span></a>
			</li>
			
		</ul>
	</nav>
	<span class="minifyme" data-action="minifyMenu"> 
		<i class="fa fa-arrow-circle-left hit"></i> 
	</span>

</aside>