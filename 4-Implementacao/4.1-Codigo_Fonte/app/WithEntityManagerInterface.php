<?php
namespace App;
use Doctrine\ORM\EntityManagerInterface;

trait WithEntityManagerInterface {

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}