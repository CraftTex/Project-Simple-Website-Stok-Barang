@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('container')
    <div class="d-flex justify-content-start">
        <div class="card card-md-6 p-3">
            <h3 class="mb-3">
                {{ $barang->nama }}
            </h3>
            <div class="row g-5 mb-3">
                <div class="col-6">
                    @if ($barang->gambar)
                        <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama }}" width="100%" >
                    @else
                        <img src="/dist/img/unknown-img.jpg" alt="{{ $barang->nama }}" width="100%" class="img-fluid ">
                    @endif
                </div>
                <div class="col ml-3">
                    <div class="form-fieldset mb-3">
                        <div class="d-block">
                            <b>ID: </b> {{ $barang->id }}
                        </div>
                        <div class="d-block">
                            <b>Harga Beli: </b> Rp. {{ number_format($barang->harga_beli) }}
                        </div>
                        <div class="d-block">
                            <b>Harga Jual: </b> Rp. {{ number_format($barang->harga_jual) }}
                        </div>
                    </div>
                    <div class="form-fieldset mb-3" id="stock-information">
                        <b>Stock Sekarang: </b> {{ number_format($stock) }} 
                    </div>
                    <div class="form-fieldset mb-3">
                        <div class="form-label d-block">
                            <b>Deskripsi</b>
                        </div>
                        <div class="d-block text-wrap">
                            <p>
                                {{ $barang->deskripsi }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        $(document).ready(function () {
            
            $.get('/barang/{{ $barang->slug }}/stock', function(stock) {
                $('#stock-information').append(stock)
            })
            
        });
    </script> --}}
@endsection