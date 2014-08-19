<?php

namespace C33s\SimpleGalleryBundle\Model;

use C33s\SimpleGalleryBundle\Model\om\BaseGalleryItem;
use Avocode\FormExtensionsBundle\Form\Model\UploadCollectionFileInterface;
use Symfony\Component\HttpFoundation\File\File;

class GalleryItem extends BaseGalleryItem implements UploadCollectionFileInterface
{
    /**
     * Return file size in bytes
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->getImageFile()->getSize();
    }
    
    /**
     * Set governing entity (Gallery object)
     *
     * @var $parent Governing entity
    */
    public function setParent($parent)
    {
        return $this->setGallery($parent);
    }
    
    /**
     * Set uploaded file
     *
     * @var $file Uploaded file
    */
    public function setFile(File $file)
    {
        return $this->setImageFile($file);
    }
    
    /**
     * Get file
     *
     * @return Symfony\Component\HttpFoundation\File\File
    */
    public function getFile()
    {
        return $this->getImageFile();
    }
    
    /**
     * Get file web path (used by upload form types)
     *
     * @return string
    */
    public function getFileWebPath()
    {
        return $this->getImageFileWebPath();
    }
    
    /**
     * Return true if file thumbnail should be generated
     *
     * @return boolean
    */
    public function getPreview()
    {
        return true;
    }
    
    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $keys = parent::__sleep();
        
        if(($key = array_search('aNewImageFile', $keys)) !== false) {
            unset($keys[$key]);
        }
        
        return $keys;
    }
}
