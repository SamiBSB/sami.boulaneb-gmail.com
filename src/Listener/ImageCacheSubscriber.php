<?php

namespace App\Listener;


use App\Entity\Picture;
use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber{

    /**
     * @var CacheManager
     */
    private $cacheManager;
    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
{
    $this->cacheManager=$cacheManager;

    $this->uploaderHelper=$uploaderHelper;
}

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preUpdate(PreUpdateEventArgs $args){
        $entity=$args->getEntity();
if($entity instanceof Picture){
    return;
}
if($entity->getImageFile() instanceof UploaderHelper){
    $this->cacheManager->remove($this->uploaderHelper->asset($entity,'imageFile'));
}
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity=$args->getEntity();
        if($entity instanceof Picture){
            return;
        }
        if($entity->getImageFile() instanceof UploaderHelper){
            $this->cacheManager->remove($this->uploaderHelper->asset($entity,'imageFile'));
}
    }
}