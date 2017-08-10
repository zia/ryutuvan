<?php
	/**
	* View for Home Page
	* Date : 08.09.2017 (dd.mm.yyyy)
	*/
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
		<table border="0" width="100%" cellspacing="1">
			<tr>
				<!-- Header table -->
				<td width="300px" valign="bottom">
					<table width="100%" border="0">
						<tr>
							<th align="left">
								<h1>受注＆欠品入力画面</h1>
							</th>
						</tr>
						<tr>
							<td>
								<table border="0">
									<tr>
										<td colspan="3" align="left" nowrap class="sub-title">
											納品日　04月09日
										</td>
									</tr>
									<tr>
										<td colspan="3" align="left" nowrap class="sub-title">
											Ｘスーパー殿
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td align="left" valign="bottom" width="180px">
					<div class="fixed_area">
						未確定
					</div>
				</td>
				<td align="right" valign="bottom">
					<button type="button" class="btn_base btn_touroku"
						onClick="showDialogSaleDestination1();">登録
					</button>
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

			<tr id="test">
				<!-- Data Table -->
				<td colspan="3">
					<table border="0">
						<tr>
							<td>
								<div class="scroll_div">
									<!-- If kbd navigation is required, should be applied on this table -->
									<!-- Calculation -->
									<?=form_open('home/update')?>
									<table border="0" align="center" cellspacing="1" class="SO_bg" _fixedhead="rows:2; cols:5">
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
													<th class="SO_title3" colspan="3"><?=$heading?></th>
											<?php		
													$j++;
												}
											?>

										</tr>
										<!-- Row 2 : Sub Headers-->
										<tr>
											<?php foreach($subheadings as $subheading) { ?>
												<th class="SO_title5" nowrap><?=$subheading?></th>
											<?php } ?>

											<th class="SO_th3" nowrap></th>

											<?php
												/**
												* Each Headers got 3 sub heading
												*/
												foreach($headings as $heading) {
													foreach ($subheadings as $subheading) {
											?>
													<th class="SO_title5" nowrap><?=$subheading?></th>
													
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
													<td class='SO_tdtr1c0' id="r<?=$r?>ca">
														<?=$product->total_0?>
													</td>
													<td class='SO_tdtr1c1' id="r<?=$r?>cb">
														<?=$product->total_1?>
													</td>
													<td class='SO_tdtr1c2' id="r<?=$r?>cc">
														<?=$product->total_2?>
													</td>
													<!-- Summation Columns : Row 1 ends -->

													<!-- Border -->
													<th class='SO_th3'></th>

													<?php
														$c=0;
														for($l=0;$l<$j;$l++) {
													?>
														<td class='SO_td1'>
															<input class="SO_input1" type="number" name="r<?=$r?>c<?=$c?>" id="r<?=$r?>c<?=$c++?>" data-cat="<?=$r?>a" value="0" min="0">
														</td>
														<td class='SO_td2'>
															<input class="SO_input1" type="number" name="r<?=$r?>c<?=$c?>" id="r<?=$r?>c<?=$c++?>" data-cat="<?=$r?>b" value="0" min="0">
														</td>
														<td class='SO_td3'>
															<input class="SO_input1" type="number" name="r<?=$r?>c<?=$c?>" id="r<?=$r?>c<?=$c++?>" data-cat="<?=$r?>c" value="0" min="0">
														</td>
													<?php		
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
														<?=$product->total_3?>
													</td>
													<td class='SO_tdtr2c1' id="r<?=$r?>cb">
														<?=$product->total_4?>
													</td>
													<td class='SO_tdtr2c2' id="r<?=$r?>cc">
														<?=$product->total_5?>
													</td>
													
													<!-- Border -->
													<th class='SO_th3'></th>

													<?php
														$c = 0;
														for($m=0;$m<$j;$m++) {
													?>
															<td class='SO_td4'>
																<input class="SO_input2" type="number" name="r<?=$r?>c<?=$c?>" id="r<?=$r?>c<?=$c++?>" data-cat="<?=$r?>a" value="0" min="0">
															</td>
															<td class='SO_td5'>
																<input class="SO_input2" type="number" name="r<?=$r?>c<?=$c?>" id="r<?=$r?>c<?=$c++?>" data-cat="<?=$r?>b" value="0" min="0">
															</td>
															<td class='SO_td6'>
																<input class="SO_input2" type="number" name="r<?=$r?>c<?=$c?>" id="r<?=$r?>c<?=$c++?>" data-cat="<?=$r?>c" value="0" min="0">
															</td>
													<?php		
														}
													?>
												</tr>
										<?php
												$r++;
											}
										?>
									</table>
									<?=form_close()?>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<!-- data tables ends -->
			</tr>
		</table>
		<!-- Header Scripts begins -- Need to be on top -->
		<!-- JQuery -->
		<script
			src="http://code.jquery.com/jquery-1.12.4.min.js"
			integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
			crossorigin="anonymous">
		</script>
		
		<!-- JQuery Migrate -->
		<script
  			src="http://code.jquery.com/jquery-migrate-3.0.0.min.js"
  			integrity="sha256-JklDYODbg0X+8sPiKkcFURb5z7RvlNMIaE3RA2z97vw="
  			crossorigin="anonymous">
  		</script>
		
		<!-- Fixed Midashi -->
		<script type="text/javascript" src="<?=base_url('assets/js/fixed_midashi.js')?>"></script>
		<!-- Header Scripts ends -->

		<!-- Calculation -->
		<script type="text/javascript">
			
			$(document).ready(function() {
			    /**
			    * Disabling up and down key for number input
			    */
			    $('input').bind('keypress', function(e) {
				    if(e.keyCode == 13 || e.keyCode == 40 ) {
				        alert('pressed');
				        //e.preventDefault();
				    }
				});

			    /**
			    * Calc
			    */
			    /*
			    $("input").focusout(function() {
			       var aaa =  parseInt($(this).val());
			       var sum = parseInt($("td#r1ca").text());
			       sum = sum + aaa;
			       $("td#r1ca").html(sum);
			    });
			    */

			    /**
			    * Restricting deletion of default input value.
			    */
				const numInputs = document.querySelectorAll('input[type=number]')
				numInputs.forEach(function (input) {
				  input.addEventListener('change', function (e) {
				    if (e.target.value == '') {
				      e.target.value = 0
				    }
				  })
				});

				
				/**
				* Saving previous value of a cell
				*/
				$('input').on('focusin', function() {
				    console.log("Saving value " + $(this).val());
				    $(this).data('val', $(this).val());
				});

				
				/**
				* Updating value of a cell
				*/
				$('input').on('change', function() {
			    	
			    	var prev = $(this).data('val');
				    var current = $(this).val();
				    /*
				    console.log("Prev value " + prev);
				    console.log("New value " + current);
				    */
				    
				    /**
				    * If value of an existing cell is smaller than the previous one
				    */
				    if(prev > current) {
				    	var difference = prev - current;
				    	$.ajax({
				    		url: "<?=base_url('home/update')?>",
				    		type: "POST",
				    		data: {
				    			"<?=$this->security->get_csrf_token_name()?>": "<?=$this->security->get_csrf_hash()?>",
				    			"difference": difference,
				    			"sum": parseInt($("td#r1ca").text())
				    		},
				    		success: function(result) {
					        	$("td#r1ca").text(result);
					    	},
					    	error: function(e) {
								console.log(e.message);
						  	}
					    });
				    }
				    else {
				    	$.ajax({
				    		url: "<?=base_url('home/update')?>",
				    		type: "POST",
				    		data: {
				    			"<?=$this->security->get_csrf_token_name()?>": "<?=$this->security->get_csrf_hash()?>",
				    			"number": current,
				    			"sum": parseInt($("td#r1ca").text())
				    		},
				    		success: function(result) {
					        	$("td#r1ca").text(result);
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