<?php

namespace App\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Repository\EmployeeRepository;
use App\Entity\Job;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Repository\JobRepository;
use App\Entity\NewsLetter;
use App\Repository\NewsLetterRepository;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\MessageAdmin;
use App\Repository\MessageAdminRepository;
use App\Form\MessageAdminType;

/**
 * Require ROLE_ADMIN for only this controller method.
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
/**
 * Require ROLE_ADMIN for only this controller method.
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin", name="admin")
*/

// page dashboard
    public function index(UserRepository $r1,JobRepository $r2, NewsLetterRepository $r4)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        // recuperer le nombre total des entreprises 
        $companies=$this->getDoctrine()->getRepository(User::class)->findLength();
        //recuperer tous les jobs 
        $jobs=$this->getDoctrine()->getRepository(Job::class)->findAll();
        // recuperer le nombre total des employés  
        $employees=$this->getDoctrine()->getRepository(User::class)->findLengthEmp();
        //recuperer la liste des inscriptions au newsletter 
        $subscribers=$this->getDoctrine()->getRepository(NewsLetter::class)->findAll();
        //recuperer les 8 jobs les plus récents 
        $job=$this->getDoctrine()->getRepository(Job::class)->findJ();
        //recuperer les 8 entreprises les plus récentes 
        $comp=$this->getDoctrine()->getRepository(User::class)->findU();
        //recuperer les 8 employés les plus récents 
        $emp=$this->getDoctrine()->getRepository(User::class)->findU();
        //recuperer les 8 inscriptions les plus récentes 
        $new=$this->getDoctrine()->getRepository(NewsLetter::class)->findByN();
        //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();

        return $this->render('admin/adminIndex.html.twig', [
            'c' => $companies, 'j' => $jobs,'e' => $employees,'s' => $subscribers,'job'=>$job,'comp'=>$comp,
            'emp'=>$emp,'new'=>$new,'contact'=>$contact
        ]);
    }

    /**
     * @Route("/admin/companies", name="companiesAdmin")
     * @IsGranted("ROLE_ADMIN")
     */

    // page des entreprises
    public function companies(UserRepository $repository,Request $request, PaginatorInterface $paginator)
    { 
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        //recuperer tous les entreprises de la base 
        $companies=$this->getDoctrine()->getRepository(User::class)->findAll();
        //pagination 
        $company = $paginator->paginate(
            // Doctrine Query, not results
            $companies,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        //afficher les 3 messages les plus récents
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        
        return $this->render('admin/companies.html.twig', ['company' => $company,'contact'=>$contact]);
    }

    /**
     * @Route("/admin/jobs", name="jobsAdmin")
     * page des jobs 
     * @IsGranted("ROLE_ADMIN")
     */

    // page des jobs 
    public function jobs(JobRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        //recuperer tous les jobs de la base 
        $jobs=$this->getDoctrine()->getRepository(Job::class)->findAll();
        //pagination
        $job = $paginator->paginate(
            // Doctrine Query, not results
            $jobs,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
           1
        );
        //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();

        return $this->render('admin/job.html.twig', ['job' => $job,'contact'=>$contact]);
    }

    /**
     * @Route("/admin/members", name="membersAdmin")
     * @IsGranted("ROLE_ADMIN")
     */

    //page des membres 
    public function members(UserRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        // recuperer tous les membres de jobBoard
        $employees=$this->getDoctrine()->getRepository(User::class)->findAll();
        //pagination
        $employee = $paginator->paginate(
            // Doctrine Query, not results
            $employees,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
           6
        );
     //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->render('admin/employee.html.twig', ['employee' => $employee,'contact'=>$contact]);
    }

    /**
     *@Route("/admin/subscribers", name="subscribersAdmin")
     *@IsGranted("ROLE_ADMIN")
     */

    //page des inscriptions au nexsletter 
    public function subscribers(NewsLetterRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        // recuperer la liste des insriptions au newsletter
        $subscribers=$this->getDoctrine()->getRepository(NewsLetter::class)->findAll();
        //pagination
        $subscriber = $paginator->paginate(
            // Doctrine Query, not results
            $subscribers,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->render('admin/Abonnes.html.twig', ['subscriber' => $subscriber,'contact'=>$contact]);
    }

    /**
     * @Route("/admin/job/{id}", name="jobDetailsAdmin")
     * @IsGranted("ROLE_ADMIN")
     */

    // page detail de chaque job
    public function detail($id,Request $request)
    {  
        //donner l'accès qu'à l'admin 
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    // recuperer job par son id 
    $j=$this->getDoctrine()->getRepository(job::class)->find($id);
    // recuperer les jobs de méme categorie
    $jobs=$this->getDoctrine()->getRepository(job::class)->findByCat($j->getCategory());
    //recuperer les 3 messages les plus récents 
    $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();

    return $this->render('admin/JobDetails.html.twig',['job'=>$j ,'jobs'=>$jobs,'contact'=>$contact]);
  }

      /**
     * @Route("/admin/member/{id}", name="ProfileDetailsAdmin")
     * @IsGranted("ROLE_ADMIN")
     */

    // page de detail de chaque membre 
    public function detailProfile($id,Request $request)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        //recuperer le membre par son id 
        $e=$this->getDoctrine()->getRepository(User::class)->find($id);
        //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();

        return $this->render('admin/ProfileDetails.html.twig',['employee'=>$e ,'contact'=>$contact]);
  }

    /**
    *@Route("/admin/member/delete/{id}", name="DeleteMember")
    *@IsGranted("ROLE_ADMIN")
    */

    //fonction de suppression d'un membre
    public function deleteM($id,Request $request)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        // find le membre par son id 
        $e=$this->getDoctrine()->getRepository(User::class)->find($id);
        //the remove() method notifies Doctrine that you'd like to remove the given object from the database.        
        $entityManager->remove($e);
        //execute the DELETE query 
        $entityManager->flush();
        //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();

        return $this->redirectToRoute('membersAdmin', ['employee' => $e,'contact'=>$contact]);
    }
    /**
    * @Route("/admin/companies/delete/{id}", name="DeleteCompany")
    * @IsGranted("ROLE_ADMIN")
    */

    //fonction de suppression d'une entreprise
    public function deleteC($id, Request $request, PaginatorInterface $paginator)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        // trouver l'entreprise par son id    
        $c=$this->getDoctrine()->getRepository(User::class)->find($id);
        //the remove() method notifies Doctrine that you'd like to remove the given object from the database.        
        $entityManager->remove($c);
        //execute the DELETE query 
        $entityManager->flush();
        //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        
        return $this->redirectToRoute('companiesAdmin', ['company' => $c,'contact'=>$contact]);
    }
    /**
    * @Route("/admin/jobs/delete/{id}", name="DeleteJob")
    * @IsGranted("ROLE_ADMIN")
    */
   //fonction de suppression d'un job
    public function deleteJ($id, Request $request)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        // trouver le job par son id
        $j=$this->getDoctrine()->getRepository(Job::class)->find($id);
        //the remove() method notifies Doctrine that you'd like to remove the given object from the database.        
        $entityManager->remove($j);
        //execute the DELETE query
        $entityManager->flush();
        //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();

        return $this->redirectToRoute('jobsAdmin', ['job' => $j, 'contact'=>$contact]);
    }

    /**
    * @Route("/admin/subscribers/delete/{id}", name="DeleteSub")
    * @IsGranted("ROLE_ADMIN")
    */

    //fonction de suppression d'une inscription
    public function deleteS($id, Request $request)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        // trouver l'inscri par son id
        $s=$this->getDoctrine()->getRepository(NewsLetter::class)->find($id);
        //the remove() method notifies Doctrine that you'd like to remove the given object from the database.        
        $entityManager->remove($s);
        //execute the DELETE query
        $entityManager->flush();
        //recuperer les 3 messages les plus récents 
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();

        return $this->redirectToRoute('subscribersAdmin', ['s' => $s,'contact'=>$contact]);
    }

    /**
     *@Route("/admin/mailBox", name="mailBox")
     *@IsGranted("ROLE_ADMIN")
     */
