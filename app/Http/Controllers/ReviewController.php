<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $reviews = Review::query();
            return DataTables::of($reviews)

                ->addColumn('is_active', function ($review) {
                    return getStatusBadge($review->is_active);
                })
                ->addColumn('action', function ($review) {
                    $actions = '<div class="overlay-edit d-flex">';

                    if (auth()->user()->can('Update Review')) {
                        $actions .= '<a href="' . route('reviews.edit', $review->uuid) . '" class="btn btn-icon btn-secondary me-1" title="Edit"><i class="feather icon-edit-2"></i></a>';
                    }
                    if (auth()->user()->can('Update Review Status')) {
                        $actions .= '<a href="' . route('reviews.updateStatus', $review->uuid) . '" class="btn btn-icon ' . ($review->is_active == 1 ? 'btn-danger' : 'btn-success') . ' btn-status me-1">' . '<i class="feather ' . ($review->is_active == 1 ? 'icon-eye-off' : 'icon-eye') . '"></i></a>';
                    }
                    if (auth()->user()->can('Delete Review')) {
                        $actions .= '<a href="' . route('reviews.destroy', $review->uuid) . '" class="btn btn-icon btn-danger btn-delete" title="Delete"><i class="feather icon-trash-2"></i></a>';
                    }

                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }
        return view('reviews.index');
    }

    /**
     * Show the form for creating a new review.
     */
    public function create()
    {
        return view('reviews.create');
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'author'    => 'required|string|max:255',
            'location'  => 'required|string|max:255',
            'rating'    => 'required|integer|min:1|max:5',
            'booking_reference' => 'nullable|string|max:255',
            'route_detail' => 'nullable|string|max:255',
            'travel_date' => 'nullable|date',
            'comment'   => 'required|string',
        ]);

        Review::create($data);

        return redirect()->route('reviews.index')
                         ->with('success', 'Review added successfully.');
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        return view('reviews.edit', get_defined_vars());
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'author'    => 'required|string|max:255',
            'location'  => 'required|string|max:255',
            'rating'    => 'required|integer|min:1|max:5',
            'booking_reference' => 'nullable|string|max:255',
            'route_detail' => 'nullable|string|max:255',
            'travel_date' => 'nullable|date',
            'comment'   => 'required|string',
        ]);

        $review->update($data);

        return redirect()->route('reviews.index')
                         ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Review $review) {

        if($review) {

            $review->is_active = !$review->is_active;
            $review->save();

            return $this->sendResponse(true, __('messages.review_updated'));
        }

        return $this->sendResponse(false, __('messages.review_not_found'), [], 404);
    }
}