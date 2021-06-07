<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;
    protected $dates = ['published_at'];
    protected $fillable = ['title', 'description', 'category_id', 'content', 'published_at', 'image', 'user_id'];

    public function deleteImage() {
        Storage::delete($this->image);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query) {
        return $query->where('published_at', '<=', now());
    }

    public function scopeSearched($query) { //scope<ImeFunkcije>
        $search = request()->query('search');

        if(!$search) {
            return $query->published();
        }

        return $query->published()->where('title', 'LIKE', "%{$search}%"); //umesto svaki put da se ponavlja isti metod, pozvacemo ga samo sa ->searched()
    }
}
