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
    public function index(UserRepository $r1,JobRepository $r2, NewsLetterRepository $r4)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $companies=$this->getDoctrine()->getRepository(User::class)->findLength();
        $jobs=$this->getDoctrine()->getRepository(Job::class)->findAll();
        $employees=$this->getDoctrine()->getRepository(User::class)->findLengthEmp();
        $subscribers=$this->getDoctrine()->getRepository(NewsLetter::class)->findAll();
        $job=$this->getDoctrine()->getRepository(Job::class)->findJ();
        $comp=$this->getDoctrine()->getRepository(User::class)->findU();
        $emp=$this->getDoctrine()->getRepository(User::class)->findU();
        $new=$this->getDoctrine()->getRepository(NewsLetter::class)->findByN();
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
       // $c=count($employees);
        return $this->render('admin/adminIndex.html.twig', [
            'c' => $companies, 'j' => $jobs,'e' => $employees,'s' => $subscribers,'job'=>$job,'comp'=>$comp,
            'emp'=>$emp,'new'=>$new,'contact'=>$contact
        ]);
    }
    /**
     * @Route("/admin/companies", name="companiesAdmin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function companies(UserRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $companies=$this->getDoctrine()->getRepository(User::class)->findAll();
        $company = $paginator->paginate(
            // Doctrine Query, not results
            $companies,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->render('admin/companies.html.twig', [
            'company' => $company,'contact'=>$contact
        ]);
    }
    /**
     * @Route("/admin/jobs", name="jobsAdmin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function jobs(JobRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $jobs=$this->getDoctrine()->getRepository(Job::class)->findAll();
        $job = $paginator->paginate(
            // Doctrine Query, not results
            $jobs,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
           1
        );
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->render('admin/job.html.twig', [
            'job' => $job,'contact'=>$contact
        ]);
    }
    /**
     * @Route("/admin/members", name="membersAdmin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function members(UserRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $employees=$this->getDoctrine()->getRepository(User::class)->findAll();

        $employee = $paginator->paginate(
            // Doctrine Query, not results
            $employees,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
           6
        );
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->render('admin/employee.html.twig', [
            'employee' => $employee,'contact'=>$contact
        ]);
    }

    /**
     *@Route("/admin/subscribers", name="subscribersAdmin")
     *@IsGranted("ROLE_ADMIN")
     */

    public function subscribers(NewsLetterRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $subscribers=$this->getDoctrine()->getRepository(NewsLetter::class)->findAll();
        $subscriber = $paginator->paginate(
            // Doctrine Query, not results
            $subscribers,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->render('admin/Abonnes.html.twig', [
            'subscriber' => $subscriber,'contact'=>$contact
        ]);
    }
    /**
     * @Route("/admin/job/{id}", name="jobDetailsAdmin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function detail($id,Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

    $j=$this->getDoctrine()->getRepository(job::class)->find($id);
    
    $jobs=$this->getDoctrine()->getRepository(job::class)->findByCat($j->getCategory());
    $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
    return $this->render('admin/JobDetails.html.twig',['job'=>$j ,'jobs'=>$jobs,'contact'=>$contact]);
  }

      /**
     * @Route("/admin/member/{id}", name="ProfileDetailsAdmin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function detailProfile($id,Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    $e=$this->getDoctrine()->getRepository(User::class)->find($id);
    // $employees=$this->getDoctrine()->getRepository(employee::class)->findByCat($e->getCategory());
    $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
    return $this->render('admin/ProfileDetails.html.twig',['employee'=>$e ,'contact'=>$contact
    ]);
  }

    /**
    *@Route("/admin/member/delete/{id}", name="DeleteMember")
    *@IsGranted("ROLE_ADMIN")
    */
    public function deleteM($id,Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $e=$this->getDoctrine()->getRepository(User::class)->find($id);
        $entityManager->remove($e);
        $entityManager->flush();
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->redirectToRoute('membersAdmin', [
            'employee' => $e,'contact'=>$contact
        ]);
    }
    /**
    * @Route("/admin/companies/delete/{id}", name="DeleteCompany")
    * @IsGranted("ROLE_ADMIN")
    */
    public function deleteC($id, Request $request, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $c=$this->getDoctrine()->getRepository(User::class)->find($id);
        $entityManager->remove($c);
        $entityManager->flush();
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->redirectToRoute('companiesAdmin', [
            'company' => $c,'contact'=>$contact
        ]);
    }
    /**
    * @Route("/admin/jobs/delete/{id}", name="DeleteJob")
    * @IsGranted("ROLE_ADMIN")
    */
    public function deleteJ($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $j=$this->getDoctrine()->getRepository(Job::class)->find($id);
        $entityManager->remove($j);
        $entityManager->flush();
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->redirectToRoute('jobsAdmin', ['job' => $j, 'contact'=>$contact]);
    }

    /**
    * @Route("/admin/subscribers/delete/{id}", name="DeleteSub")
    * @IsGranted("ROLE_ADMIN")
    */
    public function deleteS($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $s=$this->getDoctrine()->getRepository(NewsLetter::class)->find($id);
        $entityManager->remove($s);
        $entityManager->flush();
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->redirectToRoute('subscribersAdmin', ['s' => $s,'contact'=>$contact]);
    }

    /**
     *@Route("/admin/mailBox", name="mailBox")
     *@IsGranted("ROLE_ADMIN")
     */

    public function mails(MessageAdminRepository $repository,\Swift_Mailer $mailer, LoggerInterface $logger,Request $request, PaginatorInterface $paginator)
    {
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

        // ... do any other work - like sending them an email, etc
        // maybe set a "flash" success message for the user
        $name = $request->query->get('username');
       //$to=$form['sendTo']->getData();
        $message = new \Swift_Message($form['subject']->getData());
        $message->setFrom('admin@admin.com');
        $message->setTo($form['sendTo']->getData());
        $msg=$form['message']->getData();
        $message->setBody(
          $msg,
          'text/plain','utf-8'

        );  

        $mailer->send($message);

        $logger->info('email sent');
        $this->addFlash('notice', 'Email sent');

        unset($compose);
        unset($form);
        $compose = new MessageAdmin();
        $form = $this->createForm(MessageAdminType::class, $compose);
        
      }
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        $sent=$this->getDoctrine()->getRepository(MessageAdmin::class)->findAll();
        return $this->render('admin/mailBox.html.twig', ['mails' => $mails,'sent' => $sent,'form' => $form->createView(),'contact'=>$contact]);
    }

    /**
    * @Route("/admin/sent/delete/{id}", name="DeleteSent")
    * @IsGranted("ROLE_ADMIN")
    */
    public function deleteSent($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $s=$this->getDoctrine()->getRepository(MessageAdmin::class)->find($id);
        $entityManager->remove($s);
        $entityManager->flush();
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->redirect($this-> generateUrl('mailBox', [
            's' => $s,'contact'=>$contact
        ]).'#sent');
    }

    
    /**
    * @Route("/admin/inbox/delete/{id}", name="DeleteInbox")
    * @IsGranted("ROLE_ADMIN")
    */
    public function deleteInbox($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $c=$this->getDoctrine()->getRepository(Contact::class)->find($id);
        $entityManager->remove($c);
        $entityManager->flush();
        $contact=$this->getDoctrine()->getRepository(Contact::class)->findM();
        return $this->redirectToRoute('mailBox', [
            'mail' => $c,'contact'=>$contact
        ]);
    }
}
