<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\NewsLetter;
use App\Repository\NewsLetterRepository;
use App\Entity\Job;
use App\Repository\JobRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Data\SearchData;
use App\Form\SearchHomeCompany;
use App\Form\SearchHome;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(UserRepository $repository,JobRepository $repo,Request $request,AuthenticationUtils $authenticationUtils)
    {  
      //get the company 
      $company=$this->getDoctrine()->getRepository(User::class)->findAll();
      /*formulaire SearchEmployee de recherche de job selon un mot clé 
      et/ou catégorie de job et/ou type de job et/ou salaire min et max*/

      $data=new SearchData();

      //page  1 as default page 
      $data->page=$request->get('page',1);
      //creat form for the filter 
      $formS=$this->createForm(SearchHome::class, $data);
      //handle request
      $formS->handleRequest($request);
      //filter the jobs 
      $jobs = $repo->findSearch($data);
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
      return $this->redirectToRoute("home");   

      }
      // get the login error if there is one
      $error = $authenticationUtils->getLastAuthenticationError();
      // last username entered by the user
      $lastUsername = $authenticationUtils->getLastUsername();
      //redirect after login depends on role 
      if(TRUE== $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
        return $this->redirectToRoute('admin');
      }
      if(TRUE== $this->get('security.authorization_checker')->isGranted('ROLE_COMPANY')){
          return $this->redirectToRoute('company');
      }

        return $this->render('home/index.html.twig', 
            array('form' => $form->createView(),'companies'=> $company,'jobs' => $jobs, 'formS' => $formS->createView())
        );
    }


     /**
     * @Route("/company", name="company")
     */
    public function indexCompany(UserRepository $repository,JobRepository $repo,Request $request,AuthenticationUtils $authenticationUtils)
    {  
      //home of company after login company

      //get the employee in the data base
      $emp=$this->getDoctrine()->getRepository(User::class)->findAll();
      //formulaire SearchHomeCompany de recherche de condidat selon profession 
      $data=new SearchData();
      //first pge is number 1 per default 
      $data->page=$request->get('page',1);
      //create form
      $formS=$this->createForm(SearchHomeCompany::class, $data);
      //handle request
      $formS->handleRequest($request);
      // call function to find employee depends on occupation
      $employees = $repository->findSearch($data);
      //Newsletter form
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
      return $this->redirectToRoute("company");   

      }
     
        return $this->render('home/indexCompany.html.twig', 
            array('form' => $form->createView(),'employee'=> $emp,'employees' => $employees, 'formS' => $formS->createView())
        );
    }

    
  }