<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task\Core\Batch\Console\Subscriber;

use Kompakt\Mediameister\Generic\Console\Output\ConsoleOutputInterface;
use Kompakt\Mediameister\Generic\EventDispatcher\EventSubscriberInterface;
use Kompakt\Mediameister\Task\Core\Batch\EventNamesInterface;
use Kompakt\Mediameister\Task\Core\Batch\Event\PackshotErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\PackshotEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskEndErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskEndEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskRunErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TaskRunEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TrackErrorEvent;
use Kompakt\Mediameister\Task\Core\Batch\Event\TrackEvent;

class Debugger implements EventSubscriberInterface
{
    protected $eventNames = null;
    protected $output = null;

    public function __construct(
        EventNamesInterface $eventNames,
        ConsoleOutputInterface $output
    )
    {
        $this->eventNames = $eventNames;
        $this->output = $output;
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
            $this->eventNames->taskEnd() => array(
                array('onTaskEnd', 0)
            ),
            $this->eventNames->taskEndError() => array(
                array('onTaskEndError', 0)
            ),
            $this->eventNames->packshotLoad() => array(
                array('onPackshotLoad', 0)
            ),
            $this->eventNames->packshotLoadError() => array(
                array('onPackshotLoadError', 0)
            ),
            $this->eventNames->packshotUnload() => array(
                array('onPackshotUnload', 0)
            ),
            $this->eventNames->packshotUnloadError() => array(
                array('onPackshotUnloadError', 0)
            ),
            $this->eventNames->track() => array(
                array('onTrack', 0)
            ),
            $this->eventNames->trackError() => array(
                array('onTrackError', 0)
            )
        );
    }

    public function onTaskRun(TaskRunEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<info>+ DEBUG: Task run</info>'
            )
        );
    }

    public function onTaskRunError(TaskRunErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<error>+ DEBUG: Task run error %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onTaskEnd(TaskEndEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<info>+ DEBUG: Task end</info>'
            )
        );
    }

    public function onTaskEndError(TaskEndErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '<error>+ DEBUG: Task end error %s</error>',
                $event->getException()->getMessage()
            )
        );
    }

    public function onPackshotLoad(PackshotEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <info>+ DEBUG: Packshot load (%s)</info>',
                $event->getPackshot()->getName()
            )
        );
    }

    public function onPackshotLoadError(PackshotErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <error>! DEBUG: Packshot load error (%s): %s</error>',
                $event->getPackshot()->getName(),
                $event->getException()->getMessage()
            )
        );
    }

    public function onPackshotUnload(PackshotEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <info>+ DEBUG: Packshot unload (%s)</info>',
                $event->getPackshot()->getName()
            )
        );
    }

    public function onPackshotUnloadError(PackshotErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '  <error>! DEBUG: Packshot unload error (%s): %s</error>',
                $event->getPackshot()->getName(),
                $event->getException()->getMessage()
            )
        );
    }

    public function onTrack(TrackEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '    <info>+ DEBUG: Track</info>'
            )
        );
    }

    public function onTrackError(TrackErrorEvent $event)
    {
        $this->output->writeln(
            sprintf(
                '    <error>! DEBUG: Track error: %s</error>',
                $event->getException()->getMessage()
            )
        );
    }
}