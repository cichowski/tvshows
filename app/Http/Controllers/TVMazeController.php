<?php

namespace App\Http\Controllers;

use App\Modules\TVMaze\TVMazeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TVMazeController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $searchPhrase = $request->get('q');
        if (null === $searchPhrase) {
            return response()->json([
                'error message' => 'No \'q\' parameter provided. Nothing to search.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return response()->json(
            [],
            JsonResponse::HTTP_OK
        );
    }
}
