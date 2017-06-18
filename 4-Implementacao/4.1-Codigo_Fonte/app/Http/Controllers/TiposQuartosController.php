<?php

namespace App\Http\Controllers;

use App\Entities\PrecoDiaria;
use App\Http\Requests\TiposQuartosRequest;
use App\Repositories\TiposQuartosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class TiposQuartosController extends Controller
{
    protected $tiposQuartos;
    protected $em;
    public function __construct(TiposQuartosRepository $tiposQuartos, EntityManagerInterface $em)
    {
        $this->tiposQuartos = $tiposQuartos;
        $this->em = $em;
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $tiposQuartos = $this->tiposQuartos->searchAndPaginate($search);
        return view('tipos-quartos.listar-tipos-quartos', [
            'tiposQuartos' => $tiposQuartos,
            'search' => $search
        ]);
    }

    public function showTarifas($id)
    {
        $tipoQuarto = $this->tiposQuartos->find($id);
        return view('tipos-quartos.tabela-precos-tipo-quarto', [
            'tipoQuarto' => $tipoQuarto,
            'meses' => $this->getMeses()
        ]);
    }

    public function updateTarifas($id, TiposQuartosRequest $request)
    {
        $tipoQuarto = $this->tiposQuartos->find($id);
        $tipoQuarto->updateTarifas($request->precos);
        foreach ($tipoQuarto->getTarifas() as $tarifa) {
            $this->em->persist($tarifa);
        }
        $this->tiposQuartos->save($tipoQuarto);
        $this->em->flush();
        return redirect()->route('tipos-quartos.index')->with(['msg' => 'Tarifas atualizadas com sucesso']);
    }

    public function createPromocao($id)
    {
        $tipoQuarto = $this->tiposQuartos->find($id);
        return view('tipos-quartos.iniciar-promocao-tipo-quarto', [
            'tipoQuarto' => $tipoQuarto
        ]);
    }

    public function storePromocao($id, TiposQuartosRequest $request)
    {
        $tipoQuarto = $this->tiposQuartos->find($id);
        $tipoQuarto->setPrecoPromocional($request->preco);
        $this->tiposQuartos->save($tipoQuarto);
        return redirect()->route('tipos-quartos.index')->with(['msg' => 'Promoção iniciada com sucesso']);
    }

    public function editPromocao($id)
    {
        $tipoQuarto = $this->tiposQuartos->find($id);
        return view('tipos-quartos.alterar-promocao-tipo-quarto', [
            'tipoQuarto' => $tipoQuarto
        ]);
    }

    public function updatePromocao($id, TiposQuartosRequest $request)
    {
        $tipoQuarto = $this->tiposQuartos->find($id);
        $tipoQuarto->setPrecoPromocional($request->preco);
        $this->tiposQuartos->save($tipoQuarto);
        return redirect()->route('tipos-quartos.index')->with(['msg' => 'Promoção alterada com sucesso']);
    }

    public function deletePromocao($id)
    {
        $tipoQuarto = $this->tiposQuartos->find($id);
        if ($tipoQuarto->getPrecoPromocional() === null) {
            abort(403);
        }
        $tipoQuarto->setPrecoPromocional(null);
        $this->tiposQuartos->save($tipoQuarto);
        return redirect()->back()->with(['msg' => 'Promoção concluida com sucesso']);
    }

    private function getMeses()
    {
        return [
            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        ];
    }
}
