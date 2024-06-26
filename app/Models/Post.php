<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['photo_video', 'type', 'title', 'user_id'];

    // Définir les règles de validation si nécessaire
    public static $rules = [
        'photo_video' => 'required',
        'type' => 'required|in:0,1',
        'title' => 'nullable|string|max:255',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function commentaire()
    {
        return $this->belongsTo(commentaire::class);
    }
}
