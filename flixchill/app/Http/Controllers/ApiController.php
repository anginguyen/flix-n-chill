<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Review;
use App\Models\Favorite;
use Http;
use Cache;
use Auth;

class ApiController extends Controller
{
    public function search(Request $request) {
        $request->validate([
            'query' => 'required|min:3'
        ]);

        $input = $request->input('query');
        $type = $request->input('type');
        $query = http_build_query([
            "client_id" => env('SIMKL_API_KEY'),
            "q" => $input
        ]);

        $cacheKey = "simkl-api-$type-$input";
        $seconds = 60;

        $responseObj = Cache::remember($cacheKey, $seconds, function() use ($type, $query) {
            $response = Http::get("https://api.simkl.com/search/$type?$query");
            return $response->object();
        });

        return view('search', [
            'type' => $type,
            'response' => $responseObj,
            'query' => $input
        ]);
    }

    public function show($type, $id, $review_id = null) {
        $query = http_build_query([
            "client_id" => env('SIMKL_API_KEY'),
            "extended" => "full"
        ]);

        if ($type == "movie") {
            $type = "movies";
        }

        $cacheKey = "simkl-api-$id";
        $seconds = 60;

        $responseObj = Cache::remember($cacheKey, $seconds, function() use ($type, $id, $query) {
            $response = Http::get("https://api.simkl.com/$type/$id?$query");
            return $response->object();
        });

        $isFavorite = false;
        $reviews = [];
        $isMediaInTable = Media::where('simkl_id', '=', $id)->exists();

        if ($isMediaInTable) {
            $media = Media::where('simkl_id', '=', str($id))->first();
            $reviews = Review::with(['media', 'user'])->where('media_id', '=', $media->id)->orderBy('created_at', 'desc')->get();

            if (Auth::user()) {
                $isFavorite = Favorite::where('user_id', '=', Auth::user()->id)->where('media_id', '=', $media->id)->exists();
            }
        }

        if ($review_id) {
            return view('details', [
                'response' => $responseObj,
                'isFavorite' => $isFavorite,
                'reviews' => $reviews,
                'type' => $type,
                'id' => $id,
                'review_id' => $review_id
            ]);
        }

        return view('details', [
            'response' => $responseObj,
            'isFavorite' => $isFavorite,
            'reviews' => $reviews,
            'type' => $type,
            'id' => $id
        ]);
    }
}
