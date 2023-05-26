<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class BuilderController extends Controller
{
    public function index(): View
    {
        $games = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select(
                'games.id', 'games.title', 'games.score',
                'genres.id as genre_id', 'genres.name as genre_name'
            )
            ->paginate(10);

        return view('game.builder.list', [
            'games' => $games
        ]);
    }

    public function dashboard(): View
    {
        $bestGames = DB::table('games')
            ->join('genres', 'games.genre_id', '=', 'genres.id')
            ->select(
                'games.id', 'games.title', 'games.score',
                'genres.id as genre_id', 'genres.name as genre_name'
            )
            ->where('score', '>', 9)
            ->get();

        /*
        $query = DB::table('games')
            ->select('id', 'title', 'score', 'genre_id')
            ->whereIn('id', [22, 42, 53])
            //->whereBetween('id', [33, 35])
        ;
        */

        $stats = [
            'count' => DB::table('games')->count(),
            'countScoreGtSeven' => DB::table('games')->where('score', '>', 7)->count(),
            'max' => DB::table('games')->max('score'),
            'min'=> DB::table('games')->min('score'),
            'avg'=> DB::table('games')->avg('score'),
        ];

        $scoreStats = DB::table('games')
            ->select(DB::raw('count(*) as count'), 'score')
            ->having('count', '>', 10)
            ->groupBy('score')
            ->orderBy('count', 'desc')
            ->get();

        return view('game.builder.dashboard', [
            'bestGames' => $bestGames,
            'stats' => $stats,
            'scoreStats' => $scoreStats
        ]);
    }

    public function show(int $gameId): View
    {
        $game = DB::table('games')->find($gameId);

        return view('game.builder.show', [
            'game' => $game
        ]);
    }
}
