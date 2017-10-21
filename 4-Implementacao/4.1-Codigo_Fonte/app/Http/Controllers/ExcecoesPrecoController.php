<?php

namespace App\Http\Controllers;

use App\Entities\ExcecaoPreco;
use App\Entities\TipoQuarto;
use App\Http\Requests\TiposQuartosRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExcecoesPrecoController extends Controller
{
    public function index($tipoQuartoId, Request $request)
    {
        $search = $request->search;
        $excecoes = ExcecaoPreco::doTipo($tipoQuartoId)
            ->search($request->search)
            ->paginate(10);
        $tipoQuarto = TipoQuarto::find($tipoQuartoId);
        return view('tipos-quartos.excecoes-precos.listar-excecoes-preco', [
            'excecoes' => $excecoes,
            'tipoQuarto' => $tipoQuarto,
            'search' => $search
        ]);
    }

    public function create($tipoQuartoId)
    {
        return view('tipos-quartos.excecoes-precos.criar-excecao-preco', [
            'tipoQuarto' => TipoQuarto::find($tipoQuartoId)
        ]);
    }

    public function store($tipoQuartoId, TiposQuartosRequest $request)
    {
        ExcecaoPreco::create(array_merge($request->all(), ['id_tipo_quarto' => $tipoQuartoId]));
        return redirect()->route('tipos-quartos.excecoes-precos.index', [$tipoQuartoId])
            ->with(['msg' => 'Exceção criada com sucesso!']);
    }

    public function edit($tipoQuartoId, $excecaoId)
    {
        $tipoQuarto = TipoQuarto::find($tipoQuartoId);
        $excecao = ExcecaoPreco::find($excecaoId);
        return view('tipos-quartos.excecoes-precos.editar-excecao-preco', [
            'tipoQuarto' => $tipoQuarto,
            'excecao' => $excecao
        ]);
    }

    public function update($tipoQuartoId, $excecaoId, TiposQuartosRequest $request)
    {
        try {
            $excecao = ExcecaoPreco::findOrFail($excecaoId);
            $excecao->fill($request->all())->save();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->route('tipos-quartos.excecoes-precos.index', [$tipoQuartoId])
            ->with(['msg' => 'Exceção editada com sucesso!']);
    }

    public function destroy($tipoQuartoId, $excecaoId, TiposQuartosRequest $request)
    {
        try {
            $excecao = ExcecaoPreco::findOrFail($excecaoId);
            $excecao->delete();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->route('tipos-quartos.excecoes-precos.index', [$tipoQuartoId])
            ->with(['msg' => 'Exceção eliminada com sucesso!']);
    }
}
