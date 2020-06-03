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
use App\Repository\UserRepository;
use App\Repository\TypeJobRepository;
use App\Repository\EmployeeRepository;
use App\Entity\NewsLetter;
use App\Repository\NewsLetterRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use App\Data\SearchData;
use App\Form\SearchCompany;
use App\Form\SearchForm;
use App\Form\AddJobFormType;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
class CandidateController extends AbstractController
{
    /**
     * @Route("/job", name="job")
     */
    public function index(JobRepository $repository,Request $request, PaginatorInterface $paginator)
    {   
      /*formulaire SearchForm de recherche de candidat de poste selon un mot clé 
      et/ou catégorie de job et/ou type de job */

      //creer instance de SearchData
        $data=new SearchData();
        //1ere page par defaut est 1
        $data->page=$request->get('page',1);
        //create form
        $formS=$this->createForm(SearchForm::class, $data);
        //Handle form response
        $formS->handleRequest($request);
        // appel fonction de filtrage des jobs
        $jobs = $repository->findSearch($data);

      //formulaire d'inscription au Newsletter
        $contact = new NewsLetter;     
        # Add form fields
          $form = $this->createFormBuilder($contact)
          ->add('email', EmailType::class, array('label'=> 'Email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->add('subscribe', SubmitType::class, array(
            'label' => 'Subscribe',
            'attr'=>array('style' => 'margin-top:-5%;')
          ))
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
        ['jobs' => $jobs, 'form' => $form->createView(),'formS' => $formS->createView()]);
    }

    /**
     * @Route("/companies", name="companies")
     * Page des entreprises 
     */
    public function companies(UserRepository $repository,Request $request, PaginatorInterface $paginator)
    {  
      /*formulaire SearchCompany de recherche de compagnies selon un mot clé 
      et/ou sa catégorie et/ou adresse */
    
      //creer instance de SearchData
      $data=new SearchData();
      //1ere page par defaut est 1
      $data->page=$request->get('page',1);
      //create form
      $formS=$this->createForm(SearchCompany::class, $data);
      //Handle form response
      $formS->handleRequest($request);
      // appel fonction de filtrage des jobs
      $companies = $repository->findSearch($data);

     //formulaire d'inscription au Newsletter
        $contact = new NewsLetter;     
        # Add form fields
          $form = $this->createFormBuilder($contact)
          ->add('email', EmailType::class, array('label'=> 'Email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->add('subscribe', SubmitType::class, array(
            'label' => 'Subscribe',
            'attr'=>array('style' => 'margin-top:-5%;')
           // 'attr' => array('class' => 'site-button')
        ))
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
        ['companies' => $companies, 'formS' => $formS->createView(),'form' => $form->createView()]);
    }

    /**
     * @Route("/job/{id}", name="JobDetail")
     * page de detail de chaque job
    */
    public function detail($id,Request $request)
    {
   //formulaire d'inscription au Newsletter
    $contact = new NewsLetter;     
          # Add form fields
            $form = $this->createFormBuilder($contact)
            ->add('email', EmailType::class, array('label'=> 'Email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('subscribe', SubmitType::class, array(
              'label' => 'Subscribe',
              'attr'=>array('style' => 'margin-top:-5%;')
          ))
            ->getForm();
          # Handle form response
            $form->handleRequest($request);
            if($form->isSubmitted() &&  $form->isValid()){
              //afficher un message flash après l'envoi du form correctement
                $this->addFlash('success','You are subscribed!');
                $email = $form['email']->getData();
          # set form data   
                $contact->setEmail($email);                             
          # finally add data in database
                $sn = $this->getDoctrine()->getManager();      
                $sn -> persist($contact);
                $sn -> flush();
        return $this->redirectToRoute("JobDetail");   
        }
     
    //find un job par son id
      $j=$this->getDoctrine()->getRepository(job::class)->find($id); 
    //creer nouvelle instance de job
      $job = new Job();
      $job = $this->getDoctrine()->getRepository(Job::class)->find($id);
      # create form
      $formE=$this->createForm(AddJobFormType::class, $job);
      # Handle form response
      $formE->handleRequest($request);
        if($formE->isSubmitted() && $formE->isValid()) {
          # add data in database
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
          #redirect to route JobDetail
          return $this->redirectToRoute('JobDetail', ['id'=>$id]);
        }
       #add data in database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
    // recuperer les jobs par categorie     
    $jobs=$this->getDoctrine()->getRepository(job::class)->findByCat($j->getCategory());
    return $this->render('candidate/JobDetail.html.twig',['job'=>$j ,'j'=>$job,'jobs'=>$jobs,'form' => $form->createView(),'formE' => $formE->createView()]);
  }


}
