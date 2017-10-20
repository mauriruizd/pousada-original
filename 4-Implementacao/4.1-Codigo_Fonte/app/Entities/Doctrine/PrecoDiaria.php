<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class PrecoDiaria
 * @ORM\Entity
 * @ORM\Table(name="preco_diaria")
 * @Gedmo\Softdeleteable(fieldName="deletedAt", timeAware=false)
 * @package App\Entities
 */
class PrecoDiaria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $mes;


    /**
     * @ORM\Column(type="float")
     */
    protected $preco = 0;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="TipoQuarto", inversedBy="tarifas", cascade={"all"})
     * @ORM\JoinColumn(name="id_tipo", referencedColumnName="id")
     */
    protected $tipoQuarto;

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
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * @param mixed $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    /**
     * @return mixed
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * @param mixed $preco
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;
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
}