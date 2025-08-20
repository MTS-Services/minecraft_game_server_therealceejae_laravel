<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin\Vote;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Plugin\ServerListing\Models\ServerListing;
use Azuriom\Plugin\ServerListing\Models\Vote\Reward;
use Azuriom\Plugin\ServerListing\Requests\Vote\RewardRequest;
use Illuminate\Support\Arr;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('server-listing::admin.vote.rewards.index', [
            'rewards' => Reward::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('server-listing::admin.vote.rewards.create', [
            'servers' => ServerListing::online()->get(),
            'cron' => function_exists('scheduler_running') && scheduler_running(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RewardRequest $request)
    {
        $reward = Reward::create(Arr::except($request->validated(), 'servers'));

        $reward->servers()->sync($request->input('servers', []));


        return to_route('server-listing.admin.vote.rewards.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reward $reward)
    {
        return view('server-listing::admin.vote.rewards.edit', [
            'reward' => $reward->load('servers'),
            'servers' => ServerListing::online()->get(),
            'cron' => function_exists('scheduler_running') && scheduler_running(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RewardRequest $request, Reward $reward)
    {
        $reward->update(Arr::except($request->validated(), 'servers'));

        $reward->servers()->sync($request->input('servers', []));

        if ($request->hasFile('image')) {
            $reward->storeImage($request->file('image'), true);
        }

        return to_route('server-listing.admin.vote.rewards.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Reward $reward)
    {
        $reward->delete();

        return to_route('server-listing.admin.vote.rewards.index')
            ->with('success', trans('messages.status.success'));
    }
}
