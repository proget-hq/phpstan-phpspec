<?php

declare(strict_types=1);

namespace Proget\PHPStan\PhpSpec\Locator;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class SpecClassLocator
{
    /**
     * @param string[] $dirs
     *
     * @return string[]
     */
    public function locate(array $dirs): array
    {
        $finder = (new Finder())->in($dirs)->name('*.php');

        $classes = array_map(function (SplFileInfo $fileInfo): string {
            return (string) $this->getClassName($fileInfo);
        }, iterator_to_array($finder->files()));

        return array_values(array_filter($classes, function (string $className): bool {
            return preg_match('/Spec$/', $className) !== false && class_exists($className);
        }));
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

            if ($tokens[$i][0] === T_CLASS) {
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
