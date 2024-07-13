<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BundeslandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BundeslandRepository::class)]
#[ORM\Table(name: 'public.bundesland')]
class Bundesland
{

    #[ORM\Id]
    #[ORM\Column(name: 'kuerzel', type: Types::STRING, length: 2)]
    private ?string $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;


    public function __construct()
    {
        $this->adressen = new ArrayCollection();
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
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
}
