<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'book_id',
        'user_id',
        'value',
        'comment',
    ]; 


    /**
     * Many Ratings To One User 
     * 
     * @return \Illuminate\Database\Eloquent\Model;
     */    
    public function user() 
    {
        
        return $this->belongsTo(User::class);
    }


    /**
     * Many Ratings To One Book 
     * 
     * @return \Illuminate\Database\Eloquent\Model;
     */    
    public function book() 
    {
        
        return $this->belongsTo(Book::class);
    }
    
}
