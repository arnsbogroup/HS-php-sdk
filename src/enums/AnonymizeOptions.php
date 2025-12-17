<?php

namespace Heysender\Enums;


enum AnonymizeOptions: string
{
    case NONE = 'none';
    case ALL = 'all';
    case RECIPIENT = 'recipient';
    case SUBJECT = 'subject';
    case CONTENT = 'content';

    /**
     * Get all anonymization option values as an array
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
