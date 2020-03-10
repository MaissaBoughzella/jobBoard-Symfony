<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CandidateController extends AbstractController
{
    /**
     * @Route("/job", name="job")
     */
    public function index()
    {
        return $this->render('candidate/browseJob.html.twig', [
            'controller_name' => 'CandidateController',
        ]);
    }

    /**
     * @Route("/companies", name="companies")
     */
    public function companies()
    {
        return $this->render('candidate/companies.html.twig', [
            'controller_name' => 'CandidateController',
        ]);
    }


}
