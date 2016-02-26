<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class GameController extends Controller
{

    const HIT_INT = 1;
    const MISS_INT = 2;
    const SHIP_INT = 3;
    const HITS_TO_WIN_INT = 18;

    public function showBoards(Request $request, $player)
    {

        $emptyBoardModel = [
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0,0,0,0],
        ];

        $request->session()->put("playingBoardPlayer1", $emptyBoardModel);
        $request->session()->put("hitsPlayer1", 0);
        $request->session()->put("playingBoardPlayer2", $emptyBoardModel);
        $request->session()->put("hitsPlayer2", 0);

        $viewData = [
            'appName' => 'Battleship!',
            'opponentBoard' => $this->renderBoard($emptyBoardModel),
            'playerBoard' => $this->renderBoard($this->getPlayerShipBoard($player)),
            'player' => $player,
            ];

        return view('home', $viewData);
    }

    public function playerInput(Request $request)
    {
        $player = $request->player;
        $row = $request->row;
        $column = $request->column;

        $this->doPlayerInput($request);
        $winner = $this->checkForAWinner($request);
        $currentBoard = $request->session()->get("playingBoardPlayer{$player}");

        return response()->json(['opponentBoard' => $this->renderBoard($currentBoard), 'winner' => $winner]);
    }

    private function doPlayerInput($request)
    {
        $player = $request->player;
        $row = $request->row;
        $column = $request->column;

        $opponent = (1 == $player) ? 2 : 1;
        $opponentBoard = $this->getPlayerShipBoard($opponent);
        $playerBoard = $request->session()->get("playingBoardPlayer{$player}");
        $playerHits = $request->session()->get("hitsPlayer{$player}", 0);

        //Check against opponent an set the cell as hit/miss
        if (self::SHIP_INT == $opponentBoard[$row][$column]) {
            $playerBoard[$row][$column] = self::HIT_INT;
            $playerHits++;
        } else {
            $playerBoard[$row][$column] = self::MISS_INT;
        }

        $playerHits = $request->session()->put("hitsPlayer{$player}", $playerHits);
        $request->session()->put("playingBoardPlayer{$player}", $playerBoard);

        $pusher = App::make('pusher');
        $pusher->trigger( 'deviship_channel', 'game_event', ['playsPlayer' => $opponent]);
    }

    private function renderBoard($boardModel)
    {
        $output = '<table class="board">';
        foreach ($boardModel as $boardRow) {
            $output .= '<tr>';
            foreach ($boardRow as $rowColumn) {
                $colors = [1 => 'hit', 2 => 'miss', 3 => 'ship', 'default' => 'white'];
                $class = isset($colors[$rowColumn]) ? $colors[$rowColumn] : $colors['default'];
                $output .= "<td class={$class}></td>";
            }
            $output .= '</tr>';
        }
        return $output.'</table>';
    }

    // So far I will hardcode the player ships positions.
    private function getPlayerShipBoard($player)
    {
        $playersShipsModel = [
        1 => [
                [0,0,0,0,3,3,0,0,0,0],
                [3,0,0,0,0,0,0,0,0,0],
                [0,0,0,3,3,0,0,0,0,0],
                [0,0,0,0,0,0,0,3,0,0],
                [0,0,3,0,0,0,0,3,0,0],
                [0,0,3,0,0,0,0,3,0,0],
                [0,0,3,0,0,0,0,0,0,0],
                [3,0,3,0,0,0,0,0,0,0],
                [0,0,3,0,3,3,3,3,0,0],
                [0,0,0,0,0,0,0,0,0,0],
            ],
        2 => [
                [3,0,0,0,0,0,0,0,0,0],
                [3,0,0,0,0,0,0,3,0,0],
                [3,0,0,0,0,0,0,3,0,0],
                [3,0,0,0,3,3,0,0,0,0],
                [3,0,0,0,0,0,0,0,0,0],
                [0,0,0,0,0,3,0,0,0,0],
                [0,0,0,0,0,0,0,3,0,0],
                [3,3,3,3,0,0,0,0,0,0],
                [0,0,0,0,0,3,3,3,0,0],
                [0,0,0,0,0,0,0,0,0,0],
            ],
        ];

        return isset($playersShipsModel[$player]) ? $playersShipsModel[$player] : false;
    }

    private function checkForAWinner($request)
    {
        if ($request->session()->get("hitsPlayer1", 0) >= self::HITS_TO_WIN_INT)
            return 1;
        if ($request->session()->get("hitsPlayer2", 0) >= self::HITS_TO_WIN_INT)
            return 2;
        return 0;
    }

}
