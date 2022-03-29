<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Form\EditDocumentType;
use App\Repository\DocumentRepository;
use App\Service\Security\PasswordService;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/documents')]
class DocumentController extends AbstractController
{
    #[Route('/', name: 'bo_documents', methods: ['GET'])]
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('backOffice/document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'bo_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentRepository $documentRepository, SluggerInterface $slugger, UserPasswordHasherInterface $passHasher): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);
        $appUser = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $document->setOwner($appUser);
            $document->setUploadAt(new \DateTime('now'));

            //--FILE UPLOAD
            $file = $form->get('filepath')->getData();
            $document->setType($file->guessExtension());
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($file) {
                // $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                // $safeFilename = $slugger->slug($originalFilename);
                $newFilename = uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('file_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $document->setFilepath($newFilename);
            }
            $password = $document->getProtected();
            if($password){
                $protectedPass = $passHasher->hashPassword($document, $password);
                $document->setProtected($protectedPass);
            }

            $documentRepository->add($document);
            return $this->redirectToRoute('bo_documents', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('backOffice/document/new.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'bo_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Document $document, DocumentRepository $documentRepository, UserPasswordHasherInterface $passHasher, FlashyNotifier $flashy): Response
    {
        $owner = $document->getOwner();
        $user = $this->getUser();
        if($owner == $user)
        {
            $form = $this->createForm(EditDocumentType::class, $document);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $fieldPass = $form["protected"]->getData();
                if(!empty($fieldPass)){
                    $protectedPass = $passHasher->hashPassword($document, $fieldPass);
                    $document->setProtected($protectedPass);
                }
                $documentRepository->add($document);
                return $this->redirectToRoute('bo_documents', [], Response::HTTP_SEE_OTHER);
            }
    
            return $this->renderForm('backOffice/document/edit.html.twig', [
                'document' => $document,
                'form' => $form,
            ]);
        } else if($user->getRoles()[0] == "ROLE_USER" || $user->getRoles()[0] == "ROLE_GESTIONNAIRE") {
            //-- Si l'utilisateur n'est pas le propriétaire & a le role User ou Gestionnaire
            $flashy->error("Tu n'es pas autorisé à editer ce document !");
            return $this->redirectToRoute('bo_documents');
        }else{
            $allowRole = $document->getAllowRoles()[0];
            $this->denyAccessUnlessGranted($allowRole, $document);

            $form = $this->createForm(EditDocumentType::class, $document);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $fieldPass = $form["protected"]->getData();
                if(!empty($fieldPass)){
                    $protectedPass = $passHasher->hashPassword($document, $fieldPass);
                    $document->setProtected($protectedPass);
                }
                $documentRepository->add($document);
                return $this->redirectToRoute('bo_documents', [], Response::HTTP_SEE_OTHER);
            }
    
            return $this->renderForm('backOffice/document/edit.html.twig', [
                'document' => $document,
                'form' => $form,
            ]);
        }
    }

    #[Route('/{id}', name: 'bo_document_delete', methods: ['POST'])]
    public function delete(Request $request, Document $document, DocumentRepository $documentRepository, FlashyNotifier $flashy): Response
    {
        $owner = $document->getOwner();
        $user = $this->getUser();
        if($owner == $user)
        {
            if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
                $documentRepository->remove($document);
            }
            $flashy->success('Document bien supprimé !');
            return $this->redirectToRoute('bo_documents', [], Response::HTTP_SEE_OTHER);

        }elseif($user->getRoles()[0] == "ROLE_ADMIN") {
            //-- Denied si il n'es pas l'owner ni un administrateur
            $this->denyAccessUnlessGranted("ROLE_ADMIN");

            if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
                $documentRepository->remove($document);
            }
            $flashy->success('Document bien supprimé !');
            return $this->redirectToRoute('bo_documents', [], Response::HTTP_SEE_OTHER);
        }

        $flashy->error("Tu n'es pas autorisé à supprimer ce document !");
        return $this->redirectToRoute('bo_documents');
    }
}
