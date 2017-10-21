<?php

namespace App\Http\Controllers;

use App\Entities\Cidade;
use App\Entities\Cliente;
use App\Entities\Estado;
use App\Entities\Pais;
use App\Helpers\FormSelectCreator;
use App\Http\Requests\ClientesDeleteRequest;
use App\Http\Requests\ClientesRequest;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $clientes = Cliente::search($search)->paginate(10);
        return view('clientes.listar-clientes', [
            'clientes' => $clientes,
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
        $clientes = Cliente::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('clientes.listar-clientes-arquivados', [
            'clientes' => $clientes,
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
        return view('clientes.criar-cliente', [
            'nacionalidade' => $this->getPaises(null, 'id_nacionalidade'),
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
    public function store(ClientesRequest $request)
    {
        Cliente::create(array_merge($request->all(), $this->getActiveUserArray()));
        return redirect()->route('clientes.index')->with(['msg' => 'Cliente criado com sucesso!']);
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
            $cliente = Cliente::find($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return view('clientes.detalhe-cliente', [
            'cliente' => $cliente
        ]);
    }

    /**
     * Retorna ficha do cliente em PDF
     *
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function ficha($id, Request $request)
    {
        $cliente = Cliente::find($id);
        if (is_null($cliente)) {
            abort(404);
        }
        $view = view('clientes.ficha-cliente', [
            'cliente' => $cliente
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view->render());
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);
        if (is_null($cliente)) {
            abort(404);
        }
        $cidade = $cliente->getCidade();
        $estado = $cidade->getEstado();
        $pais = $estado->getPais();
        return view('clientes.editar-cliente', [
            'cliente' => $cliente,
            'nacionalidade' => $this->getPaises($cliente->getNacionalidade()->getId(), 'id_nacionalidade'),
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
    public function update(ClientesRequest $request, $id)
    {
        $cliente = Cliente::find($id);
        $cliente->fill($request->all())->save();
        return redirect()->back()->with(['msg' => 'Cliente atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ClientesDeleteRequest $request)
    {
        $cliente = Cliente::find($id);
        if (is_null($cliente)) {
            abort(404);
        }
        $cliente->delete();
        return redirect()->route('clientes.index')->with(['msg' => 'Cliente arquivado com sucesso!']);
    }

    public function recuperar($id)
    {
        try {
            $cliente = Cliente::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $cliente->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Cliente recuperado com sucesso!']);
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

    private function getActiveUserArray()
    {
        return [
            'id_usuario' => auth()->user()->id
        ];
    }
}
