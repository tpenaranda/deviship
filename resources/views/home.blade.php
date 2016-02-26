@extends('layouts.master')

@section('content')
    <div class="title">{{ $appName or 'None'}}</div>
    <div id="boards_container" data-player="{{ $player }}">
        <div class="left_board">
            Your Ships:<br>
            {!! $playerBoard !!}
        </div>
        <div class="right_board">
            Your shoots:<br>
            <div id="opponent_board">
                {!! $opponentBoard !!}
            </div>
        </div>
    </div>
@endsection
