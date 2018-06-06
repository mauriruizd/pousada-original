<?php

namespace App\Http\Controllers;

use App\Entities\Caixa;
use App\Entities\Enumeration\TipoMovimento;
use App\Entities\Movimento;
use App\Http\Requests\CaixaRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CaixasController extends Controller
{
    public function index()
    {
        if (!is_null($this->caixaAberto())) {
            return redirect()->route('caixas.aberto');
        }
        return view('caixas.historico', [
            'caixas' => Caixa::doUsuario($this->usuario()->getId())->paginate(10)
        ]);
    }

    public function aberto()
    {
        return view('caixas.aberto', [
            'caixa' => $this->caixaAberto()
        ]);
    }

    public function createAbrir()
    {
        $caixaAnterior = Caixa::orderBy('created_at', 'desc')->first();
        return view('caixas.abrir', [
            'caixaAnterior' => $caixaAnterior
        ]);
    }

    public function abrir(CaixaRequest $request)
    {
        $caixa = Caixa::create([
            'quantidade_inicial' => $request->quantidade_inicial,
            'valor_total' => $request->quantidade_inicial,
            'datahora_apertura' => Carbon::now(),
            'id_usuario' => $this->usuario()->getId()
        ]);
        return redirect()->route('caixas.aberto')->with([
            'msg' => 'Caixa aberto às ' . Carbon::createFromFormat('Y-m-d H:i:s', $caixa->datahora_apertura)->format('H:i:s')
        ]);
    }

    public function fechar()
    {
        $caixa = $this->caixaAberto();
        $caixa->datahora_fechamento = Carbon::now();
        $caixa->save();
        return redirect()->route('caixas.index')->with([
            'msg' => 'Caixa fechado con sucesso às ' . Carbon::createFromFormat('Y-m-d H:i:s', $caixa->datahora_fechamento)->format('H:i') . ' no valor de R$' . $caixa->valor_total . '!'
        ]);
    }

    public function createDeposito()
    {
        return view('caixas.deposito', [
            'caixa' => $this->caixaAberto()
        ]);
    }

    public function deposito(CaixaRequest $request)
    {
        $this->caixaAberto()->registrarDeposito($request->valor, $request->motivo);
        return redirect()->route('caixas.index')->with([
            'msg' => 'Deposito registrado com sucesso!'
        ]);
    }

    public function createSaque()
    {
        return view('caixas.saque', [
            'caixa' => $this->caixaAberto(),
            'max' => $this->caixaAberto()->valor_total
        ]);
    }

    public function saque(CaixaRequest $request)
    {
        $this->caixaAberto()->registrarSaque($request->valor, $request->motivo);
        return redirect()->route('caixas.index')->with([
            'msg' => 'Saque registrado com sucesso!'
        ]);
    }

    public function pagamento()
    {
        //
    }

    public function venda()
    {
        //
    }

    public function usuario()
    {
        return auth()->user();
    }
    
    public function caixaAberto()
    {
        return $this->usuario()->caixaAberto();
    }
}
