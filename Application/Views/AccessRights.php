<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<script type="text/javascript">var _controllerName = 'AccessRights';</script>

<div data-button="add-new-record"></div>

<nav class="paginator"><?php echo $pager->itemsPerPageSelector . $pager->paginator; ?></nav>

<table data-grid>
	<thead>
		<tr>
			<th class="w70">ID</th>
			<th class="mdl-data-table__cell--non-numeric mdl-data-table__header--sorted-ascending">Controller</th>
			<th class="mdl-data-table__cell--non-numeric mdl-data-table__header--sorted-ascending">Action</th>
			<th>User Types</th>
			<th class="w80">Is Ajax</th>
			<th class="w70">Actions</th>
		</tr>
		<?php echo $filters; ?>
		<tr data-record="new" data-save-path="AccessRights/AddExec">
			<td><span data-object="label-id"></span></td>
			<td><div data-object="text-input" data-field="controller" data-validation="minlength:1,maxlength:50"></div></td>
			<td><div data-object="text-input" data-field="action" data-validation="minlength:1,maxlength:50"></div></td>
			<td><div data-object="text-input" data-field="users" data-validation="minlength:3,maxlength:100"></div></td>
			<td><div data-object="button-on-off" data-field="ajax"></div></td>
			<td><div data-object="button-delete" data-save-path="AccessRights/DeleteExec"></div></td>
		</tr>
	</thead>
	<tbody data-save-path="AccessRights/UpdateFieldExec">
		<?php foreach ($AccessRights as $ar) { ?>
			<tr data-record="existing" data-id="<?php echo $ar->id; ?>">
				<td><span data-object="label-id"><?php echo $ar->id; ?></span></td>
				<td><div data-object="text-input" data-field="controller" data-validation="minlength:1,maxlength:50" data-value="<?php echo $ar->controller; ?>"></div></td>
				<td><div data-object="text-input" data-field="action" data-validation="minlength:1,maxlength:50" data-value="<?php echo $ar->action; ?>"></div></td>
				<td><div data-object="text-input" data-field="users" data-validation="minlength:3,maxlength:100" data-value="<?php echo $ar->users; ?>"></div></td>
				<td><div data-object="button-on-off" data-field="ajax" data-checked="<?php echo ($ar->ajax) ? 'checked="checked"' : ''; ?>"></div></td>
				<td><div data-object="button-delete" data-save-path="AccessRights/DeleteExec"></div></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<nav class="paginator"><?php echo $pager->paginator; ?></nav>