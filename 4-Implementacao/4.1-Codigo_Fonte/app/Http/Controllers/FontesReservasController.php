<?php

namespace App\Http\Controllers;

use App\Entities\FonteReserva;
use App\Http\Requests\FonteReservasRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FontesReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FonteReservasRequest $request)
    {
        $search = $request->search;
        $fontes = FonteReserva::search($search)->paginate(10);
        return view('fontes-reservas.listar-fontes-reservas', [
            'fontes' => $fontes,
            'search' => $search
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function arquivados(FonteReservasRequest $request)
    {
        $search = $request->search;
        $fontes = FonteReserva::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('fontes-reservas.listar-fontes-reservas-arquivadas', [
            'fontes' => $fontes,
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
        return view('fontes-reservas.criar-fonte-reservas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FonteReservasRequest $request)
    {
        $data = $request->all();
        if (!$request->has('pagamento_parcelado') && !$request->has('pagamento_vista')) {
            $data['pagamento_parcelado'] = 1;
        } else {
            $data['pagamento_parcelado'] = $request->has('pagamento_parcelado') ? 1 : 0;
            $data['pagamento_vista'] = $request->has('pagamento_vista') ? 1 : 0;
        }
        FonteReserva::create($data);
        return redirect()->route('fontes-reservas.index')->with(['msg' => 'Fonte criada com sucesso!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fonte = FonteReserva::find($id);
        if (is_null($fonte)) {
            abort(404);
        }
        return view('fontes-reservas.editar-fonte-reservas', [
            'fonte' => $fonte
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FonteReservasRequest $request, $id)
    {
        $fonte = FonteReserva::find($id);
        $data = $request->all();
        if (!$request->has('pagamento_parcelado') && !$request->has('pagamento_vista')) {
            $data['pagamento_vista'] = 1;
            $data['pagamento_parcelado'] = 0;
        } else {
            $data['pagamento_parcelado'] = $request->has('pagamento_parcelado') ? 1 : 0;
            $data['pagamento_vista'] = $request->has('pagamento_vista') ? 1 : 0;
        }
        $fonte->fill($data)->save();
        return redirect()->back()->with(['msg' => 'Fonte atualizada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, FonteReservasRequest $request)
    {
        $fonte = FonteReserva::find($id);
        if (is_null($fonte)) {
            abort(404);
        }
        $fonte->delete();
        return redirect()->route('fontes-reservas.index')->with(['msg' => 'Fonte arquivada com sucesso!']);
    }

    public function recuperar($id, FonteReservasRequest $request)
    {
        try {
            $fonte = FonteReserva::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $fonte->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Fonte recuperada com sucesso!']);
    }
}
