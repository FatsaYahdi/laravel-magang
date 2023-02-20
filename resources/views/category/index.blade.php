@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
@if(session('success'))
<div class="container-fluid">
    <div class="row">
        <div class="alert alert-success" role="alert">
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
                                <th>Category Name</th>
                                <th>Created By</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.modal-delete')
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        let userDataTable;
        $(document).ready(function () {
            userDataTable = $('table').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('category.list') }}",
                order: [],
                columns: [
                    { data: 'DT_RowIndex',sortable: false, searchable: false},
                    { data: 'category' },
                    { data: 'created_by' },
                    { data: 'action', sortable: false },
                ],
            });
        });
    </script>
    <script src="{{ asset('js/delete.js') }}"></script>
@endpush