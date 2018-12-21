<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Extractor;

final class CollaboratorExtractor
{
    /**
     * @param string[] $classes
     *
     * @return string[]
     */
    public function extract(array $classes): array
    {
        $collaborators = [];
        foreach ($classes as $className) {
            $reflection = new \ReflectionClass($className);
            $this->extractFromMethods($reflection->getMethods(\ReflectionMethod::IS_PUBLIC), $collaborators);
        }

        return array_unique($collaborators);
    }

    /**
     * @param \ReflectionMethod[] $methods
     * @param string[]            $collaborators
     */
    private function extractFromMethods(array $methods, array &$collaborators): void
    {
        foreach ($methods as $method) {
            if (!preg_match('/^(it|its)[^a-zA-Z]/', $method->getName())) {
                continue;
            }
            $this->extractFromAttributes($method->getParameters(), $collaborators);
        }
    }

    /**
     * @param \ReflectionParameter[] $parameters
     * @param string[]               $collaborators
     */
    private function extractFromAttributes(array $parameters, array &$collaborators): void
    {
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            if ($type !== null) {
                $collaborators[] = $type->getName();
            }
        }
    }
}
