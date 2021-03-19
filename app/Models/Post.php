<?php

namespace App\Models;

use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use UserTrait, HasFactory;

    protected $table = 'posts';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    protected $guarded = [
        'id', 'user_id', 
    ];

    protected $with = [
        'user',
        'comments',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //Mutators/Accessors
    protected $appends = [
        'comments_count',
    ];
    
    public function getCommentsCountAttribute(){
        return $this->comments->count();
    }
    public function setCommentsCountAttribute($value){
        return $this->attributes['comments_count'] = $value;
    }

}
