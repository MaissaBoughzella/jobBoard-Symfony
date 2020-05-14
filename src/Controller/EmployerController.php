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
use App\Entity\User;
use App\Repository\JobRepository;
use App\Repository\CompanyRepository;
use App\Repository\CategoryRepository;
use App\Repository\TypeJobRepository;
use App\Repository\UserRepository;
use App\Entity\NewsLetter;
use App\Entity\Resume;
use App\Repository\NewsLetterRepository;
use App\Repository\ResumeRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\SearchEmployee;
use App\Form\ResumeType;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
class EmployerController extends AbstractController
{
    /**
     * @Route("/candidate", name="candidate")
     */

    public function index(UserInterface $user,UserRepository $repository,Request $request, PaginatorInterface $paginator)
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
      return $this->redirectToRoute("candidate");   
      }
      $e = $user->getId(); 
        
        return $this->render('employer/browseCandidate.html.twig', 
        ['employees' => $jobs,'employee'=> $e, 'form' => $form->createView(),'formS' => $formS->createView()]);
    }

    /**
     * @Route("/resume/{id}", name="resume")
     */
    public function resume($id,Request $request)
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
      return $this->redirectToRoute("resume");   
      }

      $j=$this->getDoctrine()->getRepository(job::class)->find($id);

      // 1) build the form
      $resume = new Resume();
      $form1 = $this->createForm(ResumeType::class, $resume);

      // 2) handle the submit (will only happen on POST)
      $form1->handleRequest($request);
      if ($form1->isSubmitted() && $form1->isValid()) {


        $brochureFile = $form1['cv']->getData();
        if ($brochureFile) {
          $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
          // this is needed to safely include the file name as part of the URL
          $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
          $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

          // Move the file to the directory where brochures are stored
          try {
              $brochureFile->move(
                  $this->getParameter('brochures_directory'),
                  $newFilename
              );
          } catch (FileException $e) {
              // ... handle exception if something happens during file upload
          }

          // updates the 'brochureFilename' property to store the PDF file name
          // instead of its contents
          $resume->setCv($newFilename);
      }
      $imageFile = $form1['photo']->getData();
      if ($imageFile) {
        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $imageFile->move(
                $this->getParameter('photo_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        // updates the 'brochureFilename' property to store the PDF file name
        // instead of its contents
        $resume->setPhoto($newFilename);
    }

          // 3) save the User!
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($resume);
          $entityManager->flush();

          // ... do any other work - like sending them an email, etc
          // maybe set a "flash" success message for the user

          return $this->redirectToRoute('job');
      }

        return $this->render('employer/resume.html.twig', ['job'=>$j,
            'form' => $form->createView(), 'form1' => $form1->createView()
        ]);
    }

    /**
     * @Route("/candidate/{id}", name="candidateDetail")
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

    $e=$this->getDoctrine()->getRepository(User::class)->find($id);
    return $this->render('employer/CandidateDetail.html.twig',['employee'=>$e ,'form' => $form->createView()]);
  }

}
