<?php

declare(strict_types=1);

namespace Narrowspark\TestingHelper\Constraint;

use Narrowspark\TestingHelper\Constraint\Traits\AdditionalFailureDescriptionTrait;
use Narrowspark\TestingHelper\Constraint\Traits\ToArrayTrait;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Constraint to assert the extending or implementing of specific classes and interfaces.
 */
final class ExtendsOrImplements extends Constraint
{
    use ToArrayTrait;
    use AdditionalFailureDescriptionTrait;

    /**
     * The FQCN of the classes and interfaces which the tested object
     * must extend or implement.
     *
     * @var string[]
     */
    private $parentsAndInterfaces;

    /**
     * Stores the result of each tested class|interface for internal use.
     *
     * @var bool[]
     */
    private $result = [];

    /**
     * Creates a new instance.
     *
     * @param iterable $parentsAndInterfaces FQCNs of classes or interfaces
     */
    public function __construct(iterable $parentsAndInterfaces = [])
    {
        $this->parentsAndInterfaces = $this->toArray($parentsAndInterfaces);
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->parentsAndInterfaces);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return 'extends or implements required classes and interfaces';
    }

    /**
     * Tests if an object extends or implements the required classes or interfaces.
     *
     * Returns true, if and only if the object extends or implements ALL the classes and interfaces
     * provided with {@link $parentsAndInterfaces}
     *
     * @param mixed|object|\ReflectionClass $other
     *
     * @throws \ReflectionException
     *
     * @return bool
     */
    protected function matches($other): bool
    {
        $this->result = [];
        $success = true;

        if (\is_string($other)) {
            $other = new \ReflectionClass($other);
        }
        $isReflection = $other instanceof \ReflectionClass;

        foreach ($this->parentsAndInterfaces as $fqcn) {
            $check = $isReflection ? $other->isSubclassOf($fqcn) : $other instanceof $fqcn;
            $this->result[$fqcn] = $check;
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
