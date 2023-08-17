<?php
namespace Andrusdev\Composer;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ComposerFileCleanup 
{
    public static function cleanup( Event $event ) {
        $composer   = $event->getComposer();
        $extra      = $composer->getPackage()->getExtra();
        
        $itemsToRemove = $extra['composer-file-cleanup'] ?? [];

        $defaultItemsToRemove = [
            'README.md',
            'CHANGELOG.md',
            'LICENSE',
        ];

        $allItemsToRemove = array_merge($defaultItemsToRemove, $itemsToRemove);

        if (!empty($allItemsToRemove)) {
            $vendorDir = $composer->getConfig()->get('vendor-dir');
            $filesystem = new Filesystem();
            $removedCount = self::removeItemsInPackages($vendorDir, $allItemsToRemove, $filesystem);

            if ($removedCount > 0) {
                $event->getIO()->write(sprintf('Removed %s items', $removedCount));
            }
        }
    }

    private static function removeItemsInPackages( $vendorDir, array $itemsToRemove, Filesystem $filesystem ) {
        $removedCount = 0;
        $packagesDir = $vendorDir . '/';

        foreach (glob($packagesDir . '*', GLOB_ONLYDIR) as $packageDir) {
            foreach ($itemsToRemove as $item) {
                $finder = (new Finder())
                    ->files()
                    ->name($item)
                    ->in($packageDir);

                foreach ($finder as $file) {
                    $realpath = $file->getRealPath();
                    $filesystem->remove($realpath);
                    $removedCount++;
                }
            }
        }

        return $removedCount;
    }
}
