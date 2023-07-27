@extends('layouts.main')

@section('title')
    Tambah Barang
@endsection

@section('container')
    <div class="d-flex justify-content-center">
        <div class="card col-md-6 p-3">
            <form action="/barang" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label class="form-label required" for="nama">Nama Barang</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" autocomplete="off" value={{ old('nama') }}>
                    </div>
                    @error('slug')
                    <div class="mb-3">
                        <label class="form-label required" for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" autocomplete="off" value={{ old('slug') }}>
                    </div>
                    @enderror
                    <div class="mb-3">
                        <div class="row g-2">
                            <label class="form-label required" for="harga_beli">Harga Beli Barang</label>
                            <div class="col-auto disabled btn btn-outline-secondary">
                                Rp.
                            </div>
                            <div class="col">
                                <input type="text" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" autocomplete="off" value={{ old('harga_beli') }}>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row g-2">
                            <label class="form-label required" for="harga_jual">Harga Jual Barang</label>
                            <div class="col-auto disabled btn btn-outline-secondary">
                                Rp.
                            </div>
                            <div class="col">
                                <input type="text" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" autocomplete="off" value={{ old('harga_jual') }}>
                            </div>
                        </div>
                    </div>
                    <img class="img-preview img-fluid">
                    <div class="mb-3">
                        <label class="form-label mb-3 col-sm-5" for="gambar">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" autocomplete="off" value="{{ old('gambar') }}" onchange="previewImage()">
                    </div>
                    <div class="mb-3">
                        <label class="form-label required" for="deskripsi">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" data-bs-toggle="autosize" id="deskripsi" name="deskripsi" value={{ old('deskripsi') }}></textarea>
                    </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        
        function previewImage() {
            const gambar = document.querySelector('#gambar');
            const gambarPreview = document.querySelector('.img-preview');

            gambarPreview.style.display = 'block';

            const ofReader = new FileReader();

            ofReader.readAsDataURL(gambar.files[0]);

            ofReader.onload = function(oFREvent) {
                gambarPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection