<?php

namespace App\Controller;

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

        $companies=$this->getDoctrine()->getRepository(User::class)->findAll();
        $jobs=$this->getDoctrine()->getRepository(Job::class)->findAll();
        $employees=$this->getDoctrine()->getRepository(User::class)->findAll();
        $subscribers=$this->getDoctrine()->getRepository(NewsLetter::class)->findAll();
        $job=$this->getDoctrine()->getRepository(Job::class)->findJ();
        $comp=$this->getDoctrine()->getRepository(User::class)->findU();
        $emp=$this->getDoctrine()->getRepository(User::class)->findU();
        $new=$this->getDoctrine()->getRepository(NewsLetter::class)->findByN();
       // $c=count($employees);
        return $this->render('admin/adminIndex.html.twig', [
            'c' => $companies, 'j' => $jobs,'e' => $employees,'s' => $subscribers,'job'=>$job,'comp'=>$comp,
            'emp'=>$emp,'new'=>$new
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
        return $this->render('admin/companies.html.twig', [
            'company' => $company
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
        return $this->render('admin/job.html.twig', [
            'job' => $job
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
        return $this->render('admin/employee.html.twig', [
            'employee' => $employee
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
        return $this->render('admin/Abonnes.html.twig', [
            'subscriber' => $subscriber
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
    return $this->render('admin/JobDetails.html.twig',['job'=>$j ,'jobs'=>$jobs]);
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
    return $this->render('admin/ProfileDetails.html.twig',['employee'=>$e ,//'employees'=>$employees
    ]);
  }

    /**
    * @Route("/admin/member/delete/{id}", name="DeleteMember")
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
        return $this->redirectToRoute('membersAdmin', [
            'employee' => $e
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
        return $this->redirectToRoute('companiesAdmin', [
            'company' => $c
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
        return $this->redirectToRoute('jobsAdmin', ['job' => $j]);
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
        return $this->redirectToRoute('subscribersAdmin', ['s' => $s]);
    }

    /**
     *@Route("/admin/mailBox", name="mailBox")
     *@IsGranted("ROLE_ADMIN")
     */

    public function mails(NewsLetterRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        $mails=$this->getDoctrine()->getRepository(Contact::class)->findAll();
        return $this->render('admin/mailBox.html.twig', ['mails' => $mails]);
    }
}
