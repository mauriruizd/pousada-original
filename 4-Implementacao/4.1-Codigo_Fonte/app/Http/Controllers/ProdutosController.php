<?php

namespace App\Http\Controllers;

use App\Entities\CategoriaProduto;
use App\Entities\Fornecedor;
use App\Entities\PrecoProduto;
use App\Entities\Produto;
use App\Http\Requests\ProdutosRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $produtos = Produto::search($search)->paginate(10);
        return view('produtos.listar-produtos', [
            'produtos' => $produtos,
            'search' => $search
        ]);
    }

    public function listagem()
    {
        $produtos = Produto::orderBy('id_categoria')->get();
        return view('produtos.listagem-produtos', [
            'produtos' => $produtos
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
        $produtos = Produto::search($search)
            ->onlyTrashed()
            ->paginate(10);
        return view('produtos.listar-produtos-arquivados', [
            'produtos' => $produtos,
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
        return view('produtos.criar-produto', [
            'categorias' => CategoriaProduto::pluck('nome', 'id'),
            'fornecedores' => Fornecedor::pluck('nome', 'id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutosRequest $request)
    {
        DB::transaction(function () use($request) {
            $produto = Produto::create(array_merge([
                'estoque' => $request->estoque_inicial
            ], $request->all()));
            PrecoProduto::create([
                'id_produto' => $produto->id,
                'preco' => $request->preco,
                'datahora_cadastro' => Carbon::now()
            ]);
        });
        return redirect()->route('produtos.index')->with(['msg' => 'Produto criado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, ProdutosRequest $request)
    {
        try {
            $produto = Produto::find($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
            return null;
        }
        return view('produtos.detalhe-produto', [
            'produto' => $produto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, ProdutosRequest $request)
    {
        $produto = Produto::find($id);
        if (is_null($produto)) {
            abort(404);
        }
        return view('produtos.editar-produto', [
            'produto' => $produto,
            'categorias' => CategoriaProduto::pluck('nome', 'id'),
            'fornecedores' => Fornecedor::pluck('nome', 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutosRequest $request, $id)
    {
        DB::transaction(function() use($request, $id) {
            $produto = Produto::find($id);
            if ($request->preco !== PrecoProduto::orderBy('datahora_cadastro', 'desc')->first()->preco) {
                PrecoProduto::create([
                    'id_produto' => $id,
                    'preco' => $request->preco,
                    'datahora_cadastro' => Carbon::now()
                ]);
            }
            $produto->fill($request->all())->save();
        });
        return redirect()->back()->with(['msg' => 'Produto atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ProdutosRequest $request)
    {
        $produto = Produto::find($id);
        if (is_null($produto)) {
            abort(404);
        }
        $produto->delete();
        return redirect()->route('produtos.index')->with(['msg' => 'Produto arquivado com sucesso!']);
    }

    public function recuperar($id, ProdutosRequest $request)
    {
        try {
            $produto = Produto::onlyTrashed()
                ->where('id', $id)
                ->firstOrFail();
            $produto->restore();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
        return redirect()->back()->with(['msg' => 'Produto recuperado com sucesso!']);
    }

    public function relatoriosEstoque(ProdutosRequest $request)
    {
        $produtos = Produto::paginate(10);
        return view('produtos.relatorio-estoque-produtos', [
            'produtos' => $produtos
        ]);
    }

    public function relatoriosEntrada(ProdutosRequest $request)
    {
        // TODO: continuar apos finalização da parte de compras
    }

    public function relatoriosSaida(ProdutosRequest $request)
    {
        // TODO: continuar apos finalização da parte de vendas
    }

    public function consultarEstoque(Request $request)
    {
        return Produto::find($request->id)->estoque;
    }
}
