<?php

namespace Monii\AggregateEventStorage\EventStore\Persistence;

use Monii\AggregateEventStorage\EventStore\EventEnvelope;
use Monii\AggregateEventStorage\Fixtures\Banking\Account\AccountWasOpened;
use Monii\AggregateEventStorage\Fixtures\Banking\Account\AccountBalanceIncreased;
use Monii\AggregateEventStorage\Fixtures\Banking\Account\AccountBalanceDecreased;
use Monii\AggregateEventStorage\EventStore\Persistence\Persistence;
use Monii\AggregateEventStorage\Contract\SimplePhpFqcnContractResolver;
use PHPUnit_Framework_TestCase as TestCase;

abstract class PersistenceTest extends TestCase
{
    /**
     * @var ContractResolver
     */
    private $contractResolver;

    /**
     * @var array
     */
    private $fixtures;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures($this->createPersistence());
    }

    private function setUpContractResolver()
    {
        $this->contractResolver = new SimplePhpFqcnContractResolver();
    }

    /**
     * Create a persistence instance.
     *
     * For persistence implementations that are query based (basically
     * anything not InMemoryPersistence) each call to this method
     * should return a brand new instance. This will allow for
     * creation of fixtures using one persistence and then
     * any additional work can be done in a state-free
     * environment.
     *
     * @return Persistence
     */
    abstract protected function createPersistence();

    protected function createEventEnvelope($eventId, $event)
    {
        return new EventEnvelope(
            $this->contractResolver->resolveFromObject($event),
            $eventId,
            $event
        );
    }

    protected function loadFixtures()
    {
        // create a known set of data
        $this->fixtures = array(
            $this->createEventEnvelope(
                123,
                new AccountWasOpened('fixture-account-000', 25)
            ),
            $this->createEventEnvelope(
                124,
                new AccountWasOpened('fixture-account-001', 45)
            ),
            $this->createEventEnvelope(
                125,
                new AccountBalanceIncreased('fixture-account-000', 105)
            ),
            $this->createEventEnvelope(
                126,
                new AccountBalanceIncreased('fixture-account-001', 10)
            ),
            $this->createEventEnvelope(
                127,
                new AccountBalanceDecreased('fixture-account-000', 50)
            )
        );
    }

    public function testFetch(Persistence $persistence)
    {
        $this->loadFixtures();

        // Do we need to create a mock object here?
        //$persistence->fetch();
    }

    public function testCommit(Persistence $persistence)
    {
        $this->loadFixtures();

        // Do we need to create a mock object here?
        //$persistence->commit($commitId);
    }
}