<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrontOfficeController extends AbstractController
{
    /**
     * @Route("/", name="fo_home")
     */
    public function index(): Response
    {
        return $this->render('frontOffice/layoutFrontOffice.html.twig');
    }
}
