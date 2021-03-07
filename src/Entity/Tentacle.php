<?php

namespace App\Entity;

use App\Repository\TentacleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TentacleRepository::class)
 */
class Tentacle
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
     * @ORM\Column(type="integer")
     */
    private $pv;

    /**
     * @ORM\Column(type="integer")
     */
    private $strength;

    /**
     * @ORM\Column(type="integer")
     */
    private $dex;

    /**
     * @ORM\Column(type="integer")
     */
    private $con;

    /**
     * @ORM\ManyToOne(targetEntity=Kraken::class, inversedBy="tentacles")
     */
    private $kraken;

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

    public function getPv(): ?int
    {
        return $this->pv;
    }

    public function setPv(int $pv): self
    {
        $this->pv = $pv;

        return $this;
    }

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getDex(): ?int
    {
        return $this->dex;
    }

    public function setDex(int $dex): self
    {
        $this->dex = $dex;

        return $this;
    }

    public function getCon(): ?int
    {
        return $this->con;
    }

    public function setCon(int $con): self
    {
        $this->con = $con;

        return $this;
    }

    public function getKraken(): ?Kraken
    {
        return $this->kraken;
    }

    public function setKraken(?Kraken $kraken): self
    {
        $this->kraken = $kraken;

        return $this;
    }
}
