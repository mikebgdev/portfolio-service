<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class CreateUploadDirectoriesListener
{
    private array $uploadDirectories = [
        '/uploads/photos',
        '/uploads/files',
    ];

    public function onKernelRequest(RequestEvent $event): void
    {
        foreach ($this->uploadDirectories as $directory) {
            $absolutePath = $_SERVER['DOCUMENT_ROOT'].$directory;
            if (!\is_dir($absolutePath) && !\mkdir($absolutePath, 0777, true) && !\is_dir($absolutePath)) {
                throw new \RuntimeException(\sprintf('Directory "%s" was not created', $absolutePath));
            }
        }
    }
}
