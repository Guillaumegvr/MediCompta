<?php

namespace App\EventSubscriber; //

use App\Repository\RemplacementRepository;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RemplacementRepository $remplacementRepository,
        private readonly UrlGeneratorInterface $router
    ) {}

    public static function getSubscribedEvents()
    {
        return [
            SetDataEvent::class => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(SetDataEvent $setDataEvent)
    {
        $start = $setDataEvent->getStart();
        $end = $setDataEvent->getEnd();
        $filters = $setDataEvent->getFilters();

        $remplacements = $this->remplacementRepository
            ->createQueryBuilder('remplacement')
            ->where('remplacement.beginAt BETWEEN :start and :end OR remplacement.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($remplacements as $remplacement) {
            $remplacementEvent = new CelendarEvent(
                $remplacement->getTitle(),
                $remplacement->getBeginAt(),
                $remplacement->getEndAt()
            );

            $remplacementEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $remplacementEvent->addOption(
                'url',
                $this->router->generate('app_remplacement_show', [
                    'id' => $remplacement->getId(),
                ])
            );

            $setDataEvent->addEvent($remplacementEvent);
        }
    }
}
