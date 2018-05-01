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
    
    public function replies()
    {
        return $this->hasMany('App\Submission', 'parent_id');
    }
    
    public function allReplies()
    {
        return $this->replies()->with(['allReplies','user']);
    }
    
    public function owner()
    {
        return $this->belongsTo('App\Submission', 'parent_id');
    }
}
