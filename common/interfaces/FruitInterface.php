<?php

namespace common\interfaces;

/**
 * Общий интерфейс, с возможностями реализуемыми фруктами (яблоком)
 */
interface FruitInterface
{

    public function eat(int $percent): void;

    /**
     * Упасть на землю
     * @return void
     */
    public function failToGround(): void;

    /**
     * Удалить
     * @return void
     */
    public function remove(): void;

    /**
     * Проверяет, испортилось ли яблоко
     */
    public function isRotten(): bool;

    /**
     * Проверяет, можно ли съесть яблоко
     */
    public function canEat(): bool;

    /**
     * Проверяет, может ли упасть
     * @return bool
     */
    public function canFall(): bool;

    /**
     * Изображение фрукта
     * @return string
     */
    public function getImage(): string;
}