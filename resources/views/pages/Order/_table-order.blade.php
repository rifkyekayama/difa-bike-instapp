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
				<td><button class="btn waves-effect waves-light green" id="btnLocation" data-id="{{ encrypt($order->id) }}"><i class="mdi-communication-location-on"></i></button></td>
				<td>{{ $order->ket_lokasi_penjemputan }}</td>
				<td>{{ $order->tujuan }}</td>
			</tr>
		@endforeach
	</tbody>
</table>