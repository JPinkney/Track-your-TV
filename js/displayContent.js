/**
 * Displays the TV Show data assosiated with the value inputted
 * 
 * @return None
 */
function displayContent(){
    var show_title = $('#urlText').val();
    var related_show = checkShows(show_title);

    if(related_show.length === 0){
        alert("You are already tracking that show!");
    }else if (related_show[0] === "Not found") {
        alert("Sorry, that show is not found");
    }
    else{
        $('#tvResults').append('<tr><td>' + related_show[0] + '</td><td>' + related_show[1] + '</td><td>' + related_show[2] + '</td></tr>');
    }
    
}

/**
 * Load the users previous data after they log in
 * 
 * @return None
 */
function loadPreviousData(){
    $.getJSON("scripts/loadPreviousData.php", function(data){
        for (var i = 0; i < data.length; i++) {
            $('#tvResults').append('<tr><td>' + data[i][0] + '</td><td>' + data[i][1] + '</td><td>' + data[i][2] + '</td></tr>');
        }
    });
}

/**
 * Adds the auto complete to the text section
 * @return None
 */
function checkShows(n){
    var related_shows = [];
    $.ajax({
        type: 'GET',
        url: 'scripts/checkShow.php',
        async: false,
        data: { show_name: n },
        dataType: 'json',
        success: function(data){
            related_shows = data;
        }
    });
    return related_shows;
}

/**
 * Sets the autofill of text while the user is typing
 * 
 * @return None
 */
$(function autoFilling() {
    $( "#urlText" ).autocomplete({
        source: "scripts/autofill.php",
        autoFocus: true
    });
});

/**
 * Events that must have the document loaded before trying to invoke them 
 */
$(document).ready(function() {

    /**
     * When log in is submitted it checks if the username and password are in the database
     * If they are then log in
     */
    $("#login-modal").submit(function(event) {
        event.preventDefault();

        $.post("scripts/loginVerification.php", $(this).serialize(), function(data){
            if(data == 1){
                window.location.reload();
            }else{
                $('#error').text(data);
            }
        }); 

    });

    /**
     * Register an account with the given username if the username isn't taken
     */
    $("#register-modal").submit(function(event) {
        event.preventDefault();

        $.post("scripts/accountValidation.php", $(this).serialize(), function(data){
            if(data == 1){
                window.location.reload();
            }else{
                $('#register-error').text(data);
            }
        });

    });

    /**
     * Update the users profile if they enter phone number etc etc
     */
    $("#profile-modal").submit(function(event) {
        event.preventDefault();

        $.post("scripts/updateProfile.php", $(this).serialize(), function(data){
            $('#myModal').modal('hide');
        });

    });
});

/**
 * Checks the document for an enter click
 */
$(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        $('#submitURL').click();
    }
});