@extends('layouts.main')

@section('title')
    Editing Stock Information
@endsection

@section('container')
    
<div class="d-flex justify-content-center">
    <div class="card col-md-6 p-3">
        <form action="/stock/{{ $stok->id }}" method="POST">
            @method('put')
            @csrf
                <div class="mb-3">
                    <label for="barang_id" class="form-label required">Nama Barang (id)</label>
                    <select name="barang_id" id="barang_id" class="form-select">
                        @foreach ($barang as $item)
                            @if ($item->id == old('barang_id',$stok->barang_id))
                                <option value="{{ $item->id }}" selected>{{ $item->nama }} ({{ $item->id }})</option>
                            @else
                                <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->id }})</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label required" for="jumlah">Jumlah Stok</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah" value="{{ old('jumlah', $stok->jumlah) }}">
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label required">Jenis</label>
                    <select name="jenis" id="jenis" class="form-select">
                        @if ( old('jenis',$stok->jenis) == '1')
                            <option value="1" selected>Masuk</option>
                            <option value="0">Keluar</option>
                        @else
                            <option value="1">Masuk</option>
                            <option value="0"selected>Keluar</option>
                        @endif
                        
                    </select>
                </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>


@endsection