<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantiqiy Kalkulyator</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f7f9fa;
            --card-bg: #ffffff;
            --primary: #007aff; 
            --primary-hover: #005bb5;
            --text-dark: #1d1d1f;
            --text-muted: #86868b;
            --border: #d2d2d7;
            --true-color: #34c759;
            --true-bg: rgba(52, 199, 89, 0.1);
            --false-color: #ff3b30;
            --false-bg: rgba(255, 59, 48, 0.1);
            --radius-lg: 20px;
            --radius-md: 12px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-dark);
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .main-card {
            width: 100%;
            max-width: 900px;
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            padding: 40px;
            animation: slideUp 0.6s ease-out;
            margin-bottom: 30px;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 5px;
        }

        
        .calculator-area {
            background: #fbfbfd;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px;
        }

        .toolbar {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .btn-op {
            background: var(--card-bg);
            border: 1px solid var(--border);
            color: var(--text-dark);
            font-size: 1.3rem;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            position: relative;
        }

        .btn-op:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 122, 255, 0.1);
        }

        
        .btn-op::after {
            content: attr(data-title);
            position: absolute;
            bottom: 115%;
            left: 50%;
            transform: translateX(-50%);
            background: #1d1d1f;
            color: #fff;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: 0.2s;
        }
        .btn-op:hover::after {
            opacity: 1;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        .expression-input {
            flex-grow: 1;
            padding: 15px 20px;
            font-size: 1.6rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            outline: none;
            color: var(--text-dark);
            letter-spacing: 2px;
            transition: 0.2s;
            font-weight: 500;
        }

        .expression-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.15);
        }

        .btn-submit {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 0 30px;
            border-radius: var(--radius-md);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
        }

       
        .table-wrapper {
            margin-top: 40px;
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        th, td {
            padding: 16px 20px;
            text-align: center;
        }

        th {
            border-bottom: 2px solid var(--border);
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.95rem;
        }

        td {
            border-bottom: 1px solid #eaeaea;
            font-size: 1.1rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .step-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
            color: var(--text-muted);
        }

        .formula-text {
            color: var(--text-dark);
            font-weight: 600;
        }

        
        .val-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .val-true {
            background: var(--true-bg);
            color: var(--true-color);
        }

        .val-false {
            background: var(--false-bg);
            color: var(--false-color);
        }

        .result-column {
            background: #fbfbfd;
            border-radius: 8px;
        }

        .alert-error {
            background: var(--false-bg);
            color: var(--false-color);
            padding: 15px;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

    </style>
</head>
<body>

    <div class="main-card">
        <div class="header">
            <h1>Mantiqiy Kalkulyator</h1>
        </div>

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('logic.calculate') }}" method="POST">
            @csrf
            <div class="calculator-area">
                <div class="toolbar">
                    <button type="button" class="btn-op" data-title="Inkor" onclick="insertOp('¬')">¬</button>
                    <button type="button" class="btn-op" data-title="Kon'yunksiya" onclick="insertOp('∧')">∧</button>
                    <button type="button" class="btn-op" data-title="Diz'yunksiya" onclick="insertOp('∨')">∨</button>
                    <button type="button" class="btn-op" data-title="Implikatsiya" onclick="insertOp('→')">→</button>
                    <button type="button" class="btn-op" data-title="Ekvivalensiya" onclick="insertOp('↔')">↔</button>
                    <button type="button" class="btn-op" data-title="Sheffer shtrixi" onclick="insertOp('|')">|</button>
                    <button type="button" class="btn-op" data-title="Pirs strelkasi" onclick="insertOp('↓')">↓</button>
                    <button type="button" class="btn-op" data-title="Olti mohi halqasi" onclick="insertOp('⊕')">⊕</button>
                    <button type="button" class="btn-op" style="margin-left: 10px;" onclick="insertOp('(')">(</button>
                    <button type="button" class="btn-op" onclick="insertOp(')')">)</button>
                </div>

                <div class="input-group">
                    <input type="text" id="expression" name="expression" 
                           class="expression-input"
                           placeholder="(A ∧ B) → ¬C" 
                           value="{{ $expression ?? '' }}" 
                           required autocomplete="off">
                    <button type="submit" class="btn-submit">Hisoblash</button>
                </div>
            </div>
        </form>

        @if(isset($table) && count($table) > 0)
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            
                            @foreach($variables as $var)
                                <th>
                                    <div class="step-label">O'zgaruvchi</div>
                                    <div class="formula-text">{{ $var }}</div>
                                </th>
                            @endforeach
                            
                            
                            @foreach($steps as $idx => $step)
                                <th class="{{ $loop->last ? 'result-column' : '' }}">
                                    <div class="step-label">№ {{ $idx + 1 }}</div>
                                    <div class="formula-text">{{ $step }}</div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($table as $row)
                            <tr>
                                
                                @foreach($variables as $var)
                                    <td>
                                        @if($row[$var] == 1)
                                            <span class="val-badge val-true">1</span>
                                        @else
                                            <span class="val-badge val-false">0</span>
                                        @endif
                                    </td>
                                @endforeach

                                
                                @foreach($row['steps'] as $idx => $stepResult)
                                    <td class="{{ $loop->last ? 'result-column' : '' }}">
                                        @if(is_numeric($stepResult))
                                            @if($stepResult == 1)
                                                <span class="val-badge val-true">1</span>
                                            @else
                                                <span class="val-badge val-false">0</span>
                                            @endif
                                        @else
                                            <span style="color:#ff3b30">{{ $stepResult }}</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        function insertOp(op) {
            const input = document.getElementById('expression');
            const start = input.selectionStart;
            const end = input.selectionEnd;
            const text = input.value;
            
            input.value = text.substring(0, start) + op + text.substring(end, text.length);
            input.selectionStart = input.selectionEnd = start + op.length;
            input.focus();
        }
    </script>
</body>
</html>
