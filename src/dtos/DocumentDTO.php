<?php

class DocumentDTO
{
    public $idDocument;
    public $date;
    public $number;
    public $state;
    public $description;

    public function __construct(int $idDocument, string $date, string $number, int $state, string $description)
    {
        $this->idDocument = $idDocument;
        $this->date = $date;
        $this->number = $number;
        $this->state = $state;
        $this->description = $description;
    }
}