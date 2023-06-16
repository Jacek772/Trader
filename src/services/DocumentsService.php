<?php

// Models
require_once __DIR__."/../models/User.php";

// Repositories
require_once __DIR__."/../repository/DocumentsRepository.php";

class DocumentsService
{
    private $documentsRepository;

    public function __construct()
    {
        $this->documentsRepository = new DocumentsRepository();
    }

    public function getAllDocuments() : array
    {
        return $this->documentsRepository->getAllDocuments();
    }

    public function getDocuments(string $periodFrom = null, string $periodTo = null, int $idDefinition = null, int $idContractor = null, int $idWarehouse = null)  : array
    {
        return $this->documentsRepository->getDocuments($periodFrom, $periodTo, $idDefinition, $idContractor, $idWarehouse);
    }

    public function createDocumentIfNotExist(Document $document): void
    {
        if(!$this->existsDocument($document->getNumber()))
        {
            $this->createDocument($document);
        }
    }

    public function createDocument(Document $document): void
    {
        $this->documentsRepository->createDocument($document);
    }

    public function existsDocument(?string $number): bool
    {
        if(!$number)
        {
            return false;
        }

        $document = $this->getDocument($number);
        return $document != null;
    }

    public function getDocument(string $number): ?Document
    {
        return $this->documentsRepository->getDocument($number);
    }

    public function deleteDocuments(array $ids): void
    {
        if(!$ids || count($ids) == 0)
        {
            return;
        }

        $this->documentsRepository->deleteDocuments($ids);
    }
}