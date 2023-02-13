@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
@if(session('success'))
<div class="container-fluid">
    <div class="row">
        <div class="alert alert-success" role="aler">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Profile</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('table').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('user.list') }}",
                order: [],
                columns: [
                    { data: 'DT_RowIndex', sortable: false, searchable: false },
                    { data: 'pp' , sortable:false, searchable: false},
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'status' },
                    { data: 'action', sortable: false },
                ],
            });
        });
    </script>
@endpush