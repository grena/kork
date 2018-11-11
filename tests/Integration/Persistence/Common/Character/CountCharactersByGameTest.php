<?php

declare(strict_types=1);

namespace App\Tests\Integration\Persistence\Common\Character;

use App\Domain\Model\Game\GameIdentifier;
use App\Domain\Query\Character\CountCharactersByGameInterface;
use App\Tests\Integration\IntegrationTestCase;

class CountCharactersByGameTest extends IntegrationTestCase
{
    /** @var CountCharactersByGameInterface */
    private $query;

    protected function setUp()
    {
        parent::setUp();

        $this->query = self::$container->get('App\Domain\Query\Character\CountCharactersByGameInterface');
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
