<?php
namespace App\Entities;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Promocao
 * @package App\Entities
 * @ORM\Entity
 * @ORM\Table(name="promocoes")
 */
class Promocao
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="data_inicio", type="datetime")
     */
    protected $dataInicio;

    /**
     * @ORM\Column(name="data_fim", type="datetime", nullable=true)
     */
    protected $dataFim;

    /**
     * @ORM\Column(type="float")
     */
    protected $preco;

    /**
     * @ORM\ManyToOne(targetEntity="Quarto", inversedBy="promocoes")
     * @ORM\JoinColumn(name="id_quarto", referencedColumnName="id")
     */
    protected $quarto;

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
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * @param mixed $dataInicio
     */
    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = $dataInicio;
    }

    /**
     * @return mixed
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * @param mixed $dataFim
     */
    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;
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
    public function getQuarto()
    {
        return $this->quarto;
    }

    /**
     * @param mixed $quarto
     */
    public function setQuarto($quarto)
    {
        $this->quarto = $quarto;
    }
}