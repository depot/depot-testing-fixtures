<?php

namespace Depot\Testing\Fixtures\Banking\Common;

use Depot\AggregateRoot\Support\AggregateRootEventStorage;

abstract class EventSourcedAggregate implements AggregateRootEventStorage
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

    public function clearAggregateChanges()
    {
        $this->committedEvents = array_merge(
            $this->committedEvents,
            $this->recordedEvents
        );
        $this->recordedEvents = [];
    }

    public function getAggregateChanges()
    {
        return $this->recordedEvents;
    }

    abstract public function getAggregateIdentity();

    public function getAggregateVersion()
    {
        return $this->playhead;
    }

    /**
     * @param array|BankingEventEnvelope[] $events
     *
     * @return void
     */
    public function reconstituteAggregateFrom(array $events)
    {
        foreach ($events as $event) {
            $this->playhead++;
            if (! $event instanceof BankingEventEnvelope) {
                throw new \InvalidArgumentException('Cannot reconstitute from an unexpected event type.');
            }

            $this->committedEvents[] = $event;

            $this->handle($event->getAggregateEvent());
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

    /**
     * @return static
     */
    public static function instantiateAggregateForReconstitution()
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
