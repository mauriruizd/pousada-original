<?php

namespace App\Http\Controllers;

use App\Entities\ConsumicaoFrigobar;
use App\Entities\CargoConta;
use App\Entities\Cliente;
use App\Entities\Estada;
use App\Entities\Hospede;
use App\Entities\PagamentoReserva;
use App\Entities\Produto;
use App\Entities\Quarto;
use App\Entities\Reserva;
use App\Http\Requests\EstadasRequest;
use App\Entities\PagamentoConta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $estadas = Estada::search($search)
            ->aberta()
            ->paginate(10);
        return view('estadas.listar-estadas', [
            'estadas' => $estadas,
            'search' => $search
        ]);
    }

    public function show($id, Request $request)
    {
        return view('estadas.show', [
            'estada' => Estada::find($id)
        ]);
    }

    public function checkinForm($id)
    {
        return view('estadas.checkin', [
            'reserva' => Reserva::find($id),
            'clientes' => Cliente::pluck('nome', 'id')
        ]);
    }

    public function checkin($id, EstadasRequest $request)
    {
        DB::transaction(function () use ($id, $request) {
            $reserva = Reserva::find($id);
            $estada = Estada::create([
                'datahora_entrada' => Carbon::now(),
                'nro_dias' => Carbon::createFromFormat('d/m/Y', $reserva->getDataEntrada())->diffInDays(Carbon::createFromFormat('d/m/Y', $reserva->getDataSaida())),
                'valor_total' => $reserva->getValorTotal(),
                'id_reserva' => $id,
                'id_usuario' => auth()->user()->getId(),
                'id_quarto' => $reserva->getQuarto()->getId()
            ]);
            foreach ($request->hospedes as $clienteId) {
                Hospede::create([
                    'id_estada' => $estada->getId(),
                    'id_cliente' => $clienteId
                ]);
            }
        });
        return redirect()->route('estadas.index')->with([
            'msg' => 'Checkin realizado com sucesso!'
        ]);
    }

    public function checkout($id)
    {
        Estada::where('id', $id)
            ->update([
                'datahora_saida' => Carbon::now()
            ]);
        return redirect()->route('estadas.index')->with([
            'msg' => 'Checkout realizado com sucesso!'
        ]);
    }

    public function editHospedes($id)
    {
        $estada = Estada::find($id);
        return view('estadas.hospedes', [
            'clientes' => Cliente::pluck('nome', 'id'),
            'estada' => $estada,
            'hospedes' => $estada->hospedes()->pluck('id_cliente')
        ]);
    }

    public function updateHospedes($id, EstadasRequest $request)
    {
        DB::transaction(function () use ($id, $request) {
            $estada = Estada::find($id);
            $estada->hospedes()->delete();
            foreach ($request->hospedes as $clienteId) {
                Hospede::create([
                    'id_estada' => $estada->getId(),
                    'id_cliente' => $clienteId
                ]);
            }
        });
        return redirect()->route('estadas.index')->with([
            'msg' => 'Lista de hospedes editada com sucesso!'
        ]);
    }

    public function editQuarto($id)
    {
        $estada = Estada::find($id);
        $hoje = Carbon::now()->format('d/m/Y');
        $quartos = Quarto::consultarDisponibilidade($hoje, $hoje, $estada->getReserva()->getId())
            ->whereHas('tipoQuarto', function ($q) use ($estada) {
                $q->where('capacidade', '>=', $estada->hospedes()->count());
            })
            ->select('id', 'numero', 'id_tipo_quarto')
            ->with('tipoQuarto')
            ->get();
        return view('estadas.quartos', [
            'quartos' => $quartos->groupBy('id_tipo_quarto'),
            'estada' => $estada
        ]);
    }

    public function updateQuarto($id, EstadasRequest $request)
    {
        Estada::where('id', $id)
            ->update([
                'id_quarto' => $request->id_quarto
            ]);
        return redirect()->route('estadas.index')->with([
            'msg' => 'Quarto alterado com sucesso!'
        ]);
    }

    public function createFrigobar($id)
    {
        return view('estadas.frigobar', [
            'produtos' => Produto::comEstoque()->pluck('nome', 'id'),
            'estada' => Estada::find($id)
        ]);
    }

    public function storeFrigobar($id, EstadasRequest $request)
    {
        DB::transaction(function () use ($id, $request) {
            $producto = Produto::find($request->id_produto);
            $preco = $producto->getPrecos()->sortByDesc('datahora_cadastro')->first()->preco;
            $valor = $request->quantidade * $preco;
            $cargo = CargoConta::create([
                'id_estada' => $id,
                'id_usuario' => auth()->user()->getId(),
                'valor' => $valor,
                'motivo' => 'Consumição de Frigobar'
            ]);

            ConsumicaoFrigobar::create([
                'id_cargo_conta' => $cargo->getId(),
                'id_produto' => $producto->getId(),
                'preco' => $preco,
                'quantidade' => $request->quantidade,
                'subtotal' => $valor
            ]);
        });
        return redirect()->route('estadas.create-frigobar', [$id])->with([
            'msg' => 'Consumição registrada com sucesso!'
        ]);
    }

    public function estadoConta($id)
    {
        return view('estadas.estado-conta', [
            'estada' => Estada::find($id)
        ]);
    }

    public function createPagamento($id)
    {
        return view('estadas.pagamento', [
            'estada' => Estada::find($id)
        ]);
    }

    public function storePagamento($id, EstadasRequest $request)
    {
        PagamentoConta::create([
            'id_estada' => $id,
            'id_usuario' => auth()->user()->getId(),
            'valor' => $request->valor
        ]);
        return redirect()->route('estadas.index')->with([
            'msg' => 'Pagamento efeituado com sucesso!'
        ]);
    }

    public function createExtender($id)
    {
        return view('estadas.extender', [
            'estada' => Estada::find($id)
        ]);
    }

    public function storeExtender($id, EstadasRequest $request)
    {
        $estada = Estada::find($id);
        $estada->extenderEstada($request->diarias);
        $estada->save();
        return redirect()->route('estadas.index')->with([
            'msg' => 'Estada extendida com sucesso!'
        ]);
    }

    public function createDano($id)
    {
        return view('estadas.dano', [
            'estada' => Estada::find($id)
        ]);
    }

    public function storeDano($id, EstadasRequest $request)
    {
        CargoConta::create([
            'id_estada' => $id,
            'id_usuario' => auth()->user()->getId(),
            'valor' => $request->valor,
            'motivo' => $request->descricao
        ]);
        return redirect()->route('estadas.index')->with([
            'msg' => 'Dano registrado com sucesso!'
        ]);
    }
}
