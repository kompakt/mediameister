<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Core\Batch\Subscriber;

use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Generic\Logger\Handler\StreamHandlerFactoryInterface;
use Kompakt\Mediameister\Generic\Logger\LoggerInterface;
use Kompakt\Mediameister\Task\Core\Batch\EventNamesInterface;
use Kompakt\Mediameister\Task\Core\Batch\Event\PackshotErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TrackErrorEvent;

class ErrorLogger implements EventSubscriberInterface
{
    protected $eventNames = null;
    protected $logger = null;
    protected $streamHandlerFactory = null;

    public function __construct(
        EventNamesInterface $eventNames,
        LoggerInterface $logger,
        StreamHandlerFactoryInterface $streamHandlerFactory,
        $filename
    )
    {
        $this->eventNames = $eventNames;
        $this->logger = $logger;
        $this->streamHandlerFactory = $streamHandlerFactory;
        $this->filename = $filename;
    }

    public function getSubscriptions()
    {
        return array(
            $this->eventNames->taskRun() => array(
                array('onTaskRun', 0)
            ),
            $this->eventNames->taskRunError() => array(
                array('onTaskRunError', 0)
            ),
            $this->eventNames->taskEndError() => array(
                array('onTaskEndError', 0)
            ),
            $this->eventNames->packshotLoadError() => array(
                array('onPackshotLoadError', 0)
            ),
            $this->eventNames->packshotUnloadError() => array(
                array('onPackshotUnloadError', 0)
            ),
            $this->eventNames->trackError() => array(
                array('onTrackError', 0)
            )
        );
    }

    public function onTaskRun(TaskRunEvent $event)
    {
        $logfile = sprintf('%s/%s', $event->getBatch()->getDir(), $this->filename);
        $this->logger->pushHandler($this->streamHandlerFactory->getInstance($logfile));
    }

    public function onTaskRunError(TaskRunErrorEvent $event)
    {
        $this->logger->error($event->getException()->getMessage());
    }

    public function onTaskEndError(TaskEndErrorEvent $event)
    {
        $this->logger->error($event->getException()->getMessage());
    }

    public function onPackshotLoadError(PackshotErrorEvent $event)
    {
        $this->logger->error(
            sprintf(
                '%s: "%s"',
                $event->getPackshot()->getName(),
                $event->getException()->getMessage()
            )
        );
    }

    public function onPackshotUnloadError(PackshotErrorEvent $event)
    {
        $this->logger->error(
            sprintf(
                '%s: "%s"',
                $event->getPackshot()->getName(),
                $event->getException()->getMessage()
            )
        );
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $this->logger->error(
            sprintf(
                '%s (track): "%s"',
                $event->getPackshot()->getName(),
                $event->getException()->getMessage()
            )
        );
    }
}