<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Parser;

use PhpParser\NodeTraverser;
use PHPStan\Parser\Parser;
use Proget\PHPStan\PhpSpec\NodeVisitor\CollaboratorResolver;
use Proget\PHPStan\PhpSpec\NodeVisitor\CustomMatchersResolver;

final class SpecAwareDirectParser implements Parser
{
    /**
     * @var \PhpParser\Parser
     */
    private $parser;

    /**
     * @var NodeTraverser
     */
    private $traverser;

    /**
     * @var NodeTraverser
     */
    private $specTraverser;

    /**
     * @var string
     */
    private $specDir;

    public function __construct(\PhpParser\Parser $parser, NodeTraverser $traverser, string $specDir)
    {
        $this->parser = $parser;
        $this->traverser = $traverser;

        $this->specTraverser = clone $traverser;
        $this->specTraverser->addVisitor(new CollaboratorResolver());
        $this->specTraverser->addVisitor(new CustomMatchersResolver());

        $this->specDir = $specDir;
    }

    /**
     * @param string $file path to a file to parse
     *
     * @return \PhpParser\Node[]
     */
    public function parseFile(string $file): array
    {
        $contents = file_get_contents($file);
        if ($contents === false) {
            throw new \PHPStan\ShouldNotHappenException();
        }

        if (false !== strpos($file, $this->specDir)) {
            return $this->parseSpecString($contents);
        }

        return $this->parseString($contents);
    }

    /**
     * @param string $sourceCode
     *
     * @return \PhpParser\Node[]
     */
    public function parseString(string $sourceCode): array
    {
        $nodes = $this->parser->parse($sourceCode);
        if ($nodes === null) {
            throw new \PHPStan\ShouldNotHappenException();
        }

        return $this->traverser->traverse($nodes);
    }

    /**
     * @param string $sourceCode
     *
     * @return \PhpParser\Node[]
     */
    public function parseSpecString(string $sourceCode): array
    {
        $nodes = $this->parser->parse($sourceCode);
        if ($nodes === null) {
            throw new \PHPStan\ShouldNotHappenException();
        }

        return $this->specTraverser->traverse($nodes);
    }
}
