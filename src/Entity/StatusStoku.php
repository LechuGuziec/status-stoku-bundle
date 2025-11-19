<?php

namespace LechuGuziec\StatusStokuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use LechuGuziec\StatusStokuBundle\Enum\WarunkiStatus;
use LechuGuziec\StatusStokuBundle\Enum\WyciagiStatus;
use LechuGuziec\StatusStokuBundle\Repository\StatusStokuRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StatusStokuRepository::class)]
class StatusStoku
{
    use TimestampableEntity;

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: WyciagiStatus::class)]
    #[Assert\NotNull(message: 'Podaj status wyciągów.')]
    private WyciagiStatus $wyciagi = WyciagiStatus::NIECZYNNE;

    #[ORM\Column(enumType: WarunkiStatus::class)]
    #[Assert\NotNull(message: 'Podaj warunki na stoku.')]
    private WarunkiStatus $warunki = WarunkiStatus::BRAK;

    #[ORM\Column(type: 'smallint', options: ['unsigned' => true])]
    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Range(notInRangeMessage: 'Pokrywa musi być w zakresie 0–600 cm.', min: 0, max: 600)]
    private int $pokrywa = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWyciagi(): WyciagiStatus
    {
        return $this->wyciagi;
    }

    public function setWyciagi(WyciagiStatus $wyciagi): self
    {
        $this->wyciagi = $wyciagi;

        return $this;
    }

    public function getWarunki(): WarunkiStatus
    {
        return $this->warunki;
    }

    public function setWarunki(WarunkiStatus $warunki): self
    {
        $this->warunki = $warunki;

        return $this;
    }

    public function getPokrywa(): int
    {
        return $this->pokrywa;
    }

    public function setPokrywa(int $pokrywa): self
    {
        $this->pokrywa = $pokrywa;

        return $this;
    }
}
