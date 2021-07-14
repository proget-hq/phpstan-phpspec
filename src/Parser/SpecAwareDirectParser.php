<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Parser;

use PhpParser\NodeTraverser;
use PHPStan\File\FileHelper;
use PHPStan\Parser\Parser;
use Proget\PHPStan\PhpSpec\NodeVisitor\CollaboratorResolver;
use Proget\PHPStan\PhpSpec\NodeVisitor\CustomMatchersResolver;

final class SpecAwareDirectParser implements Parser
{
    /**
     * @var FileHelper
     */
    private $fileHelper;

    /**
     * @var Parser
     */
    private $originalParser;

    /**
     * @var NodeTraverser
     */
    private $specTraverser;

    /**
     * @var string
     */
    private $specDir;

    public function __construct(FileHelper $fileHelper, Parser $originalParser, string $specDir)
    {
        $this->fileHelper = $fileHelper;
        $this->originalParser = $originalParser;
        $this->specTraverser  = new \PhpParser\NodeTraverser();
        $this->specTraverser->addVisitor(new CollaboratorResolver());
        $this->specTraverser->addVisitor(new CustomMatchersResolver());
        $this->specDir = $specDir;
    }

    public function parseFile(string $file): array
    {
        $file = $this->fileHelper->normalizePath($file, '/');

        $contents = file_get_contents($file);
        if ($contents === false) {
            throw new \PHPStan\ShouldNotHappenException();
        }

        if (false !== strpos($file, $this->specDir)) {
            return $this->parseString($contents);
        }

        return $this->originalParser->parseString($file);
    }

    public function parseString(string $sourceCode): array
    {
        $nodes = $this->originalParser->parseString($sourceCode);
        if ($nodes === null) {
            throw new \PHPStan\ShouldNotHappenException();
        }

        return $this->specTraverser->traverse($nodes);
    }
}
