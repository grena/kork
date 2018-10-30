<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Sql\Character;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Character\CharacterDetails;
use App\Infrastructure\Persistence\Sql\Character\SqlFindCharactersDetailsByGame;
use App\Tests\Integration\SqlIntegrationTestCase;

class SqlFindCharactersDetailsByGameTest extends SqlIntegrationTestCase
{
    /** @var SqlFindCharactersDetailsByGame */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Infrastructure\Persistence\Sql\Character\SqlFindCharactersDetailsByGame');
    }

    /**
     * @test
     */
    public function it_finds_all_characters_details_for_a_given_game_identifier()
    {
        $gameIdentifier = GameIdentifier::fromString('game_running');

        $charactersDetails = $this->query->withIdentifier($gameIdentifier);

        $slurpy = new CharacterDetails();
        $slurpy->name = 'Slurpy le Vicelard';
        $slurpy->picture = 'img/other/slur.png';
        $slurpy->playerUsername = 'bob';
        $slurpy->playerIdentifier = 'bob-123';

        $this->assertCount(2, $charactersDetails);
        $this->assertContainsOnlyInstancesOf(CharacterDetails::class, $charactersDetails);

        $normalizedCharacters = array_map(function (CharacterDetails $characterDetails): array {
            return $characterDetails->normalize();
        }, $charactersDetails);
        $this->assertContains($slurpy->normalize(), $normalizedCharacters);
    }
}
