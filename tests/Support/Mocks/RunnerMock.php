<?php

namespace Tests\Support\Mocks;

use Acf\Fluent\Runner;

class RunnerMock extends Runner
{
    public function __construct()
    {
        parent::__construct(new BehaviorMock);
    }
}
