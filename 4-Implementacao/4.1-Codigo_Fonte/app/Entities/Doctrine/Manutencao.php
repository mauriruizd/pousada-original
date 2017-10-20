<?php
namespace App\Entities\Doctrine;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Manutencao
 * @package App\Entities
 * @ORM\Entity
 * @ORM\Table(name="manutencao")
 */
class Manutencao
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $motivo;

    /**
     * @ORM\Column(name="data_hora", type="datetime")
     */
    protected $dataHora;

    /**
     * @ORM\ManyToOne(targetEntity="Quarto", inversedBy="manutencoes")
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
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * @param mixed $motivo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
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

    /**
     * @return mixed
     */
    public function getDataHora()
    {
        return $this->dataHora;
    }

    /**
     * @param mixed $dataHora
     */
    public function setDataHora($dataHora)
    {
        $this->dataHora = $dataHora;
    }
}