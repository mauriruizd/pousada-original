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
use Illuminate\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
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
        $cliente = $this->clientes->find($id);
        if (is_null($cliente)) {
            abort(404);
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
        $cliente = $this->clientes->find($id);
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
        $cliente = $this->clientes->find($id);
        if (is_null($cliente)) {
            abort(404);
        }
        $cidade = $cliente->getCidade();
        $estado = $cidade->getEstado();
        $pais = $estado->getPais();
        return view('clientes.editar-cliente', [
            'cliente' => $cliente,
            'nacionalidade' => $this->getPaises($cliente->getNacionalidade()->getId(), 'nacionalidade'),
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
        $data = $request->all();
        $data['nacionalidade'] = $this->paises->find($request->nacionalidade);
        $data['cidade'] = $this->cidades->find($data['cidade']);
        $data['dataNascimento'] = new \DateTime($this->formatDate($data['dataNascimento']));
        $usario = $this->clientes->update($id, $data);
        $this->clientes->save($usario);
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
        $cliente = $this->clientes->find($id);
        if (is_null($cliente)) {
            abort(404);
        }
        $this->clientes->delete($cliente);
        return redirect()->route('clientes.index')->with(['msg' => 'Cliente eliminado com sucesso!']);
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
