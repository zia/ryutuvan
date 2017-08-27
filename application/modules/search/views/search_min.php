<?php
/**
* View for Search Page
* Date : 19.09.2017 (dd.mm.yyyy)
*/
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
<meta name=viewport content="width=device-width, initial-scale=1.0">
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta http-equiv=Content-Script-Type content="text/javascript; charset=UTF-8">
<title>受注＆欠品入力画面</title>
<link href=https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css rel=stylesheet integrity=sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN crossorigin=anonymous>
<link rel=stylesheet href=<?=base_url('assets/css/webss_so.css')?>>
<link rel=stylesheet media=screen href=<?=base_url('assets/css/styles.css')?>>
</head>
<body onLoad=FixedMidashi.create()>
<table id=mother_table>
<tr>
<td id=primary_heading>
<table>
<tr>
<th class=lefty>
<h1>受注＆欠品入力画面</h1>
</th>
</tr>
<tr>
<td>
<table class=no_border>
<tr>
<td colspan=3 nowrap class="sub-title lefty">
納品日 04月09日
</td>
</tr>
<tr>
<td colspan=3 nowrap class="sub-title lefty">
Ｘスーパー殿
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
<td id=secondary_heading>
<div class=fixed_area>
未確定
</div>
</td>
<td id=button_column>
<a class=btn_default href>登録</a>
<a class=btn_primary href>終了</a>
<a class=btn_success href=<?=base_url()?>>手書入力</a>
<a class=btn_info href class=btn>履歴</a>
<a class=btn_warning href class=btn>販売先一覧</a>
<a class=btn_danger href class=btn>機能</a>
<div class=slider>
<div class=next-column>
<button id=next-column> 右へ移動</button>
</div>
<div class=previous-column>
<button id=previous-column> 左へ移動</button>
</div>
</div>
</td>
</tr>
<tr>
<td colspan=3>
<table border=0>
<tr>
<td>
<div class=scroll_div>
<?=form_open('search/search_result')?>
<div class=scroll_div>
<table align=center cellspacing=1 class=SO_bg _fixedhead="rows:2; cols:5">
<tr>
<th class=SO_title2 rowspan=2 nowrap>商品名</th>
<th class=SO_title3 rowspan=2 nowrap></th>
<th class="SO_title4 healthy_border" colspan=3>全体</th>
<?php
/**
* This is dynamic header rows
*/
$j=0;
foreach ($headings as $heading) {
?>
<th class=SO_title3 colspan=3>
<?=$heading->title?>
</th>
<?php		
$j++;
}
?>
</tr>
<tr>
<?php $nm = 1; foreach($subheadings as $subheading) { ?>
<th class="SO_title5 static_sub_header <?= $nm == 3 ? 'healthy_border' : ''?>" nowrap>
<?=$subheading->title?>
</th>
<?php $nm++; } ?>
<?php
/**
* Each Headers got 3 sub heading
*/
foreach($headings as $heading) {
foreach ($subheadings as $subheading) {
?>
<th class=SO_title5 nowrap><?=$subheading->title?></th>
<?php		
}
}
?>
</tr>
<tr id=search_row>
<th colspan=5>&nbsp;</th>
<th colspan=5>&nbsp;</th>
<th colspan=9>
<input type=text name=s_n_s id=search_field placeholder=JANまたはインストア入力>
<div id=live_search>
<table id=suggestionTable>
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
<th colspan=8>&nbsp;</th>
</tr>
<?php
/**
* Data Rows
*/
$r = 0;
$p = 0;
foreach ($products as $product) {
?>
<tr>
<td class=SO_td1 rowspan=2>
<table border=0 width=100%>
<tr>
<td class=lefty style=padding:5px nowrap>
<?=$product->title?>
</td>
</tr>
<tr>
<td class=righty>
<div class=<?='table_'.$product->id?>><?=$product->quantity?></div>
</td>
</tr>
</table>
</td>
<td class=SO_td1 nowrap>発注数</td>
<td class=SO_tdtr1c0 id=r<?=$r?>ca>0</td>
<td class=SO_tdtr1c1 id=r<?=$r?>cb>0</td>
<td class='SO_tdtr1c2 healthy_border' id=r<?=$r?>cc>0</td>
<?php
$c=0;
foreach ($headings as $heading) {
foreach ($subheadings as $subheading) {
?>
<td class=SO_td1>0</td>
<?php
}
}
?>
</tr>
<?php
$r++;
?>
<tr>
<td class=SO_tdn>確定</td>
<td class=SO_tdtr2c0 id=r<?=$r?>ca>
<?=$product->total_0?>
</td>
<td class=SO_tdtr2c1 id=r<?=$r?>cb>
<?=$product->total_1?>
</td>
<td class='SO_tdtr2c2 healthy_border' id=r<?=$r?>cc>
<?=$product->total_2?>
</td>
<?php
$c = 0;
foreach ($headings as $heading) {
foreach ($subheadings as $subheading) {
?>
<td class=SO_td4>
<input class=SO_input2 type=text pattern=[0-9].{0,} name=r<?=$r?>c<?=$c?> data-id=<?=$product->id?> value=<?=$infos[$p++]->data?> id=r<?=$r?>c<?=$c++?> maxlength=5 minlength=1>
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
</tr>
</table>
<div id=snackbar></div>
<script src=<?=base_url('assets/js/jquery.min.js')?>></script>
<script src=<?=base_url('assets/js/jquery-migrate.js')?>></script>
<script type=text/javascript src=<?=base_url('assets/js/fixed_midashi.js')?>></script>
<script type=text/javascript>var base_url="<?=base_url()?>",csrf_name="<?=$this->security->get_csrf_token_name()?>",csrf_hash="<?=$this->security->get_csrf_hash()?>";</script>
<script type=text/javascript src=<?=base_url('assets/js/script.js')?>></script>
<!--<script type=text/javascript src=<?=base_url('assets/js/script.min.js')?>></script>-->
</body>
</html>