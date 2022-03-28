<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[UniqueEntity('name', message: 'La catégorie existe déjà')]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $name;

    #[ORM\ManyToMany(targetEntity: Document::class, inversedBy: 'categories')]
    private $documentList;

    public function __construct()
    {
        $this->documentList = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Document>
     */
    public function getDocumentList(): Collection
    {
        return $this->documentList;
    }

    public function addDocumentList(Document $documentList): self
    {
        if (!$this->documentList->contains($documentList)) {
            $this->documentList[] = $documentList;
        }

        return $this;
    }

    public function removeDocumentList(Document $documentList): self
    {
        $this->documentList->removeElement($documentList);

        return $this;
    }
}
