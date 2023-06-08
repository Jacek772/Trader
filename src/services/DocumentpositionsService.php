<?php

// Repositories
require_once __DIR__."/../repository/DocumentpositionsRepository.php";

// Models
require_once __DIR__."/../models/Documentposition.php";

class DocumentpositionsService
{
    private $documentpositionsRepository;

    public function __construct()
    {
        $this->documentpositionsRepository = new DocumentpositionsRepository();
    }

    public function createDocumentpositionIfNotExists(Documentposition $documentposition): void
    {
        if(!$this->existsDocumentposition($documentposition->getIddocument(), $documentposition->getIdcommodity()))
        {
            $this->createDocumentposition($documentposition);
        }
    }

    public function createDocumentposition(Documentposition $documentposition): void
    {
        $this->documentpositionsRepository->createDocumentposition($documentposition);
    }

    public function existsDocumentposition(int $iddocument, int $idcommodity): bool
    {
        $documentposition = $this->getDocumentposition($iddocument, $idcommodity);
        return $documentposition != null;
    }

    public function getDocumentposition(int $iddocument, int $idcommodity): ?Documentposition
    {
        return $this->documentpositionsRepository->getDocumentposition($iddocument, $idcommodity);
    }
}