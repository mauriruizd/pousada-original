<?php

namespace App\Http\Controllers;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Usuario;
use App\Http\Requests\UsuariosDeleteRequest;
use App\Http\Requests\UsuariosRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Helpers\EnumExtractor;

class UsuariosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $usuarios = Usuario::search($search)
            ->paginate(10);
        return view('usuarios.listar-usuarios', [
            'usuarios' => $usuarios,
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
        $usuarios = Usuario::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('usuarios.listar-usuarios-arquivados', [
            'usuarios' => $usuarios,
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
        return view('usuarios.criar-usuario', [
            'tipos' => EnumExtractor::title(TipoUsuario::class)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuariosRequest $request)
    {
        Usuario::create($request->all());
        return redirect()->route('usuarios.index')->with(['msg' => 'Usuário criado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = Usuario::find($id);
        if (is_null($usuario)) {
            abort(404);
        }
        return view('usuarios.detalhe-usuario', [
            'usuario' => $usuario
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
        $usuario = Usuario::find($id);
        if (is_null($usuario)) {
            abort(404);
        }
        return view('usuarios.editar-usuario', [
            'usuario' => $usuario,
            'tipos' => EnumExtractor::title(TipoUsuario::class)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuariosRequest $request, $id)
    {
        try {
            $usuario = Usuario::where('id', '=', $id)->firstOrFail();
            $usuario->fill($request->all())->save();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Usuário atualizado com sucesso!']);
    }

    public function alterarSenhaForm($id)
    {
        $usuario = Usuario::find($id);
        if (is_null($usuario)) {
            abort(404);
        }
        return view('usuarios.alterar-senha', [
            'usuario' => $usuario
        ]);
    }

    public function alterarSenha($id, UsuariosRequest $request)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->fill($request->all())->save();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->route('usuarios.index')->with(['msg' => 'Senha do Usuário alterada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, UsuariosDeleteRequest $request)
    {
        $usuario = Usuario::find($id);
        $usuario->delete();
        return redirect()->route('usuarios.index')->with(['msg' => 'Usuário arquivado com sucesso!']);
    }

    public function recuperar($id)
    {
        try {
            $usuario = Usuario::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $usuario->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Usuario recuperado com sucesso!']);
    }

    /**
     * Retorna o histórico de acessos do usuário
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function historico($id)
    {
        $usuario = Usuario::with('acessos')
            ->find($id);
        return view('usuarios.historico-acessos', [
            'usuario' => $usuario
        ]);
    }
}
