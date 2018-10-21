<?php

declare(strict_types=1);

namespace App\Tests\Acceptance;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FakeIntegrationTestCase extends KernelTestCase
{
    protected function setUp()
    {
        parent::setUp();

        self::bootKernel(['environment' => 'fake']);
    }
}
