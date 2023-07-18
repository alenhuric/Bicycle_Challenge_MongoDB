<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations\UniqueIndex;

/**
 * @MongoDB\Document(collection="bicycles")
 * @UniqueIndex(keys={"email"="asc"}, options={"unique"=true})
 */
class Bicycle
{

    /**
     * @MongoDB\Id
     */
    public $id;


    /**
     * @MongoDB\Field(type="string")
     */
    private $color;


    /**
     * @MongoDB\Field(type="string")
     */
    private $brand;


    /**
     * @MongoDB\Field(type="string")
     */
    private $status;
    /**
     * @MongoDB\Field(type="string")
     */
    private $currentSpeed;

    /**
     * @MongoDB\Field(type="string")
     */
    private $accelerateStatus;

    /**
     * @MongoDB\Field(type="string")
     */
    private $geolocation;


    // Getter and setter methods for the properties



    public function getCurrentSpeed(): int
    {
        return $this->currentSpeed;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getAccelerateStatus(): string
    {
        return $this->accelerateStatus;
    }

    public function setAccelerateStatus(string $accelerateStatus): void
    {
        $this->accelerateStatus = $accelerateStatus;
    }

    public function getGeolocation(): ?string
    {
        return $this->geolocation;
    }

    public function setGeolocation(?string $geolocation): void
    {
        $this->geolocation = $geolocation;
    }

    public function updateSpeed(): void
    {
        if ($this->status === 'Stopped') {
            $this->currentSpeed = 0;
            $this->accelerateStatus = 'Deceleration';
        } elseif ($this->accelerateStatus === 'Accelerate') {
            $this->accelerate();
            $this->accelerateStatus = 'Accelerating';
        } else {
            $this->deceleration();
            $this->accelerateStatus = 'Deceleration';
        }
    }

    private function accelerate(): void
    {
        if ($this->status !== 'Stopped') {
            $this->currentSpeed += 10;
        }
    }

    private function deceleration(): void
    {
        if ($this->status !== 'Stopped' && $this->currentSpeed > 0) {
            $this->currentSpeed -= 5;

            if ($this->currentSpeed < 0) {
                $this->currentSpeed = 0;
            }
        }
    }
}
