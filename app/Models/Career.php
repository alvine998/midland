<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['title', 'department', 'location', 'type', 'description', 'requirements', 'deadline', 'is_active', 'sort_order'];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline'  => 'date',
    ];

    public function getTypeLabel(): string
    {
        return [
            'full-time'  => 'Full Time',
            'part-time'  => 'Part Time',
            'contract'   => 'Kontrak',
            'internship' => 'Magang',
        ][$this->type] ?? $this->type;
    }
}
