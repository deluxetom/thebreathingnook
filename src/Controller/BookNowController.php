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

class BookNowController extends AbstractController
{
    public function __construct(protected SEO $seo)
    {
    }

    #[Route('/consultation/{type<free|private>?free}', name: 'consultation')]
    #[Template('consultation.html.twig')]
    public function consultation(string $type): array
    {
        return [
            'seo'  => $this->seo->consultation(),
            'type' => $type,
        ];
    }
}
