<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, emun>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
    ];
    // each project is assigned to a specific user
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
