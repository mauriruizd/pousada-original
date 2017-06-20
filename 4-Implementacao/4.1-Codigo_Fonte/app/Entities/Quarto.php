<?php
namespace App\Entities;

use App\Entities\Interfaces\EntityValidation;
use App\Entities\Interfaces\SaveableEntity;
use App\Entities\Interfaces\SearchableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Http\Request;
use App\Entities\Enumeration\TipoUsuario;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Quarto
 * @package App\Entities
 * @ORM\Entity
 * @ORM\Table(name="quartos",
 *     indexes={
 *     @ORM\Index(name="numero_idx", columns={"numero"}),
 *     @ORM\Index(name="tipo_quarto_idx", columns={"id_tipo_quarto"}),
 * })
 * @Gedmo\Softdeleteable(fieldName="deletedAt", timeAware=false)
 */
class Quarto implements EntityValidation, SearchableEntity, SaveableEntity
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
    protected $numero;

    /**
     * @ORM\Column(type="integer")
     */
    protected $andar;

    /**
     * @ORM\Column(name="em_manutencao", type="boolean")
     */
    protected $emManutencao = false;

    /**
     * @ORM\ManyToOne(targetEntity="TipoQuarto", inversedBy="quartos")
     * @ORM\JoinColumn(name="id_tipo_quarto", referencedColumnName="id")
     */
    protected $tipoQuarto;

    /**
     * @ORM\OneToMany(targetEntity="Manutencao", mappedBy="quarto", cascade={"all"})
     */
    protected $manutencoes;

    /**
     * @ORM\OneToMany(targetEntity="FotoQuarto", mappedBy="quarto", cascade={"all"})
     */
    protected $fotos;

    /**
     * @ORM\OneToMany(targetEntity="Promocao", mappedBy="quarto", cascade={"all"})
     */
    protected $promocoes;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    public function __construct()
    {
        $this->manutencoes = new ArrayCollection();
        $this->fotos = new ArrayCollection();
        $this->promocoes = new ArrayCollection();
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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getAndar()
    {
        return $this->andar;
    }

    /**
     * @param mixed $andar
     */
    public function setAndar($andar)
    {
        $this->andar = $andar;
    }

    /**
     * @return mixed
     */
    public function getEmManutencao()
    {
        return $this->emManutencao;
    }

    /**
     * @param mixed $emManutencao
     */
    public function setEmManutencao($emManutencao)
    {
        $this->emManutencao = $emManutencao;
    }

    public function startManutencao($motivo)
    {
        $this->setEmManutencao(true);
        $manutencao = new Manutencao();
        $manutencao->setMotivo($motivo);
        $manutencao->setQuarto($this);
        $manutencao->setDataHora(new \DateTime());
        $this->manutencoes->add($manutencao);
    }

    public function endManutencao()
    {
        $this->setEmManutencao(false);
    }

    /**
     * @return mixed
     */
    public function getTipoQuarto()
    {
        return $this->tipoQuarto;
    }

    /**
     * @param mixed $tipoQuarto
     */
    public function setTipoQuarto($tipoQuarto)
    {
        $this->tipoQuarto = $tipoQuarto;
    }

    /**
     * @return mixed
     */
    public function getManutencoes()
    {
        return $this->manutencoes;
    }

    /**
     * @param mixed $manutencao
     */
    public function setManutencoes($manutencao)
    {
        $this->manutencoes = $manutencao;
    }

    /**
     * @return mixed
     */
    public function getFotos()
    {
        return $this->fotos;
    }

    /**
     * @param mixed $fotos
     */
    public function setFotos($fotos)
    {
        foreach ($fotos as $file) {
            $url = public_path(str_slug($file->getClientOriginalName()) . ' .jpg');
            $file->move($url);
            $foto = new FotoQuarto();
            $foto->setQuarto($this);
            $foto->setUrl($url);
            $this->fotos->add($foto);
        }
    }

    /**
     * @param $ids
     * @return ArrayCollection
     */
    public function deleteFotos($ids)
    {
        return $this->fotos->filter(function($item) use($ids) {
            return in_array($item->getId(), $ids);
        });
    }

    /**
     * @return mixed
     */
    public function getPromocoes()
    {
        return $this->promocoes;
    }

    /**
     * @param mixed $promocoes
     */
    public function setPromocoes($promocoes)
    {
        $this->promocoes = $promocoes;
    }

    public function createPromocao($preco)
    {
        $promocao = new Promocao();
        $promocao->setPreco($preco);
        $promocao->setDataInicio(new \DateTime());
        $promocao->setQuarto($this);
        $this->promocoes->add($promocao);
    }

    public function getPromocao()
    {
        return $this->promocoes->filter(function($item) {
            return is_null($item->getDataFim());
        })->first();
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

    public function whitelist()
    {
        return [
            'id',
            'numero',
            'em_manutencao',
            'andar',
            'tipoQuarto'
        ];
    }

    public static function validationRules(Request $request)
    {
        $url = $request->path();
        switch (true) {
            case str_contains($url, 'promocao') : {
                if (strtolower($request->method()) !== 'delete') {
                    return [
                        'preco' => 'required|numeric'
                    ];
                }
                return [];
            }
            case str_contains($url, 'manutencao') : {
                if (strtolower($request->method()) === 'delete') {
                    return [];
                }
                return [
                    'motivo' => 'required'
                ];
            }
            default : {
                if (strtolower($request->method()) === 'put') {
                    return [];
                }
                return [
                    'numero' => 'required',
                    'andar' => 'required|numeric|max:3'
                ];
            }
        }
    }

    public static function authorizationVerification(Request $request)
    {
        if ($request->user()->getTipo() === TipoUsuario::$RECEPCIONISTA) {
            return strtolower($request->method() === 'get');
        }
        return true;
    }

    public static function searchableFields()
    {
        return [
            'numero',
        ];
    }

}