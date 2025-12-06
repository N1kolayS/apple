<?php

namespace common\interfaces;

/**
 * Интерфейс для описания состояний яблока
 */
interface StateInterface
{

    public function fall(): void;
    public function eat(int $percent): void;

    /**
     * Проверить (Пересчитать) состояние фрукта
     * @return void
     */
    public function checkCondition(): void;
    public function canEat(): bool;
    public function getStatus(): string;
}