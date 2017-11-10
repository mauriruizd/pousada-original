<?php

namespace App\Http\Controllers;

use App\Http\Requests\SouvenirsRequest;
use App\Entities\Souvenir;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SouvenirsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $souvenirs = Souvenir::search($search)->paginate(10);
        return view('souvenirs.listar-souvenirs', [
            'souvenirs' => $souvenirs,
            'search' => $search
        ]);
    }

    public function listagem()
    {
        $souvenirs = Souvenir::orderBy('id_categoria')->get();
        return view('souvenirs.listagem-souvenirs', [
            'souvenirs' => $souvenirs
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
        $souvenirs = Souvenir::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('souvenirs.listar-souvenirs-arquivados', [
            'souvenirs' => $souvenirs,
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
        return view('souvenirs.criar-souvenir');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SouvenirsRequest $request)
    {
        Souvenir::create($request->all());
        return redirect()->route('souvenirs.index')->with(['msg' => 'Souvenir criado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, SouvenirsRequest $request)
    {
        try {
            $souvenir = Souvenir::find($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return view('souvenirs.detalhe-souvenir', [
            'souvenir' => $souvenir
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, SouvenirsRequest $request)
    {
        $souvenir = Souvenir::find($id);
        if (is_null($souvenir)) {
            abort(404);
        }
        return view('souvenirs.editar-souvenir', [
            'souvenir' => $souvenir
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SouvenirsRequest $request, $id)
    {
        $souvenir = Souvenir::find($id);
        $souvenir->fill($request->all())->save();
        return redirect()->back()->with(['msg' => 'Souvenir atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, SouvenirsRequest $request)
    {
        $souvenir = Souvenir::find($id);
        if (is_null($souvenir)) {
            abort(404);
        }
        $souvenir->delete();
        return redirect()->route('souvenirs.index')->with(['msg' => 'Souvenir arquivado com sucesso!']);
    }

    public function recuperar($id, SouvenirsRequest $request)
    {
        try {
            $souvenir = Souvenir::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $souvenir->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Souvenir recuperado com sucesso!']);
    }
}
