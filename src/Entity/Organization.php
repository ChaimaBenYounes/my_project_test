<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganizationRepository")
 */
class Organization
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $users;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUsers(): ?string
    {
        return $this->users;
    }

    public function setUsers(string $users): self
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Object to Array
     * @return array
     */
    public function normalize()
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'users' => explode(",", $this->getUsers())
        ];
    }

    /**
     * Array to Object
     * @param $organisationArray
     * @return $this|null
     */
    public function denormalize($organisationArray){

        if(!$organisationArray){
            return null;
        }
        $this->setName($organisationArray['name']);
        $this->setDescription($organisationArray['description']);
        $this->setUsers('implode(",",$organisationArray[users])');

        return $this;
    }

}
