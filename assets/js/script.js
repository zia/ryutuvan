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
 * On Load Gets The Data
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
				if(count <=25) recursive_ajax();
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
 * And Sorts the table accordingly
 * @param
 * @return
*/
$(document).ready(function() {
	/*Change background color for searched row*/
	if (typeof(Storage) !== "undefined") {
		if (localStorage['status']) {
		    $(".table_"+localStorage['status']).css("color", "#4256f4");
		    localStorage['status']=0;
		}
	}
	var term = '';
	var data = '';
	var count = 0;
	$('#search_field').on('change', function(event) {
		term = $(this).val();
		if(term) {
			$.ajax({
    			url: base_url+"search/search_result/"+term,
    			cache: true,
    			success: function(result) {
	        		if(result!=0 && result!=-1) {
	        			data = JSON.parse(result);
	        			if(data.row>1) {
	        				$(".SO_input2").attr('disabled','disabled');
	        				$('#loader').css("visibility", "visible");
							$.ajax({
				    			url: base_url+"search/update/"+data.row,
				    			cache: true,
				    			success: function(res) {
				    				if(res) {
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
	    						url: base_url+"search/update_info/"+data.row,
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
	    					$('#loader').css("visibility", "hidden");
	    					$(".SO_input2").removeAttr('disabled');
						}
	        		}
	        		else if (result==-1) {
	        			//First Row
	        			$(".SO_input2").attr('disabled','disabled');
    					$('#loader').css("visibility", "visible");
    					$("#search_field").val('');
    					$('#loader').css("visibility", "hidden");
    					myFunction('最初の行');
    					$(".SO_input2").removeAttr('disabled');
    					localStorage['focus']='#search_field';
	        		}
	        		else {
	        			//No match Found..
	        			$(".SO_input2").attr('disabled','disabled');
	        			$('#loader').css("visibility", "visible");
	        			$("#search_field").val('');
	        			$('#loader').css("visibility", "hidden");
	        			myFunction('一致が見つかりません');
	        			$(".SO_input2").removeAttr('disabled');
	        			localStorage['focus']='#search_field';
	        		}
	    		},
	    		error: function(e) {
					console.log(e.message);
		  		}
	    	});
		}
		else {
		}
	});
});

/**
 * Sliding
 * Unfortunately next-column is done manually.
 * Need to check it later.
 */
$(document).ready(function() {
	var currentItem,prevItem,to_move,nextItem;
	$("#previous-column").click(function() {
		currentItem = $(".SO_title3.dynamic_header.move_bitch");
		prevItem = currentItem.prev();
		currentItem.removeClass('move_bitch');
		prevItem.addClass('move_bitch');
		to_move = $(".move_bitch").outerWidth();

		$('.scroll_div').animate({
    		scrollLeft: "-="+to_move+"px"
  		}, 50);
	});
	$("#next-column").click(function() {
		currentItem = $(".SO_title3.dynamic_header.move_bitch");
		nextItem = currentItem.next();
		currentItem.removeClass('move_bitch');
		nextItem.addClass('move_bitch');
		to_move = $(".move_bitch").outerWidth();

		$('.scroll_div').animate({
    		scrollLeft: "+="+to_move+"px"
  		}, 50);
	});
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
function myFunction(msg) {
	$("#snackbar").text(msg);
	var x = document.getElementById("snackbar");
	x.className = "show";
	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

//]]>
