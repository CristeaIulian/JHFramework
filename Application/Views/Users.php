<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<script type="text/javascript">var _controllerName = 'Users';</script>

<div data-button="add-new-record"></div>

<nav class="paginator"><?php echo $pager->itemsPerPageSelector . $pager->paginator; ?></nav>

<table data-grid>
	<thead>
		<tr>
			<th class="w70">ID</th>
			<th class="mdl-data-table__cell--non-numeric">Name</th>
			<th class="mdl-data-table__cell--non-numeric">Email</th>
			<th class="mdl-data-table__cell--non-numeric">Type</th>
			<th class="mdl-data-table__cell--non-numeric">Password</th>
			<th class="w120">Login Attempts</th>
			<th>Last Login</th>
			<th class="w80">Enabled</th>
			<th class="w70">Actions</th>
		</tr>
		<?php echo $filters; ?>
		<tr data-record="new" data-save-path="Users/AddExec">
			<td><div data-object="label-id"></div></td>
			<td><div data-object="text-input" data-field="name" data-validation="minlength:2,maxlength:100"></div></td>
			<td><div data-object="text-input" data-field="email" data-validation="mandatory,email"></div></td>
			<td><div data-object="select" data-field="user_type" data-validation="mandatory"></div></td>
			<td><div data-object="text-input" data-object-type="password" data-field="password" data-validation="minlength:6,maxlength:50"></div></td>
			<td><div data-object="text-input" data-field="login_attempts" data-validation="mandatory,min:0,max:5"></div></td>
			<td></td>
			<td><div data-object="button-on-off" data-field="enabled"></div></td>
			<td><div data-object="button-delete" data-save-path="Users/DeleteExec"></div></td>
		</tr>
		<tr data-record="info">
			<td colspan="9">
				<div data-model="user_type"><?php echo json_encode($userTypes); ?></div>
			</td>
		</tr>
	</thead>
	<tbody data-save-path="Users/UpdateFieldExec">
		<?php foreach ($users as $user) { ?>
			<tr data-record="existing" data-id="<?php echo $user->id; ?>">
				<td><div data-object="label-id"><?php echo $user->id; ?></div></td>
				<td><div data-object="text-input" data-field="name" data-validation="minlength:2,maxlength:100" data-value="<?php echo $user->name; ?>"></div></td>
				<td><div data-object="text-input" data-field="email" data-validation="mandatory,email" data-value="<?php echo $user->email; ?>"></div></td>
				<td><div data-object="select" data-field="user_type" data-validation="mandatory" data-value="<?php echo $user->user_type; ?>"></div></td>
				<td><div data-object="text-input" data-object-type="password" data-field="password" data-validation="minlength:6,maxlength:50"></div></td>
				<td><div data-object="text-input" data-field="login_attempts" data-validation="mandatory,min:0,max:5" data-value="<?php echo $user->login_attempts; ?>"></div></td>
				<td><?php echo $user->last_login_attempt; ?></td>
				<td><div data-object="button-on-off" data-field="enabled" data-checked="<?php echo ($user->enabled) ? 'checked="checked"' : ''; ?>"></div></td>
				<td><div data-object="button-delete" data-save-path="Users/DeleteExec"></div></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<nav class="paginator"><?php echo $pager->paginator; ?></nav>