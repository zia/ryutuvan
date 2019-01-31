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
		<!-- Styles -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<!-- Font-Awesome -->
		<!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->
		<!-- Webss_SO -->
		<!-- <?=link_tag('assets/css/webss_so.css')?> -->
		<!-- Styles.css -->
		<?=link_tag('assets/css/styles.css')?>
	</head>

	<body onLoad=FixedMidashi.create()>
	<div class="container-fluid">
		<div class="row" id="topheaderbar">
			<div class="col-xs-9 col-sm-4">
				<h1><?=$title?></h1>
				<h3><?=date("Y-m-d")?></h3>
				<h4>Product List</h4>
			</div>

			<div class="col-xs-3 col-sm-2 top60">
				<div class="fixed_area">Yeah!</div>
			</div>

			<div class="hidden-xs col-sm-2">
				&nbsp;
			</div>

			<div class="col-xs-12 col-sm-4 top20">
				<div class="row" style="text-align: right;">
					<div class="col-xs-12">
						<a class="btn btn-default" href>Empty</a>
						<a class="btn btn-primary" href>Empty</a>
						<?php
							$direction='';
							switch ($this->uri->segment(1)) {
								case 'home':
									$direction = 'search';
									break;
								default:
									$direction = 'search';
									break;
							}
						?>
						<!-- <a class="btn btn-success" href=<?=base_url($direction)?>><?=ucfirst($direction)?></a> -->
						<button class="btn btn-success" id="search_button">Search</button>
						<a class="btn btn-info" href class=btn>Empty</a>
						<a class="btn btn-warning" href class=btn>Empty</a>
						<a class="btn btn-danger" href class=btn>Empty</a>
					</div>
					<div class="col-xs-12 top10">
						<button class="btn btn-warning" id=previous-column>Previous</button>
						<button class="btn btn-info" id=next-column>Next</button>
					</div>
				</div>
			</div>
		</div>