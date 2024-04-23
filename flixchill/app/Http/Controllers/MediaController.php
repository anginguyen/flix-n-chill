<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Review;
use App\Models\Favorite;
use Auth;

class MediaController extends ApiController
{
    public function post(Request $request) {
        $request->validate([
            'review' => 'required|min:3'
        ]);

        $media = $this->fetchMedia($request->input('id'), $request->input('title'), $request->input('type'), $request->input('poster'));

        $review = new Review();
        $review->user_id = Auth::user()->id;
        $review->media_id = $media->id;
        $review->description = $request->input('review');
        $review->save();

        return back()->with('success', "Successfully posted review for \"{$request->input('title')}\"");
    }

    public function favorite(Request $request) {
        $title = $request->input('title');
        $isFavorite = $request->boolean('favorite');
        $media = $this->fetchMedia($request->input('id'), $title, $request->input('type'), $request->input('poster'));

        if ($isFavorite) {
            Favorite::where('user_id', '=', Auth::user()->id)->where('media_id', '=', $media->id)->delete();
            return back()->with('success', "Removed \"$title\" from Favorites");
        }
        
        $favorite = new Favorite();
        $favorite->user_id = Auth::user()->id;
        $favorite->media_id = $media->id;
        $favorite->save();

        return back()->with('success', "Added \"$title\" to Favorites");
    }

    public function update(Request $request, $type, $id, $review_id) {
        $request->validate([
            'review-edit' => 'required|min:3'
        ]);

        $review = Review::with(['media'])->where('id', '=', $review_id)->first();
        $review->description = $request->input('review-edit');
        $review->save();

        return redirect()
            ->route('show', [
                'type' => $type,
                'id' => $id,
            ])
            ->with('success', "Successfully updated review for \"{$review->media->title}\"");
    }

    function fetchMedia(string $id, string $title, string $type, string $poster) {
        $isMediaInTable = Media::where('simkl_id', '=', $id)->exists();

        if (!$isMediaInTable) {
            $media = new Media();
            $media->simkl_id = $id;
            $media->title = $title;
            $media->type = $type;
            $media->poster = $poster;
            $media->save();

            return $media;
        }

        return Media::where('simkl_id', '=', $id)->first();
    }
}
