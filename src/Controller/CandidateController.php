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
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
class CandidateController extends AbstractController
{
    /**
     * @Route("/job", name="job")
     */
    public function index(JobRepository $repository,Request $request, PaginatorInterface $paginator)
    {   
        $data=new SearchData();
        $data->page=$request->get('page',1);
        $formS=$this->createForm(SearchForm::class, $data);
        $formS->handleRequest($request);
        $jobs = $repository->findSearch($data);
       
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
      return $this->redirectToRoute("job");   
      }
        
        return $this->render('candidate/browseJob.html.twig', 
        ['jobs' => $jobs, 'form' => $form->createView(),'formS' => $formS->createView()]);
    }

    /**
     * @Route("/companies", name="companies")
     */
    public function companies(UserRepository $repository,Request $request, PaginatorInterface $paginator)
    {  
         
      $data=new SearchData();
      $data->page=$request->get('page',1);
      $formS=$this->createForm(SearchCompany::class, $data);
      $formS->handleRequest($request);
      $companies = $repository->findSearch($data);

        
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
    */
    public function detail($id,Request $request)
    {
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
        return $this->redirectToRoute("JobDetail");   
        }
     

    $j=$this->getDoctrine()->getRepository(job::class)->find($id);
    
    $jobs=$this->getDoctrine()->getRepository(job::class)->findByCat($j->getCategory());
    return $this->render('candidate/JobDetail.html.twig',['job'=>$j ,'jobs'=>$jobs,'form' => $form->createView()]);
  }


}
