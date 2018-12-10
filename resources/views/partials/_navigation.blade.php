<?php $url = url()->current(); ?>
<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
			
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<img src="{{ asset('template_asset/img/avatars/sunny.png') }}" alt="me" class="online" /> 
				<span>
					{{ (!is_null(auth()->user()->id_karyawan)) ? auth()->user()->karyawan->m_username.' '.auth()->user()->karyawan->nama_lengkap : auth()->user()->m_name }}
				</span>
			</a> 
			
		</span>
	</div>
	<!-- end user info -->

	<!-- NAVIGATION : This navigation is also responsive-->
	<nav>
		<ul>
			<li class="{{ Request::is('dashboard') ? 'active' : '' }}">
				<a href="{{ url('dashboard') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
			</li>

			<li class="{{ Request::is('master/*') ? 'active' : '' }}">
				<a href="#"><i class="fa fa-lg fa-fw fa-asterisk"></i> <span class="menu-item-parent">Data Master</span></a>
				<ul>
					<li class="{{ (Request::is('master/supplier/*') || Request::is('master/supplier')) ? 'active' : '' }}">
						<a href="{{ url('master/supplier') }}">Master Supplier</a>
					</li>

					<li class="{{ (Request::is('master/barang/*') || Request::is('master/barang')) ? 'active' : '' }}">
						<a href="{{ route('barang.index') }}">Master Barang</a>
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

			<li>
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
				<a href="#">
					<i class="fa fa-lg fa-fw fa-wrench"></i> 
					<span class="menu-item-parent">Perbaikan</span>
				</a>
				<ul>
					<li>
						<a href="flot.html">Perbaikan Barang</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="#">
					<i class="fa fa-lg fa-fw fa-sliders"></i> 
					<span class="menu-item-parent">Manajemen Penjualan</span>
				</a>
				<ul>
					<li>
						<a href="flot.html">Pembuatan Rencana Penjualan</a>
					</li>
					<li>
						<a href="flot.html">Monitoring Penjualan</a>
					</li>
					<li>
						<a href="flot.html">Analisis Penjualan</a>
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