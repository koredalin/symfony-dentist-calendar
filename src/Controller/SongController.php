<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
//use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of SongController
 *
 * @author user
 */
class SongController extends AbstractController
{
    #[Route('/api/songs/{id<\d+>}', methods: 'GET', name: 'api_songs_get_one')]
    public function getSong(int $id, LoggerInterface $logger): Response
    {
        // TODO query the database
        $song = [
            'id' => $id,
            'name' => 'Waterfalls',
            'url' => 'https://symfonycasts.s3.amazonaws.com/sample.mp3',
        ];
        
        $logger->info('Returning API response for song {song}', [
            'song' => $id,
        ]);

        return $this->json($song);
    }
}
