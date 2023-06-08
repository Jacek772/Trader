<?php

require_once __DIR__."/../repository/DocumentdefinitionsRepository.php";

class DocumentdefinitionsService
{
    private $documentdefinitionsRepository;

    public function __construct()
    {
        $this->documentdefinitionsRepository = new DocumentdefinitionsRepository();
    }

    public function createDocumentdefinitionIfNotExists(Documentdefinition $documentdefinition): void
    {
        if(!$this->existsDocumentdefinition($documentdefinition->getSymbol()))
        {
            $this->createDocumentdefinition($documentdefinition);
        }
    }

    public function getDocumentdefinition(string $symbol) : ?Documentdefinition
    {
        return $this->documentdefinitionsRepository->getDocumentdefinition($symbol);
    }

    public function createDocumentdefinition(Documentdefinition $documentdefinition): void
    {
        $this->documentdefinitionsRepository->createDocumentdefinition($documentdefinition);
    }

    public function existsDocumentdefinition(?string $symbol): bool
    {
        if(!$symbol)
        {
            return false;
        }

        $documentdefinition = $this->getDocumentdefinition($symbol);
        return $documentdefinition != null;
    }
}