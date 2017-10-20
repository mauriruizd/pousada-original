<?php
namespace App\Entities\Doctrine;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PasswordReset
 * @package App\Entities
 * @ORM\Entity
 * @ORM\Table("password_resets", indexes={@ORM\Index(name="email_idx", columns={"email"}), @ORM\Index(name="token_idx", columns={"token"})})
 */
class PasswordReset {
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $token;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
}