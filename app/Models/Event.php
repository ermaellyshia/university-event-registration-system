<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['event_name', 'description', 'event_date'])]
class Event extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'event_date' => 'datetime',
        ];
    }


    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}