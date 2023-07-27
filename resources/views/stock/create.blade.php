@extends('layouts.main')

@section('title')
    Input Stok
@endsection

@section('container')

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <div class="d-flex justify-content-center">
        <div class="card col-lg p-3">
            <form action="/stock" method="POST">
                @csrf
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h4 class="card-title d-inline">
                            Input Stok
                        </h4>
                        <button class="btn btn-primary p-2" type="button" id="add_new_input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                </svg>
                        </button>
                    </div>
                    <div class="ml-auto">
                        <button class="btn btn-primary"> Submit </button>
                    </div>
                </div>
            <div class="card-body">
                    @csrf
                    
                    <div class="form-fieldset">
                        <ul>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Stok</th>
                                        <th>Jenis</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <input type="hidden" id="old-input-count" name="old-input-count">
                                <tbody id="inputs">
                                    {{-- <tr>
                                        <td style="width: 50%">
                                            <select name="id_barang[]" id="id_barang[]" class="form-select">
                                                @foreach ($barangs as $barang)
                                                    <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="jumlah_stok[]" id="jumlah_stok[]" placeholder="Jumlah Stok...">
                                        </td>
                                        <td>
                                            <select name="jenis[]" id="jenis[]" class="form-select">
                                                <option value="1">Masuk</option>
                                                <option value="0">Keluar</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" id="delete-row">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </ul>        
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            const max_input = 10;
            var input_count = 0;
            const old_input = $('#old-input-count');

            

            $('#add_new_input').click(function(e) {
                if (input_count <= max_input) {
                    input_count++;
                    old_input.val(input_count);
                    $('#inputs').append('<tr>\
                                            <td style="width: 50%">\
                                                <select name="inputData[' + input_count +'][barang_id]" id="inputData[' + input_count +'][barang_id]" class="form-select">\
                                                    @foreach ($barangs as $barang)\
                                                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>\
                                                    @endforeach\
                                                </select>\
                                            </td>\
                                            <td>\
                                                <input type="number" class="form-control" name="inputData[' + input_count +'][jumlah]" id="inputData[' + input_count +'][jumlah]" placeholder="Jumlah Stok...">\
                                            </td>\
                                            <td>\
                                                <select name="inputData[' + input_count +'][jenis]" id="inputData[' + input_count +'][jenis]" class="form-select">\
                                                    <option value="1">Masuk</option>\
                                                    <option value="0">Keluar</option>\
                                                </select>\
                                            </td>\
                                            <td>\
                                                <button type="button" class="btn btn-danger" id="delete-row">\
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">\
                                                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>\
                                                    </svg>\
                                                </button>\
                                            </td>\
                                        </tr>');
                }
            })
            for (let i = 0; i < {{ old('old-input-count',0) }}; i++) {
                document.querySelector('#add_new_input').click();
            }
            $(document).on('click','#delete-row', function(e) {
                let row_item = $(this).parent().parent();
                $(row_item).remove();
                input_count--;
                old_input.val(input_count);
            });
        });
    </script>
    <script>
        
    </script>
@endsection