<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message=" le mail est deja utilisé"
 * )
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     *
     */
    private $email;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="Votre mot de passe doit contenir aumoins 8 caractéres")
     * @Assert\EqualTo(propertyPath="confirm_password",message="Votre mot de passe doit etre le meme ")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password",message="Votre mot de passe doit etre le meme ")
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize([
         $this->id,
         $this->username,
          $this->password
    ]);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password
            )=unserialize($serialized,['allowed_classes'=>false]);
    }
}
