<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Sql\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Infrastructure\Persistence\Sql\Game\SqlGameExists;
use App\Tests\Integration\SqlIntegrationTestCase;

class SqlGameExistsTest extends SqlIntegrationTestCase
{
    /** @var SqlGameExists */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Infrastructure\Persistence\Sql\Game\SqlGameExists');
    }

    /**
     * @test
     */
    public function it_tells_if_a_game_with_a_given_identifier_exists()
    {
        $gameIdentifier = GameIdentifier::fromString('game_running');
        $this->assertTrue($this->query->withIdentifier($gameIdentifier));

        $gameIdentifier = GameIdentifier::fromString('unknown');
        $this->assertFalse($this->query->withIdentifier($gameIdentifier));
    }
}
