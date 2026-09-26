<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LogicEvaluator;

class LogicController extends Controller
{
    protected $evaluator;

    public function __construct(LogicEvaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    
    public function index()
    {
        return view('logic.index');
    }

    
    public function calculate(Request $request)
    {
        $request->validate([
            'expression' => 'required|string|max:255'
        ]);

        $expression = $request->input('expression');
        
        
        $result = $this->evaluator->generateTruthTable($expression);

        if (!$result) {
            return back()->with('error', "Iltimos, yaroqli o'zgaruvchilarni (A, B, C...) kiriting.");
        }

       
        return view('logic.index', [
            'expression' => $expression,
            'variables' => $result['variables'],
            'steps' => $result['steps'],
            'table' => $result['table']
        ]);
    }
}
