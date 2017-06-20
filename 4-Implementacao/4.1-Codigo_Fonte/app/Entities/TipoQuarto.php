<?php

namespace App\Entities;

use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SaveableEntity;
use App\Entities\Interfaces\SearchableEntity;
use App\Repositories\TiposQuartosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Entities\Enumeration\TipoUsuario;

/**
 * Class TipoQuarto
 * @ORM\Entity
 * @ORM\Table(name="tipo_quarto",
 *      indexes={
 *      @ORM\Index(name="nome_idx", columns={"nome"})
 * })
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @package App\Entities
 */
class TipoQuarto implements EntityValidation, SearchableEntity, SaveableEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="integer")
     */
    protected $capacidade;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $precoPromocional;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="PrecoDiaria", mappedBy="tipoQuarto", cascade={"all"})
     */
    protected $tarifas;

    /**
     * @ORM\OneToMany(targetEntity="Quarto", mappedBy="tipoQuarto")
     */
    protected $quartos;

    public function __construct()
    {
        $this->tarifas = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getCapacidade()
    {
        return $this->capacidade;
    }

    /**
     * @param mixed $capacidade
     */
    public function setCapacidade($capacidade)
    {
        $this->capacidade = $capacidade;
    }

    /**
     * @return mixed
     */
    public function getPrecoPromocional()
    {
        return $this->precoPromocional;
    }

    /**
     * @param mixed $precoPromocional
     */
    public function setPrecoPromocional($precoPromocional)
    {
        $this->precoPromocional = $precoPromocional;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @param $tarifas
     * @return void
     */
    public function updateTarifas($tarifas)
    {
        for ($mes = 1; $mes <= 12; $mes++) {
            $this->setTarifa($mes, $tarifas[$mes]);
        }
        foreach ($this->tarifas as $tarifa) {
            $tarifa->setTipoQuarto(null);
        }
        foreach ($this->tarifas as $tarifa) {
            $tarifa->setTipoQuarto($this);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getTarifas()
    {
        return $this->tarifas;
    }

    /**
     * @param int $mes
     * @return mixed
     */
    public function getTarifa($mes)
    {
        $tarifasAchadas = $this->tarifas->filter(function($tarifa) use($mes) {
            return $tarifa->getMes() === $mes;
        });
        if (count($tarifasAchadas) > 0) {
            return $tarifasAchadas->first();
        }
        return $this->setTarifa($mes, 0);
    }

    /**
     * @param int $mes
     * @param float $preco
     * @return mixed
     */
    public function setTarifa($mes, $preco)
    {
        if (empty($preco)) {
            $preco = 0;
        }
        $tarifasAchadas = $this->tarifas->filter(function($tarifa) use($mes) {
            return $tarifa->getMes() === $mes;
        });
        if (count($tarifasAchadas) > 0) {
            $tarifa = $tarifasAchadas->first();
            $key = $this->tarifas->indexOf($tarifa);
            $tarifa->setPreco($preco);
            $this->tarifas->set($key, $tarifa);
            return $tarifa;
        }
        $tarifa = new PrecoDiaria();
        $tarifa->setMes($mes);
        $tarifa->setPreco($preco);
        $tarifa->setTipoQuarto($this);
        $this->tarifas->add($tarifa);
        return $tarifa;
    }

    /**
     * @return mixed
     */
    public function getQuartos()
    {
        return $this->quartos;
    }

    /**
     * @param mixed $quartos
     */
    public function setQuartos($quartos)
    {
        $this->quartos = $quartos;
    }

    public function whitelist()
    {
        return [
            'id',
            'nome',
            'capacidade'
        ];
    }

    public static function validationRules(Request $request)
    {
        switch (true) {
            case str_contains($request->path(), 'tarifas') : {
                return [
                    'precos.*' => 'numeric|min:0'
                ];
            }
            case str_contains($request->path(), 'promocao') : {
                $thisRepo = resolve(TiposQuartosRepository::class);
                $method = strtolower($request->method());
                if ($method === 'post' || $method === 'put') {
                    $tipoQuarto = $thisRepo->find($request->route('id'))->getTarifa(Carbon::now()->month);
                    return [
                        'preco' => 'required|numeric|min:0|max:' . ($tipoQuarto->getPreco() - 0.01)
                    ];
                }
                break;
            }
        }
        return [];
    }

    public static function authorizationVerification(Request $request)
    {
        return $request->user()->getTipo() === TipoUsuario::$ADMINISTRADOR;
    }

    public static function validationMessages(Request $request)
    {
        switch (true) {
            case str_contains($request->path(), 'tarifas') : {
                return [
                    'precos.*.numeric' => 'O preço deve ter valor númerico',
                    'precos.*.min' => 'O preço deve ser um valor positivo',
                ];
            }
            case str_contains($request->path(), 'promocao') : {
                $method = strtolower($request->method());
                if ($method === 'post' || $method === 'put') {
                    return [
                        'preco.required' => 'O preco é obrigatório',
                        'preco.numeric' => 'O preço deve ter valor númerico',
                        'preco.min' => 'O preço deve ser um valor positivo',
                        'preco.max' => 'O preço deve ser inferior ao preco da diária do mês atual',
                    ];
                }
                break;
            }
        }
        return [];
    }

    public static function searchableFields()
    {
        return [
            'nome'
        ];
    }


}