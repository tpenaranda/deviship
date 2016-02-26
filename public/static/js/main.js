$(document).ready(function() {
    $('body').on('click', '#opponent_board > table > tbody > tr > td.white', function() {
        if (!yourTurn) {
            alert('Not your turn!');
            return;
        }
        $('#messages').html('Shooting!')
        $.ajax({
            url: '/input',
            type: 'POST',
            traditional: true,
            timeout: 3000,
            data: {
                    _token              : $('#jqueryData').data('csrftoken'),
                    player              : $('#boards_container').data('player'),
                    row                 : $(this).closest('tr').index(),
                    column              : $(this).index()
                },
            success: function(data) {
                data.playsPlayer
                if (data.winner != 0) {
                    alert('Player ' + data.winner + ' wins!')
                }
                $('#opponent_board').html(data.opponentBoard)
                $('#messages').html('Waiting for opponent...')
                yourTurn = false;
            },
            error: function(e) {
                alert('Debug: Something went wrong doing the POST');
            }
        });
    });

    channel.bind('game_event', function(data) {
        console.log(data);
        if ($('#boards_container').data('player') == data.playsPlayer) {
            $('#messages').html('Your turn!')
            yourTurn = true;
        }
    });

});

var pusher = new Pusher('fada390f8da960496c20', { encrypted: true });
var channel = pusher.subscribe('deviship_channel');
var yourTurn = true;
