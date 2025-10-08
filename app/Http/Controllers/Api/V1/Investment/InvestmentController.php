<?php

namespace App\Http\Controllers\Api\V1\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Investment\SearchInvestmentRequest;
use App\Http\Resources\V1\Investment\InvestmentOpportunityResource;
use App\Http\Services\Api\V1\Investment\InvestmentService;
use App\Http\Helpers\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function App\Http\Helpers\paginatedJsonResponse;
use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class InvestmentController extends Controller
{
    protected InvestmentService $investmentService;

    public function __construct(InvestmentService $investmentService)
    {
        $this->investmentService = $investmentService;
    }

    /**
     * Get all investment opportunities
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = $request->only(['market', 'sector', 'risk_level', 'is_halal']);
            $opportunities = $this->investmentService->getAllOpportunities($filters);

            return paginatedJsonResponse(
                paginator: $opportunities->setCollection(
                    $opportunities->getCollection()->map(fn($item) => new InvestmentOpportunityResource($item))
                ),
                message: __('messages.Investment opportunities fetched successfully')
            );
        } catch (\Exception $e) {
            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to fetch investment opportunities'),
                data: $e->getMessage()
            );
        }
    }

    /**
     * Get investment opportunity details
     */
    public function show($id): JsonResponse
    {
        try {
            $opportunity = $this->investmentService->getOpportunityById($id);

            if (!$opportunity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Investment opportunity not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => new InvestmentOpportunityResource($opportunity)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch investment opportunity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get investment opportunities by user's risk profile
     */
    public function getRecommendations(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user */
            $user = $request->user();
            $data = $this->investmentService->getRecommendations($user);

            return response()->json([
                'success' => true,
                'data' => [
                    'risk_profile' => $data['risk_profile'],
                    'risk_score' => $data['risk_score'],
                    'opportunities' => InvestmentOpportunityResource::collection($data['opportunities'])
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Search investment opportunities
     */
    public function search(SearchInvestmentRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $opportunities = $this->investmentService->searchOpportunities($validated['query']);

            return response()->json([
                'success' => true,
                'data' => InvestmentOpportunityResource::collection($opportunities)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get investment statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->investmentService->getStatistics();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
