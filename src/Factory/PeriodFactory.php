<?php

namespace App\Factory;

use App\Entity\Period;
use Zenstruck\Foundry\ModelFactory;

class PeriodFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
        'name' => self::faker()->text(50),
        'description' => self::faker()->text(100),
        'weekStart' => self::faker()->dateTimeBetween('-1 month', 'now'),
        'weekEnd' => self::faker()->dateTimeBetween('now', '+1 month'),
        ];
    }

    protected static function getClass(): string
    {
        return Period::class;
    }
}
