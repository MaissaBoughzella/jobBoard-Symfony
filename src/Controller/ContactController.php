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
use App\Entity\Contact;
use App\Entity\NewsLetter;
use App\Repository\ContactRepository;
use App\Repository\NewsLetterRepository;
use App\Controller\ContactController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
   

    public function createAction(NewsLetterRepository $cont,Request $request)
    {   
      $cont = new NewsLetter;     
        # Add form fields
          $form = $this->createFormBuilder($cont)
          ->add('email', EmailType::class, array('label'=> 'Email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->getForm();
        # Handle form response
          $form->handleRequest($request);
  
          if($form->isSubmitted() &&  $form->isValid()){
              $this->addFlash('success','You are subscribed!');
              $email = $form['email']->getData();
        # set form data   
              $cont->setEmail($email);                             
         # finally add data in database
              $sn = $this->getDoctrine()->getManager();      
              $sn -> persist($cont);
              $sn -> flush();
      return $this->redirectToRoute("contact");   
      }

    
       $contact = new Contact;     
      # Add form fields
        $formC = $this->createFormBuilder($contact)
        ->add('name', TextType::class, array('label'=> 'Name', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('email', EmailType::class, array('label'=> 'Email','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('message', TextareaType::class, array('label'=> 'Message','attr' => array('class' => 'form-control','style' => 'height:90px')))
        ->getForm();
      # Handle form response
        $formC->handleRequest($request);

        if($formC->isSubmitted() &&  $formC->isValid()){
            $this->addFlash('success','Your message was successfully sent!');
            $name = $formC['name']->getData();
            $email = $formC['email']->getData();
            $message = $formC['message']->getData(); 
      # set form data   
            $contact->setName($name);
            $contact->setEmail($email);              
            $contact->setMessage($message);                
       # finally add data in database
            $sn = $this->getDoctrine()->getManager();      
            $sn -> persist($contact);
            $sn -> flush();
    return $this->redirectToRoute("contact");   
    }
    return $this->render('contact/contact.html.twig', ['form' => $form->createView(),'formC' => $formC->createView()]);
   

  }
}
