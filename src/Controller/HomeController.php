<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ApiService;
use App\Service\Slug;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ApiService $apiService)
    {
        $department = $apiService->findDepartment();
        return $this->render('home/index.html.twig', [
            'department' => $department
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/show/{id<^[0-9-]+$>}", defaults={"id" = null}, name="show")
     */
    public function show(ApiService $apiService, $id):Response
    {
        $department = $apiService->findDepartment();
        $departmentObjects = $apiService->findArtworksByDpt($id);

        return $this->render('home/show.html.twig', [
            'departmentObjects'=>$departmentObjects,
            'department'=>$department
        ]);
    }
}
