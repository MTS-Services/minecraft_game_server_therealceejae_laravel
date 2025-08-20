<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin\Vote;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\Vote\Vote;
use Carbon\Carbon;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $votes = Vote::with('user', 'reward', 'site')->latest()->paginate();

        return view('server-listing::admin.vote.votes', [
            'votes' => $votes,
            'votesCount' => Vote::count(),
            'votesCountMonth' => Vote::where('created_at', '>', Carbon::now()->startOfMonth())->count(),
            'votesCountWeek' => Vote::where('created_at', '>', Carbon::now()->startOfWeek())->count(),
            'votesCountDay' => Vote::where('created_at', '>', Carbon::now()->startOfDay())->count(),
        ]);
    }
}
