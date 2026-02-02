<?php

declare(strict_types=1);

namespace ErpPackages\ModelTimeline\Traits;

use ErpPackages\ModelTimeline\Models\TimelineEntry;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

trait HasTimeline
{
    public function timeline(): MorphMany
    {
        return $this->morphMany(TimelineEntry::class, 'subject')->latest();
    }

    public function recordTimeline(
        string $description, 
        string $action = 'info', 
        ?string $body = null, 
        array $metadata = [], 
        $actor = null
    ): TimelineEntry {
        
        if (! $actor && Auth::check()) {
            $actor = Auth::user();
        }

        return $this->timeline()->create([
            'actor_id'    => $actor ? $actor->id : null,
            'actor_type'  => $actor ? get_class($actor) : null,
            'action'      => $action,
            'description' => $description,
            'body'        => $body,
            'metadata'    => $metadata,
        ]);
    }

    public function comment(string $comment, $actor = null): TimelineEntry
    {
        return $this->recordTimeline(
            description: 'Comentário',
            action: 'comment',
            body: $comment,
            actor: $actor
        );
    }
}