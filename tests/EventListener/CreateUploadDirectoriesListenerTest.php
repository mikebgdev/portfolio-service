<?php
/*
 * This class is part of a software application developed by Michael Ballester Granero.
 *
 * The application is distributed under the terms of the MIT License.
 * For more information, please see the LICENSE file included in the source code.
 */

declare(strict_types=1);

namespace App\Tests\EventListener;

use App\EventListener\CreateUploadDirectoriesListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[covers(CreateUploadDirectoriesListener::class)]
final class CreateUploadDirectoriesListenerTest extends TestCase
{
    public function testOnKernelRequest()
    {
        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $parameterBag->method('get')
            ->willReturnMap([
                ['upload_photo_directory', '/path/to/upload/photo'],
                ['upload_curriculum_directory', '/path/to/upload/curriculum'],
            ]);

        $listener = new CreateUploadDirectoriesListener($parameterBag);

        $requestEvent = $this->createMock(RequestEvent::class);

        $listener->onKernelRequest($requestEvent);

        self::assertTrue(\is_dir('/path/to/upload/photo'));
        self::assertTrue(\is_dir('/path/to/upload/curriculum'));

        \rmdir('/path/to/upload/photo');
        \rmdir('/path/to/upload/curriculum');
    }

    public function testOnKernelRequestException()
    {
        $this->expectException(\RuntimeException::class);

        $parameterBag = $this->createMock(ParameterBagInterface::class);
        $parameterBag->method('get')
            ->willReturnMap([
                ['upload_photo_directory', '/path/to/upload/photo.jpg'],
            ]);

        $listener = new CreateUploadDirectoriesListener($parameterBag);

        $requestEvent = $this->createMock(RequestEvent::class);

        $listener->onKernelRequest($requestEvent);
    }
}
