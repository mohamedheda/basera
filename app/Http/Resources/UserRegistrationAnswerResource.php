<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRegistrationAnswerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question_id' => $this->question_id,
            'question_text' => $this->question->question_text,
            'question_type' => $this->question->question_type,
            'answer' => $this->decodeAnswer(),
            'answered_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }

    private function decodeAnswer()
    {
        if (in_array($this->question->question_type, ['checkbox']) && is_string($this->answer)) {
            return json_decode($this->answer, true);
        }

        return $this->answer;
    }
}
