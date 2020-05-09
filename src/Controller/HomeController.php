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
use App\Repository\CompanyRepository;
use App\Entity\Job;
use App\Repository\JobRepository;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Entity\Company;
use App\Data\SearchData;
use App\Form\SearchHome;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CompanyRepository $repository,JobRepository $repo,Request $request,AuthenticationUtils $authenticationUtils)
    { 
      $company=$this->getDoctrine()->getRepository(Company::class)->findAll();

      $data=new SearchData();
      $data->page=$request->get('page',1);
      $formS=$this->createForm(SearchHome::class, $data);
      $formS->handleRequest($request);
      $jobs = $repo->findSearch($data);

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
                 if(TRUE== $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
                   return $this->redirectToRoute('admin');
                 }
        return $this->render('home/index.html.twig', 
            array('form' => $form->createView(), 'companies'=> $company,'jobs' => $jobs, 'formS' => $formS->createView())
        );
    }

    /**
     * @Route("/home/employee/{id}", name="homeEmp")
     */
    public function HomeEmp($id,CompanyRepository $repository,JobRepository $repo,Request $request)
    { 
      $company=$this->getDoctrine()->getRepository(Company::class)->findAll();

      $data=new SearchData();
      $data->page=$request->get('page',1);
      $formS=$this->createForm(SearchHome::class, $data);
      $formS->handleRequest($request);
      $jobs = $repo->findSearch($data);

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
      $e=$this->getDoctrine()->getRepository(Employee::class)->find($id);
      //$j=$this->getDoctrine()->getRepository(Job::class)->findAll();
   
        return $this->render('home/EmployeeHome.html.twig', 
            array('form' => $form->createView(), 'companies'=> $company,'jobs' => $jobs,'employee' => $e, 'formS' => $formS->createView())
        );
    }
  
    
}
