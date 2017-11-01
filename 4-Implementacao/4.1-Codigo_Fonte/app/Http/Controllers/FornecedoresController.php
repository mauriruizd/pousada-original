<?php

namespace App\Http\Controllers;

use App\Entities\Cidade;
use App\Entities\Estado;
use App\Entities\Fornecedor;
use App\Entities\Pais;
use App\Helpers\FormSelectCreator;
use App\Http\Requests\FornecedoresRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FornecedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $fornecedores = Fornecedor::search($search)->paginate(10);
        return view('fornecedores.listar-fornecedores', [
            'fornecedores' => $fornecedores,
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
        $fornecedores = Fornecedor::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('fornecedores.listar-fornecedores-arquivados', [
            'fornecedores' => $fornecedores,
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
        $firstEstado = Estado::where([
            'id_pais' => 1
        ])->first();
        return view('fornecedores.criar-fornecedor', [
            'paises' => $this->getPaises(null, 'paises'),
            'estados' => $this->getEstados(1, null),
            'cidades' => $this->getCidades($firstEstado->id, null)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FornecedoresRequest $request)
    {
        Fornecedor::create($request->all());
        return redirect()->route('fornecedores.index')->with(['msg' => 'Fornecedor criado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $fornecedor = Fornecedor::find($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return view('fornecedores.detalhe-fornecedor', [
            'fornecedor' => $fornecedor
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FornecedoresRequest $request)
    {
        $fornecedor = Fornecedor::find($id);
        if (is_null($fornecedor)) {
            abort(404);
        }
        $cidade = $fornecedor->getCidade();
        $estado = $cidade->getEstado();
        $pais = $estado->getPais();
        return view('fornecedores.editar-fornecedor', [
            'fornecedor' => $fornecedor,
            'paises' => $this->getPaises($pais->getId(), 'paises'),
            'estados' => $this->getEstados($pais->getId(), $estado->getId()),
            'cidades' => $this->getCidades($estado->getId(), $cidade->getId())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FornecedoresRequest $request, $id)
    {
        $fornecedor = Fornecedor::find($id);
        $fornecedor->fill($request->all())->save();
        return redirect()->back()->with(['msg' => 'Fornecedor atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, FornecedoresRequest $request)
    {
        $fornecedor = Fornecedor::find($id);
        if (is_null($fornecedor)) {
            abort(404);
        }
        $fornecedor->delete();
        return redirect()->route('fornecedores.index')->with(['msg' => 'Fornecedor arquivado com sucesso!']);
    }

    public function recuperar($id, FornecedoresRequest $request)
    {
        try {
            $fornecedor = Fornecedor::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $fornecedor->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Fornecedor recuperado com sucesso!']);
    }

    public function relatorio(FornecedoresRequest $request)
    {
        return view('fornecedores.relatorio-compras-fornecedores');
    }

    /**
     * Endpoint para retornar elemento select para estados e cidades
     *
     * @param $endpoint
     * @param $id
     * @return string
     */
    public function selectEndpoint($endpoint, $id)
    {
        switch ($endpoint) {
            case 'estados' :
                return $this->getEstados($id, null);
            case 'cidades' :
                return $this->getCidades($id, null);
            default :
                return '';
        }
    }

    public function getPaises($selected, $elementNameId)
    {
        $paises = Pais::all();
        return FormSelectCreator::fromEntity('id', 'nome', $paises, $elementNameId, $selected, ['id' => $elementNameId]);
    }

    public function getEstados($idPais, $selected)
    {
        $estados = Estado::where([
            'id_pais' => $idPais
        ])->get();
        return FormSelectCreator::fromEntity('id', 'nome', $estados, 'estado', $selected, ['id' => 'estados']);
    }

    public function getCidades($idEstado, $selected)
    {
        $cidades = Cidade::where([
            'id_estado' => $idEstado
        ])->get();
        return FormSelectCreator::fromEntity('id', 'nome', $cidades, 'id_cidade', $selected, ['id' => 'cidades']);
    }
}
