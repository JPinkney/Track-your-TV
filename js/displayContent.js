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
            var test = [["Buffy the Vampire Slayer","2930"],["Buffy the Vampire Slayer - Season Eight: Motion comics","31192"],["Buffy the Animated Series","2931"]];
            var new_test = [];
            for(var x = 0; x < test.length; x+=1){
                new_test.push({"label":test[x][0], "idx":test[x][1]});
            }

            alert(new_test);

            $("#urlText").autocomplete({
                source: new_test,
                select: function(e, ui) {
                    var show_name = ui.item.idx;
                    //Call the other PHP file using AJAX!
                    alert(show_name);
                }
            });
            $("#urlText").autocomplete("search");

        //}
}

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
            //$('#tvResults').append('<tr><td>' + "hello1" + '</td><td>' + "hello2" + '</td><td>' + "hello3" + '</td></tr>');
            alert(data);
        }
    });
    return related_shows;
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

$(document).ready(function() {
    $("#submitURL").click(function(){

    });
});

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
            //$('#tvResults').append('<tr><td>' + "hello1" + '</td><td>' + "hello2" + '</td><td>' + "hello3" + '</td></tr>');
        }
    });
    return related_shows;
}


 /**
 * Checks the document for an enter click
 */
$(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        $('#submitURL').click();
    }
});
