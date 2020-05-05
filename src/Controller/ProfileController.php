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
use App\Entity\Resume;
use App\Repository\NewsLetterRepository;
use App\Repository\ResumeRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Form\SearchEmployee;
use App\Form\ResumeType;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\File;

//use Symfony\Component\Validator\Constraints\DateTime;
class ProfileController extends AbstractController
{

    /**
     * @Route("/profile/{id}", name="profile")
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

    $e=$this->getDoctrine()->getRepository(employee::class)->find($id);
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

  $employee = new Employee();
  $employee = $this->getDoctrine()->getRepository(Employee::class)->find($id);
  
        $formE = $this->createFormBuilder($employee)
          ->add('name', TextType::class,[ 'label'=>false],array('attr' => array('class' => 'form-control')))
          ->add('email', EmailType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
          ->add('tel', TextType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
          ->add('address', TextType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
          ->add('prof', TextType::class, [ 'label'=>false],array('attr' => array('class' => 'form-control')))
          ->add('education', TextareaType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
          ->add('experience', TextareaType::class, [ 'label'=>false], array('attr' => array('class' => 'form-control')))
          ->add('comp1', TextType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
          ->add('salary', NumberType::class,[ 'label'=>false], array('attr' => array('class' => 'form-control')))
          ->add('type',EntityType::class,[
            'label'=>false,
            'required'=>false,
            'class'=> TypeJob::class,
          ])
          ->add('image',FileType::class,[
            'required'=>true,
            'label'=>false,
            "data_class"=> NULL,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/jpg'
                    ],
                    
                    'mimeTypesMessage' => 'Please upload a valid Image',
                ])
            ],
        ])
            ->add('save', SubmitType::class, array(
                'label' => 'Save changes',
               // 'attr' => array('class' => 'site-button')
            ))
          ->getForm();
  
        $formE->handleRequest($request);
  
        if($formE->isSubmitted() && $formE->isValid()) {

            $imageFile = $formE['image']->getData();
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

       
  
    $emp=$this->getDoctrine()->getRepository(employee::class)->find($id);
    return $this->render('profile/edit.html.twig',['emp'=>$emp ,'form' => $form->createView(),'formE' => $formE->createView()]);
  }


  

}
