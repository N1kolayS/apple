<?php

namespace common\states;

use common\helpers\Status;
use common\interfaces\StateInterface;
use common\models\Apple;

class AppleStateFactory
{
    /**
     * @throws \Exception
     */
    public static function create(Apple $apple): StateInterface
    {
        return match ($apple->status) {
            Status::ON_TREE => new OnTreeState($apple),
            Status::ON_GROUND => new OnGroundState($apple),
            Status::ROTTEN => new RottenState($apple),
            Status::EATEN => new EatenState($apple),
            default => throw new \Exception("Unknown apple status: {$apple->status}"),
        };
    }
}