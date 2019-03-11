<?php

namespace Depot\Testing\Fixtures\Banking\Account;

use Depot\Testing\Fixtures\Banking\Common\EventSourcedAggregateRoot;

class Account extends EventSourcedAggregateRoot
{
    /**
     * @var string
     */
    private $accountId;

    /**
     * @var int
     */
    private $balance = 0;

    public static function open($eventId, $accountId, $startingBalance = 0)
    {
        $account = new static();
        $account->recordEvent($eventId, new AccountWasOpened($accountId, $startingBalance));

        return $account;
    }

    public function increaseBalance($eventId, $amount)
    {
        $this->recordEvent($eventId, new AccountBalanceIncreased($this->accountId, $amount));
    }

    public function decreaseBalance($eventId, $amount)
    {
        $this->recordEvent($eventId, new AccountBalanceDecreased($this->accountId, $amount));
    }

    protected function applyAccountWasOpened(AccountWasOpened $event)
    {
        $this->accountId = $event->accountId;
        $this->balance = $event->startingBalance;
    }

    protected function applyAccountBalanceIncreased(AccountBalanceIncreased $event)
    {
        $this->balance += $event->amount;
    }

    protected function applyAccountBalanceDecreased(AccountBalanceDecreased $event)
    {
        $this->balance -= $event->amount;
    }

    /**
     * @return string
     */
    public function getAggregateRootIdentity()
    {
        return $this->accountId;
    }

}
