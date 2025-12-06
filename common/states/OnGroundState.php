<?php

namespace common\states;

use common\helpers\Status;
use common\models\Apple;
use Exception;

class OnGroundState extends BaseAppleState
{

    public function fall(): void
    {
        throw new Exception('Яблоко уже на земле');
    }

    /**
     * @param int $percent
     * @return void
     * @throws \Throwable
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function eat(int $percent): void
    {
        if ($percent <= 0 || $percent > 100) {
            throw new Exception('Процент должен быть от 0 до 100');
        }

        $this->checkCondition();

        if ($this->apple->isRotten()) {
            throw new Exception('Съесть нельзя, яблоко испортилось');
        }

        $newSize = $this->apple->size - $percent;

        if ($newSize <= 0) {
            $this->apple->status = Status::EATEN;
            $this->apple->size = 0;
            $this->apple->save(false);
            $this->apple->remove();
        } else {
            $this->apple->size = $newSize;
            $this->apple->save(false);
        }
    }

    /**
     * @return void
     * @throws \yii\db\Exception
     */
    public function checkCondition(): void
    {
        if (!$this->apple->fall_date) {
            return;
        }

        $hoursOnGround = (time() - $this->apple->fall_date) / 3600;

        if ($hoursOnGround >= Apple::ROTTEN_HOURS) {
            $this->apple->status = Status::ROTTEN;
            $this->apple->save(false);
        }
    }

    public function canEat(): bool
    {
        $this->checkCondition();
        return !$this->apple->isRotten();
    }

    public function getStatus(): string
    {
        $this->checkCondition();
        return $this->apple->status;
    }

    public function getImage(): string
    {
        return 'fresh';
    }
}