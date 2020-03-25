<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Job;
use App\Entity\Company;
use App\Entity\Category;
use App\Entity\TypeJob;
use App\Entity\Employee;
use App\Repository\JobRepository;
use App\Repository\CompanyRepository;
use App\Repository\CategoryRepository;
use App\Repository\TypeJobRepository;
use App\Repository\EmployeeRepository;

class EmployerController extends AbstractController
{
    /**
     * @Route("/candidate", name="candidate")
     */

    public function index(EmployeeRepository $repository,CategoryRepository $reposit,TypeJobRepository $repo,Request $request, PaginatorInterface $paginator)
    {   
        $categories=$this->getDoctrine()->getRepository(Category::class)->findAll();
        $types=$this->getDoctrine()->getRepository(TypeJob::class)->findAll();
        $donnees = $this->getDoctrine()->getRepository(Employee::class)->findBy([],['created_at' => 'desc']);
        $jobs = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );
        
        return $this->render('employer/browseCandidate.html.twig', ['employees' => $jobs,"categories"=>$categories,"types"=>$types]);
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
