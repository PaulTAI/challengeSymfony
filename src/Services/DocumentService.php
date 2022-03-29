<?php

namespace App\Service;

use App\Repository\DocumentRepository;
use League\Flysystem\Filesystem;
use Symfony\Component\Security\Core\Security;


class DocumentService
{

    private $documentRepository;
    private $security;
    private $privateStorage;

    public function __construct(DocumentRepository $documentRepository, Security $security, Filesystem $privateStorage)
    {
        $this->documentRepository = $documentRepository;
        $this->security = $security;
        $this->privateStorage = $privateStorage;
    }


    /**
     * Return a ressource
     */
    public function readStream(string $path)
    {
        $ressource = $this->privateStorage->readStream($path);

        return $ressource;

        if($ressource === false){
            throw new \Exception(sprintf('Erreur dans ouverture (stream) "%s"', $path ));
        }

        return $ressource;
    }

    /**
     * Get mimeType
     */
    public function getMimeType(string $path)
    {
        $mimeType = $this->privateStorage->mimeType($path);

        return $mimeType;
    }
}