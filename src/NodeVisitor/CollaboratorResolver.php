<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\NodeVisitor;

use PhpParser\Node;
use PhpParser\NodeVisitor;
use Proget\PHPStan\PhpSpec\Registry\SpoofedCollaboratorRegistry;
use Proget\PHPStan\PhpSpec\Wrapper\SpoofedCollaborator;

final class CollaboratorResolver implements NodeVisitor
{
    /**
     * @var bool
     */
    private $isInExampleMethod = false;

    /**
     * @var string[]
     */
    private $spoofedCollaborators = [];

    public function beforeTraverse(array $nodes)
    {
        return null;
    }

    public function enterNode(Node $node)
    {
        if ($this->isExampleMethod($node)) {
            $this->isInExampleMethod = true;
        }

        return null;
    }

    public function leaveNode(Node $node)
    {
        if ($this->isInExampleMethod && $node instanceof Node\Param && $node->type instanceof Node\Name\FullyQualified) {
            $spoofedCollaborator = ltrim($node->type->toCodeString(), '\\').'Collaborator';
            if (!in_array($spoofedCollaborator, $this->spoofedCollaborators)) {
                // todo: maybe anon class can implement or extend collaborator? (problem with finding what collaborator really is)
                class_alias($className = eval('return get_class(new class implements '.SpoofedCollaborator::class.' {});'), $spoofedCollaborator);
                SpoofedCollaboratorRegistry::setAlias($className, $spoofedCollaborator);
                $this->spoofedCollaborators[] = $spoofedCollaborator;
            }

            return new Node\Param(
                $node->var,
                $node->default,
                new Node\Name\FullyQualified($spoofedCollaborator),
                $node->byRef,
                $node->variadic,
                $node->getAttributes()
            );
        }

        if ($this->isExampleMethod($node)) {
            $this->isInExampleMethod = false;
        }

        return null;
    }

    public function afterTraverse(array $nodes)
    {
        return null;
    }

    private function isExampleMethod(Node $node): bool
    {
        return $node instanceof Node\Stmt\ClassMethod && (preg_match('/^(it|its)[^a-zA-Z]/', $node->name->name) !== false || $node->name->name === 'let') ;
    }
}
