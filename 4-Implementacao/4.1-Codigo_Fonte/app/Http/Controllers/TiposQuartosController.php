<?php

namespace App\Http\Controllers;

use App\Entities\PrecoDiaria;
use App\Entities\TipoQuarto;
use App\Http\Requests\TiposQuartosRequest;
use App\Repositories\TiposQuartosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TiposQuartosController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $tiposQuartos = TipoQuarto::search($search)
            ->paginate(10);
        return view('tipos-quartos.listar-tipos-quartos', [
            'tiposQuartos' => $tiposQuartos,
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
        $tiposQuartos = TipoQuarto::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('tipos-quartos.listar-tipos-quartos-arquivados', [
            'tiposQuartos' => $tiposQuartos,
            'search' => $search
        ]);
    }

    public function create()
    {
        return view('tipos-quartos.criar-tipo-quarto');
    }

    public function store(TiposQuartosRequest $request)
    {
        TipoQuarto::create($request->all());
        return redirect()->route('tipos-quartos.index')->with(['msg' => 'Tipo de Quarto criado com sucesso!']);
    }

    public function show($id)
    {
        return view('tipos-quartos.detalhe-tipo-quarto', [
            'tipoQuarto' => TipoQuarto::find($id)
        ]);
    }

    public function edit($id)
    {
        try {
            $tipoQuarto = TipoQuarto::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return view('tipos-quartos.editar-tipo-quarto', [
            'tipoQuarto' => $tipoQuarto
        ]);
    }

    public function update($id, TiposQuartosRequest $request)
    {
        try {
            $tipoQuarto = TipoQuarto::findOrFail($id);
            $tipoQuarto->fill($request->all())->save();
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return redirect()->route('tipos-quartos.index')->with(['msg' => 'Tipo de Quarto atualizado com sucesso!']);
    }

    public function destroy($id, TiposQuartosRequest $request)
    {
        try {
            $tipoQuarto = TipoQuarto::findOrFail($id);
            $tipoQuarto->delete();
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return redirect()->route('tipos-quartos.index')->with(['msg' => 'Tipo de Quarto eliminado com sucesso!']);
    }

    public function recuperar($id)
    {
        try {
            $tipoQuarto = TipoQuarto::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $tipoQuarto->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Tipo de Quarto recuperado com sucesso!']);
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
