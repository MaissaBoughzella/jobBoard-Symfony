<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\NewsLetter;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {   
      // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
      // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


      //newsletter form
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
       
       return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error,'form' => $form->createView()]);
      
    
      }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {   //logout function the path after login is in services.yaml file
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
