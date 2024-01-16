<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\String\u;

/**
 * Description of VinylController
 *
 * @author user
 */
class VinylController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        $tracks = [
            ['song'=>'Creep', 'artist'=>'Radiohead'],
            ['song'=>'Wateffalls', 'artist'=>'TLC'],
        ];
        
        return $this->render('vinyl/homepage.html.twig', [
            'title'=>'PB & Jams',
            'tracks'=>$tracks
        ]);
    }
    
    #[Route('/browse/{slug}')]
    public function browse(string $slug = ''): Response
    {
        if ($slug) {
            $title = 'Genre: '.u(str_replace('-', ' ', $slug))->title(true).'.';
        } else {
            $title = 'All Genres.';
        }
        
        return new Response($title);
    }
}
