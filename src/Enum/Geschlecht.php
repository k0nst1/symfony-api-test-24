<?php

namespace App\Enum;

enum Geschlecht: string
{
    case Weiblich = 'weiblich';
    case Maennlich = 'männlich';
    case Divers = 'divers';
}