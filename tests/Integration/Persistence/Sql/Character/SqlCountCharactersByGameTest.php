<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Sql\Character;

use App\Domain\Model\Game\GameIdentifier;
use App\Infrastructure\Persistence\Sql\Character\SqlCountCharactersByGame;
use App\Tests\Integration\SqlIntegrationTestCase;

class SqlCountCharactersByGameTest extends SqlIntegrationTestCase
{
    /** @var SqlCountCharactersByGame */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Infrastructure\Persistence\Sql\Character\SqlCountCharactersByGame');
    }

    /**
     * @test
     */
    public function it_counts_characters_for_a_given_game_identifier()
    {
        $count = $this->query->withIdentifier(GameIdentifier::fromString('game_finished'));
        $this->assertSame(2, $count);

        $count = $this->query->withIdentifier(GameIdentifier::fromString('unknown'));
        $this->assertSame(0, $count);
    }
}
