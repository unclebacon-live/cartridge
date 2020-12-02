<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class WebsiteCategory extends Enum
{
    const Official = 1;
    const Wikia = 2;
    const Wikipedia = 3;
    const Facebook = 4;
    const Twitter = 5;
    const Twitch = 6;
    const Instagram = 8;
    const Youtube = 9;
    const IPhone = 10;
    const IPad = 11;
    const Android = 12;
    const Steam = 13;
    const Reddit = 14;
    const Itch = 15;
    const EpicGames = 16;
    const Gog = 17;
    const Discord = 18;
}