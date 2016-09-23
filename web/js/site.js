$(document).ready(function () {
    $('body').on('submit', '#kladr-search', function (event) {
        event.stopPropagation();
        event.preventDefault();
        var formAction = $(this).attr('action');
        var formData = $(this).serialize();
        $('#kladr-results').hide();
        $('#kladr-results').find('tr').remove();
        $.ajax({
            type: "POST",
            url: formAction,
            data: formData,
            success: function (data) {
                if($(data).filter('#kladr-recent-queries').length > 0) {
                    console.log('test')
                    $('#kladr-recent-queries').html($(data).filter('#kladr-recent-queries').html());
                }
                if($(data).filter('#kladr-results').length > 0) {
                    $('#kladr-results').html($(data).filter('#kladr-results').html());
                    $('#kladr-results').show();
                }
            },
            dataType: 'html'
        });
    });
});