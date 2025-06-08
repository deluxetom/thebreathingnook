<?php

/*
 * Distribution and reproduction are prohibited.
 *
 * @package   thebreathingnook
 * @copyright Deluxetom 2025
 * @license   No License (Proprietary)
 */

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
