<?php

namespace Xi\Filelib;

use Serializable;
use Xi\Filelib\Queue\Enqueueable;

interface Command extends Enqueueable, Serializable
{

    const STRATEGY_SYNCHRONOUS = 'sync';
    const STRATEGY_ASYNCHRONOUS = 'async';

    public function execute();

}
