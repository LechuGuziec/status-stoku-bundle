<?php

namespace LechuGuziec\StatusStokuBundle\Enum;

enum WyciagiStatus: string
{
    case CZYNNE = 'Czynne';
    case NIECZYNNE = 'Nieczynne';

    public static function choices(): array
    {
        // ['Czynne' => self::CZYNNE, ...]
        return array_combine(
            array_map(static fn(self $case) => $case->value, self::cases()),
            self::cases()
        );
    }

    public static function choicesAsStrings(): array
    {
        $values = array_map(static fn(self $case) => $case->value, self::cases());

        return array_combine($values, $values);
    }
}
