<?php

declare(strict_types=1);

namespace App\Tests\Integration\FileSystem\Provider\Character;

use App\Domain\Model\Character\CharacterName;
use App\Infrastructure\FileSystem\Provider\Character\NameProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NameProviderTest extends KernelTestCase
{
    /** @var NameProvider */
    private $fileCharacterNameProvider;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->fileCharacterNameProvider = self::$container->get('App\Infrastructure\FileSystem\Provider\Character\NameProvider');
    }

    /**
     * @test
     */
    public function it_returns_all_names_for_a_given_gender()
    {
        $maleNames = $this->fileCharacterNameProvider->allForGender('male');

        $this->assertCount(19, $maleNames);
        $this->assertContainsOnlyInstancesOf(CharacterName::class, $maleNames);
        $this->assertEquals('Scrootchy', current($maleNames));
    }
}
