<?php

/*
 * This file is part of the kompakt/release-batch-tasks package.
 *
 * (c) Christian Hoegl <chrigu@sirprize.me>
 *
 */

namespace Kompakt\Mediameister\Task;

use Kompakt\Mediameister\DropDir\DropDirInterface;
use Kompakt\Mediameister\DropDir\Registry\RegistryInterface;
use Kompakt\Mediameister\EventDispatcher\EventDispatcherInterface;
use Kompakt\Mediameister\Task\Exception\InvalidArgumentException;
use Kompakt\Mediameister\Task\Tracer\Event\Events as TaskEvents;
use Kompakt\Mediameister\Task\Tracer\Event\InputErrorEvent;
use Kompakt\Mediameister\Task\Tracer\Event\InputOkEvent;

class Task
{
    protected $dispatcher = null;
    protected $dropDirRegistry = null;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        RegistryInterface $dropDirRegistry
    )
    {
        $this->dispatcher = $dispatcher;
        $this->dropDirRegistry = $dropDirRegistry;
    }

    public function start($sourceDropDirLabel, $sourceBatchName, $targetDropDirLabel)
    {
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

            if (!$targetDropDir)
            {
                throw new InvalidArgumentException(sprintf('Target drop dir "%s" not found', $targetDropDirLabel));
            }

            $event = new InputOkEvent($sourceBatch, $targetDropDir);
            $this->dispatcher->dispatch(TaskEvents::INPUT_OK, $event);
        }
        catch (\Exception $e)
        {
            $event = new InputErrorEvent($e);
            $this->dispatcher->dispatch(TaskEvents::INPUT_ERROR, $event);
        }
    }
}