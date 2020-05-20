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
use App\Entity\Category;
use App\Entity\TypeJob;
use App\Repository\JobRepository;
use App\Repository\CategoryRepository;
use App\Repository\TypeJobRepository;
use App\Entity\NewsLetter;
use App\Entity\User;
use App\Entity\Resume;
use App\Repository\NewsLetterRepository;
use App\Repository\ResumeRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\ProfileFormType;
use App\Form\EditCompanyType;
use App\Form\PhotoFormType;
use App\Form\SearchEmployee;
use App\Form\ResumeType;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

//use Symfony\Component\Validator\Constraints\DateTime;
class ProfileController extends AbstractController
{

    /**
     * @Route("/profile", name="profile")
    */
    public function detail(TokenStorageInterface $tokenStorage, Request $request)
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
        $e=$tokenStorage->getToken()->getUser();
        return $this->render('profile/index.html.twig',['employee'=>$e ,'form' => $form->createView()]);
  }

  /**
   * @Route("profile/edit/{id}", name="EditProfile")
   */
  public function Edit($id,Request $request)
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
  return $this->redirectToRoute("EditProfile");   
  }

  $employee = new User();
  $employee = $this->getDoctrine()->getRepository(User::class)->find($id);

  $formE=$this->createForm(ProfileFormType::class, $employee);
  $formE->handleRequest($request);
    if($formE->isSubmitted() && $formE->isValid()) {

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->flush();

      return $this->redirectToRoute('profile', ['id'=>$id]);
    }
    $formP=$this->createForm(PhotoFormType::class, $employee);
    $formP->handleRequest($request);
        if($formP->isSubmitted() && $formP->isValid()) {
            
            $imageFile = $formP['image']->getData();
            if ($imageFile) {
              $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
              // this is needed to safely include the file name as part of the URL
              $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
      
              //Move the file to the directory where brochures are stored
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
              $employee->setImage($newFilename);
          }
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('profile', ['id'=>$id]);
        }

    $emp=$this->getDoctrine()->getRepository(User::class)->find($id);
    return $this->render('profile/edit.html.twig',['employee'=>$emp ,'form' => $form->createView(),'formE' => $formE->createView(),'formP' => $formP->createView()]);
  }

  /**
   * @Route("company/edit/{id}", name="EditCompany")
   */
  public function EditCompany($id,Request $request)
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
  return $this->redirectToRoute("EditCompany");   
  }

  $company = new User();
  $company = $this->getDoctrine()->getRepository(User::class)->find($id);

  $formC=$this->createForm(EditCompanyType::class, $company);
  $formC->handleRequest($request);
    if($formC->isSubmitted() && $formC->isValid()) {

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->flush();

      return $this->redirectToRoute('profile', ['id'=>$id]);
    }
    $formP=$this->createForm(PhotoFormType::class, $company);
    $formP->handleRequest($request);
        if($formP->isSubmitted() && $formP->isValid()) {
            
            $imageFile = $formP['image']->getData();
            if ($imageFile) {
              $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
              // this is needed to safely include the file name as part of the URL
              $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
      
              //Move the file to the directory where brochures are stored
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
              $company->setImage($newFilename);
          }
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('profile', ['id'=>$id]);
        }

    $comp=$this->getDoctrine()->getRepository(User::class)->find($id);
    return $this->render('profile/edit.html.twig',['company'=>$comp ,'form' => $form->createView(),'formC' => $formC->createView(),'formP' => $formP->createView()]);
  }


  

}
