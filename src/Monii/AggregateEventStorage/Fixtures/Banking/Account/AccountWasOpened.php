<?php

namespace Monii\AggregateEventStorage\Fixtures\Banking\Account;

class AccountWasOpened
{
    /**
     * @var string
     */
    public $accountId;

    /**
     * @var int
     */
    public $startingBalance;

    public function __construct($accountId, $startingBalance)
    {
        $this->accountId = $accountId;
        $this->startingBalance = $startingBalance;
    }
}
