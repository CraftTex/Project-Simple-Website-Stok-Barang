@extends('layouts.main')

@section('title')
    Edit
@endsection

@section('container')
    <div class="d-flex justify-content-center">
        <div class="card col-md-6 p-3">
            <form action="/barang/{{ $barang->slug }}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
                    <div class="mb-3">
                        <label class="form-label required" for="nama">Nama Barang</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" autocomplete="off" value="{{ old('nama',$barang->nama) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label required" for="slug">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" autocomplete="off" value="{{ old('slug',$barang->slug) }}">
                    </div>
                    <div class="mb-3">
                        <div class="row g-2">
                            <label class="form-label required" for="harga_beli">Harga Beli Barang</label>
                            <div class="col-auto disabled btn btn-outline-secondary">
                                Rp.
                            </div>
                            <div class="col">
                                <input type="text" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" autocomplete="off" value="{{ old('harga_beli',$barang->harga_beli) }}">
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
                                <input type="text" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" autocomplete="off" value="{{ old('harga_jual',$barang->harga_jual) }}">
                            </div>
                        </div>
                    </div>
                    @if ($barang->gambar)
                    <img class="img-preview img-fluid d-block" src="{{ asset('storage/' . $barang->gambar) }}">
                    @else
                    <img class="img-preview img-fluid">
                    @endif
                    <div class="mb-3">
                        <label class="form-label" for="gambar">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" autocomplete="off" value="{{ old('gambar',$barang->gambar) }}" onchange="previewImage()">
                    </div>
                    <input type="hidden" name="oldGambar" id="oldGambar" value="{{ $barang->gambar }}">
                    <div class="mb-3">
                        <label class="form-label required" for="deskripsi">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" data-bs-toggle="autosize" id="deskripsi" name="deskripsi">{{ old('deskripsi',$barang->deskripsi) }}</textarea>
                    </div>
                <button type="submit" class="btn btn-primary">Finish</button>
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