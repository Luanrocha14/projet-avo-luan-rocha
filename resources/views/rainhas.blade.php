<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jogo das 8 Rainhas</title>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f3f4f6;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        /* Header e Botão Voltar */
        .header {
            width: 100%;
            max-width: 600px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-back {
            text-decoration: none;
            color: #4b5563;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }
        .btn-back:hover { background-color: #e5e7eb; }

        h1 { margin: 0; color: #1f2937; font-size: 1.5rem; }

        .info {
            margin-bottom: 20px;
            font-size: 1.2rem;
            color: #4b5563;
        }

        /* Tabuleiro */
        .board {
            display: grid;
            grid-template-columns: repeat(8, 50px);
            grid-template-rows: repeat(8, 50px);
            border: 5px solid #374151;
            user-select: none;
            background-color: #fff;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 600px) {
            .board {
                grid-template-columns: repeat(8, 60px);
                grid-template-rows: repeat(8, 60px);
            }
            .cell { width: 60px; height: 60px; font-size: 40px; }
        }

        .cell {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        /* Cores do Tabuleiro */
        .cell.white { background-color: #f9fafb; }
        .cell.black { background-color: #9ca3af; }

        /* Casas Atacadas (Vermelho) */
        .cell.attacked { background-color: #fecaca !important; }
        .cell.black.attacked { background-color: #f87171 !important; }

        /* Dica (Verde) */
        .cell.hint-active {
            background-color: #6ee7b7 !important; /* Verde Esmeralda */
            animation: pulse 0.5s ease-in-out infinite alternate;
        }
        
        @keyframes pulse {
            from { opacity: 1; }
            to { opacity: 0.7; }
        }

        .queen { pointer-events: none; }

        /* Área de Controles */
        .controls {
            margin-top: 25px;
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 8px;
            color: white;
            transition: transform 0.1s, opacity 0.2s;
            font-weight: bold;
        }
        .btn:active { transform: scale(0.98); }
        .btn:hover { opacity: 0.9; }

        .btn-reset { background-color: #dc2626; } /* Vermelho */
        .btn-hint { background-color: #2563eb; } /* Azul */
    </style>
</head>
<body>

    <div class="header">
        <a href="{{ url('/') }}" class="btn-back">
            &#8592; Voltar
        </a>
        <h1>8 Rainhas</h1>
        <div style="width: 80px;"></div>
    </div>

    <div class="info">Rainhas: <span id="queen-count">0</span>/8</div>
    
    <div class="board" id="board"></div>

    <div class="controls">
        <button class="btn btn-hint" onclick="showHint()">💡 Dica</button>
        <button class="btn btn-reset" onclick="resetBoard()">🗑️ Reiniciar</button>
    </div>

    <script>
        const boardElement = document.getElementById('board');
        const countElement = document.getElementById('queen-count');
        const size = 8;
        let queens = [];

        // --- Inicialização e Tabuleiro ---

        function createBoard() {
            boardElement.innerHTML = '';
            for (let row = 0; row < size; row++) {
                for (let col = 0; col < size; col++) {
                    const cell = document.createElement('div');
                    cell.classList.add('cell');
                    
                    if ((row + col) % 2 === 0) {
                        cell.classList.add('white');
                    } else {
                        cell.classList.add('black');
                    }

                    cell.dataset.row = row;
                    cell.dataset.col = col;
                    cell.addEventListener('click', () => toggleQueen(row, col));
                    boardElement.appendChild(cell);
                }
            }
        }

        function toggleQueen(row, col) {
            clearHints();

            const existingIndex = queens.findIndex(q => q.row === row && q.col === col);

            if (existingIndex !== -1) {
                // Remove se já existir
                queens.splice(existingIndex, 1);
            } else {
                // Adiciona se não existir e limite não atingido
                if (queens.length < 8) {
                    queens.push({ row, col });
                } else {
                    alert("Limite de 8 rainhas atingido!");
                    return;
                }
            }
            updateBoardVisuals();
        }

        function updateBoardVisuals() {
            // Limpa visual
            document.querySelectorAll('.cell').forEach(cell => {
                cell.innerHTML = ''; 
                cell.classList.remove('attacked');
            });

            // 1. Marca ataques (Vermelho)
            queens.forEach(q => markAttacks(q.row, q.col));

            // 2. Desenha Rainhas
            queens.forEach(q => {
                const cell = getCell(q.row, q.col);
                if (cell) cell.innerHTML = '<span class="queen">♛</span>';
            });

            countElement.textContent = queens.length;
        }

        function markAttacks(row, col) {
            document.querySelectorAll('.cell').forEach(cell => {
                const r = parseInt(cell.dataset.row);
                const c = parseInt(cell.dataset.col);

                if (r === row && c === col) return;

                // Lógica de ataque: Linha, Coluna ou Diagonal
                if (r === row || c === col || Math.abs(r - row) === Math.abs(c - col)) {
                    cell.classList.add('attacked');
                }
            });
        }

        // --- LÓGICA DE DICA (Backtracking) ---

        function showHint() {
            clearHints();

            // 1. Verifica se já existe algum conflito
            if (hasConflicts(queens)) {
                alert("O tabuleiro atual já tem rainhas se atacando! Corrija antes de pedir dica.");
                return;
            }

            // 2. Tenta encontrar UMA solução completa
            const currentQueensCopy = queens.map(q => ({...q})); 
            const solution = solveNQueens(currentQueensCopy);

            if (solution) {
                const nextMove = findNextMove(solution, queens);
                
                if (nextMove) {
                    const cell = getCell(nextMove.row, nextMove.col);
                    cell.classList.add('hint-active');
                    
                    setTimeout(() => {
                        cell.classList.remove('hint-active');
                    }, 3000);
                } else {
                    alert("O jogo já está completo e correto!");
                }
            } else {
                alert("Não existe solução possível a partir desta posição! Você precisa remover ou mover alguma rainha antiga.");
            }
        }

        function solveNQueens(currentQueens) {
            if (currentQueens.length === 8) {
                return currentQueens;
            }

            for (let r = 0; r < size; r++) {
                if (currentQueens.some(q => q.row === r)) continue; // Pula linha já ocupada

                for (let c = 0; c < size; c++) {
                    if (isSafe(r, c, currentQueens)) {
                        currentQueens.push({row: r, col: c});
                        
                        const result = solveNQueens(currentQueens);
                        if (result) return result;

                        currentQueens.pop(); // Backtracking
                    }
                }
                return null; 
            }
            return null;
        }

        function isSafe(row, col, existingQueens) {
            for (let q of existingQueens) {
                if (q.row === row || q.col === col) return false;
                if (Math.abs(q.row - row) === Math.abs(q.col - col)) return false;
            }
            return true;
        }

        function hasConflicts(currentQueens) {
            for (let i = 0; i < currentQueens.length; i++) {
                for (let j = i + 1; j < currentQueens.length; j++) {
                    const q1 = currentQueens[i];
                    const q2 = currentQueens[j];
                    if (q1.row === q2.row || q1.col === q2.col || 
                        Math.abs(q1.row - q2.row) === Math.abs(q1.col - q2.col)) {
                        return true;
                    }
                }
            }
            return false;
        }

        function findNextMove(fullSolution, currentBoard) {
            for (let solQ of fullSolution) {
                const exists = currentBoard.some(curQ => curQ.row === solQ.row && curQ.col === solQ.col);
                if (!exists) {
                    return solQ;
                }
            }
            return null;
        }

        // --- Utilitários ---

        function clearHints() {
            document.querySelectorAll('.hint-active').forEach(cell => {
                cell.classList.remove('hint-active');
            });
        }

        function getCell(row, col) {
            return document.querySelector(`.cell[data-row='${row}'][data-col='${col}']`);
        }

        function resetBoard() {
            queens = [];
            clearHints();
            updateBoardVisuals();
        }

        // Iniciar
        createBoard();
    </script>
</body>
</html>