<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GifService;
use App\Http\Requests\GifRequest;
use App\Http\Traits\ApiResponser;
use Illuminate\Container\Attributes\Auth;

class GifController extends Controller
{
    use ApiResponser;
    protected $gifService;

    public function __construct(GifService $gifService)
    {
        $this->gifService = $gifService;
    }

    public function searchGifts(Request $request)
    {
        $query = $request->input('query');
        $limit = $request->input('limit');
        $offset = $request->input('offset');

        $gifs = $this->gifService->searchGifs($query, $limit, $offset);

        return response()->json($gifs);
    }

    public function searchGifById($id)
    {
        $gif = $this->gifService->getGifById($id);
        return response()->json($gif);
    }

    public function saveGifAsFavorite($id)
    {
        $this->gifService->saveGifAsFavorite($id);
        return $this->successResponse(['message' => 'Gif saved as favorite']);
    }
}
