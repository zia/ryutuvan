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
		
		// Check Later
		if($(this).data('val') === '0') {
			$(this).val('');
		}
	});

	$('.SO_input2').on('focusin', function() {
	    $(this).data('val', $(this).val());
	});
	
	$('.SO_input2').on('change', function(event) {
		var product_id = $(this).attr("data-id");
		var val = $(this).val();

		// If value isn't a number keep the previous value.
		if(isNaN(val)) {
			val = $(this).data('val');
			$(this).val(val);
		}
		
		var changed = $(this).attr("id");
		var rest = changed.split("c");
		var column = rest[1];

		$.ajax({
			url: base_url+"home/update_info2",
			type: "POST",
			cache: true,
			data: {
				"product_id": product_id,
				"value": val,
				"column": column
			},
			success: function(result) {
				if(result === 'transaction_error') {
					alert('Transaction Error occured!');
				}
				else {
					// $("#"+changed).load(" #"+changed);
					switch (result % 3 ) {
						case 0:
							$("#c"+product_id).load(" #c"+product_id);
					        break;
						case 1:
					        $("#a"+product_id).load(" #a"+product_id);
					        break;
						default:
					        $("#b"+product_id).load(" #b"+product_id);
					}
					// location.reload();
				}
			},
			error: function(e) {
				console.log(e.message);
			  }
		});
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
	/* By default hidden, shown when search_button clicked. */
	$('#search_row').hide();
	$('#search_button').on('click', function() {
		$('#search_row').toggle();
	});

	/* Change background for searched row. */
	if (typeof(Storage) !== "undefined") {
		if (localStorage['status']) {
		    $(".table_"+localStorage['status']).css("color", "#4256f4");
		    localStorage['status']=0;
		}
	}

	var term = data = '';
	var count = 0;
	$('#search_field').on('keyup', function(event) {
		term = $(this).val();
		if(term != '') {
			$(".SO_input2").attr('disabled','disabled');
			$.ajax({
    			url: base_url+"home/product_lookup",
    			cache: true,
    			type: "GET",
    			data: {"term": term},
    			success: function(result) {
					// if enter pressed
					if(event.which == 13) {
						// if product found
						if(result != 0) {
							data = JSON.parse(result);
							// alert(data[0].id);
	        				$('#loader').css("visibility", "visible");
							$.ajax({
				    			url: base_url+"home/change_position/"+data[0].id,
				    			cache: true,
				    			success: function(res) {
									if(res == -1) {
										//First Row
										// $(this).css("visibility", "visible");
										$("#search_field").val('');
										$(".SO_input2").removeAttr('disabled');
										$('#loader').css("visibility", "hidden");
										$("#snackbar").text('Initial Row');
										myFunction();
										localStorage['focus']='#search_field';
									}
									else if(res !=0) {
										// $(this).css("visibility", "visible");
										$("#search_field").val('');
										for(var i = 1; i <= res; i++) {
											$("#quantity"+i).load(" #quantity"+i);
											$("#title"+i).load(" #title"+i);
										}
										// $("#scroll_div").empty().load(" #scroll_div");

										$(".SO_input2").removeAttr('disabled');
										$('#loader').css("visibility", "hidden");
										$("#snackbar").text('Table Sorted!');
										myFunction();
										
										localStorage['status']=1;
										localStorage['focus']='#search_field';
										// location.reload();
										// console.log('updating.. '+res);
										// $("#reloadable").load(" #reloadable");
				    				}
				    				else {
				    					console.log(res.message);
				    				}
				    			},
				    			error: function(err) {
									console.log(err.message);
						  		}
				    		});
						}
						//No match Found..
						else {
							// $(this).css("visibility", "visible");
							$("#search_field").val('');
							$(".SO_input2").removeAttr('disabled');
							$("#snackbar").text('Product Not Found!');
							$('#loader').css("visibility", "hidden");
							myFunction();
							localStorage['focus']='#search_field';
						}
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
