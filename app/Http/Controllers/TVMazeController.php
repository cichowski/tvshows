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
        $this->validate(request(), [
            'q' => 'required',
        ]);

        try {
            $showList = $this->service->search($request->get('q'));
        } catch (TVMazeResponseException $e) {
            $errorMessage = $e->getMessage();
        }

        return response()->json([
                'no_items' => isset($showList) ? count($showList) : -1,
                'results' => !empty($showList) ? $showList : [],
                'error_message' => !empty($errorMessage) ? $errorMessage : '',
            ],
            JsonResponse::HTTP_OK
        );
    }
}
