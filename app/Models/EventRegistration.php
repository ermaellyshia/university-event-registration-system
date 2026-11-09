<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id', 
    'event_id', 
    'participant_name', 
    'participant_email', 
    'registration_date', 
    'status', 
    'admin_remarks'
])]
class EventRegistration extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'registration_date' => 'datetime',
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}