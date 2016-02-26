@extends('layouts.master')

@section('content')
    <div class="title">{{ $appName or 'None'}}</div>
    <div id="boards_container" data-player="{{ $player }}">
        <br>
        <div class="left_board">
            Your Ships:<br><br>
            {!! $playerBoard !!}
        </div>
        <div class="right_board">
            Your shoots:<br>
            <div id="messages"><br></div>
            <div id="opponent_board">
                {!! $opponentBoard !!}
            </div>
        </div>
    </div>
@endsection
