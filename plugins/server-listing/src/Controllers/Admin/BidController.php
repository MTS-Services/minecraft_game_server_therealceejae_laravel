<?php

namespace Azuriom\Plugin\ServerListing\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\ServerListing\Models\ServerBid;
use Azuriom\Plugin\ServerListing\Services\BidService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class BidController extends Controller
{
    protected BidService $bidService;

    public function __construct(BidService $bidService)
    {

        $this->bidService = $bidService;
    }

    public function index(Request $request)
    {
        $bids = $this->bidService->getAllBids();
        $data['per_page'] = 10;
        if ($request->has('year')) {
            $bids = $bids->whereYear('bidding_at', $request->year);
        }
        if ($request->has('month') && $request->month != 'all') {
            $bids = $bids->whereMonth('bidding_at', $request->month);
        }
        if ($request->has('status') && $request->status != 'all') {
            $bids = $bids->where('status', $request->status);
        }
        $data['bids'] = $bids->paginate($data['per_page'])->withQueryString();

        return view('server-listing::admin.bids.index', $data);
    }

    public function updateOrder(Request $request)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'order.*.id' => ['required', 'integer'],
                'order.*.children' => ['sometimes', 'array'],
                'page' => ['nullable', 'integer'],
                'per_page' => ['nullable', 'integer'],
            ]);

            if ($validator->fails()) {
                Log::warning('Tag reorder validation failed', [
                    'errors' => $validator->errors(),
                    'payload' => $request->all(),
                ]);

                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $elements = $request->input('order');
            $page = $request->input('page', 1);
            $perPage = $request->input('per_page', 10);
            $position = ($page - 1) * $perPage + 1; // starting position offset for the current page

            foreach ($elements as $element) {
                $id = $element['id'];
                $children = $element['children'] ?? [];

                ServerBid::whereKey($id)->update([
                    'position' => $position++,
                ]);

                $childPosition = 1;

                foreach ($children as $child) {
                    ServerBid::whereKey($child['id'])->update([
                        'position' => $childPosition++,
                    ]);
                }
            }

            return response()->json([
                'message' => trans('messages.status.success'),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update tag order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Something went wrong while saving the order.',
            ], 500);
        }
    }







}
