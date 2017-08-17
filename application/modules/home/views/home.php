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
		<link rel=stylesheet href="<?=base_url('assets/css/webss_so.css')?>">
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
					
					<button type="button" class="btn_base btn_touroku" onClick="showDialogSaleDestination1();">登録</button>

					<button type="button" value="code" class="btn_base btn_kanryou" onClick="showDialogComplete1();">終了</button>

					<button type="button" value="code" id="manual-input" class="btn_base btn_handwriting">手書入力</button>

					<button type="button" value="code" class="btn_base btn_rireki" onClick="ScreenChange('FIXED');">履歴</button>

					<button type="button" value="code" class="btn_base btn_kouri" onClick="List('OPEN','UNFIXED');">販売先<br>一覧</button>

					<button type="button" value="code" class="btn_base btn_kouri" onClick="Func('OPEN');">機能</button>

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
									<?=form_open('home/update')?>
									<div class="seperator">
										<table align="center" cellspacing="1" class="SO_bg" _fixedhead="rows:2; cols:5">
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
															<table border='0' width='100%'>
																<tr>
																	<td align='left' nowrap>
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
		<script
			src="https://code.jquery.com/jquery-1.12.4.min.js"
			integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
			crossorigin="anonymous">
		</script>
		
		<!-- JQuery Migrate -->
		<script
  			src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"
  			integrity="sha256-JklDYODbg0X+8sPiKkcFURb5z7RvlNMIaE3RA2z97vw="
  			crossorigin="anonymous">
  		</script>
		
		<!-- Fixed Midashi -->
		<script type="text/javascript" src="<?=base_url('assets/js/fixed_midashi.js')?>"></script>
		<!-- Header Scripts ends -->

		<!-- Calculation -->
		<script type="text/javascript">
			
			$(document).ready(function() {
				/* ------------ Calculation ------------ */
				/**
				* Saver
				* Saving previous value of a cell
				*/
				$('input').on('focusin', function() {
				    //console.log("Saving value " + $(this).val());
				    $(this).data('val', $(this).val());
				});

				
				/**
				* Updating value of a cell
				*/
				$('input').on('change', function(event) {

				    /* Previous value of the changed element @Saver */
			    	var prev = $(this).data('val');
			    	/* New value of the changed element */
				    var current = $(this).val();

				    if(current == '') {
				    	$(this).val('0');
				    }

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