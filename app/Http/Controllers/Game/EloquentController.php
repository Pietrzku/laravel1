<?php

namespace App\Http\Controllers\Game;

use App\Model\Game;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RequestLog;

class EloquentController extends Controller
{
    public function index(): View
    {
        $this->middleware(RequestLog::class);

        $games = Game::with('genre')
            ->orderBy('crated_at')
            ->paginate(10);


        return view('game.eloquent.list', [
            'games' => $games
        ]);
    }

    public function dashboard(): View
    {
        $bestGames = Game::best()->get();

        $stats = [
            'count' => Game::count(),
            'countScoreGtSeven' => Game::where('score', '>', 7)->count(),
            'max' => Game::max('score'),
            'min'=> Game::min('score'),
            'avg'=> Game::avg('score'),
        ];

        $scoreStats = Game::select(
                Game::raw('count(*) as count'), 'score'
            )
            ->having('count', '>', 10)
            ->groupBy('score')
            ->orderBy('count', 'desc')
            ->get();

        return view('game.eloquent.dashboard', [
            'bestGames' => $bestGames,
            'stats' => $stats,
            'scoreStats' => $scoreStats
        ]);
    }

    public function show(int $gameId, Request $request): View
    {
        $game = Game::find($gameId);

        return view('game.eloquent.show', [
            'game' => $game
        ]);
    }
}
