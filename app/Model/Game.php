<?php

namespace App\Model;

use App\Model\Scope\LastWeekScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    // games
    //protected $table = 'application_game';
    //protected $primaryKey = 'email';
    //protected $timestamps = false;

    protected $fillable = [
        'title', 'description', 'score', 'publisher', 'genre_id'
    ];

    protected $attributes = [
        'score' => 5
    ];

    //protected static function booted()
    //{
    //    static::addGlobalScope(new LastWeekScope());
    //}

    // relations
    public function genre()
    {
        // table: genres
        // fk: genre_id
        // pk: id
        return $this->belongsTo(Genre::class);
        //return $this->belongsTo(Genre::class, 'foreign_key');
        //return $this->belongsTo(Genre::class, 'foreign_key', 'owner_key');
    }

    // scope
    public function scopeBest(Builder $query): Builder
    {
        return $query
            ->with('genre')
            ->where('score', '>=', 9)
            ->orderBy('score', 'desc')
        ;
    }

    public function scopeGenre(Builder $query, int $genreId): Builder
    {
        return $query->where('genre_id', $genreId);
    }

    public function scopePublisher(Builder $query, string $name): Builder
    {
        return $query->where('publisher', $name);
    }
}
