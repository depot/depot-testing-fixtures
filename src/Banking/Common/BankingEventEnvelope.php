<?php

namespace Depot\Testing\Fixtures\Banking\Common;

use DateTimeImmutable;
use Depot\AggregateRoot\Support\Change\Change;

class BankingEventEnvelope implements Change
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

    public static function instantiateChangeFromEventAndMetadata(
        $eventId,
        $event,
        $when = null,
        $metadata = null,
        $version = null
    )
    {
        return new self($eventId, $event, $when, $metadata, $version);
    }

    public function getAggregateRootEvent()
    {
        return $this->event;
    }

    public function getAggregateRootMetadata()
    {
        return $this->metadata;
    }

    public function getCanReadAggregateRootEventId()
    {
        return true;
    }

    public function getAggregateRootEventId()
    {
        return $this->eventId;
    }

    public function getCanReadAggregateRootEventVersion()
    {
        return true;
    }

    public function getAggregateRootEventVersion()
    {
        return $this->version;
    }

    public function getAggregateRootEventWhen()
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
