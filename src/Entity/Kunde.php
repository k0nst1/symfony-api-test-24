<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\KundenController;
use App\Repository\KundenRepository;
use App\State\KundenProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KundenRepository::class)]
#[ORM\Table(name: 'std.tbl_kunden')]
#[Put(uriTemplate: '/kunden/{id}')]
#[Delete(uriTemplate: '/kunden/{id}')]
#[Get(uriTemplate: '/kunden/{id}')]
#[Post(uriTemplate: '/kunden')]
#[GetCollection(uriTemplate: '/kunden')]
class Kunde
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'string', length: 36)]
    private ?string $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    private ?string $vorname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $geburtsdatum = null;

    #[ORM\Column(nullable: true)]
    private ?bool $geloescht = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'geschlecht', nullable: true, columnDefinition: "ENUM('männlich', 'weiblich', 'divers')")]
    private ?string $geschlecht = null;


    #[ORM\ManyToOne(targetEntity: Vermittler::class, inversedBy: 'kunden')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Vermittler $vermittler = null;


    #[ORM\OneToOne(mappedBy: 'kunde', targetEntity: User::class)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'kunde', targetEntity: KundenAdresse::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Collection $adressen;

    public function __construct()
    {
        $this->adressen = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function getGeburtsdatum(): ?\DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?\DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(?bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVermittler(): ?vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(?vermittler $vermittler): self
    {
        $this->vermittler = $vermittler;

        return $this;
    }


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setKunde(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getKunde() !== $this) {
            $user->setKunde($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, KundenAdresse>
     */
    public function getAdressen(): Collection
    {
        return $this->adressen;
    }

    public function addKundenAdressen(KundenAdresse $kundenAdressen): self
    {
        if (!$this->adressen->contains($kundenAdressen)) {
            $this->adressen->add($kundenAdressen);
            $kundenAdressen->setKunde($this);
        }

        return $this;
    }

    public function removeKundenAdressen(KundenAdresse $kundenAdressen): self
    {
        if ($this->adressen->removeElement($kundenAdressen)) {
            // set the owning side to null (unless already changed)
            if ($kundenAdressen->getKunde() === $this) {
                $kundenAdressen->setKunde(null);
            }
        }

        return $this;
    }

    #[Groups('ViewAlleMeineKunden')]
    public function getFormattedAdresses()
    {

        $adressen = [];
        /** @var KundenAdresse $kundenAdresse */
        foreach($this->getAdressen() as $kundenAdresse)
        {
            $adresse['adresseId'] = $kundenAdresse->getAdresse();
            $adresse['strasse'] = $kundenAdresse->getAdresse()->getStrasse();

            $adressen[] = $adresse;
        }
        return $adressen;
    }
}
