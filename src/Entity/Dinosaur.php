<?php

namespace App\Entity;

use App\Enum\HealthStatus;

class Dinosaur
{
    public function __construct(
        private string $name,
        private string $genus = 'Unknown',
        private int $length = 0,
        private string $enclosure = 'Unknown',
        private HealthStatus $health = HealthStatus::HEALTHY,
    ) {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGenus(): string
    {
        return $this->genus;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getEnclosure(): string
    {
        return $this->enclosure;
    }

    public function getSizeDescription(): string
    {
        if ($this->length >= 10) {
            return 'Large';
        }
        if($this->length >= 5) {
            return 'Medium';
        }

        return 'Small';
    }

    public function isAcceptingVisitors(): bool
    {
        return $this->health !== HealthStatus::SICK;
    }

    public function getHealth(): HealthStatus
    {
        return $this->health;
    }

    public function setHealth(HealthStatus $health): self
    {
        $this->health = $health;

        return $this;
    }
}
