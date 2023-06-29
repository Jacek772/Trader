<?php

// Models
require_once __DIR__."/../models/User.php";

// Repositories
require_once __DIR__."/../repository/DocumentsRepository.php";
require_once __DIR__."/../repository/DocumentpositionsRepository.php";

class DocumentsService
{
    private $documentsRepository;
    private $documentpositionsRepository;

    public function __construct()
    {
        $this->documentsRepository = new DocumentsRepository();
        $this->documentpositionsRepository = new DocumentpositionsRepository();
    }

    public function getAllDocuments() : array
    {
        $documents = $this->documentsRepository->getAllDocuments();
        foreach ($documents as $document)
        {
            $positions = $this->documentpositionsRepository->getDocumentpositionsByIdDocument($document->getIdDocument());
            $document->setPositions($positions);
        }
        return $documents;
    }

    public function getDocuments(?string $periodFrom = null, ?string $periodTo = null, ?int $idDefinition = null,
                                 ?int $idContractor = null, ?int $idWarehouse = null, ?int $type = null)  : array
    {
        $documents = $this->documentsRepository->getDocuments($periodFrom, $periodTo, $idDefinition, $idContractor, $idWarehouse, $type);
        foreach ($documents as $document)
        {
            $positions = $this->documentpositionsRepository->getDocumentpositionsByIdDocument($document->getIdDocument());
            $document->setPositions($positions);
        }
        return $documents;
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

    public function updateDocument(int $iddocument,  array $documentData): void
    {
        $this->documentsRepository->updateDocument($iddocument, $documentData);
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
        $document = $this->documentsRepository->getDocument($number);
        $positions = $this->documentpositionsRepository->getDocumentpositionsByIdDocument($document->getIddocument());
        $document->setPositions($positions);
        return $document;
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