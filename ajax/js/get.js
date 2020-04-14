$(document).ready(function() {
    $('#btn').click(function() {
        $.get('data.txt', function(data, status) {
            $('#test').html(data);
            alert(status);
        })
    });
});