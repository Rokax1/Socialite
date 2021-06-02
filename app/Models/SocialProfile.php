<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialProfile extends Model
{
    use HasFactory;

    protected $guarded=[];

    public $allowed=['facebook'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
