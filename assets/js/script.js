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
		        			//Do nothing
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
		        			//Do Nothing
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
		        			//Do Nothing
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
	        			if(event.which == 13) {
	        				$('#loader').css("visibility", "visible");
							$.ajax({
				    			url: base_url+"search/update",
				    			type: "GET",
				    			cache: true,
				    			data: {
				    				"data": data
				    			},
				    			success: function(res) {
				    				if(res !=0) {
				    					localStorage['status']=1;
				    					localStorage['focus']='#search_field';
				    					//window.top.location=window.top.location;
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
				    			error: function(err) {
									console.log(err.message);
						  		}
				    		});
				    		$.ajax({
	    						url: base_url+"search/update_info",
	    						type: "GET",
	    						cache: true,
	    						data: {
	    							"data": data
	    						},
	    						success: function(final) {
	    							if(final !=0) {
	    								$('#loader').css("visibility", "hidden");
	    								location.reload();
	    							}
	    							else {
	    								//window.top.location=window.top.location;
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
* Snackbar
*/

function myFunction() {
	var x = document.getElementById("snackbar")
	x.className = "show";
	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

/**
* Prevent Scrolling from Reaching Top
*/
$(document).ready(function() {
	var eTop = 1;
	$('.scroll_div').scrollTop(eTop);
	$('.scroll_div').on("scroll", function(e) {
		var windowScrollTop = $(this).scrollTop();
		if(windowScrollTop < eTop) {
			$(this).scrollTop(eTop);
		}
	});
});

/**
* Sliding
* Unfortunately next-column is done manually.
* Need to check it later.
*/
$(document).ready(function() {
	var scrollSpace = 0;
	$(".scroll_div").scroll(function() {
		scrollSpace = $(".scroll_div").scrollLeft();
	});

	$("#next-column").click(function() {
		if(scrollSpace < 215) {
			// $(".scroll_div").scrollLeft(scrollSpace+=43);

			$(".scroll_div").animate({scrollLeft: '+=43'},300);
			scrollSpace+=43;
		}
		else {
			scrollSpace = 215;
		}
		console.log(scrollSpace);
	});
	$("#previous-column").click(function() {
		if(scrollSpace > 0) {
			// $(".scroll_div").scrollLeft(scrollSpace-=43);

			$(".scroll_div").animate({scrollLeft: '-=43'},300);
			scrollSpace-=43;
		}
		else {
			scrollSpace = 0;
		}
		console.log(scrollSpace);
	});
});
//]]>
