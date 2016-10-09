<table class="striped">
	<thead>
		<tr>
			<th data-field="name">{{ 'Nama' }}</th>
			<th data-field="email">{{ 'Email' }}</th>
			<th data-field="action">{{ 'Aksi' }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
			<tr>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>
					<a class="btn waves-effect waves-light green" href="{{ route('user-control.edit', encrypt($user->id)) }}"><i class="mdi-image-edit left"></i>Ubah</a>
					<a class="btn waves-effect waves-light red" id="delete_user" data-id="{{ encrypt($user->id) }}" data-token="{{ csrf_token() }}"><i class="mdi-action-delete left"></i>Hapus</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>