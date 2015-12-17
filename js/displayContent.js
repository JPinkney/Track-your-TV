/**
 * Decides what to do after the user has clicked the button
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

function loadPreviousData(){
    $.getJSON("scripts/loadPreviousData.php", function(data){
        for (var i = 0; i < data.length; i++) {
            $('#tvResults').append('<tr><td>' + data[i][0] + '</td><td>' + data[i][1] + '</td><td>' + data[i][2] + '</td></tr>');
        }
    });
}

$(function() {

    // When the form is submitted
    $("#login-modal").submit(function(event) {
        event.preventDefault();
        $.post("scripts/loginVerification.php", $(this).serialize(), function(data){
            if(data == true){
                window.location.reload();
            }else{
                $('#error').text(data);
            }
        });
    });

    // When the form is submitted
    $("#register-modal").submit(function(event) {
        event.preventDefault();

        $.post("scripts/accountValidation.php", $(this).serialize(), function(data){
            if(data == true){
                window.location.reload();
            }else{
                $('#register-error').text(data);
            }
        });
    });

    $("#profile-modal").submit(function(event) {
        event.preventDefault();
        $.post("scripts/updateProfile.php", $(this).serialize(), function(data){
            $('#myModal').modal('hide');
        });
    });
});

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
 * Appends data to the table after getting the info from TVRage
 * @return None
 */
function getShowInfo(n){

    $.ajax({
        type: 'GET',
        url: 'scripts/getShowInfo.php',
        data: { id: n },
        dataType: 'json',
        success: function(data){
            alert("getting the show");
            alert(data);
            $('#tvResults').append('<tr><td>' + data[0] + '</td><td>' + data[1] + '</td><td>' + data[2] + '</td></tr>');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            alert(errorThrown);
        }
    });
}

/**
 * Sets the autofill of text
 * @return None
 */
$(function autoFilling() {
    $( "#urlText" ).autocomplete({
        source: "scripts/autofill.php",
        autoFocus: true
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





















