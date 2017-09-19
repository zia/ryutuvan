<?php
	/**
	* Common Header
	* Date : 28.08.2017 (dd.mm.yyyy)
	*/
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Meta -->
		<!--<meta http-equiv="refresh" content="60">-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="Content-Script-Type" content="text/javascript; charset=UTF-8">
		<!-- Title -->
		<title><?=$title?></title>
		<!-- Favicon -->
		<link rel="shortcut icon" href="">
		<!-- Styles -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Font-Awesome -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- Webss_SO -->
		<?=link_tag('assets/css/webss_so.css')?>
		<!-- Styles.css -->
		<?=link_tag('assets/css/styles.css')?>
	</head>

	<body onLoad=FixedMidashi.create()>
		<div class="container-fluid">
			<div class="row" id="topheaderbar">
				<div class="col-xs-9 col-sm-4">
					<h1><?=$title?></h1>
					<h3>納品日　<?=date("m")?>月<?=date("d")?>日</h3>
					<h4>Ｘスーパー殿</h4>
				</div>

				<div class="col-xs-3 col-sm-2 top60">
					<div class="fixed_area">未確定</div>
				</div>

				<div class="hidden-xs col-sm-2">
					&nbsp;
				</div>

				<div class="col-xs-12 col-sm-4 top20">
					<div class="row" style="text-align: right;">
						<div class="col-xs-12">
							<a class="btn btn-default" href>登録</a>
							<a class="btn btn-primary" href>終了</a>
							<?php
								$direction='';
								switch ($this->uri->segment(1)) {
									case '':
										$direction = 'search';
										break;
									default:
										$direction = '';
										break;
								}
							?>
							<a class="btn btn-success" href=<?=base_url($direction)?>>手書入力</a>
							<a class="btn btn-info" href class=btn>履歴</a>
							<a class="btn btn-warning" href class=btn>販売先一覧</a>
							<a class="btn btn-danger" href class=btn>機能</a>
						</div>
						<div class="col-xs-12 top10">
							<button class="btn btn-warning" id=previous-column>左へ移動</button>
							<button class="btn btn-info" id=next-column>右へ移動</button>
						</div>
					</div>
				</div>
			</div>