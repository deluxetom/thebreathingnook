<?php

/*
 * Distribution and reproduction are prohibited.
 *
 * @package   thebreathingnook
 * @copyright Deluxetom 2025
 * @license   No License (Proprietary)
 */

namespace App\Controller;

use App\Service\SEO;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Yizack\InstagramFeed;

class IndexController extends AbstractController
{
    public function __construct(protected SEO $seo)
    {
    }

    #[Route('/', name: 'home')]
    #[Template('home.html.twig')]
    public function index(): array
    {
//        $feed = new InstagramFeed(
//            'IGAAfTnVKkdVNBZAE9YNF80TmUyZAzl2Qmt2NXYwUFVjTEdxSGtKbGZAWTjBvcUFXRlowNEQ3a2xvQWoxOXpLbzktdU0zZAnBMMmZAiWWt4c1dpeHl0XzB4aUxLS01HZA0lrNnZAXdlpTQjhreGRCVWp6bUpWNzByRlBSaVRsS1MzbmVWZAwZDZD' // Paste your long-lived-access-token here
//        );
//        $array = $feed->getFeed(['username', 'permalink', 'timestamp', 'caption', 'media_type', 'media_url', 'thumbnail_url']);

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

    #[Route('/contact', name: 'contact')]
    #[Template('contact.html.twig')]
    public function contact(): array
    {
        return [
            'seo' => $this->seo->contact(),
        ];
    }

    #[Route('/services', name: 'services')]
    #[Template('services.html.twig')]
    public function services(): array
    {
        return [
            'seo' => $this->seo->services(),
        ];
    }
}
