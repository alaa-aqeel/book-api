<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    public $timestamps = false;     

    protected $fillable = [
        'book_id',
        'user_id',
    ]; 


      /**
     * Many Favorites To One User 
     * 
     * @return \Illuminate\Database\Eloquent\Model;
     */    
    public function user() 
    {
        
        return $this->belongsTo(User::class);
    }


    /**
     * Many Favorites To One Book 
     * 
     * @return \Illuminate\Database\Eloquent\Model;
     */    
    public function book() 
    {
        
        return $this->belongsTo(Book::class);
    }
      
}
