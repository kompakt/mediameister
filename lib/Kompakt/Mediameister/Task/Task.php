<?php

/*
 * This file is part of the kompakt/mediameister package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task;

use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\DropDir\Registry\RegistryInterface;
use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Task\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Task\Tracer\EventNamesInterface;
use Kompakt\Mediameister\Task\Tracer\Event\InputErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\InputOkEvent;
use Kompakt\Mediameister\Task\Tracer\Event\TaskEndEvent;
use Kompakt\Mediameister\Timer\Timer;

class Task
{
    protected $dispatcher = null;
    protected $eventNames = null;
    protected $dropDirRegistry = null;
    protected $requireTargetDropDir = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        EventNamesInterface $eventNames,
        RegistryInterface $dropDirRegistry,
        $requireTargetDropDir = true

    )
    {
        $this->dispatcher = $dispatcher;
        $this->eventNames = $eventNames;
        $this->dropDirRegistry = $dropDirRegistry;
        $this->requireTargetDropDir = (bool) $requireTargetDropDir;
    }

    public function run($sourceDropDirLabel, $sourceBatchName, $targetDropDirLabel = null)
    {
        $timer = new Timer();
        $timer->start();

        if (function_exists('pcntl_signal'))
        {
            $handleSig = function() use ($timer)
            {
                $this->dispatcher->dispatch(
                    $this->eventNames->taskEnd(),
                    new TaskEndEvent($timer->stop())
                );
            };

            pcntl_signal(SIGTERM, $handleSig);
        }

        try {
            $sourceDropDir = $this->dropDirRegistry->get($sourceDropDirLabel);

            if (!$sourceDropDir)
            {
                throw new InvalidArgumentException(sprintf('Source drop dir "%s" not found', $sourceDropDirLabel));
            }

            $sourceBatch = $sourceDropDir->getBatch($sourceBatchName);

            if (!$sourceBatch)
            {
                throw new InvalidArgumentException(sprintf('Source batch "%s" not found', $sourceBatchName));
            }

            $targetDropDir = $this->dropDirRegistry->get($targetDropDirLabel);

            if (!$targetDropDir && $this->requireTargetDropDir)
            {
                throw new InvalidArgumentException(sprintf('Target drop dir "%s" not found', $targetDropDirLabel));
            }

            $this->dispatcher->dispatch(
                $this->eventNames->inputOk(),
                new InputOkEvent($sourceBatch, $targetDropDir)
            );
        }
        catch (\Exception $e)
        {
            $this->dispatcher->dispatch(
                $this->eventNames->inputError(),
                new InputErrorEvent($e)
            );
        }

        $this->dispatcher->dispatch(
            $this->eventNames->taskEnd(),
            new TaskEndEvent($timer->stop())
        );
    }
}