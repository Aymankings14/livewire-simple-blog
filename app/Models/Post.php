<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable=['title','category_id','body','user_id','image'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public static function search($input){
        return self::where('title','like','%'.$input.'%')->get();
    }
}
