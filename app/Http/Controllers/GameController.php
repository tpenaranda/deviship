<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GameController extends Controller
{

    public function showBoards(Request $request)
    {

        $boardModel = [
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


        $player = 1;

        $viewData = [
            'appName' => 'Battleship!',
            'opponentBoard' => $this->renderBoard($boardModel),
            'playerBoard' => $this->renderBoard($this->getPlayerShipBoard($player)),
            ];

        return view('home', $viewData);
    }

    public function playerInput(Request $request)
    {

        return response()->json(['opponentBoard' => 'Test!']);
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
}
