/**
 * Decides what to do after the user has clicked the button
 * @return None
 */
function displayContent(){
    var show_title = $('#urlText').val();

    //var related_shows = checkShows(show_title);
    //alert("here");
    //alert(related_shows);
    //if the show is not already in the database
    // if(related_shows != NULL || related_shows != []){
    //We need to call an additional php file
    //autocomplete the thing then get the result


    var related_show = checkShows(show_title);

    var related_shows = [];
    for(var x = 0; x < related_show.length; x+=1){
        related_shows.push({"label":related_show[x][0], "idx":related_show[x][1]});
    }

    $("#urlText").autocomplete({
        source: related_shows,
        select: function(e, ui) {
            var show_id = ui.item.idx;
            //alert(show_name);
            getShowInfo(show_id);
        }
    });
    $("#urlText").autocomplete("search");

    //}
}

/**
 * Gets all of the show names in the database for auto complete
 * @return {Array} String of show names
 */


/**
 * Adds the auto complete to the text section
 * @return None
 */

function checkShows(n){
    var related_shows = [];
    $.ajax({
        type: 'GET',
        url: '/scripts/checkShow.php',
        async: false,
        data: { show_name: n },
        dataType: 'json',
        success: function(data){
            related_shows = data;
        }
    });
    return related_shows;
}

function getShowInfo(n){
    $.ajax({
        type: 'GET',
        url: '/scripts/getShowInfo.php',
        data: { id: n },
        dataType: 'json',
        success: function(data){
            $('#tvResults').append('<tr><td>' + data[0] + '</td><td>' + data[1] + '</td><td>' + data[2] + '</td></tr>');
        }
    });
}

$(function autoFilling() {
    $( "#urlText" ).autocomplete({
        source: "/scripts/autofill.php",
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





















