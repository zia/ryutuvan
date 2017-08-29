<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<body onLoad=FixedMidashi.create()>
<table id=mother_table>
<tr>
<td id=primary_heading>
<table>
<tr>
<th class=lefty>
<h1><?=$title?></h1>
</th>
</tr>
<tr>
<td>
<table class=no_border>
<tr>
<td colspan=3 nowrap class="sub-title lefty">
納品日　04月09日
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
<a class=btn_success href=<?=base_url('search')?>>手書入力</a>
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
<table class=no_border>
<tr>
<td>
<?=form_open('home/update')?>
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
<th class=SO_title5 nowrap>
<?=$subheading->title?>
</th>
<?php		
}
}
?>
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
<td align=left nowrap>
<?=$product->title?>
</td>
</tr>
<tr>
<td align=right><?=$product->quantity?></td>
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
</td>
</tr>
</table>
</td>
</tr>
</table>