<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<script type="text/javascript">var _controllerName = 'Logs';</script>

<nav class="paginator"><?php echo $pager->itemsPerPageSelector . $pager->paginator; ?></nav>

<table data-grid>
	<thead>
		<tr>
			<th class="w70">ID</th>
			<th class="w170 mdl-data-table__cell--non-numeric">User</th>
			<th class="w170 mdl-data-table__cell--non-numeric">Action</th>
			<th class="mdl-data-table__cell--non-numeric">Details</th>
			<th class="w170">Date added</th>
			<th class="w70">Actions</th>
		</tr>
		<?php echo $filters; ?>
	</thead>
	<tbody>
		<?php foreach ($logs as $log) { ?>
			<tr data-record="existing" data-id="<?php echo $log->id; ?>">
				<td><span data-object="label-id"><?php echo $log->id; ?></span></td>
				<td class="mdl-data-table__cell--non-numeric"><?php echo $log->name; ?></td>
				<td class="mdl-data-table__cell--non-numeric"><?php echo $log->action; ?></td>
				<td class="mdl-data-table__cell--non-numeric"><?php echo htmlentities($log->details); ?></td>
				<td><?php echo $log->date_added; ?></td>
				<td><div data-object="button-delete" data-save-path="Logs/DeleteExec"></div></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<nav class="paginator"><?php echo $pager->paginator; ?></nav>