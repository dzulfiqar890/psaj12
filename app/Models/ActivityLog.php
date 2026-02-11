<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'properties',
    ];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper to log an activity.
     */
    public static function log(string $action, $model, string $description, array $properties = []): self
    {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->id ?? null,
            'description' => $description,
            'properties' => $properties ?: null,
        ]);
    }

    /**
     * Get human-readable "time ago".
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get icon based on action type.
     */
    public function getIconAttribute(): string
    {
        return match ($this->action) {
            'create' => 'plus-circle',
            'update' => 'edit-3',
            'delete' => 'trash-2',
            default => 'activity',
        };
    }
}
