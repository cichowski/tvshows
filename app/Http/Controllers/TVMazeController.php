<?php
namespace App\Http\Controllers;

use App\Modules\TVMaze\TVMazeResponseException;
use App\Modules\TVMaze\TVMazeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class TVMazeController extends Controller
{
    private const CACHE_TIME_IN_MINUTES = 240;

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
     * @throws ValidationException
     */
    public function search(Request $request): JsonResponse
    {
        $this->validate(request(), [
            'q' => 'required',
        ]);
        $searchPhrase = $request->get('q');

        if (Cache::has($searchPhrase)) {
            $showList = Cache::get($searchPhrase);
        } else {
            try {
                $showList = $this->service->search($searchPhrase);
                Cache::put($searchPhrase, $showList, self::CACHE_TIME_IN_MINUTES * 60);
            } catch (TVMazeResponseException $e) {
                $errorMessage = $e->getMessage();
            }
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
