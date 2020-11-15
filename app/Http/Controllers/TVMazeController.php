<?php
namespace App\Http\Controllers;

use App\Modules\TVMaze\TVMazeResponseException;
use App\Modules\TVMaze\TVMazeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TVMazeController extends Controller
{
    /**
     * @var TVMazeService
     */
    private $service;

    /**
     * @param TVMazeService $service
     */
    public function __construct(TVMazeService $service)
    {
        $this->service = $service;
    }

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

        try {
            $showList = $this->service->search($searchPhrase);
        } catch (TVMazeResponseException $e) {
            $errorMessage = $e->getMessage();
        }

        return response()->json([
                'results count' => isset($showList) ? count($showList) : -1,
                'results' => !empty($showList) ? $showList : [],
                'error message' => !empty($errorMessage) ? $errorMessage : '',
            ],
            JsonResponse::HTTP_OK
        );
    }
}
