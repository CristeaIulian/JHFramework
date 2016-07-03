<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<div>
	<div style="font-weight:900; line-height:30px;">
		<?php if (isset($Type)) 	{ echo $Type; } ?>
		<?php if (isset($Message)) 	{ echo ' :: ' . $Message . '<br />'; } ?>
		<?php if (isset($File)) 	{ echo 'File: ' . $File . '<br />'; } ?>
		<?php if (isset($Line)) 	{ echo 'Line: ' . $Line . '<br />'; } ?>
		<?php if (isset($Function)) { echo 'Function: ' . $Function . '()'; } ?><br />
		<?php if (isset($LastQuery)) { echo 'Mysql Last Query: ' . $LastQuery; } ?>
	</div>
	<?php if (isset($Backtrace)) { ?>
		<pre><?php print_r($Backtrace); ?></pre>
	<?php } ?>
</div>