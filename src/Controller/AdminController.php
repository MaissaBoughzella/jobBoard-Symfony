<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use App\Entity\Job;
use App\Repository\JobRepository;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Entity\NewsLetter;
use App\Repository\NewsLetterRepository;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for only this controller method.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
/**
 * Require ROLE_ADMIN for only this controller method.
 *
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin", name="admin")
*/
    public function index(CompanyRepository $r1, JobRepository $r2, EmployeeRepository $r3, NewsLetterRepository $r4)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $companies=$this->getDoctrine()->getRepository(Company::class)->findAll();
        $jobs=$this->getDoctrine()->getRepository(Job::class)->findAll();
        $employees=$this->getDoctrine()->getRepository(Employee::class)->findAll();
        $subscribers=$this->getDoctrine()->getRepository(NewsLetter::class)->findAll();
        $job=$this->getDoctrine()->getRepository(Job::class)->findJ();
        $comp=$this->getDoctrine()->getRepository(Company::class)->findC();
        $emp=$this->getDoctrine()->getRepository(Employee::class)->findE();
        $new=$this->getDoctrine()->getRepository(NewsLetter::class)->findByN();
        return $this->render('admin/adminIndex.html.twig', [
            'c' => $companies, 'j' => $jobs, 'e' => $employees,'s' => $subscribers,'job'=>$job,'comp'=>$comp,
            'emp'=>$emp,'new'=>$new
        ]);
    }
    /**
     * @Route("/admin/companies", name="companiesAdmin")
     */
    public function companies(CompanyRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        $companies=$this->getDoctrine()->getRepository(Company::class)->findAll();
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
     */
    public function jobs(JobRepository $repository,Request $request, PaginatorInterface $paginator)
    {
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
     */
    public function members(EmployeeRepository $repository,Request $request, PaginatorInterface $paginator)
    {
        $employees=$this->getDoctrine()->getRepository(Employee::class)->findAll();
        $employee = $paginator->paginate(
            // Doctrine Query, not results
            $employees,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('admin/employee.html.twig', [
            'employee' => $employee
        ]);
    }

    /**
     *@Route("/admin/subscribers", name="subscribersAdmin")
     */

    public function subscribers(NewsLetterRepository $repository,Request $request, PaginatorInterface $paginator)
    {
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
     */
    public function detail($id,Request $request)
    {

    $j=$this->getDoctrine()->getRepository(job::class)->find($id);
    
    $jobs=$this->getDoctrine()->getRepository(job::class)->findByCat($j->getCategory());
    return $this->render('admin/JobDetails.html.twig',['job'=>$j ,'jobs'=>$jobs]);
  }

      /**
     * @Route("/admin/member/{id}", name="ProfileDetailsAdmin")
     */
    public function detailProfile($id,Request $request)
    {
    $e=$this->getDoctrine()->getRepository(employee::class)->find($id);
    // $employees=$this->getDoctrine()->getRepository(employee::class)->findByCat($e->getCategory());
    return $this->render('admin/ProfileDetails.html.twig',['employee'=>$e ,//'employees'=>$employees
    ]);
  }

    /**
    * @Route("/admin/member/delete/{id}", name="DeleteMember")
    */
    public function deleteM($id,Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $e=$this->getDoctrine()->getRepository(employee::class)->find($id);
        
        $entityManager->remove($e);
        $entityManager->flush();
        return $this->redirectToRoute('membersAdmin', [
            'employee' => $e
        ]);
    }
    /**
    * @Route("/admin/companies/delete/{id}", name="DeleteCompany")
    */
    public function deleteC($id, Request $request, PaginatorInterface $paginator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $c=$this->getDoctrine()->getRepository(company::class)->find($id);
        $entityManager->remove($c);
        $entityManager->flush();
        return $this->redirectToRoute('companiesAdmin', [
            'company' => $c
        ]);
    }
    /**
    * @Route("/admin/jobs/delete/{id}", name="DeleteJob")
    */
    public function deleteJ($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $j=$this->getDoctrine()->getRepository(Job::class)->find($id);
        $entityManager->remove($j);
        $entityManager->flush();
        return $this->redirectToRoute('jobsAdmin', ['job' => $j]);
    }

    /**
    * @Route("/admin/subscribers/delete/{id}", name="DeleteSub")
    */
    public function deleteS($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $s=$this->getDoctrine()->getRepository(NewsLetter::class)->find($id);
        $entityManager->remove($s);
        $entityManager->flush();
        return $this->redirectToRoute('subscribersAdmin', ['s' => $s]);
    }
}
