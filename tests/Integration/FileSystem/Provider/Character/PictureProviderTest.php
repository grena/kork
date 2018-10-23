<?php

declare(strict_types=1);

namespace App\Tests\Integration\FileSystem\Provider\Character;

use App\Domain\Model\Character\CharacterPicture;
use App\Infrastructure\FileSystem\Provider\Character\PictureProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PictureProviderTest extends KernelTestCase
{
    /** @var PictureProvider */
    private $fileCharacterPictureProvider;

    protected function setUp()
    {
        parent::setUp();
        self::bootKernel();

        $this->fileCharacterPictureProvider = self::$container->get('App\Infrastructure\FileSystem\Provider\Character\PictureProvider');
    }

    /**
     * @test
     */
    public function it_returns_all_pictures_for_a_given_gender()
    {
        $femalePictures = $this->fileCharacterPictureProvider->allForGender('female');

        $this->assertCount(6, $femalePictures);
        $this->assertContainsOnlyInstancesOf(CharacterPicture::class, $femalePictures);
    }
}
