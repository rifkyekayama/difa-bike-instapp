<table class="responsive-table" id="tableOrder">
	<thead>
		<tr>
			<th>Nama</th>
			<th>Nomor HP</th>
			<th>Tanggal Pemesanan</th>
			<th>Lokasi Penjemputan</th>
			<th>Keterangan Lokasi Penjemputan</th>
			<th>Lokasi Tujuan</th>
		</tr>
	</thead>
	<tbody>
		@foreach($orders as $order)
			<tr>
				<td>{{ $order->nama }}</td>
				<td>{{ $order->hp }}</td>
				<td>{{ date("D, d M Y", strtotime($order->tgl_pemesanan)) }}</td>
				<td>
					<?php
						$location = (!empty($order->lokasi->latitude) ? $order->lokasi->latitude : '').",".(!empty($order->lokasi->longitude) ? $order->lokasi->longitude : '');
						$location = str_replace(' ', '', $location);
					?>
					{!! ($location != ',') ? '<a href="'.'http://maps.google.com/maps?q=loc:'.$location.'" target="_blank">http://maps.google.com/maps?q=loc:'.$location.'</a>' : '-' !!}
				</td>
				<td>{{ $order->ket_lokasi_penjemputan }}</td>
				<td>{{ $order->tujuan }}</td>
			</tr>
		@endforeach
	</tbody>
</table>