// page de mailBox 
    public function mails(MessageAdminRepository $repository,\Swift_Mailer $mailer, LoggerInterface $logger,Request $request, PaginatorInterface $paginator)
    { 
        //afficher liste des messages envoyés à l'admin
        $mails=$this->getDoctrine()->getRepository(Contact::class)->findAll();
         // 1) build the form
      $compose = new MessageAdmin();
      $form = $this->createForm(MessageAdminType::class, $compose);

      // 2) handle the submit (will only happen on POST)
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        // 3) save the User!
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($compose);
        $entityManager->flush();

        $name = $request->query->get('username');
        $message = new \Swift_Message($form['subject']->getData()); //instance de message avec précision de sujet
        $message->setFrom('admin@admin.com'); //set sender
        $message->setTo($form['sendTo']->getData()); // set destination
        $msg=$form['message']->getData();
        // set contenu de l'email
        $message->setBody(
          $msg,
          'text/plain','utf-8'
        );  
        //envoi de l'email 
        $mailer->send($message);
        // afficher un message flash d'envoi avec succès
        $logger->info('email sent');
        $this->addFlash('notice', 'Email sent');
        //vider le form 
        unset($compose);
        unset($form);
        //préparer un autre form
        $compose = new MessageAdmin();
        $form = $this->createForm(MessageAdminType::class, $compose);
      }
        //recuperer les 3 messges les plus recents
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        // afficher tous les messages envoyés 
        $sent=$this->getDoctrine()->getRepository(MessageAdmin::class)->findAll();

        return $this->render('admin/mailBox.html.twig', ['mails' => $mails,'sent' => $sent,'form' => $form->createView(),'contact'=>$contact]);
    }

    /**
    * @Route("/admin/sent/delete/{id}", name="DeleteSent")
    * @IsGranted("ROLE_ADMIN")
    */

    //fonction de suppression de messages envoyés 
    public function deleteSent($id, Request $request)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        // trouver le message à supprimer par son id
        $s=$this->getDoctrine()->getRepository(MessageAdmin::class)->find($id);
        //the remove() method notifies Doctrine that you'd like to remove the given object from the database.
        $entityManager->remove($s);
        //execute the DELETE query
        $entityManager->flush();
        //recuperer les 3 messages les plus récents
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();

        return $this->redirect($this-> generateUrl('mailBox', ['s' => $s,'contact'=>$contact]).'#sent');
    }

    /**
    * @Route("/admin/inbox/delete/{id}", name="DeleteInbox")
    * @IsGranted("ROLE_ADMIN")
    */

    //fonction de suppression de messages reçus 
    public function deleteInbox($id, Request $request)
    {
        //donner l'accès qu'à l'admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        // trouver le message à supprimer par son id
        $c=$this->getDoctrine()->getRepository(Contact::class)->find($id);
        //the remove() method notifies Doctrine that you'd like to remove the given object from the database.
        $entityManager->remove($c);
        //execute the DELETE query
        $entityManager->flush();
        //recuperer les 3 messages les plus récents
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        
        return $this->redirectToRoute('mailBox', ['mail' => $c,'contact'=>$contact]);
    }
}
