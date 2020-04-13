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
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/adminIndex.html.twig', [
            'controller_name' => 'AdminController',
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
}
