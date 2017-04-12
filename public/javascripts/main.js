$(function(){

	function openNav() {
	    document.getElementById("mySidenav").style.width = "70%";
	    // document.getElementById("flipkart-navbar").style.width = "50%";
	    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
	}

	function closeNav() {
	    document.getElementById("mySidenav").style.width = "0";
	    document.body.style.backgroundColor = "rgba(0,0,0,0)";
	}

	for(let x = 0; x < $('.show-container').length; x++){
		$('#'+$('.show-container > .middle > .text')[x].id).on('click', function(){
			$.post('/api/shows/removeFromUserViaID', {"showid": $('#'+$('.show-container > .middle > .text')[x].id)[0].id}, function(resp){
				$('#'+$('.show-container > .middle > .text')[x].id).parent().parent().remove();
			});
		});
	}

	$('#search-button').on('click', function(){
		//Do the request to the backend
		var showToAdd = $('#search-input').val();

		$.post('/api/shows/addShowToUser', {'showname': showToAdd}, function(result){

			if(result.message){
				alert(result.message);
				$('#search-input').val('');
			}else{
				$('#middle-container').append('<div class="show-container"><img src=' + result.imagesrc + ' alt="Avatar" class="image"><div class="middle"><div id=' + result.id + ' class="text">Remove Show</div></div>');
				$('#search-input').val('');

				$('#'+result.id).on('click', function(){
					$.post('/api/shows/removeFromUserViaID', {"showid": result.id}, function(resp){
						$('#'+result.id).parent().parent().remove();
					});
				});
			}

		});
	});

});