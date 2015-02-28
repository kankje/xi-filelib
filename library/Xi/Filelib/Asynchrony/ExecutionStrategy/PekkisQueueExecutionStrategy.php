<?php

/**
 * This file is part of the Xi Filelib package.
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xi\Filelib\Asynchrony\ExecutionStrategy;

use Pekkis\Queue\Adapter\Adapter;
use Pekkis\Queue\Message;
use Pekkis\Queue\Queue;
use Pekkis\Queue\SymfonyBridge\EventDispatchingQueue;
use Xi\Filelib\Asynchrony\ExecutionStrategies;
use Xi\Filelib\Asynchrony\Serializer\AsynchronyDataSerializer;
use Xi\Filelib\Asynchrony\Serializer\SerializedCallback;
use Xi\Filelib\FileLibrary;

class PekkisQueueExecutionStrategy implements ExecutionStrategy
{
    /**
     * @var EventDispatchingQueue
     */
    private $queue;

    /**
     * @param EventDispatchingQueue $queue
     */
    public function __construct(Adapter $adapter, FileLibrary $filelib)
    {
        $queue = new Queue($adapter);
        $queue->addDataSerializer(
            new AsynchronyDataSerializer($filelib)
        );

        $this->queue = new EventDispatchingQueue(
            $queue,
            $filelib->getEventDispatcher()
        );
    }

    /**
     * @return EventDispatchingQueue
     */
    public function getQueue()
    {
        return $this->queue;
    }


    public function getIdentifier()
    {
        return ExecutionStrategies::STRATEGY_ASYNC_PEKKIS_QUEUE;
    }

    /**
     * @param callable $callback
     * @param array $params
     * @return Message
     */
    public function execute(callable $callback, $params = [])
    {
        $command = new SerializedCallback(
            $callback,
            $params
        );

        return $this->queue->enqueue('xi_filelib.asynchrony.command', $command);
    }
}
