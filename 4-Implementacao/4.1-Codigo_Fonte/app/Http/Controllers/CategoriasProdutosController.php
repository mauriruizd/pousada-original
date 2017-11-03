<?php

namespace App\Http\Controllers;

use App\Entities\Categoria;
use App\Http\Requests\CategoriaProdutosRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoriasProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoriaProdutosRequest $request)
    {
        $search = $request->search;
        $categorias = Categoria::search($search)->paginate(10);
        return view('categorias.listar-categorias-produtos', [
            'categorias' => $categorias,
            'search' => $search
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function arquivados(CategoriaProdutosRequest $request)
    {
        $search = $request->search;
        $categorias = Categoria::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('categorias.listar-categorias-produtos-arquivadas', [
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
        return view('categorias.criar-categoria-produtos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaProdutosRequest $request)
    {
        Categoria::create($request->all());
        return redirect()->route('categorias.index')->with(['msg' => 'Categoria criad com sucesso!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::find($id);
        if (is_null($categoria)) {
            abort(404);
        }
        return view('categorias.editar-categoria-produtos', [
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
    public function update(CategoriaProdutosRequest $request, $id)
    {
        $categoria = Categoria::find($id);
        $categoria->fill($request->all())->save();
        return redirect()->back()->with(['msg' => 'Categoria atualizada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CategoriaProdutosRequest $request)
    {
        $categoria = Categoria::find($id);
        if (is_null($categoria)) {
            abort(404);
        }
        $categoria->delete();
        return redirect()->route('categorias.index')->with(['msg' => 'Categoria arquivada com sucesso!']);
    }

    public function recuperar($id, CategoriaProdutosRequest $request)
    {
        try {
            $categoria = Categoria::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $categoria->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Categoria recuperada com sucesso!']);
    }
}
