<?php

namespace App\Listnner;

use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use \Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use \App\Entity\Property;
use \Doctrine\ORM\Event\LifecycleEventArgs;

class ImageCacheSubscriber implements EventSubscriber
{


    private $cachemanager;
    private $helper;
    public function __construct(CacheManager $cachemanager, UploaderHelper $helper)
    {
        $this->cachemanager = $cachemanager;
        $this->helper = $helper;
    }
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
         if( !$entity instanceof Property )
            return ;
        $this->cachemanager->remove( $this->helper->asset($entity,'imageFile'));
        
    //...
    }
    public function preUpdate(PreUpdateEventArgs  $args)
    {
        $entity = $args->getEntity();
         if( !$entity instanceof Property )
            return ;
       if( $entity->getImageFile() instanceof UploadedFile)
       {
            $this->cachemanager->remove( $this->helper->asset($entity,'imageFile'));
       }
        /* 
        dump($args);
        dump($args->getEntity());
        dump($args->getObject());*/
    }
    


}