<?php

namespace C33s\SimpleGalleryBundle\Model;

use C33s\SimpleGalleryBundle\Model\om\BaseGallery;
use C33s\AttachmentBundle\Collection\UploadCollection;
use C33s\AttachmentBundle\Model\Attachment;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;

class Gallery extends BaseGallery
{
    protected $itemsCollection;
    protected $newImagesDirectory;

    public function getItemsCollection()
    {
        if (null === $this->itemsCollection)
        {
            $items = GalleryItemQuery::create()
                ->filterByGallery($this)
                ->orderBySortableRank()
                ->find()
            ;
            $this->itemsCollection = new UploadCollection($items->getArrayCopy());
            $this->itemsCollection->setModel('C33s\\SimpleGalleryBundle\\Model\\GalleryItem');
        }

        return $this->itemsCollection;
    }

    public function setItemsCollection(UploadCollection $galleryItems)
    {
        return $this->setGalleryItems($galleryItems);
    }

    public function getGalleryItems($criteria = null, \PropelPDO $con = null)
    {
        $c = GalleryItemQuery::create()
            ->orderBySortableRank()
        ;

        return parent::getGalleryItems($c, $con);
    }

    /**
     * Set images to load during postSave().
     *
     * @param string    $directory
     *
     * @return Gallery
     */
    public function setImagesLoadFromDirectory($directory)
    {
        $this->newImagesDirectory = $directory;

        return $this;
    }

    /**
     * Process any attachment files that have been set but not attached yet.
     */
    protected function processNewUnsavedFiles(\PropelPDO $con = null)
    {
        parent::processNewUnsavedFiles($con);

        if (null !== $this->newImagesDirectory)
        {
            $finder = Finder::create()
                ->ignoreDotFiles(true)
                ->files()
                ->sortByType()
                ->depth(0)
                ->in($this->newImagesDirectory)
            ;

            foreach ($finder as $file)
            {
                $item = new GalleryItem();

                /* @var $file SplFileInfo */
                $item
                    ->setTitle($file->getBasename('.'.$file->getExtension()))
                    ->setGallery($this)
                    ->setImageFilePath($file->getRealPath())
                ;
            }

            $this->newImagesDirectory = null;

            $this->save($con);
        }

        return $this;
    }
}
