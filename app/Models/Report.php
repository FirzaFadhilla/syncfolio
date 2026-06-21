<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['reporter_id', 'reported_user_id', 'reason', 'description', 'status'];

    // Relasi ke user yang melaporkan
    public function reporter() {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // Relasi ke user yang dilaporkan (tersangka)
    public function reportedUser() {
        return $this->belongsTo(User::class, 'reported_user_id');
    }
}