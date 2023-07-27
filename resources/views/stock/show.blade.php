@extends('layouts.main')

@section('title')
    {{ $title }}
@endsection

@section('container')
    <div class=" justify-content-start">
        <div class="card card-md-6 p-3">
            <div class="card-header">
                <h3 class="mb-3">
                    Stock ID: {{ $stock->id }}
                </h3>
            </div>
            <div class="card-body">
                <div class="form-fieldset row">
                    <div class="col">
                        <label class="form-label">Nama Barang</label>
                        <p>{{ $stock->barang->nama }} ({{ $stock->barang_id }})</p>
                    </div>
                    <div class="col">
                        <label class="form-label">Jumlah</label>
                        <p>{{ $stock->jumlah }}</p>
                    </div>
                    <div class="col">
                        <label class="form-label">Jenis</label>
                        @if ( $stock->jenis == "1" )
                            <p>Masuk</p>
                        @else
                            <p>Keluar</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection