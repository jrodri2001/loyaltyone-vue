<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = "submissions";
    
    protected $fillable = ['text', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
