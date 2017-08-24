<?php
	/**
	* View for Home Page
	* Date : 08.09.2017 (dd.mm.yyyy)
	*/
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Script-Type" content="text/javascript; charset=UTF-8">
		
		<!-- Title -->
		<title>受注＆欠品入力画面</title>
		
		<!-- Styles -->
		
		<!-- Font-Awesome -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

		<!-- Webss_SO -->
		<link rel=stylesheet href="<?=base_url('assets/css/webss_so.css')?>">

		<!-- Styles.css -->
		<link rel=stylesheet media="screen" href="<?=base_url('assets/css/styles.css')?>">
	</head>
	
	<body link="#000000" vlink="#000000" alink="#000000" onLoad="FixedMidashi.create();">
		
		<!-- Mother Table -->
		<table style="width: 100%; border: 0px;border-collapse: collapse; border-spacing: 1;margin-top: -20px;">
			<!-- Header table begins -->
			<tr>
				<!-- Primary Heading -->
				<td style="width: 300px;">
					<table style="width: 100%;border: 0px;">
						<tr>
							<th style="text-align:left;">
								<h1>受注＆欠品入力画面</h1>
							</th>
						</tr>
						<tr>
							<td>
								<table style="border: 0px;">
									<tr>
										<td colspan="3" style="text-align:left;" nowrap class="sub-title">
											納品日　04月09日
										</td>
									</tr>
									<tr>
										<td colspan="3" style="text-align:left;" nowrap class="sub-title">
											Ｘスーパー殿
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<!-- Secondary Heading -->
				<td style="text-align:left;vertical-align: bottom;width: 14%;">
					<div class="fixed_area">
						未確定
					</div>
				</td>
				<!-- Button Columns -->
				<td style="text-align:right;vertical-align: bottom;">
					
					<a class="btn_default" href="">登録</a>

					<a class="btn_primary" href="">終了</a>

					<a class="btn_success" href="<?=base_url()?>">手書入力</a>

					<a class="btn_info" href="" class="btn">履歴</a>

					<a class="btn_warning" href="" class="btn">販売先一覧</a>

					<a class="btn_danger" href="" class="btn">機能</a>

					<div class="slider">
						<div class="next-column">
							<button id='next-column'> 右へ移動</button>
						</div>
						<div class="previous-column">
							<button id='previous-column'> 左へ移動</button>
						</div>
					</div>
				</td>
			</tr>
			<!-- Header table ends -->

			<tr>
				<!-- Data Table -->
				<td colspan="3">
					<table border="0">
						<tr>
							<td>
								<div class="scroll_div">
									<!-- If kbd navigation is required, should be applied on this table -->
									<!-- Calculation -->
									<?=form_open('search/search_result')?>
									<div class="seperator">
										<table align="center" cellspacing="1" class="SO_bg" _fixedhead="rows:3; cols:5">
											<!--Data Table Header Starts -->
											<!-- Row 1 : Main Headers -->
											<tr>
												<!-- First 3 Headings -->
												<th class="SO_title2" rowspan="2" nowrap>商品名</th>
												<th class="SO_title3" rowspan="2" nowrap></th>
												<th class="SO_title4" colspan="3">全体</th>

												<!-- Border -->
												<th class="SO_th3" nowrap></th>

												<?php
													/**
													* This is dynamic header rows
													*/
													$j=0;
													foreach ($headings as $heading) {
												?>
														<!-- Dynamic column header name and number here -->
														<th class="SO_title3" colspan="3">
															<?=$heading->title?>
														</th>
												<?php		
														$j++;
													}
												?>
											</tr>
											<!-- Row 2 : Sub Headers-->
											<tr>
												<?php foreach($subheadings as $subheading) { ?>
													<th class="SO_title5" nowrap>
														<?=$subheading->title?>
													</th>
												<?php } ?>

												<th class="SO_th3" nowrap></th>

												<?php
													/**
													* Each Headers got 3 sub heading
													*/
													foreach($headings as $heading) {
														foreach ($subheadings as $subheading) {
												?>
														<th class="SO_title5" nowrap><?=$subheading->title?></th>
														
												<?php		
														}
													}
												?>
											</tr>
											<!-- Row 3 : Search and Sort -->
											<tr id="search_row">
												<!-- There is Five Fixed header Columns -->
												<th style="" class="" colspan="5">&nbsp;</th>

												<!-- Centering the search field -->
												<th class="" colspan="7">&nbsp;</th>

												<!-- Search Field -->
												<th class="" colspan="9">
													<input type="text" name="s_n_s" id="search_field" placeholder="JANまたはインストア入力">
													<div id="live_search">
														<table id="suggestionTable">
															<tbody>
																<tr>
																	<th>SL.</th>
																	<th>Product ID</th>
																	<th>Product Name</th>
																</tr>
															</tbody>
														</table>
													</div>
												</th>

												<!-- This empty cells colspan needs to calculated -->
												<th class="" colspan="6">&nbsp;</th>
											</tr>
											<!--Data Table Header Ends -->

											<!--Data Table Data Starts -->

											<?php
												/**
												* Data Rows
												*/
												$r = 0;
												$p = 0;
												foreach ($products as $product) {
											?>
													<!-- Row <?=$r?> white -->
													<tr>
														<td class='SO_td1' rowspan='2'>
															<table border='0' width='100%' class="<?='table_'.$product->id?>">
																<tr>
																	<td style="padding: 5px;" align='left' nowrap>
																		<?=$product->title?>
																	</td>
																</tr>
																<tr>
																	<td align='right'><?=$product->quantity?></td>
																</tr>
															</table>
														</td>
														<td class='SO_td1' nowrap>発注数</td>
														
														<!-- Summation Columns : Row 1 starts -->
														<!--
															ca = column a
															cb = column b
															cc = column c
														-->
														<td class='SO_tdtr1c0' id="r<?=$r?>ca">0</td>
														<td class='SO_tdtr1c1' id="r<?=$r?>cb">0</td>
														<td class='SO_tdtr1c2' id="r<?=$r?>cc">0</td>
														<!-- Summation Columns : Row 1 ends -->

														<!-- Border -->
														<th class='SO_th3'></th>

														<?php
															$c=0;
															foreach ($headings as $heading) {
																foreach ($subheadings as $subheading) {
														?>
																	<td class='SO_td1'>0</td>
														<?php
																}
															}
														?>
													</tr>
											<?php
												$r++;
											?>

													<!-- Row <?=$r?> red -->
													<tr>
														<td class='SO_tdn'>確定</td>
														
														<!-- Summation Columns : Row 2 -->
														<!--
															ca = column a
															cb = column b
															cc = column c
														-->
														<td class='SO_tdtr2c0' id="r<?=$r?>ca">
															<?=$product->total_0?>
														</td>
														<td class='SO_tdtr2c1' id="r<?=$r?>cb">
															<?=$product->total_1?>
														</td>
														<td class='SO_tdtr2c2' id="r<?=$r?>cc">
															<?=$product->total_2?>
														</td>
														
														<!-- Border -->
														<th class='SO_th3'></th>

														<?php
															$c = 0;
															foreach ($headings as $heading) {
																foreach ($subheadings as $subheading) {
														?>
																	<td class='SO_td4'>
																		<input
																			class="SO_input2"
																			type="text"
																			pattern="[0-9].{0,}"
																			name="r<?=$r?>c<?=$c?>"
																			data-id="<?=$product->id?>"
																			value="<?=$infos[$p++]->data?>"
																			id="r<?=$r?>c<?=$c++?>"
																			maxlength="5"
																			minlength="1"
																		>
																	</td>
														<?php
																}
															}
														?>
													</tr>
											<?php
													$r++;
												}
											?>
										</table>
									</div>
									<?=form_close()?>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<!-- data tables ends -->
			</tr>
		</table>
		<!-- Header Scripts begins; Need to be on top; If Necessary -->
		<!-- JQuery -->
		<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
		
		<!-- JQuery Migrate -->
		<script src="<?=base_url('assets/js/jquery-migrate.js')?>"></script>
		
		<!-- Fixed Midashi -->
		<script type="text/javascript" src="<?=base_url('assets/js/fixed_midashi.js')?>"></script>
		<!-- Header Scripts ends -->

		<!-- Search -->
		<script type="text/javascript">
			$(document).ready(function() {
				
				/* Change background for searched row */
				if (typeof(Storage) !== "undefined") {
					if (localStorage['status']) {
					    $(".table_"+localStorage['status']).css("background-color", "#c9d6e5");
					    localStorage['status']=0;
					}
				}

				var term = '';
				var data = '';
				var count = 0;
				$('#search_field').on('keyup', function(event) {
					//if(event.keyCode != 8) {
						//Show The Result section
						//$("#live_search").css("visibility", "visible");

						term = $(this).val();
						if(term != '') {
						$.ajax({
				    		url: "<?=base_url('search/search_result')?>",
				    		cache: false,
				    		type: "POST",
				    		data: {
				    			"<?=$this->security->get_csrf_token_name()?>": "<?=$this->security->get_csrf_hash()?>",
				    			"term": term
				    		},
				    		success: function(result) {
					        	if(result != 0) {
					        		$(".no_match").remove();
					        		$(".result_row").remove();

					        		//Match Found !
					        		data = JSON.parse(result);

					        		/* !Important
					        		* config changed
					        		*/
					        		
					        		/*If you want to use both sorting and live search feature. Use the count== 1 condition below..(Here you're getting only the specific match..(from where not like..))..Take a look you've to paste the full name of the product to find it..*/
					        		//count = Object.keys(data).length;
  									//console.log(count);

  									/*The feature is developed for live search.. so the query is written as it is (like operator instead of get_where).This query returns >1 value for similar result and 1 for exact match.. To enable the live search feature uncomment the result section..*/
  									//if(count == 1) {
  									//}

					        		/* First matched then grab keypress enter */
					        		
					        		if(event.which == 13) {
        								$.ajax({
								    		url: "<?=base_url('search/update')?>",
								    		type: "POST",
								    		cache: false,
								    		data: {
								    			"<?=$this->security->get_csrf_token_name()?>": "<?=$this->security->get_csrf_hash()?>",
								    			"data": data
								    		},
								    		success: function(res) {
								    			//console.log(res);
								    			if(res != 'negetive') {
								    				window.top.location=window.top.location;
								    				localStorage['status']=res;
								    			}
								    			else {
								    				console.log('FIRST_ROW');
								    			}
								    		},
								    		error: function(err) {
												console.log(err.message);
										  	}
								    	});
    								}

					        		$.each( data, function( key, value ) {
										$('#suggestionTable > tbody:last-child').append('<tr class="result_row"><td><a href="#">'+ ++key +'</a></td><td><a href="#">'+value.quantity+'</a></td><td><a href="#">'+value.title+'</a></td></tr>');
									});
					        	}
					        	else {
					        		$(".result_row").remove();
					        		$(".no_match").remove();
					        		
					        		//No Match Found !
					        		$('#suggestionTable > tbody:last-child').append(
										'<tr class="no_match"><td colspan="3">No Match Found !</td></tr>'
									);
					        	}
					    	},
					    	error: function(e) {
								console.log(e.message);
						  	}
					    });
						}

						else {
							//Remove Things..
							$(".result_row").remove();
							$(".no_match").remove();
							//On emtying field value
							$("#live_search").css("visibility", "hidden");
						}
					//}
				});
			});
		</script>

		<!-- Calculation -->
		<script type="text/javascript">
			
			$(document).ready(function() {
				/* ------------ Calculation ------------ */
				/**
				* Saver
				* Saving previous value of a cell
				*/
				$('.SO_input2').on('focusin', function() {
				    //console.log("Saving value " + $(this).val());
				    $(this).data('val', $(this).val());
				});

				
				/**
				* Updating value of a cell
				*/
				$('.SO_input2').on('change', function(event) {

				    /* Previous value of the changed element @Saver */
			    	var prev = $(this).data('val');
			    	/* New value of the changed element */
				    var current = $(this).val();

				    //Turning off temporarily
				    //if(current == '') {
				    	//$(this).val('0');
				    //}

					/* Element changed */
					//var changed = event.target.id; -> FireFox dosen't support this.
					var changed = $(this).attr("id");
					var product_id = $(this).attr("data-id");

					/* 
					* First split based on column 'c' then
					* split the existing string based on row 'r'
					*/
					/* Column */
					var rest = changed.split("c");
					var col = rest[1];

					/* row */
					var temp = rest[0].split("r");
					var row = temp[1];

					//console.log('row = '+ row +', col = '+ col);
					/* Got row and column of changed element */
				    
					/**
					* If col%3 == 0 write in ca
					* else if col%3 == 1 write in cb
					* else write in cc
					*/
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

				    /**
				    * If value of an existing cell is smaller than the previous one
				    */
				    if(prev > current) {
				    	/**
				    	* Need to deduct the difference only
				    	* Ex: summation column = 50, random value of a cell was 6 and updated to 4
				    	* So the summation will be 48.
				    	*/
				    	var decreased_difference = prev - current;
				    	$.ajax({
				    		url: "<?=base_url('index.php/home/update')?>",
				    		type: "POST",
				    		cache: false,
				    		data: {
				    			"<?=$this->security->get_csrf_token_name()?>": "<?=$this->security->get_csrf_hash()?>",
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
					        		$("#r"+row+"c"+write).text(result);
					        	}
					    	},
					    	error: function(e) {
								console.log(e.message);
						  	}
					    });
				    }
				    /**
				    * If value of an existing cell is greater than the previous one
				    */
				    else if(prev < current) {
				    	/**
				    	* Need to add the difference only
				    	* Ex: summation column = 50, random value of a cell was 4 and updated to 6
				    	* So the summation will be 52.
				    	*/
				    	var increased_difference = current - prev;
				    	$.ajax({
				    		url: "<?=base_url('index.php/home/update')?>",
				    		type: "POST",
				    		cache: false,
				    		data: {
				    			"<?=$this->security->get_csrf_token_name()?>": "<?=$this->security->get_csrf_hash()?>",
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
					        		$("#r"+row+"c"+write).text(result);
					        	}
					    	},
					    	error: function(e) {
								console.log(e.message);
						  	}
					    });
				    }
				    else {
				    	$.ajax({
				    		url: "<?=base_url('index.php/home/update/')?>",
				    		type: "POST",
				    		cache: false,
				    		data: {
				    			"<?=$this->security->get_csrf_token_name()?>": "<?=$this->security->get_csrf_hash()?>",
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
					        		$("#r"+row+"c"+write).text(result);
					        	}
					    	},
					    	error: function(e) {
								console.log(e.message);
						  	}
					    });
				    }
			    });
			});
		</script>

	</body>
</html>