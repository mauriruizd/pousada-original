<?php

namespace App\Http\Controllers;

use App\Entities\FotoQuarto;
use App\Entities\Promocao;
use App\Helpers\FormSelectCreator;
use App\Http\Requests\QuartosRequest;
use App\Repositories\QuartosRepository;
use App\Repositories\TiposQuartosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuartosController extends Controller
{
    protected $quartos;
    protected $tiposQuartos;
    protected $promocoes;
    protected $em;
    protected $fotos;

    public function __construct(
        QuartosRepository $quartos,
        TiposQuartosRepository $tiposQuartos,
        EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->quartos = $quartos;
        $this->tiposQuartos = $tiposQuartos;
        $this->promocoes = $em->getRepository(Promocao::class);
        $this->fotos = $em->getRepository(FotoQuarto::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $quartos = $this->quartos->searchAndPaginate($search);
        return view('quartos.listar-quartos', [
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
        $data = $request->all();
        $data['tipoQuarto'] = $this->tiposQuartos->find($request->tipoQuarto);
        $quarto = $this->quartos->create($data);
        if ($request->has('fotos')) {
            $quarto->setFotos($request->fotos);
        }
        $this->quartos->save($quarto);
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
        $quarto = $this->quartos->find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        return view('quartos.detalhe-quarto', [
            'quarto' => $quarto
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
        $quarto = $this->quartos->find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        $tipoQuarto = $quarto->getTipoQuarto();
        return view('quartos.editar-quarto', [
            'quarto' => $quarto,
            'tiposQuartos' => $this->getTiposQuartos($tipoQuarto->getId())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuartosRequest $request, $id)
    {
        $data = $request->only(['tipoQuarto', 'fotos']);
        $data['tipoQuarto'] = $this->tiposQuartos->find($request->tipoQuarto);
        $quarto = $this->quartos->update($id, $data);
        if ($request->has('fotos')) {
            $quarto->setFotos($request->fotos);
        }
        if ($request->has('keepfoto')) {
            foreach ($quarto->deleteFotos($request->keepfoto) as $foto) {
                $this->em->remove($foto);
            }
        }
        $this->quartos->save($quarto);
        $this->em->flush();
        return redirect()->back()->with(['msg' => 'Quarto atualizado com sucesso!']);
    }

    /**
     * @return Response
     */
    public function createPromocao($id)
    {
        $quarto = $this->quartos->find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        return view('quartos.promocao.criar-promocao', [
            'quarto' => $quarto
        ]);
    }

    public function storePromocao(QuartosRequest $request, $id)
    {
        $quarto = $this->quartos->find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        $quarto->createPromocao($request->preco);
        $this->quartos->save($quarto);
        return redirect()->route('quartos.index')->with([
            'msg' => 'Promoção iniciada com sucesso.'
        ]);
    }

    public function editPromocao($id)
    {
        $quarto = $this->quartos->findOneBy($id);
        if (is_null($quarto)) {
            abort(404);
        }
        $promocao = $quarto->getPromocao();
        if (is_null($promocao)) {
            abort(404);
        }
        return view('quartos.promocao.editar-promocao', [
            'quarto' => $quarto,
            'promocao' => $promocao
        ]);
    }

    public function updatePromocao(QuartosRequest $request, $id)
    {
        $quarto = $this->quartos->find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        $promocao = $quarto->getPromocao();
        if (is_null($promocao)) {
            abort(404);
        }
        $promocao->setPreco($request->preco);
        $this->promocoes->save($promocao);
        return redirect()->route('quartos.index')->with([
            'msg' => 'Promoção alterada com sucesso.'
        ]);
    }

    public function deletePromocao(QuartosRequest $request, $id)
    {
        $quarto = $this->quartos->find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        $promocao = $quarto->getPromocao();
        if (is_null($promocao)) {
            abort(404);
        }
        $promocao->setDataFim(new \DateTime());
        $this->promocoes->save($promocao);
        return redirect()->route('quartos.index')->with([
            'msg' => 'Promoção finalizada com sucesso.'
        ]);
    }

    public function createManutencao($id)
    {
        $quarto = $this->quartos->find($id);
        return view('quartos.manutencao.criar-manutencao', [
            'quarto' =>$quarto
        ]);
    }

    public function storeManutencao(QuartosRequest $request, $id)
    {
        $quarto = $this->quartos->find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        if ($quarto->getEmManutencao()) {
            abort(403);
        }
        $quarto->startManutencao($request->motivo);
        $this->quartos->save($quarto);
        return redirect()->route('quartos.index')->with([
            'msg' => 'Manutenção inicida com sucesso.'
        ]);
    }

    public function deleteManutencao(QuartosRequest $request, $id)
    {
        $quarto = $this->quartos->find($id);
        if (is_null($quarto)) {
            abort(404);
        }
        if ($quarto->getEmManutencao()) {
            abort(403);
        }
        $quarto->stopManutencao();
        $this->quartos->save($quarto);
        return redirect()->route('quartos.index')->with([
            'msg' => 'Manutenção finalizada com sucesso.'
        ]);
    }

    /**
     * Retorna array com tipos de quartos.
     */
    private function getTiposQuartos($selected)
    {
        $tiposQuartos = $this->tiposQuartos->findAll();
        return FormSelectCreator::fromEntity('Id', 'Nome', $tiposQuartos, 'tipoQuarto', $selected, ['id' => 'tipoQuarto']);
    }
}
