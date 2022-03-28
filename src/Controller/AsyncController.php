<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\DocumentRepository;
use App\Service\UserService;
use App\Repository\UserRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\HeaderUtils;

class AsyncController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/deleteUser/{id}", name="async_delete_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteUser(int $id, FlashyNotifier $flashy): Response
    {
        $this->userService->deleteUser($id);

        $flashy->success("L'utilisateur a bien été supprimé");

        return $this->redirectToRoute('bo_users');
    }

    /**
     * @Route("/makeAdmin/{id}", name="async_up_to_admin_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function AdminUser(int $id, FlashyNotifier $flashy): Response
    {
        $this->userService->upgradeToAdmin($id);

        $userName = $this->userService->nameUserById($id);
        $flashy->success("Un matelot de plus ! $userName[0] $userName[1]");

        return $this->redirectToRoute('bo_users');
    }

    /**
     * @Route("/changeRole/{id}/{isUpgrade}", name="async_update_role_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function changeRoleUser(int $id, int $isUpgrade, FlashyNotifier $flashy): Response
    {
        $changedRolePassed = $this->userService->changeUserRole($id, $isUpgrade);

        if($changedRolePassed ==  true){
            $flashy->success('Le role a bien été modifié !');
            return $this->redirectToRoute('bo_users');
        }else{
            $flashy->error("Le role n'a pas pu être modifié !");
            return $this->redirectToRoute('bo_users');
        }
    }

    /**
     * @Route("/valideUser/{id}", name="async_valide_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function valideUser(int $id, FlashyNotifier $flashy)
    {
        $this->userService->changeValidateValue($id);

        $flashy->success("Utilisateur validé !");
        return $this->redirectToRoute('bo_users');

    }

    /**
     * @Route("/removeCategorie/{id}", name="async_remove_categorie")
     * @isGranted("ROLE_ADMIN")
     * @isGranted("ROLE_GESTIONNAIRE")
     */
    public function removeCategorie(int $id, FlashyNotifier $flashy, CategorieRepository $catRepo)
    {
        $catRepo->removeCatById($id);

        $flashy->success("Catégorie supprimée !");
        return $this->redirectToRoute('bo_categories');

    }

    /**
     * @Route("/downloadFile/{id}/{roleUser}", name="async_download_file")
     */
    public function downloadFile($id, $roleUser, FlashyNotifier $flashy, DocumentRepository $docRepo){

        $path = $docRepo->getFilePathById($id);
        $user = $this->getUser();
        $file = new File("../public/uploads/$path");
        if($user->getRoles()[0] == $roleUser){

            header('Content-Disposition: inline; filename="' . $file . '"');
            header('Content-Tranfert-Encoding: binay');
            header('Accept-Ranges: bytes');

            $flashy->success("Fichier téléchargé !");
            return $this->redirectToRoute('bo_documents');
        }else{
            $flashy->error("Le téléchargement n'as pas eu lieu, Acces refusé !");
            return $this->redirectToRoute('bo_documents');
        }
    }
}