<?php

namespace Heysender\Enums;


enum EventType: string
{
    case QUEUED = 'queued';
    case SENT = 'sent';
    case ATTEMPT = 'attempt';
    case SOFT_BOUNCE = 'soft_bounce';
    case HARD_BOUNCE = 'hard_bounce';
    case COMPLAINT = 'complaint';
    case UNSUBSCRIBE = 'unsubscribe';
    case OPEN = 'open';
    case CLICK = 'click';

    /**
     * Get all event values as an array
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
