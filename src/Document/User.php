<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations\UniqueIndex;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @MongoDB\Document(collection="users")
 * @UniqueIndex(keys={"email"="asc"}, options={"unique"=true})
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @MongoDB\Id
     */
    private $id;


     /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="Name is required.")
     * @Assert\Length(max=25, maxMessage="Name should not exceed {{ limit }} characters.")
     */
    private $name;


    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="Email is required.")
     * @Assert\Email(message="Invalid email format.")
     * @Assert\Length(max=180, maxMessage="Email should not exceed {{ limit }} characters.")
     */
    private $email;
    

    /**
     * @MongoDB\Field(type="collection")
     */
    private $roles = [];

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="Password is required.")
     * @Assert\Length(min=6, max=255, minMessage="Password should be at least {{ limit }} characters.")
     */
    private $password;

    // Getter and setter methods for the properties

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    public function getRoles(): array
    {
        // return $this->roles;
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt(): ?string
    {
        return null;
    }
    
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // Implement the logic to clear sensitive data
        $this->plainPassword = null;
    }

}
