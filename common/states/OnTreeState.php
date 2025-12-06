<?php

namespace common\states;

use common\helpers\Status;
use Exception;

class OnTreeState extends BaseAppleState
{
    public function fall(): void
    {
        $this->apple->fall_date = time();
        $this->apple->status = Status::ON_GROUND;
        $this->apple->save(false);
    }

    public function eat(int $percent): void
    {
        throw new Exception('Съесть нельзя, яблоко на дереве');
    }

    public function checkCondition(): void
    {
        // На дереве не портится
    }

    public function canEat(): bool
    {
        return false;
    }

    public function getStatus(): string
    {
        return Status::ON_TREE;
    }

    public function failToGround(): void
    {
        $this->apple->failToGround();
    }

    public function remove(): void
    {
        $this->apple->remove();
    }

    public function isRotten(): bool
    {
        return false;
    }
}