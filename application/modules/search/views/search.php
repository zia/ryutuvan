<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<body onLoad="FixedMidashi.create();">
<!-- Search Box -->
<input type="text" name="s_n_s" id="search_field" placeholder="JANまたはインストア入力">
<img src="<?=base_url('assets/img/loader.gif')?>" alt="Searching.." id="loader">

<!-- Mother Table -->
<table id="mother_table">
<!-- Header table begins -->
<tr>
<!-- Primary Heading -->
<td id="primary_heading">
<table>
<tr>
<th class="lefty">
<h1><?=$title?></h1>
</th>
</tr>
<tr>
<td>
<table class="no_border">
<tr>
<td colspan="3" nowrap class="sub-title lefty">
納品日　04月09日
</td>
</tr>
<tr>
<td colspan="3" nowrap class="sub-title lefty">
Ｘスーパー殿
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
<!-- Secondary Heading -->
<td id="secondary_heading">
<div class="fixed_area">
未確定
</div>
</td>
<!-- Button Columns -->
<td id="button_column">

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
<!-- If kbd navigation is required, should be applied on this table -->
<!-- Calculation -->
<?=form_open('search/search_result')?>
<div class="scroll_div">
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
<?php $nm = 1; foreach($subheadings as $subheading) { ?>
<th class="SO_title5 static_sub_header" nowrap>
<?=$subheading->title?>
</th>
<?php $nm++; } ?>

<!-- Border -->
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
<th colspan="5"></th>
<!-- Centering the search field -->
<th colspan="22">&nbsp;</th>

<!-- Search Field -->
<!--<th colspan="9">
</th>-->

<!-- This empty cells colspan needs to calculated -->
<!--<th colspan="8">&nbsp;</th>-->
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
<table border='0' width='100%' class="<?='table_'.$product->row?>">
<tr>
<td class="lefty" style="padding: 5px;" nowrap>
<?=$product->title?>
</td>
</tr>
<tr>
<td class="righty">
<?=$product->quantity?>
</td>
</tr>
</table>
</td>
<td class='SO_td1' style="padding-top: 12px;" nowrap>発注数</td>

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
</td>
</tr>
</table>
</td>
<!-- data tables ends -->
</tr>
</table>
