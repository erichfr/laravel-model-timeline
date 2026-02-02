<?php

declare(strict_types=1);

namespace ErpPackages\ModelTimeline\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TimelineEntry extends Model
{
    protected $table = 'model_timelines';

    protected $fillable = [
        'subject_id', 'subject_type',
        'actor_id', 'actor_type',
        'action', 'description', 'body', 'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function actor(): MorphTo
    {
        return $this->morphTo();
    }
}