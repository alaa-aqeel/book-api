<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author',
        'description',
        'language',
        'pages',
        'image',
        'link',
        'section_id'
    ];  

    /**
     * Many Books To One Section 
     * 
     * @return \Illuminate\Database\Eloquent\Model;
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Many Ratings To One Book 
     * 
     * @return \Illuminate\Database\Eloquent\Model;
     */
    public function ratings()
    {

        return $this->hasMany(Rating::class);
    }
}
