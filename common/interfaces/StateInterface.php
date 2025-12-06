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

    public function canFall(): bool;
    public function getStatus(): string;

    /**
     * Изображение фрукта, в зависимости от состояния
     * @return string
     */
    public function getImage(): string;
}