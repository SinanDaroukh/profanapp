<?php


namespace App\Listener;


use App\Entity\Medium;
use App\Entity\Support;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{


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
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;

    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if ( !$entity instanceof Support){
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity,'imagefile'));
    }

    public function preUpdate(PreUpdateEventArgs $args){
       $entity = $args->getEntity();
       if ( !$entity instanceof Support){
           return;
       }
       if ( $entity->getImagefile() instanceof UploadedFile){
           $this->cacheManager->remove($this->uploaderHelper->asset($entity,'imagefile'));
       }
    }
}