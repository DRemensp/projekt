<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'author_name',
        'ip_address',
        'moderation_status',
        'moderation_scores',
        'moderation_reason',
        'moderated_at'
    ];

    protected $casts = [
        'moderation_scores' => 'array',
        'moderated_at' => 'datetime',
    ];

    /**
     * Scope für nur genehmigte Kommentare
     */
    public function scopeApproved($query)
    {
        return $query->where('moderation_status', 'approved');
    }

    /**
     * Scope für ausstehende Moderation
     */
    public function scopePending($query)
    {
        return $query->where('moderation_status', 'pending');
    }

    /**
     * Scope für blockierte Kommentare
     */
    public function scopeBlocked($query)
    {
        return $query->where('moderation_status', 'blocked');
    }
}
