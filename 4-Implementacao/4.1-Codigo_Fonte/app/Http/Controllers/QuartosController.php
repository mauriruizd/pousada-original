<?php

namespace App\Http\Controllers;

use App\Entities\FotoQuarto;
use App\Entities\Manutencao;
use App\Entities\Quarto;
use App\Entities\TipoQuarto;
use App\Helpers\FormSelectCreator;
use App\Http\Requests\QuartosRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QuartosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $quartos = Quarto::search($search)
            ->paginate(10);
        return view('quartos.listar-quartos', [
            'quartos' => $quartos,
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
        $quartos = Quarto::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('quartos.listar-quartos-arquivados', [
            'quartos' => $quartos,
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
        return view('quartos.criar-quarto', [
            'tiposQuartos' => $this->getTiposQuartos(null)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuartosRequest $request)
    {
        DB::transaction(function() use($request) {
            $quarto = Quarto::create($request->all());
            $this->saveFotos($request, $quarto->id);
        });
        return redirect()->route('quartos.index')->with(['msg' => 'Quarto criado com sucesso!']);
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
            $quarto = Quarto::with(['manutencoes' => function ($q) {
                $q->aberta();
            }])
                ->findOrFail($id);
            return view('quartos.detalhe-quarto', [
                'quarto' => $quarto
            ]);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $quarto = Quarto::with('fotos')
                ->findOrFail($id);
            return view('quartos.editar-quarto', [
                'quarto' => $quarto,
                'tiposQuartos' => $this->getTiposQuartos($quarto->getIdTipoQuarto())
            ]);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuartosRequest $request, $id)
    {
        DB::transaction(function() use($request, $id) {
            FotoQuarto::whereNotIn(
                'id',
                $request->has('img') ? $request->img : []
            )->delete();
            $this->saveFotos($request, $id);
            $quarto = Quarto::find($id);
            $quarto->fill($request->all());
            $quarto->save();
        });
        return redirect()->back()->with(['msg' => 'Quarto atualizado com sucesso!']);
    }

    public function destroy($id, QuartosRequest $request)
    {
        try {
            $quarto = Quarto::findOrFail($id);
            $quarto->delete();
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return redirect()->route('quartos.index')->with(['msg' => 'Quarto eliminado com sucesso!']);
    }

    public function recuperar($id)
    {
        try {
            $quarto = Quarto::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $quarto->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Quarto recuperado com sucesso!']);
    }

    private function saveFotos(Request $request, $quartoId)
    {
        if ($request->hasFile('fotos')) {
            foreach ($request->fotos as $foto) {
                FotoQuarto::create([
                    'id_quarto' => $quartoId,
                    'url' => $foto
                ]);
            }
        }
    }

    public function createManutencao($id)
    {
        $quarto = Quarto::find($id);
        return view('quartos.manutencao.criar-manutencao', [
            'quarto' =>$quarto
        ]);
    }

    public function storeManutencao(QuartosRequest $request, $id)
    {
        $quarto = Quarto::find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        if ($quarto->getEmManutencao()) {
            abort(403);
        }
        DB::transaction(function () use($id, $request) {
            Manutencao::create([
                'id_quarto' => $id,
                'motivo' => $request->motivo,
                'data_inicio' => Carbon::now()
            ]);
            Quarto::where('id', '=', $id)->update([
                'em_manutencao' => true
            ]);
        });
        return redirect()->route('quartos.index')->with([
            'msg' => 'Manutenção inicida com sucesso.'
        ]);
    }

    public function deleteManutencao(QuartosRequest $request, $id)
    {
        $quarto = Quarto::find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        if (!$quarto->getEmManutencao()) {
            abort(403);
        }
        DB::transaction(function () use($id, $request) {
            Manutencao::where('id', '=', $id)
                ->where('data_fim', '=', null)
                ->update([
                    'data_fim' => Carbon::now()
                ]);
            Quarto::where('id', '=', $id)->update([
                'em_manutencao' => false
            ]);
        });
        return redirect()->route('quartos.index')->with([
            'msg' => 'Manutenção finalizada com sucesso.'
        ]);
    }

    /**
     * Retorna array com tipos de quartos.
     */
    private function getTiposQuartos($selected)
    {
        $tiposQuartos = TipoQuarto::all();
        return FormSelectCreator::fromEntity('id', 'nome', $tiposQuartos, 'id_tipo_quarto', $selected, ['id' => 'id_tipo_quarto']);
    }
}
