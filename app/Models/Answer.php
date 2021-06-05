<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    /**
     * attributes.
     *
     * @var array
     */
    protected $attributes = [
        'option' => 'Opção',
        'isCorrect' => false,
    ];

    /**
     * Get the question of this answer.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
