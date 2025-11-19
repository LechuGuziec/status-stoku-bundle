<?php

namespace LechuGuziec\StatusStokuBundle\Enum;

enum WarunkiStatus: string
{
    case BRAK = 'Brak';
    case DOBRE = 'Dobre';
    case SREDNIE = 'Średnie';
    case TRUDNE = 'Trudne';

    public static function choices(): array
    {
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
