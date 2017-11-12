<?php

namespace App\Http\Controllers;

use App\Entities\Cliente;
use App\Entities\ClienteReserva;
use App\Entities\Comissionista;
use App\Entities\FonteReserva;
use App\Entities\Quarto;
use App\Entities\Reserva;
use App\Http\Requests\ReservasRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Form;
use Illuminate\Support\Facades\DB;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReservasRequest $request)
    {
        $search = $request->search;
        $reservas = Reserva::search($search)->paginate(10);
        return view('reservas.listar-reservas', [
            'reservas' => $reservas,
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
        return view('reservas.gerar-reserva', [
            'clientes' => Cliente::pluck('nome', 'id'),
            'quartos' => Quarto::pluck('numero', 'id'),
            'fontes' => FonteReserva::pluck('nome', 'id'),
            'comissionistas' => Comissionista::pluck('nome', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservasRequest $request)
    {
        DB::transaction(function () use($request) {
            $reserva = Reserva::create($request->all());
            foreach ($request->clientes as $cliente) {
                ClienteReserva::create([
                    'id_cliente' => $cliente,
                    'id_reserva' => $reserva->id
                ]);
            }
        });
        return redirect()->route('reservas.index')->with(['msg' => 'Reserva gerada com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, ReservasRequest $request)
    {
        try {
            $reserva = Reserva::find($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return view('reservas.detalhe-reserva', [
            'reserva' => $reserva
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
        $reserva = Reserva::find($id);
        if (is_null($reserva)) {
            abort(404);
        }
        $cidade = $reserva->getCidade();
        $estado = $cidade->getEstado();
        $pais = $estado->getPais();
        return view('reservas.editar-reserva', [
            'reserva' => $reserva,
            'nacionalidade' => $this->getPaises($reserva->getNacionalidade()->getId(), 'id_nacionalidade'),
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
    public function update(ReservasRequest $request, $id)
    {
        $reserva = Reserva::find($id);
        $reserva->fill($request->all())->save();
        return redirect()->back()->with(['msg' => 'Reserva atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ReservasRequest $request)
    {
        $reserva = Reserva::find($id);
        if (is_null($reserva)) {
            abort(404);
        }
        $reserva->delete();
        return redirect()->route('reservas.index')->with(['msg' => 'Reserva arquivado com sucesso!']);
    }

    public function recuperar($id, ReservasRequest $request)
    {
        try {
            $reserva = Reserva::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $reserva->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Reserva recuperado com sucesso!']);
    }

    public function consultarDisponibilidade(Request $request)
    {
        $quartos = Quarto::consultarDisponibilidade($request->dataentrada, $request->datasaida)
            ->pluck('numero', 'id');
        return Form::select('id_quarto', $quartos, null);
    }

}
