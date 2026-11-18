<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Text extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'text',
        'categorie_id',
        'user_id',
        'is_blocked',
    ];

    protected function casts(): array
    {
        return [
            'is_blocked' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function author(): BelongsTo
    {
        return $this->user();
    }
}
