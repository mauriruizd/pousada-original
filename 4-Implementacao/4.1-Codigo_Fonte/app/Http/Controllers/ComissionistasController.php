<?php

namespace App\Http\Controllers;

use App\Entities\CategoriaComissionista;
use App\Entities\Comissionista;
use App\Http\Requests\ComissionistasRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComissionistasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $comissionistas = Comissionista::search($search)->paginate(10);
        return view('comissionistas.listar-comissionistas', [
            'comissionistas' => $comissionistas,
            'search' => $search
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function arquivados(Request $request)
    {
        $search = $request->search;
        $comissionistas = Comissionista::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('comissionistas.listar-comissionistas-arquivados', [
            'comissionistas' => $comissionistas,
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
        return view('comissionistas.criar-comissionista', [
            'categorias' => CategoriaComissionista::pluck('nome', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComissionistasRequest $request)
    {
        DB::transaction(function () use($request) {
            Comissionista::create($request->all());
        });
        return redirect()->route('comissionistas.index')->with(['msg' => 'Comissionista criado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, ComissionistasRequest $request)
    {
        try {
            $comissionista = Comissionista::find($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return view('comissionistas.detalhe-comissionista', [
            'comissionista' => $comissionista
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, ComissionistasRequest $request)
    {
        $comissionista = Comissionista::find($id);
        if (is_null($comissionista)) {
            abort(404);
        }
        return view('comissionistas.editar-comissionista', [
            'comissionista' => $comissionista,
            'categorias' => CategoriaComissionista::pluck('nome', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComissionistasRequest $request, $id)
    {
        DB::transaction(function() use($request, $id) {
            $comissionista = Comissionista::find($id);
            $comissionista->fill($request->all())->save();
        });
        return redirect()->back()->with(['msg' => 'Comissionista atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ComissionistasRequest $request)
    {
        $comissionista = Comissionista::find($id);
        if (is_null($comissionista)) {
            abort(404);
        }
        $comissionista->delete();
        return redirect()->route('comissionistas.index')->with(['msg' => 'Comissionista arquivado com sucesso!']);
    }

    public function recuperar($id, ComissionistasRequest $request)
    {
        try {
            $comissionista = Comissionista::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $comissionista->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Comissionista recuperado com sucesso!']);
    }

    public function relatorioComissoes(ComissionistasRequest $request)
    {
        // TODO: depues de estadas
    }

    public function formModificarPercentagem(ComissionistasRequest $request, $id)
    {
        try {
            return view('comissionistas.form-percentagem-comissao', [
                'comissionista' => Comissionista::findOrFail($id)
            ]);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
    }

    public function modificarPercentagem(ComissionistasRequest $request, $id)
    {
        $comissionista = Comissionista::find($id);
        $comissionista->fill($request->all())->save();
        return redirect()->back()->with([
            'msg' => 'Percentagem modificada com sucesso!'
        ]);
    }

    public function historicoPagamentos(ComissionistasRequest $request)
    {
        // TODO: despues de estadas
    }
}
