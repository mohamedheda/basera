<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\RegistrationQuestionService;
use App\Http\Helpers\Http;
use App\Http\Resources\V1\Question\RegistrationQuestionResource;

use function App\Http\Helpers\responseFail;
use function App\Http\Helpers\responseSuccess;

class RegistrationQuestionController extends Controller
{
    protected $questionService;

    public function __construct(RegistrationQuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        return $this->questionService->getActiveQuestions();
    }
}
