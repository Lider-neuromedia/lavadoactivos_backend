<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function questions()
    {
        $questions = Question::with('options')
            ->get()
            ->map(function ($question) {
                $question->options = $question->options->map(function ($option) {
                    unset($option->question_id);
                    return $option;
                });
                return $question;
            });

        return response()->json(compact('questions'), 200);
    }

    public function respond(Request $request)
    {
        $request->validate([
            'answers' => ['required', 'array', 'min:1'],
            'answers.*.question_id' => ['required', 'exists:questions,id'],
            'answers.*.option_id' => ['required', 'exists:options,id'],
        ]);

        try {

            \DB::beginTransaction();

            foreach ($request->get('answers') as $answer) {
                \DB::table('answers')->insert([
                    'question_id' => $answer['question_id'],
                    'option_id' => $answer['option_id'],
                    'user_id' => \Auth::user()->id,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }

            \DB::commit();
            $message = 'Respuestas guardadas correctamente.';
            return response()->json(compact('message'), 200);

        } catch (\Exception $ex) {
            \Log::info($ex->getMessage());
            \Log::info($ex->getTraceAsString());
            \DB::rollBack();
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
}
