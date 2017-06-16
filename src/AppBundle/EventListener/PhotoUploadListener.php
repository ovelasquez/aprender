<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\User;
use AppBundle\Entity\Courses;
use AppBundle\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

class PhotoUploadListener {

    private $uploader;

    public function __construct(FileUploader $uploader) {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        if ($entity instanceof User || $entity instanceof Courses) :
            $this->uploadFile($entity);
        endif;
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getEntity();

        if ($entity instanceof User || $entity instanceof Courses) :
            $this->uploadFile($entity);
        endif;
    }

    public function postLoad(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        if ($entity instanceof User || $entity instanceof Courses) :
            $fileName = $entity->getPhoto();            
            $entity->setPhoto(new File($fileName, false));
        endif;
    }

    private function uploadFile($entity) {
        // upload only works for User entities
        if (!$entity instanceof User && !$entity instanceof Courses) {
            return;
        }

        $file = $entity->getPhoto();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($file);
        
        $entity->setPhoto(new File($fileName, false));
    }

}
