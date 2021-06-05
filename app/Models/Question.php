<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * attributes.
     *
     * @var array
     */
    protected $attributes = [
        'statement' => 'Enunciado',
    ];

    /**
     * Get the test of this question.
     */
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * Get the answers of this question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
