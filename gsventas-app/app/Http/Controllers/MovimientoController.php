<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Movimientos_producto;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Almacene;
use App\Models\Tipos_movimiento;
use App\Models\Socio;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Movimiento::select('movimientos.*', 'almacenes.name as almacen', 'socios.name as socio', 'tipos_movimientos.concepto as concepto')
                ->join('almacenes', 'movimientos.idalmacen', '=', 'almacenes.id')
                ->join('socios', 'movimientos.idsocio', '=', 'socios.id')
                ->join('tipos_movimientos', 'movimientos.idtipo', '=', 'tipos_movimientos.id');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<a href="' . route('movimientos.show', $row->id) . '" class="btn btn-sm btn-outline-secondary text-primary mx-1" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>';
                    return $btnEdit;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sistema.movimientos.listado');
    }






    /**
     * Display the specified resource.
     */
    public function show(Movimiento $movimiento)
    {
        // Obtener la lista de productos asociados al movimiento
        $productos = Movimientos_producto::select('movimientos_productos.cantidad', 'movimientos_productos.id', 'productos.catalogo as catalogo')
            ->join('productos', 'productos.id', '=', 'movimientos_productos.idproducto')
            ->where('movimientos_productos.idmovimiento', $movimiento->id)
            ->get();

        // Obtener el concepto asociado al movimiento
        $tipo_movimiento = Tipos_movimiento::find($movimiento->idtipo);

        // Obtener el socio asociado al movimiento
        $socio = Socio::find($movimiento->idsocio);

        // Obtener el almacén asociado al movimiento
        $almacen = Almacene::find($movimiento->idalmacen);

        return view('sistema.movimientos.ver', compact('movimiento', 'productos', 'socio', 'almacen', 'tipo_movimiento'));
    }




}
