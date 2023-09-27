<?php

namespace App\Factory;

use App\Entity\PeriodType;
use App\Repository\PeriodTypeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<PeriodType>
 *
 * @method        PeriodType|Proxy                     create(array|callable $attributes = [])
 * @method static PeriodType|Proxy                     createOne(array $attributes = [])
 * @method static PeriodType|Proxy                     find(object|array|mixed $criteria)
 * @method static PeriodType|Proxy                     findOrCreate(array $attributes)
 * @method static PeriodType|Proxy                     first(string $sortedField = 'id')
 * @method static PeriodType|Proxy                     last(string $sortedField = 'id')
 * @method static PeriodType|Proxy                     random(array $attributes = [])
 * @method static PeriodType|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PeriodTypeRepository|RepositoryProxy repository()
 * @method static PeriodType[]|Proxy[]                 all()
 * @method static PeriodType[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static PeriodType[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static PeriodType[]|Proxy[]                 findBy(array $attributes)
 * @method static PeriodType[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static PeriodType[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PeriodTypeFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(255),
            'weekEnd' => self::faker()->dateTime(),
            'weekStart' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(PeriodType $periodType): void {})
        ;
    }

    protected static function getClass(): string
    {
        return PeriodType::class;
    }
}
