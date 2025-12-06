<?php

namespace common\states;


use common\interfaces\StateInterface;
use common\models\Apple;

/**
 *
 */
abstract class BaseAppleState implements StateInterface
{
    protected Apple $apple;

    public function __construct(Apple $apple)
    {
        $this->apple = $apple;
    }

    abstract public function fall(): void;
    abstract public function eat(int $percent): void;
    abstract public function checkCondition(): void;
    abstract public function canEat(): bool;
    abstract public function getStatus(): string;
}