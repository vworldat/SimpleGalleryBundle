<?php

namespace c33s\SimpleGalleryBundle\Twig\Extension;

use C33s\SimpleGalleryBundle\Model\GalleryQuery;
class GalleryExtension extends \Twig_Extension
{
    /**
     * Create a new GalleryExtension instance.
     */
    public function __construct()
    {
    }
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('single_gallery', array($this, 'getGallery')),
            new \Twig_SimpleFunction('listed_galleries', array($this, 'getListedGalleries')),
        );
    }
    
    public function getGallery($name)
    {
        return GalleryQuery::create()
            ->filterBySlug($name)
            ->findOne()
        ;
    }
    
    public function getListedGalleries()
    {
        return GalleryQuery::create()
            ->filterByIsListed(true)
            ->orderBySortableRank()
            ->find()
        ;
    }
    
    public function getName()
    {
        return 'c33s_gallery';
    }
}
