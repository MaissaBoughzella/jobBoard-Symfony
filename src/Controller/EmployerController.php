<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmployerController extends AbstractController
{
    /**
     * @Route("/candidate", name="candidate")
     */
    public function index()
    {
        return $this->render('employer/browseCandidate.html.twig', [
            'controller_name' => 'EmployerController',
        ]);
    }

    /**
     * @Route("/resume", name="resume")
     */
    public function resume()
    {
        return $this->render('employer/resume.html.twig', [
            'controller_name' => 'EmployerController',
        ]);
    }
}
