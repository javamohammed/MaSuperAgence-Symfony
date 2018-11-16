<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface,SerializerInterface
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
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
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

     
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }
    
    public function getSalt(){
        return null;
    }
   
    public function eraseCredentials()
    {
        
    }

    /**
     * Serializes data in the appropriate format.
     *
     * @param mixed  $data    Any data
     * @param string $format  Format name
     * @param array  $context Options normalizers/encoders have access to
     *
     * @return string
     */
    public function serialize($data = null, $format = null, array $context = array())
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password
         ]);

    }
    /**
     * Deserializes data into the given type.
     *
     * @param mixed  $data
     * @param string $type
     * @param string $format
     * @param array  $context
     *
     * @return object
     */
    public function deserialize($data, $type, $format, array $context = array())
    {
        list(
            $this->id,
            $this->username,
            $this->password
        ) = unserialize($data, ['allowed_classes' => false ]);

    }
}
