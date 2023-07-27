@extends('layouts.main')

@section('title')
    Input Stok
@endsection

@section('container')
    <div class="d-flex justify-content-center">
        <div class="card col-md-6 p-3">
            <form action="/barang" method="POST" enctype="multipart/form-data">
                @csrf
                    
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