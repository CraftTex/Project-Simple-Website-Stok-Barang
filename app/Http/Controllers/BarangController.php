<?php

namespace App\Http\Controllers;

use App\DataTables\barangsDataTable;
use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
        $stock = 0;
        $stockData = Stock::where('barang_id', $barang->id)->get();

        foreach ($stockData as $data) {
            if ($data->jenis) {
                $stock += $data->jumlah;
            } else {
                $stock -= $data->jumlah;
            }
        }

        return view('barang.show',[
            'title' => "Detail " . $barang->nama,
            'barang' => $barang,
            'stock' => $stock,
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
            ->editColumn('harga_beli',function($row){
                return 'Rp' . number_format($row->harga_beli);
            })
            ->editColumn('harga_jual',function($row){
                return 'Rp' . number_format($row->harga_jual);
            })
            ->make(true);
    }

    public function getSlug(Request $request)
    {
        $slug = SlugService::createSlug(Barang::class, 'slug', $request->nama);
        return response()->json(['slug' => $slug]);
    }

    public function getBarangStock(Barang $barang)
    {
        $stock = 0;
        $stockData = Stock::where('barang_id', $barang->id)->get();

        foreach ($stockData as $data) {
            if ($data->jenis) {
                $stock += $data->jumlah;
            } else {
                $stock -= $data->jumlah;
            }
        }

        return $stock;

    }

    public function viewPDF()
    {
        $barang = Barang::all();

        $pdf = PDF::loadView('barang.print', ['barang' => $barang]);

        return $pdf->stream();
    }

    public function createExcel()
    {
        $spreadsheet = new Spreadsheet;
        $barang = Barang::all();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray(
            ['ID', 'Nama Barang', 'Harga Beli', 'Harga Jual', 'Deskripsi'],
            NULL,
            'A1'
        ); //the headers

        $headerStyle = [
            'borders' => [
                'outline' => ['borderStyle' => 'thick', 'color' => [Color::COLOR_BLACK]]
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff']
            ],
            'fill' => [
                'startColor' => ['rgb' => '107c41'],
                'fillType' => Fill::FILL_SOLID
            ]
        ];

        $bodyStyle = [
            'borders' => [
                'outline' => ['borderStyle' => 'thick', 'color' => [Color::COLOR_BLACK]],
                'vertical' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'cccccc']]
            ]
        ];

        $bodyOdd = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => [Color::COLOR_WHITE]
            ]
        ];
        
        $bodyEven = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => 'e3e3e3']
            ]
        ];

        $number = [
            'numberFormat' => [
                'formatCode' => 'Rp#,##0.00'
            ]
        ];
        
        $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);
        $sheet->getStyle('E')->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('E')->setWidth(512,'px');
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getStyle('A2:E' . strval($barang->count() + 1))->applyFromArray($bodyStyle);
        $sheet->getStyle('C2:D' . strval($barang->count() + 1))->applyFromArray($number);
        

        foreach($barang as $index => $data) {
            $toInsert = [
                $data['id'],
                $data['nama'],
                $data['harga_beli'],
                $data['harga_jual'],
                $data['deskripsi'],
            ];
            $row = "A" . strval($index + 2);
            $sheet->fromArray(
                $toInsert,
                NULL,
                $row
            );

            if (($index) % 2 == 0 ) {
                $sheet->getStyle('A' . strval($index + 2) . ':E' . strval($index + 2))->applyFromArray($bodyEven);
            } else {
                $sheet->getStyle('A' . strval($index + 2) . ':E' . strval($index + 2))->applyFromArray($bodyOdd);
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data-Barang.xlsx"');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $writer->save('php://output');
    }
}
