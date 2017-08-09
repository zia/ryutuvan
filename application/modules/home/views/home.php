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
			<form method="post" id="main_form" name="form">
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
										<table border="0" align="center" cellspacing="1" class="SO_bg" _fixedhead="rows:2; cols:5">
											
											<!--Data Table Header Starts -->
											<!-- Row 1 -->
											<tr>
												<th class="SO_title2" rowspan="2" nowrap>商品名</th>
												<th class="SO_title3" rowspan="2" nowrap></th>
												<th class="SO_title4" colspan="3">全体</th>

												<!-- Border -->
												<th class="SO_th3" nowrap></th>

												<?php
													/**
													* This is dynamic header rows
													*/
													for($j=0;$j<8;$j++) {
												?>
													<!-- Dynamic column header name and number here -->
													<th class='SO_title3' colspan='3'><?='百合ヶ丘'?>　00<?=$j?></th>
												<?php		
													}
												?>
											</tr>
											<!-- Row 2 -->
											<tr>
												<th class="SO_title5" nowrap><?='ｹｰｽ'?></th>
												<th class="SO_title5" nowrap><?='ﾎﾞｰﾙ'?></th>
												<th class="SO_title5" nowrap><?='ﾊﾞﾗ'?></th>

												<th class="SO_th3" nowrap></th>

												<?php
													/**
													* Each Header got 3 sub columns
													*/
													for($k=0;$k<$j;$k++) {
												?>
														<th class="SO_title5" nowrap><?='ｹｰｽ'?></th>
														<th class="SO_title5" nowrap><?='ﾎﾞｰﾙ'?></th>
														<th class="SO_title5" nowrap><?='ﾊﾞﾗ'?></th>
												<?php		
													}
												?>
											</tr>
											<!--Data Table Header Ends -->

											<!--Data Table Data Starts -->
											<?php
												/**
												* Data Rows
												*/
												for($i=0;$i<2;$i++) {
											?>
													<!-- Row <?=$i?> white -->
													<tr>
														<td class='SO_td1' rowspan='2'>
															<table border='0' width='100%'>
																<tr>
																	<td align='left' nowrap>
																		ランダムアイテム <?=$i?> 〜 100ユニット
																	</td>
																</tr>
																<tr>
																	<td align='right'>100&nbsp;100</td>
																</tr>
															</table>
														</td>
														<td class='SO_td1' nowrap>発注数</td>
														
														<!-- Summation Columns : Row 1 -->
														<td class='SO_tdtr1c1'>7</td>
														<td class='SO_tdtr1c2'>x</td>
														<td class='SO_tdtr1c3'>×</td>

														<!-- Border -->
														<th class='SO_th3'></th>

														<?php
															$c=0;
															for($l=0;$l<$j;$l++) {
														?>
															<td class='SO_td1'>
																<input class="SO_input1" type="number" name="row<?=$i?>col<?=$c++?>" value="0" min="0">
															</td>
															<td class='SO_td2'>
																<input class="SO_input1" type="number" name="row<?=$i?>col<?=$c++?>" value="0" min="0">
															</td>
															<td class='SO_td3'>
																<input class="SO_input1" type="number" name="row<?=$i?>col<?=$c++?>" value="0" min="0">
															</td>
														<?php		
															}
														?>
													</tr>

													<!-- Row <?=$i?> red -->
													<tr>
														<td class='SO_tdn'>確定</td>
														
														<!-- Summation Columns : Row 2 -->
														<td class='SO_tdtr2c1'>
															<a href='#' class='link'>94</a>
														</td>
														<td class='SO_tdtr2c2'></td>
														<td class='SO_tdtr2c3'></td>
														
														<!-- Border -->
														<th class='SO_th3'></th>

														<?php
															$c = 0;
															for($m=0;$m<$j;$m++) {
														?>
																<td class='SO_td4'>
																	<input class="SO_input2" type="number" name="row<?=$i?>col<?=$c++?>" value="0" min="0">
																</td>
																<td class='SO_td5'>
																	<input class="SO_input2" type="number" name="row<?=$i?>col<?=$c++?>" value="0" min="0">
																</td>
																<td class='SO_td6'>
																	<input class="SO_input2" type="number" name="row<?=$i?>col<?=$c++?>" value="0" min="0">
																</td>
														<?php		
															}
														?>
													</tr>
											<?php
												}
											?>
										</table>
									</div>
								</td>
							</tr>
						</table>
					</td>
					<!-- data tables ends -->
				</tr>
			</form>
		</table>

		<!-- Header Scripts begins -- Need to be on top -->
		<!-- JQuery -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		
		<!-- JQuery Migrate -->
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js"></script>
		
		<!-- Fixed Midashi -->
		<script type="text/javascript" src="<?=base_url('assets/js/fixed_midashi.js')?>"></script>
		<!-- Header Scripts ends -->

		<!-- Calculation -->
		<script type="text/javascript">
			
		</script>

	</body>
</html>