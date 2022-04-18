<?php

namespace App\Entity;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Comnon\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Assert\Length(
        min: 1,
        max: 2,
        minMessage: 'minMessage',
        maxMessage: 'maxMessage'
    )]
    #[Assert\Range(
        min: 0,
        max: 20,
        notInRangeMessage: 'notInRangeMessage'
    )]
    #[Assert\NotBlank]
    private $note;
    
    #[Assert\NotBlank]
    #[ORM\ManyToOne(targetEntity: Matiere::class, inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    private $matiere;
    
    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
