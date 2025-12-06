<?php

namespace common\models;

use common\helpers\Status;
use common\interfaces\FruitInterface;
use common\interfaces\StateInterface;
use common\states\AppleStateFactory;
use yii\db\StaleObjectException;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property int $appearance_date
 * @property int|null $fall_date
 * @property string $status
 * @property int $size
 * @property int $created_at
 * @property int $updated_at
 */
class Apple extends \yii\db\ActiveRecord implements FruitInterface
{

    const ROTTEN_HOURS = 5;

    private StateInterface $state;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fall_date'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'on_tree'],
            [['size'], 'default', 'value' => 100],
            [['color', 'appearance_date', 'created_at', 'updated_at'], 'required'],
            [['appearance_date', 'fall_date', 'size', 'created_at', 'updated_at'], 'integer'],
            [['color', 'status'], 'string', 'max' => 20],
            ['status', 'in', 'range' => [Status::ON_TREE, Status::ON_GROUND, Status::ROTTEN, Status::EATEN]],
        ];
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function init(): void
    {
        parent::init();

        if ($this->isNewRecord) {
            $this->color = $this->color ?? $this->getRandomColor();
            $this->appearance_date = time();
            $this->status = Status::ON_TREE;
            $this->size = 100;
            $this->created_at = time();
            $this->updated_at = time();
        }

        $this->state = AppleStateFactory::create($this);
    }

    /**
     * @param $count
     * @return void
     * @throws \yii\db\Exception
     */
    public static function generateRandom($count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $apple = new static();
            $apple->save();
        }
    }

    /**
     * @return float
     */
    public function getSize():float
    {
        return $this->size/100;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'appearance_date' => 'Appearance Date',
            'fall_date' => 'Fall Date',
            'status' => 'Status',
            'size' => 'Size',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Получить случайный цвет
     */
    private function getRandomColor(): string
    {
        $colors = ['green', 'red', 'yellow', 'orange'];
        return $colors[array_rand($colors)];
    }

    /**
     * @param int $percent
     * @return void
     */
    public function eat(int $percent): void
    {
        $this->state->eat($percent);
    }

    /**
     * @return void
     */
    public function failToGround(): void
    {
        $this->state->fall();
    }

    /**
     * @return bool
     */
    public function isRotten(): bool
    {
        return $this->state->getStatus() === Status::ROTTEN;
    }

    /**
     * @return bool
     */
    public function canEat(): bool
    {
        return $this->state->canEat();
    }

    /**
     * Проверяет состояние яблока (не испортилось ли)
     */
    public function checkCondition(): void
    {
        $this->state->checkCondition();
    }

    /**
     * Получить текущий статус
     */
    public function getCurrentStatus(): string
    {
        return $this->state->getStatus();
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function remove(): void
    {
        parent::delete();
    }
}
