<?php

declare(strict_types=1);

namespace Narrowspark\TestingHelper\Constraint;

use Narrowspark\TestingHelper\Constraint\Traits\AdditionalFailureDescriptionTrait;
use Narrowspark\TestingHelper\Constraint\Traits\ToArrayTrait;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to assert that a class uses specific traits.
 */
final class UsesTraits extends Constraint
{
    use ToArrayTrait;
    use AdditionalFailureDescriptionTrait;

    /**
     * The traits that must be used.
     *
     * @var string[]
     */
    private $expectedTraits;

    /**
     * Stores the result of each tested trait for internal use.
     *
     * @var bool[]
     */
    private $result = [];

    /**
     * Creates an instance.
     *
     * @param iterable $expectedTraits
     */
    public function __construct(iterable $expectedTraits = [])
    {
        $this->expectedTraits = $this->toArray($expectedTraits);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->expectedTraits);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'uses required traits';
    }

    /**
     * Tests if a class is using all required traits.
     *
     * Returns true if and only if all traits specified in {@link $expectedTraits} are used by
     * the tested object or class.
     *
     * @param mixed|object|\ReflectionClass $other FQCN or an object
     *
     * @return bool
     *
     * @since 0.29 accepts instances of \ReflectionClass.
     */
    protected function matches($other): bool
    {
        $traits = $other instanceof \ReflectionClass ? $other->getTraitNames() : \class_uses($other);
        $success = true;

        foreach ($this->expectedTraits as $expectedTrait) {
            $check = \in_array($expectedTrait, $traits, true);

            $this->result[$expectedTrait] = $check;

            $success = $success && $check;
        }

        return $success;
    }

    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other): string
    {
        if ($other instanceof \ReflectionClass) {
            $name = $other->getName();
        } elseif (\is_object($other)) {
            $name = \get_class($other);
        } else {
            $name = $other;
        }

        return $name . ' ' . $this->toString();
    }
}
