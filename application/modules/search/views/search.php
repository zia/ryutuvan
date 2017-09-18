<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="row">
	<div class="col-xs-12 table_container">
		<div class="scroll_div table-responsive">
			<table class="table table-bordered SO_bg" id="data-table" _fixedhead="rows:0; cols:5">
				<tr>
					<th class="SO_title2 no-wrap" rowspan=2>商品名</th>
					<th class="SO_title3 no-wrap" rowspan=2></th>
					<th class="SO_title4 healthy_border no-wrap" colspan=3>全体</th>
					<?php
						$j=0;
						foreach ($headings as $heading) {
					?>
					<th class="SO_title3 dynamic_header" colspan=3><?=$heading->title?></th>
					<?php		
							$j++;
						}
					?>
				</tr>

				<tr>
					<?php $nm = 1; foreach($subheadings as $subheading) { ?>
						<th class="SO_title5 static_sub_header no-wrap <?= $nm == 3 ? 'healthy_border' : ''?>" id="ssh_<?=$nm?>"><?=$subheading->title?></th>
					<?php $nm++; } ?>
					<?php
						/**
						 * Each Headers got 3 sub heading
						*/
						foreach($headings as $heading) {
							foreach ($subheadings as $subheading) {
					?>
								<th class="SO_title5 no-wrap"><?=$subheading->title?></th>
						<?php		
							}
						}
					?>
				</tr>
				<tr id="search_row">
					<th colspan="5"></th>
					<th colspan="<?=count($headings)*3?>"></th>
				</tr>

				<?php
					$r = $p = 0;
					foreach ($products as $product) {
				?>
				<tr>
					<td class="product_title table_<?=$product->row?> no-wrap"><?=$product->title?></td>
					<td class="SO_td1 no-wrap">発注数</td>
					<td class="SO_tdtr1c0 no-wrap" id=r<?=$r?>ca>0</td>
					<td class="SO_tdtr1c1 no-wrap" id=r<?=$r?>cb>0</td>
					<td class="SO_tdtr1c2 healthy_border no-wrap" id=r<?=$r?>cc>0</td>
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
				<?php $r++; ?>
				<tr>
					<td class="product_quantity table_<?=$product->row?>"><?=$product->quantity?></td>
					<td class=SO_tdn>確定</td>
					<td class="SO_tdtr2c0 no-wrap" id=r<?=$r?>ca></td>
					<td class="SO_tdtr2c1 no-wrap" id=r<?=$r?>cb></td>
					<td class="SO_tdtr2c2 healthy_border no-wrap" id=r<?=$r?>cc></td>
					<?php
						$c = 0;
						foreach ($headings as $heading) {
							foreach ($subheadings as $subheading) {
					?>
					<td class=SO_td4>
						<input class="SO_input2" type="text" pattern="[0-9].{0,}" name="r<?=$r?>c<?=$c?>" data-id="<?=$product->id?>" <?=$infos[$p]->data>100000 ? 'title="'.$infos[$p]->data.'"' : ''?> value="<?=$infos[$p++]->data?>" id="r<?=$r?>c<?=$c++?>" maxlength="8" minlength="1">
					</td>
					<?php
							}
						}
					?>
				</tr>
				<?php $r++;} ?>
			</table>
		</div>
	</div>
</div>
	