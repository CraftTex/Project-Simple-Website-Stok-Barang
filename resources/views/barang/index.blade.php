
@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection


@section('container')
@section('container')
@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if (session()->has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {!! session('error') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
    @auth
        <div class="d-flex col-md-6 mb-3">
            <a href="/barang/create" class="btn btn-primary">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                      </svg>
                </span>
                <span class="mx-2">
                    Tambah Barang
                </span>
            </a>
        </div>
    @endauth
    <div class="d-flex card p-3">
        <table id="myTable" class="table table-hover table-stripe">
            <thead>
                <tr>
                    <th style="width: 5%">ID</th>
                    <th style="width: auto">Nama Barang</th>
                    <th style="width: 15%">Harga Beli</th>
                    <th style="width: 15%">Harga Jual</th>
                    <th style="width: 15%">Actions</th>
                </tr>
            </thead>
        </table>
        
    </div>
@endsection

@section('scripts')
<script>
    let $table = new DataTable('#myTable', {
        processing: true,
        responsive: true,
        ajax: {
            url: '/barang/items',
            type: 'GET',
        },
        columns: [
            {data: 'id'},
            {data: 'nama'},
            {data: 'harga_beli'},
            {data: 'harga_jual'},
            {data: 'action'}
        ]
    });

    function alertWarning(string) {
        string = '#' + string
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
                document.querySelector(string).submit()
            }
            return false;
        })
        
    }

</script>
@endsection