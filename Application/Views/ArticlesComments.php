<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<table class="table table-striped table-bordered">
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Body</th>
		<th class="w160">Date Added</th>
		<th class="w70">Actions</th>
	</tr>
	<?php
		foreach ($comments as $comment) {
			?>
				<tr data-id="<?php echo $comment->id; ?>">
					<td><?php echo $comment->name; ?></td>
					<td><?php echo $comment->email; ?></td>
					<td><?php echo $comment->body; ?></td>
					<td><?php echo $comment->date_added; ?></td>
					<td>
						<a class="fa fa-times dangerColor f20 cp" href="javascript:void(0);" onclick="Controller.deleteComment(this, '<?php echo $comment->id; ?>')"></a>
					</td>
				</tr>
			<?php
		}
	
		if (!count($comments)) { ?>
			<tr>
				<th colspan="5" class="tac">There are no comments.</th>
			</tr>
	<?php } ?>
</table>