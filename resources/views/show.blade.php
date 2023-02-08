<style>
    #no {
        text-align: center
    }
    th {
        padding-top: 5px;
        padding-bottom: 5px;
    }
</style>
@extends('layouts.app',['title' => 'Show'])

@section('content')
        <table class="table table-striped">
            <thead>
                <th width="5%" id="no">No</th>
                <th width="20%">Nama</th>
                <th width="10%">Jenis Kelamin</th>
                <th width="10%">Tanggal Lahir</th>
            <th width="20%">Aksi</th>
        </thead>
        @foreach ($users as $item)
        <tbody>
            <td align="center">{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->gender }}</td>
            <td>{{ $item->birth }}</td>
            <td>
                <form action="{{ route('show.destroy',$item->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="border:none; background: none;" class="text-danger text-bold">Delete</button>
                </form>
            </td>
        </tbody>
        @endforeach
    </table>

@endsection
{{-- Buat menu `user`, yang berisi table dengan data semua user. Data yang di tampilkan di table berupa `no`, `nama`, `jenis kelamin`, `tanggal lahir`, `aksi`. Di dalam kolom `aksi` silakan di isi dengan tombol `hapus user`. --}}