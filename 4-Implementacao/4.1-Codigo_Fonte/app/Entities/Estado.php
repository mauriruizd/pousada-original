<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Estado
 * @ORM\Entity
 * @ORM\Table(name="estados")
 * @package App\Entities
 */
class Estado
{
    /**
     * @ORM\GeneratedValue
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\ManyToOne(targetEntity="Pais", inversedBy="estados")
     * @ORM\JoinColumn(name="id_pais", referencedColumnName="id")
     */
    protected $pais;

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
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }
}