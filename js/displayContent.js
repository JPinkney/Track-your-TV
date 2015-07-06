/**
 * Decides what to do after the user has clicked the button
 * @return None
 */
function displayContent(){
        var show_title = $('#urlText').val();

        data(show_title);
}

function data(n){
    $.ajax({
        type: 'GET',
        url: '/scripts/checkShow.php',
        async: false,
        data: { show_name: n },
        dataType: 'json',
        success: function(data){
            alert(data);
            $('#tvResults').append('<tr><td>' + "hello1" + '</td><td>' + "hello2" + '</td><td>' + "hello3" + '</td></tr>');
        }
    });
}

/**
 * Gets all of the show names in the database for auto complete
 * @return {Array} String of show names
 */
function autoFill(){
    var autoFill = [];
    $.ajax({
           type: 'GET',
           url: '/scripts/autofill.php',
           dataType: 'json',
           success:function(data){
                autoFill = data;
           }
    });
    return autoFill;
}

function autoFillShows(show){
    var autoFill = [];
    $.ajax({
        type: 'GET',
        url: '/scripts/getWhichTvShow.php?tvshow='.show,
        dataType: 'json',
        success:function(data){
            autoFill = data;
        }
    });
    return autoFill;
}

/**
 * Adds the auto complete to the text section
 * @return None
 */
$(function autoFilling() {
    var availableTags = autoFill();
 $( "#urlText" ).autocomplete({
      source: availableTags,
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
