<?php

class Vatrate
{
    private $idvatrate;
    private $percent;

    public function __construct(int $idvatrate, float $percent)
    {
        $this->idvatrate = $idvatrate;
        $this->percent = $percent;
    }

    public function getIdvatrate(): int
    {
        return $this->idvatrate;
    }

    public function setIdvatrate(int $idvatrate): void
    {
        $this->idvatrate = $idvatrate;
    }

    public function getPercent(): float
    {
        return $this->percent;
    }

    public function setPercent(float $percent): void
    {
        $this->percent = $percent;
    }


}