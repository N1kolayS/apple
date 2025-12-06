<?php

namespace common\states;

use common\helpers\Status;
use Exception;

class RottenState extends BaseAppleState
{
    public function fall(): void
    {
        throw new Exception('Яблоко уже на земле и испортилось');
    }

    public function eat(int $percent): void
    {
        throw new Exception('Съесть нельзя, яблоко испортилось');
    }

    public function checkCondition(): void
    {
        // Уже испорчено, дальше состояние не меняется
    }

    public function canEat(): bool
    {
        return false;
    }

    public function getStatus(): string
    {
        return Status::ROTTEN;
    }

    public function getImage(): string
    {
        return 'rotten';
    }

    public function canFall(): bool
    {
        return false;
    }
}