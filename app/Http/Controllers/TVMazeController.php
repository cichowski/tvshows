<?php
namespace App\Http\Controllers;

use App\Library\PaginatedResults;
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
            'p' => 'integer|min:1',
        ]);

        return response()->json(
            $this->getResponseData($request->get('q'), $request->get('p'))->toArray(),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @param string $searchPhrase
     * @param int|null $page
     * @return PaginatedResults
     */
    private function getResponseData(string $searchPhrase, ?int $page = null): PaginatedResults
    {
        $perPage = $page !== null ? config('tvshows.resultsPerPage') : null;
        $responseData = new PaginatedResults($page, $perPage);

        if (Cache::has($searchPhrase)) {
            $responseData->setResults(Cache::get($searchPhrase));
        } else {
            try {
                $showList = $this->service->search($searchPhrase);
                $responseData->setResults($showList);
                Cache::put($searchPhrase, $showList, self::CACHE_TIME_IN_MINUTES * 60);
            } catch (TVMazeResponseException $e) {
                $responseData->setErrorMessage($e->getMessage());
            }
        }

        return $responseData;
    }
}
