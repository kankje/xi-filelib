<?php

namespace Xi\Tests\Filelib\Queue;

use Xi\Filelib\FileLibrary;

use Xi\Filelib\Queue\Queue;
use Xi\Filelib\Queue\Message;
use Xi\Tests\Filelib\Queue\Processor\TestCommand;

abstract class TestCase extends \Xi\Tests\TestCase
{
    /**
     *
     * @var Queue
     */
    protected $queue;

    protected $message;


    public function setUp()
    {
        $this->message = new TestCommand();

        $this->queue = $this->getQueue();
    }


    abstract protected function getQueue();


    /**
     * @test
     * @return Queue
     */
    public function enqueueShouldEnqueueMessage()
    {
        $this->queue->enqueue($this->message);

        return $this->queue;
    }

    /**
     * @test
     * @depends enqueueShouldEnqueueMessage
     * @param type $queue
     */
    public function dequeueShouldDequeueMessage($queue)
    {
        $message = $queue->dequeue();
        $queue->ack($message);

        $this->assertEquals($this->message, unserialize($message->getBody()));
        $this->assertNotNull($message->getIdentifier());

        return $queue;
    }

    /**
     * @xxxtest
     */
    public function dequeueShouldReturnNullIfQueueIsEmpty()
    {
        $message = $this->queue->dequeue();
        $this->assertNull($message);
    }


    /**
     * @test
     * @depends dequeueShouldDequeueMessage
     */
    public function purgeShouldResultInAnEmptyQueue($queue)
    {
        for ($x = 10; $x <= 10; $x++) {
            $queue->enqueue(new TestCommand());
        }

        $msg = $queue->dequeue();
        $this->assertNotNull($msg);
        $queue->ack($msg);


        $queue->purge();

        $this->assertNull($queue->dequeue());

    }



   /**
     * @test
     */
    public function queueShouldResendIfMessageIsNotAcked()
    {
        $queue = $this->getQueue();
        $queue->purge();

        $this->assertNull($queue->dequeue());

        $message = new TestCommand();
        $queue->enqueue($message);

        $this->assertInstanceOf('Xi\Filelib\Queue\Message', $queue->dequeue());
        $this->assertNull($queue->dequeue());

        unset($queue);
        gc_collect_cycles();

        $queue = $this->getQueue();

        $msg = $queue->dequeue();
        $this->assertInstanceOf('Xi\Filelib\Queue\Message', $msg);

        $queue->ack($msg);

    }








}