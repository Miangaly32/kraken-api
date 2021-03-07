<?php

namespace App\Entity;

use App\Repository\KrakenPowerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KrakenPowerRepository::class)
 */
class KrakenPower
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxUsage;

    /**
     * @ORM\ManyToOne(targetEntity=Power::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $power;

    /**
     * @ORM\ManyToOne(targetEntity=Kraken::class, inversedBy="krakenPowers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Kraken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaxUsage(): ?int
    {
        return $this->maxUsage;
    }

    public function setMaxUsage(int $maxUsage): self
    {
        $this->maxUsage = $maxUsage;

        return $this;
    }

    public function getPower(): ?Power
    {
        return $this->power;
    }

    public function setPower(?Power $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getKraken(): ?Kraken
    {
        return $this->Kraken;
    }

    public function setKraken(?Kraken $Kraken): self
    {
        $this->Kraken = $Kraken;

        return $this;
    }
}
