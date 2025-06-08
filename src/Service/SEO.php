<?php

namespace App\Service;


use Symfony\Component\String\Slugger\SluggerInterface;

class SEO
{
    public string $title;
    public string $description;
    public string $canonical;
    public string $ogLocale;
    public string $ogType;
    public string $ogTitle;
    public string $ogDescription;
    public string $ogUrl;
    public string $ogSiteName;
    public string $ogImageSecureUrl;
    public string $ogImageWidth;
    public string $ogImageHeight;

    public function __construct(protected SluggerInterface $slugger)
    {
        $this->ogLocale = 'en_US';
        $this->ogType = 'website';
        $this->ogSiteName = 'The Breathing Nook';
        $this->ogImageSecureUrl = '/seo.png';
        $this->ogImageWidth = '1620';
        $this->ogImageHeight = '1080';

        $this->description = 'Based in Chicago, The Breathing Nook is a Pranayama yoga studio focused on health and healing, offering private and small group breath work classes by a certified yoga and pranayama instructor. Virtual appointments available.';
    }


    public function home(): self
    {
        $this->title = 'The Breathing Nook | Home';
        $this->description = 'Based in Chicago, The Breathing Nook is a Pranayama yoga studio focused on health and healing, offering private and small group breath work classes by a certified yoga and pranayama instructor. Virtual appointments available.';
        $this->canonical = 'https://www.thebreathingnook.com';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;

        return $this;
    }


    public function about(): self
    {
        $this->title = 'The Breathing Nook | About Ashley';
        $this->description = 'Based in Chicago, The Breathing Nook is a Pranayama yoga studio focused on health and healing, offering private and small group breath work classes by a certified yoga and pranayama instructor. Virtual appointments available.';
        $this->canonical = 'https://www.thebreathingnoko.com';

        $this->ogTitle = $this->title;
        $this->ogDescription = $this->description;
        $this->ogUrl = $this->canonical;

        return $this;
    }
}
