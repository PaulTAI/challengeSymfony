<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class BackOfficeController extends AbstractController
{
    /**
     * @Route("/Dashboard", name="bo_dashboard", methods={"GET"})
     */
    public function Dashboard(): Response
    {
        $file = new File('../public/files/toTry.pdf');
        header('Content-type: application/pdf');
        // header('Content-Disposition: inline; filename="' . $file . '"');
        // header('Content-Tranfert-Encoding: binay');
        // header('Accept-Ranges: bytes');
        //$displayFile = readfile($file);
        return $this->render('backOffice/dashboard.html.twig',[
            // "filetry" => $displayFile
        ]);
    }

    /**
     * @Route("/users", name="bo_users")
     */
    public function UserList(UserRepository $userRepository): Response{

        $usersValidates = $userRepository->getUserValidate();
        $userNotValidate = $userRepository->getUserNotValidate();

        return $this->render("backOffice/userList.html.twig", [
            'users' => $usersValidates,
            'usersNotValidates' => $userNotValidate
        ]);
    }

    /**
     * @Route("/documents", name="bo_documents")
     */
    public function Documents(){
        return $this->render("backOffice/documents.html.twig");
    }

    /**
     * @Route("/categories", name="bo_categories")
     */
    public function Categories(){
        return $this->render("backOffice/categories.html.twig");
    }
}
