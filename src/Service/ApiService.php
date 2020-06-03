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
//        names in array instead of api request for speed concern
        $metDepts =[
            0=>[
                'departmentId'=>"1",
                'displayName'=>"American Decorative Arts",
            ],
            1=>[
                'departmentId'=>"3",
                'displayName'=>"Ancient Near Eastern Art",
            ],
            2=>[
                'departmentId'=>"4",
                'displayName'=>"Arms and Armor",
            ],
            3=>[
                'departmentId'=>"5",
                'displayName'=>"Arts of Africa, Oceania, and the Americas",
            ],
            4=>[
                'departmentId'=>"6",
                'displayName'=>"Asian Art",
            ],
            5=>[
                'departmentId'=>"7",
                'displayName'=>"The Cloister",
            ],
            6=>[
                'departmentId'=>"8",
                'displayName'=>"TThe Costume Institute",
            ],
            7=>[
                'departmentId'=>"9",
                'displayName'=>"Drawings and Prints",
            ],
            8=>[
                'departmentId'=>"10",
                'displayName'=>"Egyptian Art",
            ],
            9=>[
                'departmentId'=>"11",
                'displayName'=>"European Paintings",
            ],
            10=>[
                'departmentId'=>"12",
                'displayName'=>"European Sculpture and Decorative Arts",
            ],
            11=>[
                'departmentId'=>"13",
                'displayName'=>"Greek and Roman Art",
            ],
            12=>[
                'departmentId'=>"14",
                'displayName'=>"Islamic Art",
            ],
            13=>[
                'departmentId'=>"15",
                'displayName'=>"The Robert Lehman Collection",
            ],
            14=>[
                'departmentId'=>"16",
                'displayName'=>"The Libraries",
            ],
            15=>[
                'departmentId'=>"17",
                'displayName'=>"Medieval Art",
            ],
            16=>[
                'departmentId'=>"18",
                'displayName'=>"Musical Instruments",
            ],
            17=>[
                'departmentId'=>"19",
                'displayName'=>"Photographs",
            ],
            18=>[
                'departmentId'=>"21",
                'displayName'=>"Modern Art",
            ],
        ];
        $keys = array_keys($metDepts);
        shuffle($keys);
        foreach($keys as $key) {
            $new[$key] = $metDepts[$key];
        }
        $metDepts = $new;

        return array_slice($metDepts, 0, 1);

//code working to get department names but not ids
/*      $client = HttpClient::create();
        $response = $client->request('GET', 'https://collectionapi.metmuseum.org/public/collection/v1/departments');
        $content = $response->toArray();

        for($i=0; $i<count($content['departments']); $i++){
            $departmentList[] = $content['departments'][$i]['displayName'];
            $department = array_rand(array_flip($departmentList), 1);
        }
        return $department;*/
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