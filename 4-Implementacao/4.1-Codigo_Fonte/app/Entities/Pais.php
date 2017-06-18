<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Pais
 * @ORM\Entity
 * @ORM\Table(name="paises")
 * @package App\Entities
 */
class Pais
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="nome")
     * @var string
     */
    protected $nome;

    /**
     * @ORM\OneToMany(targetEntity="Estado", mappedBy="pais")
     */
    protected $estados;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
}