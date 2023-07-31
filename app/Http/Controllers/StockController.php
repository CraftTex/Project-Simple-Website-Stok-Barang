<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Barang;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

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
            ->editColumn('jenis', function($row) {
                return (($row->jenis) ? 'Masuk' : 'Keluar');
            })
            ->editColumn('jumlah', function($row) {
                return number_format($row->jumlah);
            })
            ->addColumn('actions','stock.partials.actions')
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function viewPDF()
    {
        $stock = Stock::with('barang')->get();

        $pdf = PDF::loadView('stock.print', ['stock' => $stock]);

        return $pdf->stream();
    }

    public function createExcel()
    {
        $spreadsheet = new Spreadsheet;

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray(
            ['ID Stock','Tanggal Input' ,'Nama Barang', 'ID Barang', 'Jumlah', 'Jenis'],
            NULL,
            'A1'
        ); //the headers

        $stock = Stock::with('barang')->get();

        
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
        
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getStyle('A2:F' . strval($stock->count() + 1))->applyFromArray($bodyStyle);
        
        foreach($stock as $index => $data) {
            $toInsert = [
                $data->id,
                strval($data->created_at->format('d-m-Y, h:i:s A')),
                $data->barang->nama,
                $data->barang_id,
                $data->jumlah,
                (($data->jenis) ? 'Masuk' : 'Keluar'),
            ];
            $row = "A" . strval($index + 2);
            $sheet->fromArray(
                $toInsert,
                NULL,
                $row
            );

            if (($index) % 2 == 0 ) {
                $sheet->getStyle('A' . strval($index + 2) . ':F' . strval($index + 2))->applyFromArray($bodyEven);
            } else {
                $sheet->getStyle('A' . strval($index + 2) . ':F' . strval($index + 2))->applyFromArray($bodyOdd);
            }
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data-Input-Stock.xlsx"');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $writer->save('php://output');
    }
}
