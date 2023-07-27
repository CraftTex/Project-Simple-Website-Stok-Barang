<?php

namespace App\Http\Controllers;

use App\DataTables\barangsDataTable;
use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(barangsDataTable $dataTable)
    {
        return view('/barang/index', [
            "title" => "Daftar Barang",
            "barang" => Barang::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/barang/create', [
            "title" => "Buat Barang",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        $request['slug'] = SlugService::createSlug(Barang::class, 'slug', $request->nama);

        $rules = [
            'nama' => 'required|max:255',
            'slug' => 'required|unique:barangs|max:255',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'gambar' => 'file|image',
            'deskripsi' => 'required',
        ];

        $validated = $request->validate($rules);

        
        if ($request->file('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('img-barang');
        }

        Barang::create($validated);

        return redirect('/barang')->with('success','Barang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        return view('barang.show',[
            'title' => "Detail " . $barang->nama,
            'barang' => $barang,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $barang['oldSlug'] = $barang->slug;
        return view('barang.edit', [
            'title' => 'Edit Barang',
            'barang' => $barang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $rules = [
            'nama' => 'required|max:255',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'gambar' => 'file|image',
            'deskripsi' => 'required',
        ];

        if ($request->slug != $barang->slug) {
            $request['slug'] = SlugService::createSlug(Barang::class, 'slug', $request->slug);
            $rules['slug'] = 'required|unique:barangs|max:255';
        }

        $validated = $request->validate($rules);

        if ($request->file('gambar')) {
            if ($request->oldGambar) {
                Storage::delete($request->oldGambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('img-barang');
        }

        Barang::where('id',$barang->id)
            ->update($validated);

        return redirect('/barang')->with('success', 'Barang updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        if($barang->gambar){
            Storage::delete($barang->gambar);
        }
        Barang::destroy($barang->id);

        return redirect('/barang')->with('success','Barang dihapus!');
    }

    public function getDataTables()
    {
        return DataTables::of(Barang::query())
            ->addColumn('action', 'barang.partials.actions')
            ->make(true);
    }

    public function getSlug(Request $request)
    {
        $slug = SlugService::createSlug(Barang::class, 'slug', $request->nama);
        return response()->json(['slug' => $slug]);
    }
}
