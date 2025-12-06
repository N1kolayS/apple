<?php

namespace common\states;

use common\helpers\Status;
use Exception;

class EatenState extends BaseAppleState
{
    public function fall(): void
    {
        throw new Exception('Яблоко уже съедено');
    }

    public function eat(int $percent): void
    {
        throw new Exception('Яблоко уже съедено');
    }

    public function checkCondition(): void
    {
        // Ничего не делаем
    }

    public function canEat(): bool
    {
        return false;
    }

    public function getStatus(): string
    {
        return Status::EATEN;
    }

    public function getImage(): string
    {
        return 'blank';
    }
}