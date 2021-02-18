<?php


namespace App\DataFixtures\services;


use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

class HandlerImages
{
    private $dirroot;

    public function __construct(KernelInterface $kernel)
    {
        $this->dirroot = $kernel->getProjectDir()."/public/images";
    }

    public function randamImages()
    {
        $finder = new Finder();
        $getpictures = $finder->files()->in($this->dirroot);

        foreach ($getpictures as $file)
        {
            $pictures[] = $file->getRelativePathname();
        }

        return $pictures[rand(0,count($pictures)-1)];
    }


}
