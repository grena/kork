<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Common\Game;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Game\GameExistsInterface;
use App\Tests\Integration\IntegrationTestCase;

class GameExistsTest extends IntegrationTestCase
{
    /** @var GameExistsInterface */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Domain\Query\Game\GameExistsInterface');
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
