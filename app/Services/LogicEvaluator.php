<?php

namespace App\Services;

class LogicEvaluator
{
   
    public function generateTruthTable($expression)
    {
        
        preg_match_all('/[A-Za-z]/', $expression, $matches);
        $variables = array_values(array_unique(array_map('strtoupper', $matches[0])));
        sort($variables);
        
        if (count($variables) == 0) {
            return null;
        }
        
        
        $expr = mb_strtoupper(str_replace(' ', '', $expression));
        $steps = $this->getSteps($expr);
        if ($steps === false) {
            return null;
        }

        $table = [];
        $rows = pow(2, count($variables));
        
        for ($i = 0; $i < $rows; $i++) {
            $row = [];
            
            for ($j = 0; $j < count($variables); $j++) {
                $bit = ($i >> (count($variables) - 1 - $j)) & 1;
                $row[$variables[$j]] = $bit;
            }
            
            
            $stepResults = [];
            foreach ($steps as $stepExpr) {
                $val = $this->evaluate($stepExpr, $row);
                $stepResults[] = $val;
            }
            $row['steps'] = $stepResults;
            $table[] = $row;
        }
        
        return [
            'variables' => $variables,
            'steps' => $steps,
            'table' => $table
        ];
    }
    
   
    private function parseToRPN($expr)
    {
        $tokens = [];
        $len = mb_strlen($expr);
        for ($i = 0; $i < $len; $i++) {
            $char = mb_substr($expr, $i, 1);
            if ($char === ' ') continue;
            
            if (preg_match('/[A-Z]/', $char)) {
                $tokens[] = $char;
            } elseif (in_array($char, ['0', '1'], true)) {
                $tokens[] = $char;
            } elseif (in_array($char, ['¬', '∧', '∨', '→', '↔', '|', '↓', '⊕', '(', ')'])) {
                $tokens[] = $char;
            } else {
                return false; 
            }
        }

        $precedence = [
            '¬' => 5,
            '∧' => 4,
            '|' => 4,
            '∨' => 3,
            '↓' => 3,
            '⊕' => 3,
            '→' => 2,
            '↔' => 1
        ];

        $associativity = [
            '¬' => 'R',
            '∧' => 'L',
            '|' => 'L',
            '∨' => 'L',
            '↓' => 'L',
            '⊕' => 'L',
            '→' => 'R',
            '↔' => 'L'
        ];

        $output = [];
        $operators = [];

        foreach ($tokens as $token) {
            if (preg_match('/[A-Z01]/', $token)) {
                $output[] = $token;
            } elseif ($token === '(') {
                $operators[] = $token;
            } elseif ($token === ')') {
                while (count($operators) > 0 && end($operators) !== '(') {
                    $output[] = array_pop($operators);
                }
                if (count($operators) > 0 && end($operators) === '(') {
                    array_pop($operators);
                } else {
                    return false; 
                }
            } elseif (isset($precedence[$token])) {
                while (
                    count($operators) > 0 
                    && end($operators) !== '(' 
                    && isset($precedence[end($operators)]) 
                    && (
                        ($associativity[$token] === 'L' && $precedence[end($operators)] >= $precedence[$token]) ||
                        ($associativity[$token] === 'R' && $precedence[end($operators)] > $precedence[$token])
                    )
                ) {
                    $output[] = array_pop($operators);
                }
                $operators[] = $token;
            }
        }

        while (count($operators) > 0) {
            $op = array_pop($operators);
            if ($op === '(' || $op === ')') return false;
            $output[] = $op;
        }

        return $output;
    }

   
    private function getSteps($expr)
    {
        $rpn = $this->parseToRPN($expr);
        if ($rpn === false) return false;

        $stack = [];
        $steps = [];
        foreach ($rpn as $token) {
            if (preg_match('/[A-Z01]/', $token)) {
                $stack[] = $token;
            } elseif ($token === '¬') {
                if (count($stack) < 1) return false;
                $a = array_pop($stack);
                
                
                $needParen = (mb_strlen($a) > 1 && mb_substr($a, 0, 1) !== '(' && mb_substr($a, 0, 1) !== '¬');
                $str = '¬' . ($needParen ? '(' . $a . ')' : $a);
                
                $stack[] = $str;
                if (!in_array($str, $steps)) {
                    $steps[] = $str;
                }
            } else {
                if (count($stack) < 2) return false;
                $b = array_pop($stack);
                $a = array_pop($stack);
                
                $str = $a . ' ' . $token . ' ' . $b;
                $nodeStr = '(' . $str . ')'; 
                
                $stack[] = $nodeStr;
                if (!in_array($str, $steps)) {
                    $steps[] = $str; 
                }
            }
        }
        return $steps;
    }

    
    private function evaluate($expr, $values)
    {
        $rpn = $this->parseToRPN($expr);
        if ($rpn === false) return "?";

        $stack = [];
        foreach ($rpn as $token) {
            if (preg_match('/[A-Z]/', $token)) {
                $stack[] = (int)$values[$token];
            } elseif ($token === '0' || $token === '1') {
                $stack[] = (int)$token;
            } elseif ($token === '¬') {
                if (count($stack) < 1) return "?";
                $a = array_pop($stack);
                $stack[] = $a === 1 ? 0 : 1;
            } else {
                if (count($stack) < 2) return "?";
                $b = array_pop($stack);
                $a = array_pop($stack);
                
                if ($token === '∧') {
                    $stack[] = ($a && $b) ? 1 : 0;
                } elseif ($token === '∨') {
                    $stack[] = ($a || $b) ? 1 : 0;
                } elseif ($token === '→') {
                    $stack[] = (!$a || $b) ? 1 : 0;
                } elseif ($token === '↔') {
                    $stack[] = ($a === $b) ? 1 : 0;
                } elseif ($token === '|') {
                    $stack[] = (!($a && $b)) ? 1 : 0;
                } elseif ($token === '↓') {
                    $stack[] = (!($a || $b)) ? 1 : 0;
                } elseif ($token === '⊕') {
                    $stack[] = ($a !== $b) ? 1 : 0;
                }
            }
        }

        if (count($stack) !== 1) return "?";
        return $stack[0];
    }
}
