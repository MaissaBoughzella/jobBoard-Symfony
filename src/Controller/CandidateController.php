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
use App\Entity\NewsLetter;
use App\Repository\NewsLetterRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class CandidateController extends AbstractController
{
    /**
     * @Route("/job", name="job")
     */
    public function index(JobRepository $repository,CategoryRepository $reposit,TypeJobRepository $repo,Request $request, PaginatorInterface $paginator)
    {   
        $categories=$this->getDoctrine()->getRepository(Category::class)->findAll();
        $types=$this->getDoctrine()->getRepository(TypeJob::class)->findAll();
        $donnees = $this->getDoctrine()->getRepository(Job::class)->findBy([],['createdAt' => 'desc']);
        $jobs = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );

        $contact = new NewsLetter;     
        # Add form fields
          $form = $this->createFormBuilder($contact)
          ->add('email', EmailType::class, array('label'=> 'Email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->getForm();
        # Handle form response
          $form->handleRequest($request);
  
          if($form->isSubmitted() &&  $form->isValid()){
              $this->addFlash('success','You are subscribed!');
              $email = $form['email']->getData();
        # set form data   
              $contact->setEmail($email);                             
         # finally add data in database
              $sn = $this->getDoctrine()->getManager();      
              $sn -> persist($contact);
              $sn -> flush();
      return $this->redirectToRoute("job");   
      }
        
        return $this->render('candidate/browseJob.html.twig', 
        ['jobs' => $jobs,"categories"=>$categories,"types"=>$types, 'form' => $form->createView()]);
    }

    /**
     * @Route("/companies", name="companies")
     */
    public function companies(CompanyRepository $repository,CategoryRepository $reposit,Request $request, PaginatorInterface $paginator)
    {  
         
        $categories=$this->getDoctrine()->getRepository(Category::class)->findAll();
        $donnees = $this->getDoctrine()->getRepository(Company::class)->findAll();
        $companies = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );

        
        $contact = new NewsLetter;     
        # Add form fields
          $form = $this->createFormBuilder($contact)
          ->add('email', EmailType::class, array('label'=> 'Email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->getForm();
        # Handle form response
          $form->handleRequest($request);
  
          if($form->isSubmitted() &&  $form->isValid()){
              $this->addFlash('success','You are subscribed!');
              $email = $form['email']->getData();
        # set form data   
              $contact->setEmail($email);                             
         # finally add data in database
              $sn = $this->getDoctrine()->getManager();      
              $sn -> persist($contact);
              $sn -> flush();
      return $this->redirectToRoute("companies");   
      }
        return $this->render('candidate/companies.html.twig',
        ['companies' => $companies,"categories"=>$categories, 'form' => $form->createView()]);
    }


}
