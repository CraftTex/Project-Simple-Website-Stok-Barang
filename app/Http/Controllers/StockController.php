<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Barang;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('stock.index',[
            "title" => "Stock Barang",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stock.create', [
            "title" => "Input Stock",
            "barangs" => Barang::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $requests)
    {
        $rules = [
            'inputData.*.barang_id' => 'required',
            'inputData.*.jumlah' => 'required|numeric',
            'inputData.*.jenis' => 'required|boolean',
        ];
        
        $validated = $requests->validate($rules);

        foreach ($validated['inputData'] as $key => $value) {

            Stock::create($value);
        }
       
        return redirect('/stock')->with('success','Stock information added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return view('stock.show',[
            'title' => 'View Stock ID: ' . $stock->id,
            'stock' => $stock
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        return view('stock.edit', [
            'title' => 'Edit Data Stok',
            'barang' => Barang::all(),
            'stok' => $stock
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $rules = [
            'barang_id' => 'required',
            'jumlah' => 'required|numeric',
            'jenis' => 'required|boolean',
        ];

        $validated = $request->validate($rules);

        Stock::where('id',$stock->id)
            ->update($validated);

        return redirect('/stock')->with('success','Stock successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        Stock::destroy($stock->id);

        return redirect('/stock')->with('success','Stock successfully deleted!');
    }

    public function getDataTables()
    {
        return DataTables::of(Stock::query()->with('barang'))
            ->addColumn('nama','{{ $model->barang->nama }}')
            ->addColumn('jenis_str', '{{ ($model->jenis) ? "Masuk" : "Keluar" }}')
            ->addColumn('actions','stock.partials.actions')
            ->rawColumns(['actions'])
            ->make(true);
    }

    

}
