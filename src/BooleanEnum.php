<?php

namespace CorpSoft\Enum;

/**
 * Class BooleanEnum
 *
 * @package CorpSoft\Enum
 */
class BooleanEnum extends BaseEnum
{
    const YES = 1;
    const NO = 0;

    /**
     * @var array
     */
    public static $list = [
        self::YES => 'Yes',
        self::NO => 'No',
    ];
}
