<?php

namespace App\Http\Controllers;

use App\Entities\Cliente;
use App\Entities\ClienteReserva;
use App\Entities\Comissionista;
use App\Entities\Enumeration\EstadoReserva;
use App\Entities\FonteReserva;
use App\Entities\PagamentoReserva;
use App\Entities\Quarto;
use App\Entities\Reserva;
use App\Http\Requests\ReservasRequest;
use Carbon\Carbon;
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
    public function create(Request $request)
    {
        return view('reservas.gerar-reserva', [
            'clientes' => Cliente::select(DB::raw('concat(nome, " - ", rg) as nome, id'))->pluck('nome', 'id'),
            'fontes' => FonteReserva::pluck('nome', 'id'),
            'comissionistas' => $this->getComissionistasSelect(),
            'idCliente' => $request->idCliente
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
        Reserva::create(array_merge(
            $request->all(),
            [
                'id_usuario' => auth()->user()->id
            ]
        ));
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
        return view('reservas.editar-reserva', [
            'reserva' => $reserva
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
        return redirect()->back()->with(['msg' => 'Reserva atualizada com sucesso!']);
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
        $reserva->setEstado((string) EstadoReserva::$CANCELADA);
        $reserva->save();
        if (is_null($reserva)) {
            abort(404);
        }
        return redirect()->route('reservas.index')->with(['msg' => 'Reserva cancelada com sucesso!']);
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

    public function relatorio(Request $request)
    {
        $dataInicio = $request->data_inicio;
        $dataFim = $request->data_fim;
        if (!is_null($dataInicio) && !is_null($dataFim)) {
            $reservas = Reserva::consultarIndisponibilidade($dataInicio, $dataFim)->get();
        } else {
            $reservas = Reserva::all();
        }
        return view('reservas.relatorio-reservas', [
            'reservas' => $reservas,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim
        ]);
    }

    public function pagamentoForm($id)
    {
        return view('reservas.registrar-pagamento-reserva', [
            'reserva' => Reserva::find($id)
        ]);
    }

    public function pagamento($id, ReservasRequest $request)
    {
        PagamentoReserva::create([
            'datahora' => Carbon::now(),
            'id_reserva' => $request->route('reserva'),
            'quantia' => $request->quantia
        ]);
        return redirect()->back()->with([
            'msg' => 'Pagamento efeituado com sucesso! Saldo restante de R$' . Reserva::find($request->route('reserva'))->getSaldoPagar()
        ]);
    }

    public function saldoReserva($id)
    {
        $reserva = Reserva::find($id);
        return view('reservas.saldo-reserva', [
            'reserva' => $reserva
        ]);
    }

    public function estadoComissaoReserva($id, ReservasRequest $request)
    {
        $reserva = Reserva::find($id);
        if (is_null($reserva->getComissionista())) {
            return redirect()->route('reservas.index')
                ->with([
                    'warning' => 'Essa reserva não tem comissionista'
                ]);
        }
        return view('reservas.estado-comissao-reserva', [
            'reserva' => $reserva
        ]);
    }

    public function confirmarComissao($id, ReservasRequest $request)
    {
        $reserva = Reserva::find($id);
        if (is_null($reserva)) {
            abort(404);
        }
        $reserva->setComissaoPaga(true);
        $reserva->save();
        return redirect()->back()->with([
            'msg' => 'Pagamento confirmado com sucesso!'
        ]);
    }

    public function consultarDisponibilidade(Request $request)
    {
        $quartos = Quarto::consultarDisponibilidade($request->dataentrada, $request->datasaida, $request->reservaId)
            ->select('id', 'numero', 'id_tipo_quarto')
            ->with('tipoQuarto')
            ->get();
        return $quartos->groupBy('id_tipo_quarto');
    }

    public function consultarTiposPagamento(Request $request)
    {
        return FonteReserva::find($request->fonte);
    }

    private function getComissionistasSelect()
    {
        return Comissionista::join('categorias_comissionistas', 'comissionistas.id_categoria', '=', 'categorias_comissionistas.id')
            ->select('comissionistas.id', DB::raw('CONCAT(comissionistas.nome, " (", categorias_comissionistas.nome, ")") as nomecomposto'))
            ->orderBy('id_categoria')
            ->pluck('nomecomposto', 'id')
            ->prepend('Selecione comissionista (opcional)', '');
    }

}
