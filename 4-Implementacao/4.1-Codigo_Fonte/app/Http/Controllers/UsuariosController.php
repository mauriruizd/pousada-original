<?php

namespace App\Http\Controllers;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Usuario;
use App\Http\Requests\UsuariosDeleteRequest;
use App\Http\Requests\UsuariosRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Helpers\EnumExtractor;

class UsuariosController extends Controller
{
    /**
     * @var UserRepository
     */
    private $usuarios;

    public function __construct(UserRepository $usuarios)
    {
        $this->usuarios = $usuarios;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $usuarios = $this->usuarios->searchAndPaginate($search);
        return view('usuarios.listar-usuarios', [
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
        $usuario = $this->usuarios->create($request->all());
        $this->usuarios->save($usuario);
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
        $usuario = $this->usuarios->find($id);
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
        $usuario = $this->usuarios->find($id);
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
        $usario = $this->usuarios->update($id, $request->all());
        $this->usuarios->save($usario);
        return redirect()->back()->with(['msg' => 'Usuário atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, UsuariosDeleteRequest $request)
    {
        $usuario = $this->usuarios->find($id);
        $this->usuarios->delete($usuario);
        return redirect()->route('usuarios.index')->with(['msg' => 'Usuário eliminado com sucesso!']);
    }

    /**
     * Retorna o histórico de acessos do usuário
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function historico($id)
    {
        $usuario = $this->usuarios->find($id);
        return view('usuarios.historico-acessos', [
            'usuario' => $usuario
        ]);
    }
}
