<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_system'
    ];

    protected $casts = [
        'is_system' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public static function createSlug(string $name): string
    {
        return strtolower(str_replace(' ', '-', trim($name)));
    }

    public function isSystemRole(): bool
    {
        return $this->is_system || in_array($this->slug, ['superadmin', 'admin', 'client']);
    }

    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    public function scopeCustom($query)
    {
        return $query->where('is_system', false);
    }
}
