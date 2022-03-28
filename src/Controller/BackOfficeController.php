<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Document;
use App\Form\CategorieType;
use App\Form\DocumentType;
use App\Repository\CategorieRepository;
use App\Repository\DocumentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/categories", name="bo_categories")
     */
    public function Categories(Request $request, FlashyNotifier $flashy, EntityManagerInterface $manager, CategorieRepository $catRepo): Response{
        
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //--push datas
            $manager->persist($categorie);
            $manager->flush();

            $flashy->primary("Catégorie ajoutée !");
        }

        $cats = $catRepo->findAll();

        return $this->render("backOffice/categories.html.twig", [
            'form' => $form->createView(),
            'categories' => $cats
        ]);
    }
}
