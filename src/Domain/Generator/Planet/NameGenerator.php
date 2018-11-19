<?php

declare(strict_types=1);

namespace App\Domain\Generator\Planet;

use App\Domain\Model\Planet\PlanetName;

/**
 * This planet name generator is based on the same algorithm than the one used for the game "Elite"
 * (https://en.wikipedia.org/wiki/Elite_(video_game))
 *
 * The algorithm has been adapted to JavaScript by @BonsaiDen (https://gist.github.com/BonsaiDen/5897243), and this
 * class is a PHP port of this JavaScript adaptation.
 *
 * It has been adapted to add suffixes to planet name.
 *
 * @author Adrien Pétremann <hello@grena.fr>
 */
class NameGenerator
{
    /** @var array string[] */
    private const SUFFIXES = ['prime', 'B', 'alpha', 'proxima', 'IV', 'V', 'C', 'VI', 'VII', 'VIII', 'X', 'IX', 'D'];

    /** @var string */
    private const SYLLABLES = 'folexegezacebisousesarmaindirea.eratenberalavetiedorquanteisrion';

    /** @var string */
    private const VOCALS = 'aeiou';

    /** @var int */
    private const PERCENT_SUFFIX = 35;

    public function getName(): PlanetName
    {
        while(true) {
            $bitIndex = 0;

            $seed = (rand() * rand() + rand()) % 0x80000;

            $l = ($seed >> 15);
            $l = ($l <= 2 || $l === 4) ? 2 : ($l === 5 && ($seed & 0xfff) < 100 ? 1 : 3);

            $planetName = '';
            $previous = null;
            $split = $l === 2 && ($seed & 0x7fff) > 32000;
            $i = 0;

            while($i < $l) {
                $syllableIndex = ($seed >> $bitIndex) & 0x1f;
                $next = substr(self::SYLLABLES, $syllableIndex * 2, 2);

                if (!$previous || $this->isValid($previous, $next)) {
                    $planetName .= $next;
                    $previous = $next;
                    $i++;
                } else {
                    break;
                }

                if ($split && $bitIndex === 5) {
                    $previous = '.';
                    $planetName .= $previous;
                }

                $bitIndex += 5;
            }

            if ($bitIndex === 5 * $l) {
                break;
            }
        }

        $planetName = str_replace('..', ' ', $planetName);
        $planetName = str_replace('.', ' ', $planetName);

        if (rand(0, 100) < self::PERCENT_SUFFIX) {
            $suffixes = self::SUFFIXES;
            shuffle($suffixes);
            $planetName .= sprintf(' %s', current($suffixes));
        }

        $planetName = ucwords($planetName);

        return PlanetName::fromString($planetName);
    }

    private function isValid($previous, $next): bool
    {
        $vocalMustFollow = 'tdbr';
        $notFollowdBySelf = 'rstie';
        $onlyAtStart = 'xyz';
        $badSoundStart = ['xc', 'rc', 'bf', 'qc', 'fc', 'vr', 'vc'];
        $badSoundMiddle = ['eo', 'ou', 'ae', 'ea', 'sr', 'sg', 'sc', 'nv', 'ng', 'sb', 'sv'];

        $pa = $previous[0];
        $pb = $previous[1];
        $na = $next[0];

        if (
            // Block out eveything that's too similar by comparing the initial characters
            (abs(ord($pa) - ord($na)) === 1)
            // Prevent specific letter doubles in the middle of the "word"
            || (strpos($notFollowdBySelf, $pb) !== false && $pb === $na)
            // A vocal must follow the last character of the previous syllable
            || (strpos($vocalMustFollow, $pb) !== false && strpos(self::VOCALS, $na) === false)
            // Block the second syllable in case it's initial character can only occur at the start
            || (strpos($onlyAtStart, $na) !== false)
            // Block other combinations which simply do not sound very well
            ||  (in_array(($pa.$na), $badSoundStart))
            // Block other combinations which simply do not sound very well
            || (in_array(($pb.$na), $badSoundMiddle))
            // Block double syllable pairs
            || ($previous === $next)
        ) {
            return false;
        }

        return true;
    }
}
