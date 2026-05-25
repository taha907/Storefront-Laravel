@extends('layouts.admin')
@section('title', 'Kullanıcılar')
@section('content')
<h2>Kullanıcılar</h2>
<table class="table table-striped">
    <thead><tr><th>Ad</th><th>E-posta</th><th>Durum</th><th>İşlem</th></tr></thead>
    <tbody>
    @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{!! $u->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Dondurulmuş</span>' !!}</td>
            <td class="text-nowrap">
                <a href="{{ route('admin.users.show', $u) }}" class="btn btn-sm btn-outline-primary">Görüntüle</a>
                <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-secondary">Düzenle</a>
                @if($u->is_active)
                    <form action="{{ route('admin.users.freeze', $u) }}" method="POST" class="d-inline">@csrf<button class="btn btn-sm btn-warning">Dondur</button></form>
                @else
                    <form action="{{ route('admin.users.activate', $u) }}" method="POST" class="d-inline">@csrf<button class="btn btn-sm btn-success">Aktifleştir</button></form>
                @endif
                <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Silinsin mi?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Sil</button></form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $users->links() }}
@endsection
