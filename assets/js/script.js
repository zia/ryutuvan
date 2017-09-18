//<![CDATA[
/**
* Script.js
*
* Scripts for customized functionalities
*
* Date Modified : 08.18.2017 (dd.mm.yyyy)
*
*/

/**
* CSRF
* Includes and regenerates csrf token on each ajax request
*/
$(function() {
    $.ajaxSetup({
       data: csfrData
    });
});


/**
* recursive_ajax
* Loads The Data
* @param
* @return
*/
var count = 1;
$(document).ready(function recursive_ajax() {
		$.ajax({
			url: base_url+"home/calculate/"+count,
			cache: true,
			success: function(res) {
				res = res.replace(/data/g,'');
				res = res.replace(/[()]/g,'');
				res = JSON.parse(res);
				$("#r"+count+"ca").text(res.a.SUM);
				$("#r"+count+"cb").text(res.b.SUM);
				$("#r"+count+"cc").text(res.c.SUM);
				
				count+=2;
				if(count <=13) recursive_ajax();
			},
			error: function(err) {
				console.log(err.message);
	  		}
		});
});

/*
 * On Change add to the sum
 * @param
 * @return 
*/

$(document).ready(function() {
	$('.SO_input2').on('change', function(event) {
    	var new_value = parseInt($(this).val());
		
		var changed = $(this).attr("id");
		var rest = changed.split("c");
		var col = rest[1];
		var temp = rest[0].split("r");
		var row = temp[1];

		$.ajax({
			url: base_url+"home/update/"+row+"/"+col+"/"+new_value,
			cache: false,
			success: function(res) {
				res = res.replace(/data/g,'');
				res = res.replace(/[()]/g,'');
				res = JSON.parse(res);

				$("#r"+row+"ca").text(res.a.SUM);
				$("#r"+row+"cb").text(res.b.SUM);
				$("#r"+row+"cc").text(res.c.SUM);
			},
			error: function(err) {
				console.log(err.message);
	  		}
		});
		// location.reload();
	});
});


/**
 * Search and Sort
 * Moves the searched row to top
 * @param
 * @return
*/
$(document).ready(function() {
	/* Change background for searched row */
	if (typeof(Storage) !== "undefined") {
		if (localStorage['status']) {
		    $(".table_"+localStorage['status']).css("color", "#4256f4");
		    localStorage['status']=0;
		}
	}

	var term = '';
	var data = '';
	var count = 0;
	$('#search_field').on('keyup', function(event) {
		term = $(this).val();
		if(term != '') {
			$(".SO_input2").attr('disabled','disabled');
			$.ajax({
    			url: base_url+"search/search_result",
    			cache: true,
    			type: "GET",
    			data: {
    				"term": term
    			},
    			success: function(result) {
	        		if(result != 0) {
	        			data = JSON.parse(result);
	        			if(event.which == 13 && data[0].row > 1) {
	        				$('#loader').css("visibility", "visible");
							$.ajax({
				    			url: base_url+"search/update/"+data[0].row,
				    			cache: true,
				    			success: function(res) {
				    				if(res !=0) {
				    					localStorage['status']=1;
				    					localStorage['focus']='#search_field';
				    				}
				    				else {
				    					console.log(res.message);
				    				}
				    			},
				    			error: function(err) {
									console.log(err.message);
						  		}
				    		});
				    		$.ajax({
	    						url: base_url+"search/update_info/"+data[0].row,
	    						cache: true,
	    						success: function(final) {
	    							if(final) {
	    								$('#loader').css("visibility", "hidden");
	    								location.reload();
	    							}
	    							else {
	    								console.log(final.message);
	    							}
	    						},
	    						error: function(err) {
									console.log(err.message);
			  					}
	    					});
						}
	        		}
	        		else if (result == 0 && event.which==13) {
	        			//No match Found..
	        			$(this).css("visibility", "visible");
	        			$("#search_field").val('');
	        			$(".SO_input2").removeAttr('disabled');
	        			$("#snackbar").text('一致が見つかりません');
	        			$(this).css("visibility", "hidden");
	        			myFunction();
	        			localStorage['focus']='#search_field';
	        		}
	        		else {
	        			//First Row
    					$('#loader').css("visibility", "visible");
    					$("#search_field").val('');
    					$(".SO_input2").removeAttr('disabled');
    					$('#loader').css("visibility", "hidden");
    					$("#snackbar").text('最初の行');
    					myFunction();
    					localStorage['focus']='#search_field';
	        		}
	    		},
	    		error: function(e) {
					console.log(e.message);
		  		}
	    	});
		}
		else {
			$(".SO_input2").removeAttr('disabled');
		}
	});
});

/**
* Sliding
* Unfortunately next-column is done manually.
* Need to check it later.
*/
$(document).ready(function() {
	var inc = [];
	var i = 0;
	$('.dynamic_header').each(function(index) {
    	inc[i] = parseInt($(this).outerWidth(),0);
    	i++;
	});
	i = 0;
	var count = 1;
	$("#previous-column").mousedown(function() {
		timeout = setInterval(function() {
			if(count > 1)
        		count -=inc[--i];
        	else
        		count = 1;
        	movePlayer(count);
    	}, 50);
    	return false;
	});

	$("#next-column").mousedown(function() {
		timeout = setInterval(function() {
        	if(count < 482)
        		count +=inc[++i];
        	else
        		count = 482;
        	movePlayer(count);
    	}, 50);
    	return false;
	});

	$("#previous-column, #next-column").mouseup(function() {
			clearInterval(timeout);
    		return false;
	});

	function movePlayer(intMovement) {
		$(".scroll_div").animate({
			'scrollLeft': intMovement
		},50);
	}
});

/**
* Go to Top and Toggle Top Section subsequently
*/
$(document).ready(function() {
	$('.scroll_div').scroll(function() {
		if ($(this).scrollTop() > 0) {
			$('.go-top').fadeIn(200);
			$('#search_field').hide();
			$('#topheaderbar').hide();
		} else {
			$('.go-top').fadeOut(200);
			$('#topheaderbar').show();
			$('#search_field').show();
		}
	});
	
	$('.go-top').click(function(event) {
		event.preventDefault();
		$('#search_field').show();
		$('.scroll_div').animate({scrollTop: 0}, 200);
	})
});

/**
* Snackbar
*/
function myFunction() {
	var x = document.getElementById("snackbar")
	x.className = "show";
	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

//]]>
