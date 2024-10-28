$(document).ready(function() {
    $('.flash-message').each(function() {
        $(this).slideDown('slow');

        $(this).find('.close-btn').on('click', function() {
            $(this).parent('.flash-message').slideUp('slow', function() {
                $(this).remove();
            });
        });

        setTimeout(() => {
            $(this).slideUp('slow', function() {
                $(this).remove();
            });
        }, 5000); // Adjust the timeout as needed
    });
});