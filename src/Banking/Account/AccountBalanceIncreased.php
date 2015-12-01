<?php

namespace Depot\Testing\Fixtures\Banking\Account;

class AccountBalanceIncreased
{
    /**
     * @var string
     */
    public $accountId;

    /**
     * @var int
     */
    public $amount;

    public function __construct($accountId, $amount)
    {
        $this->accountId = $accountId;
        $this->amount = $amount;
    }
}
