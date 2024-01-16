<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\String\u;

/**
 * Description of VinylController
 *
 * @author user
 */
class VinylController
{
    #[Route('/')]
    public function index(): Response
    {
        return new Response('Title: Tralala.');
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
