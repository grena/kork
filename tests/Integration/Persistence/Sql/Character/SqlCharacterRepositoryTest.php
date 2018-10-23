<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Sql\Character;

use App\Domain\Model\Character\Character;
use App\Domain\Model\Character\CharacterIdentifier;
use App\Domain\Model\Character\CharacterName;
use App\Domain\Model\Character\CharacterPicture;
use App\Domain\Model\Game\GameIdentifier;
use App\Tests\Integration\SqlIntegrationTestCase;

class SqlCharacterRepositoryTest extends SqlIntegrationTestCase
{
    /**
     * @test
     */
    public function it_finds_all_characters_by_game()
    {
        $foundCharacters = $this->characterRepository->findAllByGame(
            GameIdentifier::fromString('game_finished')
        );

        $grenaCharacterFinished = Character::create(
            CharacterIdentifier::fromString('grena_game_finished'),
            GameIdentifier::fromString('game_finished'),
            'grena-123',
            CharacterName::fromString('Captain Krapoulax'),
            CharacterPicture::fromString('img/other/krap.png')
        );

        $leaverCharacterFinished = Character::create(
            CharacterIdentifier::fromString('leaver_game_finished'),
            GameIdentifier::fromString('game_finished'),
            'leaver-123',
            CharacterName::fromString('Inspecteur Natchouki'),
            CharacterPicture::fromString('img/male/natch.png')
        );

        $expectedCharacters = [$grenaCharacterFinished, $leaverCharacterFinished];

        $this->assertCount(2, $foundCharacters);
        $this->assertEquals($expectedCharacters, $foundCharacters);

        $foundCharacters = $this->characterRepository->findAllByGame(
            GameIdentifier::fromString('unknown')
        );

        $this->assertEmpty($foundCharacters);
    }
}
