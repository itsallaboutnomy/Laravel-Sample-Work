<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $guarded;
    public $timestamps = true;

    public function app()
    {
        return $this->belongsTo(Application::class);
    }

    public function subscription(){
        return $this->hasMany(Subscription::class);

    }
}
