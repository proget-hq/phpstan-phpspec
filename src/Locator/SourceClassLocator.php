<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Locator;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class SourceClassLocator
{
    public function locate(array $dirs): array
    {
        $finder = new Finder();

        $nonFinalClasses = [];
        foreach (iterator_to_array($finder->in($dirs)->name('*.php')->files()) as $file) {
            $className = $this->getClassName($file);
            if ($className === null || (new \ReflectionClass($className))->isFinal()) {
                continue;
            }

            $nonFinalClasses[] = $className;
        }

        return $nonFinalClasses;
    }

    private function getClassName(SplFileInfo $fileInfo): ?string
    {
        $namespace = '';
        $content = file_get_contents((string) $fileInfo->getRealPath());
        $tokens = token_get_all((string) $content);
        $count = \count($tokens);

        for ($i = 0; $i < $count; ++$i) {
            if ($tokens[$i][0] === T_NAMESPACE) {
                for ($j = $i + 1; $j < $count; ++$j) {
                    if ($tokens[$j][0] === T_STRING) {
                        $namespace .= $tokens[$j][1].'\\';
                    } elseif ($tokens[$j] === '{' || $tokens[$j] === ';') {
                        break;
                    }
                }
            }

            if ($tokens[$i][0] === T_CLASS || $tokens[$i][0] === T_INTERFACE) {
                for ($j = $i + 1; $j < $count; ++$j) {
                    if ($tokens[$j] === '{') {
                        return $namespace.$tokens[$i + 2][1];
                    }
                }
            }
        }

        return null;
    }
}
