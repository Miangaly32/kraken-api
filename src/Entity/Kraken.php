<?php

namespace App\Entity;

use App\Repository\KrakenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=KrakenRepository::class)
 */
class Kraken
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100) 
     * @Assert\NotBlank(
     * message = "The name can't be left blank")
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     * ) 
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity=Tentacle::class, mappedBy="kraken")
     */
    private $tentacles;

    public function __construct()
    {
        $this->tentacles = new ArrayCollection();
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Collection|Tentacle[]
     */
    public function getTentacles(): Collection
    {
        return $this->tentacles;
    }

    public function addTentacle(Tentacle $tentacle): self
    {
        if (!$this->tentacles->contains($tentacle)) {
            $this->tentacles[] = $tentacle;
            $tentacle->setRelation($this);
        }

        return $this;
    }

    public function removeTentacle(Tentacle $tentacle): self
    {
        if ($this->tentacles->removeElement($tentacle)) {
            // set the owning side to null (unless already changed)
            if ($tentacle->getRelation() === $this) {
                $tentacle->setRelation(null);
            }
        }

        return $this;
    }
}
