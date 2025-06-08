<?php

namespace App\Controller;

use App\Service\SEO;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct(protected SEO $seo)
    {
    }

    #[Route('/', name: 'home')]
    #[Template('home.html.twig')]
    public function index(): array
    {
        return [
            'seo' => $this->seo->home(),
        ];
    }

    #[Route('/about-ashley', name: 'about')]
    #[Template('about-ashley.html.twig')]
    public function about(): array
    {
        return [
            'seo' => $this->seo->about(),
        ];
    }
}
