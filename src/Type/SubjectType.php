<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Type;

use PhpSpec\Wrapper\Subject;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;

final class SubjectType extends ObjectType
{
    /**
     * @var Type
     */
    private $wrappedType;

    public function __construct(Type $wrappedType)
    {
        parent::__construct(Subject::class);
        $this->wrappedType = $wrappedType;
    }

    public function hasMethod(string $methodName): bool
    {
        if ($this->wrappedType->hasMethod($methodName)) {
            return true;
        }

        return parent::hasMethod($methodName);
    }

    public function getMethod(string $methodName, ClassMemberAccessAnswerer $scope): MethodReflection
    {
        if ($this->wrappedType->hasMethod($methodName)) {
            return $this->wrappedType->getMethod($methodName, $scope);
        }

        return parent::getMethod($methodName, $scope);
    }

    public function describe(VerbosityLevel $level): string
    {
        return sprintf('%s<%s>', parent::describe($level), $this->wrappedType->describe($level));
    }
}
