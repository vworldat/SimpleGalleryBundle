<?php

namespace C33s\SimpleGalleryBundle\Form\Type\GalleryItem;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden', array(
            'required' => true,
        ));

        $builder->add('title', 'text', array(
            'required' => false,
        ));

        $builder->add('description', 'textarea', array(
            'required' => false,
        ));

        $builder->add('sortableRank', 'hidden', array(
            'required' => false,
        ));

        $builder->add('isListed', 'checkbox', array(
            'required' => false,
        ));
    }

    public function getName()
    {
        return 'c33s_gallery_upload';
    }
}
