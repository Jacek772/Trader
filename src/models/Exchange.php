<?php

class Exchange
{
    private $idexchange;
    private $dateofpublication;
    private $announcementdate;
    private $tablenumber;
    private $factor;
    private $rate;
    private $idcurrency;

    public function __construct(int $idexchange, string $dateofpublication, string $announcementdate, string $tablenumber, float $factor, float $rate, int $idcurrency)
    {
        $this->idexchange = $idexchange;
        $this->dateofpublication = $dateofpublication;
        $this->announcementdate = $announcementdate;
        $this->tablenumber = $tablenumber;
        $this->factor = $factor;
        $this->rate = $rate;
        $this->idcurrency = $idcurrency;
    }

    public function getIdexchange(): int
    {
        return $this->idexchange;
    }

    public function setIdexchange(int $idexchange): void
    {
        $this->idexchange = $idexchange;
    }

    public function getDateofpublication(): string
    {
        return $this->dateofpublication;
    }

    public function setDateofpublication(string $dateofpublication): void
    {
        $this->dateofpublication = $dateofpublication;
    }

    public function getAnnouncementdate(): string
    {
        return $this->announcementdate;
    }

    public function setAnnouncementdate(string $announcementdate): void
    {
        $this->announcementdate = $announcementdate;
    }

    public function getTablenumber(): string
    {
        return $this->tablenumber;
    }

    public function setTablenumber(string $tablenumber): void
    {
        $this->tablenumber = $tablenumber;
    }

    public function getFactor(): float
    {
        return $this->factor;
    }

    public function setFactor(float $factor): void
    {
        $this->factor = $factor;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    public function getIdcurrency(): int
    {
        return $this->idcurrency;
    }

    public function setIdcurrency(int $idcurrency): void
    {
        $this->idcurrency = $idcurrency;
    }
}

