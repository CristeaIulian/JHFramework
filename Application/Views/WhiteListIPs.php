<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<script type="text/javascript">var _controllerName = 'WhiteListIPs';</script>

<div data-button="add-new-record"></div>

<nav class="paginator"><?php echo $pager->itemsPerPageSelector . $pager->paginator; ?></nav>

<table data-grid>
	<thead>
		<tr>
			<th class="w70">ID</th>
			<th>IP</th>
			<th class="mdl-data-table__cell--non-numeric">Description</th>
			<th class="w80">Enabled</th>
			<th class="w70">Actions</th>
		</tr>
		<?php echo $filters; ?>
		<tr data-record="new" data-save-path="WhiteListIPs/AddExec">
			<td><span data-object="label-id"></span></td>
			<td><div data-object="text-input" data-field="ip" data-validation="ip,mandatory"></div></td>
			<td class="mdl-data-table__cell--non-numeric"><div data-object="text-input" data-field="description" data-validation="maxlength:255"></div></td>
			<td><div data-object="button-on-off" data-field="enabled"></td>
			<td><div data-object="button-delete" data-save-path="WhiteListIPs/DeleteExec"></div></td>
		</tr>
	</thead>
	<tbody data-save-path="WhiteListIPs/UpdateFieldExec">
		<?php foreach ($WhiteListIPs as $ip) { ?>
			<tr data-record="existing" data-id="<?php echo $ip->id; ?>">
				<td><span data-object="label-id"><?php echo $ip->id; ?></span></td>
				<td><div data-object="text-input" data-field="ip" data-validation="ip,mandatory" data-value="<?php echo $ip->ip; ?>"></div></td>
				<td class="mdl-data-table__cell--non-numeric">
					<div data-object="text-input" data-field="description" data-validation="maxlength:255" data-value="<?php echo $ip->description; ?>"></div>
				</td>
				<td><div data-object="button-on-off" data-field="enabled" data-checked="<?php echo ($ip->enabled) ? 'checked="checked"' : ''; ?>"></div></td>
				<td><div data-object="button-delete" data-save-path="WhiteListIPs/DeleteExec"></div></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<nav class="paginator"><?php echo $pager->paginator; ?></nav>