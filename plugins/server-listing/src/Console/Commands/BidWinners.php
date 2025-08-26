<?php

namespace Azuriom\Plugin\ServerListing\Console\Commands;

use Illuminate\Console\Command;
use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class BidWinners extends Command
{
    protected $signature = 'server-listing:winners';
    protected $description = 'Process bid winners and losers for the current month\'s payment period.';

    public function handle()
    {
        Log::info('BidWinners command started.');

        if (!paymentIsOpen()) {
            $this->info('Payment period is not open. Skipping bid processing.');
            Log::info('BidWinners command skipped: Payment period is closed.');
            return self::SUCCESS;
        }

        $this->info('Starting to process bid winners for the current month.');
        Log::info('BidWinners command is processing bids.', ['date' => now()->toDateString()]);

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        try {
            // 1. Get the IDs of the top 10 winning bids. (Query #1)
            $winningBidIds = ServerBid::where('status', 'pending')
                ->whereYear('bidding_at', $currentYear)
                ->whereMonth('bidding_at', $currentMonth)
                ->orderByDesc('amount')
                ->take(10)
                ->pluck('id');

            if ($winningBidIds->isEmpty()) {
                $this->info('No pending bids found for the current month.');
                Log::warning('No pending bids found to process.');
                return self::SUCCESS;
            }

            // 2. Update the status of the top 10 winning bids to 'win'. (Query #2)
            $winnerCount = ServerBid::whereIn('id', $winningBidIds)
                ->update(['status' => 'win']);

            $this->info("Successfully updated {$winnerCount} bids to 'win' status.");
            Log::info("Updated winning bids.", ['count' => $winnerCount, 'ids' => $winningBidIds->toArray()]);

            // 3. Update all other pending bids to 'rejected'. (Query #3)
            $rejectedCount = ServerBid::where('status', 'pending')
                ->whereYear('bidding_at', $currentYear)
                ->whereMonth('bidding_at', $currentMonth)
                ->whereNotIn('id', $winningBidIds)
                ->update(['status' => 'rejected']);

            $this->info("Successfully rejected {$rejectedCount} other bids for the month.");
            Log::info("Rejected other bids.", ['count' => $rejectedCount]);
        } catch (\Exception $e) {
            $this->error("An error occurred during bid processing: " . $e->getMessage());
            Log::error("BidWinners command failed.", [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return self::FAILURE;
        }

        $this->info("Finished processing bids.");
        Log::info('BidWinners command finished successfully.');
        return self::SUCCESS;
    }
}
