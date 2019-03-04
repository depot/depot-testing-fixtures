<?php

namespace Depot\Testing\Fixtures\Banking\Common;

use DateTimeImmutable;
use Depot\AggregateRoot\Support\ChangeReading\AggregateRootChangeReading;

class BankingEventEnvelope implements AggregateRootChangeReading
{
    /**
     * @var object
     */
    public $event;

    /**
     * @var null
     */
    public $metadata;

    /**
     * @var string
     */
    public $eventId;

    /**
     * @var DateTimeImmutable
     */
    public $when;

    /**
     * @var int
     */
    public $version;

    private function __construct($eventId, $event, $when = null, $metadata = null, $version = null)
    {
        $this->eventId = $eventId;
        $this->event = $event;
        $this->when = (is_null($when)) ? new DateTimeImmutable('now') : $when;
        $this->metadata = $metadata;
        $this->version = null;
    }

    public static function create($eventId, $event, $when = null, $metadata = null, $version = null)
    {
        return new self($eventId, $event, $when, $metadata, $version);
    }

    public static function instantiateAggregateChangeFromEventAndMetadata(
        $eventId,
        $event,
        $when = null,
        $metadata = null,
        $version = null
    )
    {
        return new self($eventId, $event, $when, $metadata, $version);
    }

    /**
     * @return object
     */
    public function getAggregateEvent()
    {
        return $this->event;
    }

    /**
     * @return object
     */
    public function getAggregateMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return object
     */
    public function getCanReadAggregateEventId()
    {
        return true;
    }

    /**
     * @return object
     */
    public function getAggregateEventId()
    {
        return $this->eventId;
    }

    /**
     * @return bool
     */
    public function getCanReadAggregateEventVersion()
    {
        return true;
    }

    /**
     * @return object
     */
    public function getAggregateEventVersion()
    {
        return $this->version;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getAggregateEventWhen()
    {
        return $this->when;
    }

    public function withWhen(\DateTimeImmutable $when)
    {
        $instance = clone($this);
        $instance->when = $when;

        return $instance;
    }
}
