<?php

namespace App\Http\Controllers;

use App\Entities\CategoriaComissionista;
use App\Http\Requests\CategoriaComissionistasRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoriasComissionistasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoriaComissionistasRequest $request)
    {
        $search = $request->search;
        $categorias = CategoriaComissionista::search($search)->paginate(10);
        return view('categorias-comissionistas.listar-categorias-comissionistas', [
            'categorias' => $categorias,
            'search' => $search
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function arquivados(CategoriaComissionistasRequest $request)
    {
        $search = $request->search;
        $categorias = CategoriaComissionista::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('categorias-comissionistas.listar-categorias-comissionistas-arquivadas', [
            'categorias' => $categorias,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias-comissionistas.criar-categoria-comissionistas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaComissionistasRequest $request)
    {
        CategoriaComissionista::create($request->all());
        return redirect()->route('categorias-comissionistas.index')->with(['msg' => 'Categoria criad com sucesso!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = CategoriaComissionista::find($id);
        if (is_null($categoria)) {
            abort(404);
        }
        return view('categorias-comissionistas.editar-categoria-comissionistas', [
            'categoria' => $categoria
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaComissionistasRequest $request, $id)
    {
        $categoria = CategoriaComissionista::find($id);
        $categoria->fill($request->all())->save();
        return redirect()->back()->with(['msg' => 'Categoria atualizada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CategoriaComissionistasRequest $request)
    {
        $categoria = CategoriaComissionista::find($id);
        if (is_null($categoria)) {
            abort(404);
        }
        $categoria->delete();
        return redirect()->route('categorias-comissionistas.index')->with(['msg' => 'Categoria arquivada com sucesso!']);
    }

    public function recuperar($id, CategoriaComissionistasRequest $request)
    {
        try {
            $categoria = CategoriaComissionista::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $categoria->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Categoria recuperada com sucesso!']);
    }
}
