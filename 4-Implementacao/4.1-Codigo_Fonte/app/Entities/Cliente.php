<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cliente
 * @package App\Entities
 * @ORM\Entity
 * @ORM\Table(name="clientes")
 */
class Cliente
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
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $telefone;

    /**
     * @ORM\Column(type="string")
     */
    protected $celular;

    /**
     * @ORM\Column(type="string")
     */
    protected $profissao;

    /**
     * @ORM\Column(type="string")
     */
    protected $nacionalidade;

    /**
     * @ORM\Column(type="date")
     */
    protected $dataNascimento;

    /**
     * @ORM\Column(type="string")
     */
    protected $dni;

    /**
     * @ORM\Column(type="string")
     */
    protected $cpf;

    /**
     * @ORM\Column(type="string", length=1, options={"fixed" = true})
     */
    protected $genero;

    /**
     * @ORM\Column(type="string")
     */
    protected $endereco;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Cidade")
     * @ORM\JoinColumn(name="id_cidade", referencedColumnName="id")
     */
    protected $cidade;

    /**
     * @ORM\Column(type="string")
     */
    protected $observacoes;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     */
    protected $usuario;
}