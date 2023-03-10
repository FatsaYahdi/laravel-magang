@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tag</th>
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
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script>
        const smg = "{{ session()->get('success') }}";
        if(smg) {
            toastr.success(smg)
        }
        let userDataTable;
        $(document).ready(function () {
            userDataTable = $('table').DataTable({
                responsive: true,
                processing: false,
                serverSide: true,
                ajax: "{{ route('tag.list') }}",
                order: [],
                columns: [
                    { data: 'DT_RowIndex',sortable: false, searchable: false},
                    { data: 'tag' },
                    { data: 'created_by' },
                    { data: 'action', sortable: false },
                ],
            });
        });
    </script>
    <script src="{{ asset('js/delete.js') }}"></script>
@endpush