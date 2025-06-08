<?php

/*
 * Distribution and reproduction are prohibited.
 *
 * @package   thebreathingnook
 * @copyright Deluxetom 2025
 * @license   No License (Proprietary)
 */

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.{_format}', name: 'sitemap', methods: ['GET'], stateless: true)]
    #[Template('sitemap.xml.twig')]
    public function sitemap(): array
    {
        $links = [];

        $links[] = [
            'loc'        => 'https://www.thebreathingnook.com',
            'updated'    => '2025-06-07',
            'changefreq' => 'daily',
            'priority'   => '1.0',
        ];

        $links[] = [
            'loc'        => 'https://www.thebreathingnook.com/about-ashley',
            'updated'    => '2025-06-07',
            'changefreq' => 'yearly',
            'priority'   => '0.75',
        ];

        return ['links' => $links];
    }
}
