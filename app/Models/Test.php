<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    /**
     * attributes.
     *
     * @var array
     */
    protected $attributes = [
        'title' => 'Titulo',
        'time_to_finish' => 60,
    ];

    /**
     * Get questions of test.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    /**
    * The roles that belong to the user.
    */
   public function users()
   {
       return $this->belongsToMany(User::class)
       ->withPivot('is_approved')
       ->withTimestamps();
   }
}
