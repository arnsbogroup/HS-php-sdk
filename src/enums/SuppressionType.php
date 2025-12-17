<?php

namespace Heysender\Enums;

enum SuppressionType: string
{
    case BOUNCE = 'bounce';
    case UNSUBSCRIBE = 'unsubscribe';
    case COMPLAINT = 'complaint';

    /**
     * Get all suppression type values as an array
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
