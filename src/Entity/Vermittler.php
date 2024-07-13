<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VermittlerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VermittlerRepository::class)]
#[ApiResource]
#[ORM\Table(name: 'std.vermittler')]
class Vermittler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private ?string $nummer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nachname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column]
    private ?bool $geloescht = null;

    #[ORM\OneToMany(mappedBy: 'vermittler', targetEntity: Kunde::class, orphanRemoval: true)]
    private Collection $kunden;

    #[ORM\OneToOne(mappedBy: 'vermittler', cascade: ['persist', 'remove'])]
    private ?VermittlerUser $vermittlerUser = null;

    public function __construct()
    {
        $this->kunden = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): ?string
    {
        return $this->nummer;
    }

    public function setNummer(string $nummer): self
    {
        $this->nummer = $nummer;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(?string $nachname): self
    {
        $this->nachname = $nachname;

        return $this;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function isGel�oescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    /**
     * @return Collection<int, Kunde>
     */
    public function getKunden(): Collection
    {
        return $this->kunden;
    }

    public function addKunden(Kunde $kunden): self
    {
        if (!$this->kunden->contains($kunden)) {
            $this->kunden->add($kunden);
            $kunden->setVermittler($this);
        }

        return $this;
    }

    public function removeKunden(Kunde $kunden): self
    {
        if ($this->kunden->removeElement($kunden)) {
            // set the owning side to null (unless already changed)
            if ($kunden->getVermittler() === $this) {
                $kunden->setVermittler(null);
            }
        }

        return $this;
    }

    public function getVermittlerUser(): ?VermittlerUser
    {
        return $this->vermittlerUser;
    }

    public function setVermittlerUser(VermittlerUser $vermittlerUser): self
    {
        // set the owning side of the relation if necessary
        if ($vermittlerUser->getVermittler() !== $this) {
            $vermittlerUser->setVermittler($this);
        }

        $this->vermittlerUser = $vermittlerUser;

        return $this;
    }
}
