<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\KundenAdresseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KundenAdresseRepository::class)]
#[ORM\Table(name: 'std.kunde_adresse')]
class KundenAdresse
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: Adresse::class)]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id')]
    private ?Adresse $adresse = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Kunde::class, inversedBy: 'kundenAdressen')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Kunde $kunde = null;
    #[ORM\Id]
    #[ORM\Column]
    private ?bool $geschaeftlich = null;

    #[ORM\Id]
    #[ORM\Column]
    private ?bool $rechnungsadresse = null;

    #[ORM\Column]
    private ?bool $geloescht = null;

    public function getAdresse(): mixed
    {
        return $this->adresse;
    }

    public function setAdresse(mixed $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function isGeschaeftlich(): ?bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(bool $geschaeftlich): self
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function isRechnungsadresse(): ?bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(bool $rechnungsadresse): self
    {
        $this->rechnungsadresse = $rechnungsadresse;

        return $this;
    }

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getKunde(): ?Kunde
    {
        return $this->kunde;
    }

    public function setKunde(?Kunde $kunde): self
    {
        $this->kunde = $kunde;

        return $this;
    }

    #[Group]
    public function getFormattedAdress()
    {

    }
}
