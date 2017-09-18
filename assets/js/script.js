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
* Calculation
* Does the calcultion
* @param
* @return
*/
$(document).ready(function() {
	/* Change focus for changed data */
	$('.SO_input2').on('click', function() {
	    localStorage['focus'] = '#'+$(this).attr("id");
	});

	$('.SO_input2').on('focusin', function() {
	    $(this).data('val', $(this).val());
	});

	$('.SO_input2').on('change', function(event) {
    	var prev = $(this).data('val');
	    var current = $(this).val();
		var changed = $(this).attr("id");
		var product_id = $(this).attr("data-id");
		var rest = changed.split("c");
		var col = rest[1];
		var temp = rest[0].split("r");
		var row = temp[1];
		var write = '';
		if(col%3 == 0) {
			write = 'a';
		}
		else if(col%3 == 1) {
			write = 'b';
		}
		else {
			write = 'c';
		}
	    if(prev > current) {
	    	var decreased_difference = prev - current;
	    	$.ajax({
	    		url: base_url+"home/update",
	    		type: "POST",
	    		cache: true,
	    		data: {
	    			"number": current,
	    			"decreased_difference": decreased_difference,
	    			"sum": parseInt($("#r"+row+"c"+write).text()),
	    			"row": row,
	    			"col": col,
	    			"write": write,
	    			"product": product_id
	    		},
	    		success: function(result) {
		        	if(result == 'transaction_error') {
		        		alert('Transaction Error occured');
		        	}
		        	else {
		        		var old_val = parseInt($("#r"+row+"c"+write).text());
		        		$("#r"+row+"c"+write).text(result);
		        		if(old_val < 1000 && result < 1000) {
		        			Do nothing
		        		}
		        		else if(old_val.toString().length != result.toString().length) {
		        			location.reload();
		        		}
		        	}
		    	},
		    	error: function(e) {
					console.log(e.message);
			  	}
		    });
	    }
	    else if(prev < current) {
	    	var increased_difference = current - prev;
	    	$.ajax({
	    		url: base_url+"home/update",
	    		type: "POST",
	    		cache: true,
	    		data: {
	    			"number": current,
	    			"increased_difference": increased_difference,
	    			"sum": parseInt($("#r"+row+"c"+write).text()),
	    			"row": row,
	    			"col": col,
	    			"write": write,
	    			"product": product_id
	    		},
	    		success: function(result) {
		        	if(result == 'product_error') {
		        		alert('Product Error occured');
		        	}
		        	else if(result == 'information_error') {
		        		alert('Information Error Occured');
		        	}
		        	else {
		        		var old_val = parseInt($("#r"+row+"c"+write).text());
		        		$("#r"+row+"c"+write).text(result);
		        		if((old_val == 0 || old_val < 100) && (result < 100 || result < 1000)) {
		        			Do Nothing
		        		}
		        		else if(old_val.toString().length != result.toString().length) {
		        			location.reload();
		        		}
		        	}
		    	},
		    	error: function(e) {
					console.log(e.message);
			  	}
		    });
	    }
	    else {
	    	$.ajax({
	    		url: base_url+"home/update",
	    		type: "POST",
	    		cache: true,
	    		data: {
	    			"number": current,
	    			"sum": parseInt($("#r"+row+"c"+write).text()),
	    			"row": row,
	    			"col": col,
	    			"write": write,
	    			"product": product_id
	    		},
	    		success: function(result) {
		        	if(result == 'product_error') {
		        		alert('Product Error occured');
		        	}
		        	else if(result == 'information_error') {
		        		alert('Information Error Occured');
		        	}
		        	else {
		        		var old_val = parseInt($("#r"+row+"c"+write).text());
		        		$("#r"+row+"c"+write).text(result);
		        		if((old_val == 0 || old_val < 100) && (result < 100 || result < 1000)) {
		        			Do Nothing
		        		}
		        		else if(old_val.toString().length != result.toString().length) {
		        			location.reload();
		        		}
		        	}
		    	},
		    	error: function(e) {
					console.log(e.message);
			  	}
		    });
	    }
    });

    function setSelectionRange(input, selectionStart, selectionEnd) {
	  if (input.setSelectionRange) {
	    input.focus();
	    input.setSelectionRange(selectionStart, selectionEnd);
	  } else if (input.createTextRange) {
	    var range = input.createTextRange();
	    range.collapse(true);
	    range.moveEnd('character', selectionEnd);
	    range.moveStart('character', selectionStart);
	    range.select();
	  }
	}

	function setCaretToPos(input, pos) {
	  setSelectionRange(input, pos, pos);
	}

	if (typeof(Storage) !== "undefined") {
		if (localStorage['focus'] != 0 && localStorage['focus'] !== "undefined") {
		    setCaretToPos($(localStorage['focus'])[0], $(localStorage['focus']).val().length);
		    localStorage['focus']= 0;
		}
		else {
			// Check It Later
			localStorage['focus']= 0;
		}
	}
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
	        				$('.product_title.table_1').text(data[0].title);
	        				$('.product_title.table_1').css("color", "#4256f4");
	        				$('.product_quantity.table_1').text(data[0].quantity);
	        				$('.product_title.table_1').css("color", "#4256f4");
	        				$('#r1ca').text(data[0].total_0);
	        				$('#r1cb').text(data[0].total_1);
	        				$('#r1cc').text(data[0].total_2);

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
