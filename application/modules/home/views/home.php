<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-xs-12 table_container">
        <div class="scroll_div table-responsive" id="scroll_div">
            <table class="table table-bordered SO_bg" id="reloadable" _fixedhead="rows:0; cols:5">
                <tr>
                    <th class=SO_title2 rowspan=2 nowrap>Products</th>
                    <th class=SO_title3 rowspan=2 nowrap></th>
                    <th class="SO_title4 healthy_border" colspan=3>SUM</th>
                    <?php
                    $j = 0;
                    foreach ($headings as $heading) {
                        ?>
                        <th class="SO_title3 dynamic_header" colspan=3>
                            <?= $heading->title ?>
                            <a class="btn btn-xs btn-danger pull-right" href="<?=base_url('home/delete_heading/'.$heading->id)?>" title="Delete" onclick="alert('Delete?')">
                            <i class="fa fa-trash"></i>
                        </a>
                        </th>
                        <?php
                        $j++;
                    }
                    ?>
                    
                    <!-- <th class=SO_title2 rowspan="<?=2*count($products)+4?>" style="width:20px;">
                        <a class="btn btn-primary" href="<?=base_url('home/insert_heading_info')?>" title="Add">
                            <i class="fa fa-plus"></i>
                        </a>
                    </th> -->

                    <th class="SO_title2 add_more_column"></th>
                </tr>

                <tr>
                    <?php
                        $nm = 1;
                        foreach ($subheadings as $subheading) {
                            ?>
                            <th class="SO_title5 static_sub_header <?= $nm == 3 ? 'healthy_border' : '' ?>" id="ssh_<?= $nm ?>" nowrap><?= $subheading->title ?></th>
                            <?php
                            $nm++;
                        }
                        ?>
                    <?php
                        /**
                         * Each Headers got 3 sub heading
                         */
                        foreach ($headings as $heading) {
                            foreach ($subheadings as $subheading) {
                                ?>
                                <th class=SO_title5 nowrap><?= $subheading->title ?></th>
                                <?php
                            }
                        }
                    ?>
                    <th class="SO_title5 add_more_column" rowspan="<?=2*count($products)+2?>">
                        <a class="btn btn-xs btn-primary add_column_button" href="<?=base_url('home/insert_heading_info')?>" title="Add">
                            <i class="fa fa-plus"></i>
                        </a>
                    </th>
                </tr>

                <!--Row 3 : Search-->
				<tr id="search_row">
					<!-- There is Five Fixed header Columns -->
					<th class="healthy_border" colspan="5"></th>
					<!-- Search Field -->
					<th colspan="<?=count($headings)*3?>" class="SO_title5">
						<!-- Search Box -->
						<input type="text" name="s_n_s" id="search_field" placeholder="JANまたはインストア入力">
						<img src="<?=base_url('assets/img/loader.gif')?>" alt="Searching.." id="loader">
					</th>
				</tr>
                <?php
                $p = $m = 0;
                foreach ($products as $product) {
                    ?>
                    <tr>
                        <td class="product_title" nowrap>
                            <div id="title<?=++$m?>" nowrap>
                                <?= $product->title ?>
                                <a class="btn btn-xs btn-danger" href="<?=base_url('home/delete/'.$product->id)?>" title="Delete" onclick="alert('Sure?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                        <td class="SO_td1" nowrap>Done</td>
                        <td class=SO_tdtr1c0 id=ca<?= $product->id ?>>0</td>
                        <td class=SO_tdtr1c1 id=cb<?= $product->id ?>>0</td>
                        <td class='SO_tdtr1c2 healthy_border' id=cc<?= $product->id ?>>0</td>
                        <?php
                            // $c = 1;
                            foreach ($headings as $heading) {
                                foreach ($subheadings as $subheading) {
                                    ?>
                                    <td class=SO_td1>0</td>
                                    <?php
                                }
                            }
                        ?>
                    </tr>
                    <tr>
                        <td class="product_quantity" nowrap>
                            <div id="quantity<?=$m?>">
                                <?= $product->quantity ?>
                            </div>
                        </td>
                        <td class=SO_tdn>
                            <a class="btn btn-xs btn-warning" href="<?=base_url('home/reset/'.$product->id)?>" title="Reset" onclick="alert('Sure?')">
                                <i class="fa fa-recycle"></i> Reset
                            </a>
                            
                        </td>
                        <td class=SO_tdtr2c0>
                            <div id=a<?= $product->id ?>>
                                <?=modules::run('home/get_sum',$product->id,1);?>
                            </div>
                        </td>
                        <td class=SO_tdtr2c0>
                            <div id=b<?= $product->id ?>>
                                <?=modules::run('home/get_sum',$product->id,2);?>
                            </div>
                        </td>
                        <td class='SO_tdtr2c0 healthy_border'>
                            <div id=c<?= $product->id ?>>
                                <?=modules::run('home/get_sum',$product->id,0);?>
                            </div>
                        </td>
                        <?php
                            $c = 1;
                            foreach ($headings as $heading) {
                                foreach ($subheadings as $subheading) {
                                    ?>
                                    <td class=SO_td4>
                                        <input
                                            class="SO_input2"
                                            type="text"
                                            pattern="[0-9].{0,}"
                                            name="r<?= $product->id ?>c<?= $c ?>"
                                            data-id="<?= $product->id ?>"
                                            <?= $infos[$p]->value > 100000 ? 'title="' . $infos[$p]->value . '"' : '' ?>
                                            value="<?= $infos[$p++]->value ?>"
                                            id="r<?= $product->id ?>c<?= $c++ ?>"
                                            maxlength="8"
                                            minlength="1"
                                        >
                                    </td>
                                    <?php
                                }
                            }
                        ?>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td class="SO_title5" colspan="5">
                        <a class="btn btn-primary" href="<?=base_url('home/insert_product')?>" title="Add">
                            <i class="fa fa-plus"></i> Add Product
                        </a>
                    </td>
                    <td class="SO_td1" colspan="<?=count($headings) * 3?>">&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
</div>
