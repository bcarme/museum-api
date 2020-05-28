<?php


namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class ApiService
{
    const MAX_ARTWORK = 20;
    const MIN_ARTWORK = 2;

    public function findDepartment()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://collectionapi.metmuseum.org/public/collection/v1/departments');
        $content = $response->toArray();

        for($i=0; $i<count($content['departments']); $i++){
            $departmentList[] = $content['departments'][$i]['displayName'];
            $department = array_rand(array_flip($departmentList), 1);
        }
        return $department;
    }

    public function findDptArtworks(int $id)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', self::API_URL . 'objects/' . $id);

        $apiArtwork = $response->toArray();

        return $apiArtwork;
    }


}