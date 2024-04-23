<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Review;
use Auth;

class ProfileController extends Controller
{
    public function index($id = null) {
        $favorites = Favorite::with(['media'])->where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $reviews = Review::with(['media'])->where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        if ($id) {
            return view('profile', [
                'favorites' => $favorites,
                'reviews' => $reviews,
                'edit_id' => $id
            ]);
        }

        return view('profile', [
            'favorites' => $favorites,
            'reviews' => $reviews
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'review' => 'required|min:3'
        ]);

        $review = Review::with(['media'])->where('id', '=', $id)->first();
        $review->description = $request->input('review');
        $review->save();

        return redirect()->route('profile.index')->with('success', "Successfully updated review for \"{$review->media->title}\"");
    }

    public function delete(Request $request, $id) {
        $title = (Review::with(['media'])->where('id', '=', $id)->first())->media->title;
        Review::where('id', '=', $id)->delete();

        return back()->with('success', "Deleted review for \"$title\"");;
    }

    public function favorite(Request $request, $id) {
        $title = (Favorite::with(['media'])->where('id', '=', $id)->first())->media->title;
        Favorite::where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->delete();

        return back()->with('success', "Removed \"$title\" from Favorites");
    }
}
