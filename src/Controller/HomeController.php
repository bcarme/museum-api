<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ApiService;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ApiService $apiService)
    {
        $department = $apiService->findDepartment();
        return $this->render('home/index.html.twig', [
            'department'=>$department
        ]);
    }show

    /**
     * @Route("/", name="home")
     */
    public function show(ApiService $apiService)
    {
        $department = $apiService->findDepartment();
        return $this->render('home/index.html.twig', [
            'department'=>$department
        ]);
    }
}
