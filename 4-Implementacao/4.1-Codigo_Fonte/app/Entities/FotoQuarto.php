<?php
namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class FotoQuarto
 * @package App\Entities
 * @ORM\Entity
 * @ORM\Table(name="fotos_quartos")
 */
class FotoQuarto
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
    protected $url;

    /**
     * @ORM\ManyToOne(targetEntity="Quarto", inversedBy="fotos")
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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
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