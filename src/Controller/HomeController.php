<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ApiService;
use App\Service\Slug;
use App\Service\Hashtag;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ApiService $apiService)
    {
        $departments = $apiService->findDepartment();
        return $this->render('home/index.html.twig', [
            'departments' => $departments,
        ]);
    }

    /**
     * @param int $id
     * @param string $string
     * @return Response
     * @Route("/show/{string}/{id<^[0-9-]+$>}", defaults={"id" = null}, name="show")
     */
    public function show(ApiService $apiService, Hashtag $hastag, $id, $string):Response
    {
        $departmentObjects = $apiService->findArtworksByDpt($id);
        $hash = $hastag->generateHashtag($string);
        return $this->render('home/show.html.twig', [
            'departmentObjects'=>$departmentObjects,
            'hash'=>$hash,
        ]);
    }
}
