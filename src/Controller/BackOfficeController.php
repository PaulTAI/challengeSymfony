<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/profile")
 */
class BackOfficeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $file = new File('../public/files/toTry.pdf');
        header('Content-type: application/pdf');
        // header('Content-Disposition: inline; filename="' . $file . '"');
        // header('Content-Tranfert-Encoding: binay');
        // header('Accept-Ranges: bytes');
        //$displayFile = readfile($file);
        return $this->render('backOffice/layoutBackOffice.html.twig',[
            // "filetry" => $displayFile
        ]);
    }
}
