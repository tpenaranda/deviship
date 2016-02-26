$(document).ready(function() {
    $('body').on('click', '#opponent_board > table > tbody > tr > td', function() {
        $('#boards_container').spin()
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
                $('#boards_container').spin(false)
                $('#opponent_board').html(data.opponentBoard)
            },
            error: function(e) {
                alert('Debug: Something went wrong doing the POST');
            }
        });
    });
});

