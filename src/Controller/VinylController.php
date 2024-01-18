<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Psr\Cache\CacheItemInterface;
use function Symfony\Component\String\u;

/**
 * Description of VinylController
 *
 * @author user
 */
class VinylController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];
        
        return $this->render('vinyl/homepage.html.twig', [
            'title'=>'PB & Jams',
            'tracks'=>$tracks
        ]);
    }
    
    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(HttpClientInterface $httpClient, CacheInterface $cache, string $slug = ''): Response
    {
        $genre = $slug ? 'Genre: '.u(str_replace('-', ' ', $slug))->title(true).'.' : '';
        $mixes = $cache->get('mixes_data', function (CacheItemInterface $cacheItem) use ($httpClient) {
            $cacheItem->expiresAfter(60 * 5);
            $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
            
            return $response->toArray();
        });

        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }
    
    private function getMixes(): array
    {
        return [
            [
                'title' => 'PB & James',
                'trackCount' => 14,
                'genre' => 'Rock',
                'createdAt' => new \DateTime('2021-10-02'),
            ],
            [
                'title' => 'Put a Hex on your Ex',
                'trackCount' => 8,
                'genre' => 'Heavy Metal',
                'createdAt' => new \DateTime('2021-10-02'),
            ],
            [
                'title' => 'Spice Grills - Summer Tunes',
                'trackCount' => 10,
                'genre' => 'Pop',
                'createdAt' => new \DateTime('2019-06-20'),
            ],
        ];
    }
}
