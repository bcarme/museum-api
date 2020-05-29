<?php


namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class ApiService
{
    const MAX_ARTWORK = 15;
    const MIN_ARTWORK = 1;

    public function findDepartment()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://collectionapi.metmuseum.org/public/collection/v1/departments');
        $content = $response->toArray();

        for($i=0; $i<count($content); $i++){
            $departmentList[] = $content['departments'][$i]['displayName'];
            $department = array_rand(array_flip($departmentList), 1);
        }
        return $department;

    }

    public function findArtworksByDpt($id)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://collectionapi.metmuseum.org/public/collection/v1/search?departmentId=' .$id .'&q=cat');

        if($response->getStatusCode() === Response::HTTP_OK) {
            $apiArtworks = $response->toArray()['objectIDs'];

            if(!empty($apiArtworks) && count($apiArtworks) >= self::MIN_ARTWORK) {
                $randowKeys = array_rand($apiArtworks, self::MAX_ARTWORK);

                foreach ($randowKeys as $key) {
                    $artworkApiId = $apiArtworks[$key];
                    $artworks[] = $this->findArtwork($artworkApiId);
                }
            }
        }

        return $artworks ?? [];
     }

        public function findArtwork(int $id)
        {
            $client = HttpClient::create();
            $response = $client->request('GET', 'https://collectionapi.metmuseum.org/public/collection/v1/objects/'. $id);
            $apiArtwork = $response->toArray();

            return $apiArtwork;
        }


}