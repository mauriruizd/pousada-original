<?php
namespace App\Entities\Doctrine;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Acesso
 * @package App\Entities
 * @ORM\Entity
 * @ORM\Table(name="acessos")
 */
class Acesso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @var Carbon
     */
    protected $timestamp;

    /**
     * @ORM\Column(type="string")
     */
    protected $ip;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="acessos")
     * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     */
    protected $usuario;

    public function __construct()
    {
        $this->setTimestamp(Carbon::now());
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
     * @return Carbon
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param Carbon $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

}