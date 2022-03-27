<?php

namespace App\Controller;

use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrontOfficeController extends AbstractController
{
    /**
     * @Route("/", name="fo_home")
     */
    public function home(): Response
    {
        return $this->render('frontOffice/home.html.twig');
    }
}
