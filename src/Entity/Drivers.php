<?php

namespace App\Entity;

use App\Repository\DriversRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriversRepository::class)]
class Drivers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $first_name = null;

    #[ORM\Column(length: 20)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 30)]
    private ?string $car_name = null;

    #[ORM\Column(length: 10)]
    private ?string $car_plate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCarName(): ?string
    {
        return $this->car_name;
    }

    public function setCarName(string $car_name): static
    {
        $this->car_name = $car_name;

        return $this;
    }

    public function getCarPlate(): ?string
    {
        return $this->car_plate;
    }

    public function setCarPlate(string $car_plate): static
    {
        $this->car_plate = $car_plate;

        return $this;
    }
}
