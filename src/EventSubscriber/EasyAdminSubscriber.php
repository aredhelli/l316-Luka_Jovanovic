<?php

namespace App\EventSubscriber;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private SluggerInterface $slugger
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'setSlug',
            BeforeEntityUpdatedEvent::class   => 'setSlug',
        ];
    }

    public function setSlug(object $event): void
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Post) {
            return;
        }

        $slug = $this->slugger
            ->slug($entity->getTitle())
            ->lower();

        $entity->setSlug($slug);
    }
}

