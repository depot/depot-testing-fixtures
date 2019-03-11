<?php

namespace Depot\Testing\Fixtures\Banking\Common;

use Depot\AggregateRoot\Support\AggregateRoot\AggregateRoot;

abstract class EventSourcedAggregateRoot implements AggregateRoot
{
    /**
     * @var array
     */
    private $recordedEvents = [];

    /**
     * @var array
     */
    private $handledEvents = [];

    /**
     * @var array
     */
    private $committedEvents = [];

    /**
     * @var int
     */
    private $playhead = -1;

    protected function __construct()
    {
    }

    protected function recordEvent($eventId, $event)
    {
        $this->playhead++;
        $this->recordedEvents[] = BankingEventEnvelope::create($eventId, $event);
        $this->handle($event);
    }

    public function clearAggregateRootChanges()
    {
        $this->committedEvents = array_merge(
            $this->committedEvents,
            $this->recordedEvents
        );
        $this->recordedEvents = [];
    }

    public function getAggregateRootChanges()
    {
        return $this->recordedEvents;
    }

    abstract public function getAggregateRootIdentity();

    public function getAggregateRootVersion()
    {
        return $this->playhead;
    }

    public function reconstituteAggregateRootFrom(array $events)
    {
        foreach ($events as $event) {
            $this->playhead++;
            if (! $event instanceof BankingEventEnvelope) {
                throw new \InvalidArgumentException('Cannot reconstitute from an unexpected event type.');
            }

            $this->committedEvents[] = $event;

            $this->handle($event->getAggregateRootEvent());
        }
    }

    protected function handle($event)
    {
        $method = $this->getHandleMethod($event);
        if (! method_exists($this, $method)) {
            return;
        }
        $this->$method($event, $event);
        $this->handledEvents[] = $event;
    }

    private function getHandleMethod($event)
    {
        $classParts = explode('\\', get_class($event));
        return 'apply' . end($classParts);
    }

    public static function instantiateAggregateRootForReconstitution()
    {
        return new static();
    }

    public function getHandledEvents()
    {
        return $this->handledEvents;
    }

    public function getCommittedEvents()
    {
        return $this->committedEvents;
    }
}
