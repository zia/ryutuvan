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
										<table border="0" align="center" cellspacing="1" class="SO_bg" _fixedhead="rows:2; cols:5">
											
											<!--Data Table Header Starts -->
											<!-- Row 1 -->
											<tr>
												<th class="SO_title2" rowspan="2" nowrap>商品名</th>
												<th class="SO_title3" rowspan="2" nowrap></th>
												<th class="SO_title4" colspan="3">全体</th>
												<th class="SO_th3" nowrap>
												<th class='SO_title3' colspan='3'>百合ヶ丘　001</th>
												
												<input type='hidden' name='S_1' id='S_1' value='百合ヶ丘'>
												
												<th class='SO_title3' colspan='3'>築地本店　001</th>
												
												<input type='hidden' name='S_2' id='S_2' value='築地本店'>
												
												<th class='SO_title3' colspan='3'>上野　001</th>
												
												<input type='hidden' name='S_3' id='S_3' value='上野'>
												
												<th class='SO_title3' colspan='3'>渋谷　001</th>
												
												<input type='hidden' name='S_4' id='S_4' value='渋谷'>
												
												<th class='SO_title3' colspan='3'>瀬田支店　10000001</th>
												
												<input type='hidden' name='S_5' id='S_5' value='瀬田支店'>
												
												<th class='SO_title3' colspan='3'>サイクル早稲田　708</th>
												
												<input type='hidden' name='S_6' id='S_6' value='サイクル早稲田'>
												
												<th class='SO_title3' colspan='3'>九番店　900</th>
												
												<input type='hidden' name='S_7' id='S_7' value='九番店'>
												
												<th class='SO_title3' colspan='3'>十番店　1000</th>
												
												<input type='hidden' name='S_8' id='S_8' value='十番店'>
											</tr>
											<!-- Row 2 -->
											<tr>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
												<th class="SO_th3" nowrap>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
												<th class="SO_title5" nowrap>ｹｰｽ</th>
												<th class="SO_title5" nowrap>ﾎﾞｰﾙ</th>
												<th class="SO_title5" nowrap>ﾊﾞﾗ</th>
											</tr>
											<!--Data Table Header Ends -->

											<!--Data Table Data Starts -->
											<?php
												for($i=0;$i<15;$i++) {
											?>
													<!-- Row 1 -->
													<tr>
														<td class='SO_td1' rowspan='2'>
															<table border='0' width='100%'>
																<tr>
																	<td align='left' nowrap>ゴキジェットプロ４５０ｍｌ アース製薬 ４５０ｍｌ</td>
																</tr>
																<tr>
																	<td align='right'>4901080&nbsp;210210</td>
																</tr>
															</table>
														</td>
														<td class='SO_td1' nowrap>発注数</td>
														<td class='SO_td2'>7</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td1'>×</td>
														<th class='SO_th3'></th>
														<td class='SO_td2'>1</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td2'>1</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td2'>1</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td2'>1</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td2'>1</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td2'>1</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td2'></td>
														<td class='SO_td1'></td>
														<td class='SO_td1'></td>
														<td class='SO_td2'>1</td>
														<td class='SO_td1'>×</td>
														<td class='SO_td1'>×</td>
													</tr>

													<!-- Row 2 -->
													<tr>
														<td class='SO_td3'>確定</td>
														<td class='SO_td4'>
															<a href='#' class='link' onClick="CnSelect();">94</a>
														</td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<th class='SO_th3'></th>
														<td class='SO_td4'>21</td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'>2</td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'>1</td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'>1</td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'>1</td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'>2</td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
														<td class='SO_td4'>2</td>
														<td class='SO_td4'></td>
														<td class='SO_td4'></td>
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
	</body>
</html>