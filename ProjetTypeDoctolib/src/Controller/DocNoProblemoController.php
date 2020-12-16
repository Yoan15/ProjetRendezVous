<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocNoProblemoController extends AbstractController
{
    /**
     * @Route("/", name="doctolib_index")
     */
    public function index(): Response
    {
        return $this->render('docNoProblemo/index.html.twig', [
            'controller_name' => 'DoctolibController',
        ]);
    }
}
