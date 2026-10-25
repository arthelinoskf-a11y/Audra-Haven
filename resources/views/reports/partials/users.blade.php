<h3 style="font-size:11pt;">Daftar Pengguna Sistem</h3>
<table class="data">
    <thead>
        <tr>
            <th style="width:5%;">No</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Role</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $i => $u)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $u->full_name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->phone ?? '-' }}</td>
                <td class="center">{{ $u->role->label ?? '-' }}</td>
                <td class="center">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>