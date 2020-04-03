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
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\SearchEmployee;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class EmployerController extends AbstractController
{
    /**
     * @Route("/candidate", name="candidate")
     */

    public function index(EmployeeRepository $repository,Request $request, PaginatorInterface $paginator)
    {   

        $data=new SearchData();
        $data->page=$request->get('page',1);
        $formS=$this->createForm(SearchEmployee::class, $data);
        $formS->handleRequest($request);
        $jobs = $repository->findSearch($data);
 

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
      return $this->redirectToRoute("candidate");   
      }
        
        return $this->render('employer/browseCandidate.html.twig', 
        ['employees' => $jobs, 'form' => $form->createView(),'formS' => $formS->createView()]);
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
