<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<script type="text/javascript">var _controllerName = 'Articles';</script>

<div data-button="add-new-record"></div>

<nav class="paginator"><?php echo $pager->itemsPerPageSelector . $pager->paginator; ?></nav>

<table data-grid>
	<thead>
		<tr>
			<th class="w70">ID</th>
			<th class="w370 mdl-data-table__cell--non-numeric">Photo</th>
			<th class="w140 mdl-data-table__cell--non-numeric">Category</th>
			<th class="mdl-data-table__cell--non-numeric">Title</th>
			<th class="mdl-data-table__cell--non-numeric">Short Description</th>
			<th class="w160">Date Added</th>
			<th>Views</th>
			<th>Likes</th>
			<th>Comments</th>
			<th>Enabled</th>
			<th>Actions</th>
		</tr>
		<?php echo $filters; ?>
		<tr data-record="new" data-save-path="Articles/AddExec">
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
				<div data-model="category_id"><?php echo json_encode($categories); ?></div>
			</td>
		</tr>
	</thead>
	<tbody data-save-path="Articles/UpdateFieldExec">
		<?php foreach ($articles as $article) { ?>
			<tr data-record="existing" data-id="<?php echo $article->id; ?>">
				<td><div data-object="label-id"><?php echo $article->id; ?></div></td>
				<td class="mdl-data-table__cell--non-numeric">
					<?php if (!empty($article->photo)) { ?>
						<img src="<?php echo Core\Config::get('path.web'); ?>UserData/Articles/Main/<?php echo $article->photo; ?>" width="140" />
						<span class="fa fa-times cp dangerColor f20" onclick="deleteImage(this)"></span>
					<?php } ?>
					<form action="<?php echo Core\Config::get('path.web'); ?>Articles/FileUploadExec" method="post" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $article->id; ?>" />
						<input type="file" name="file" class="fl" />
						<input type="submit" class="btn btn-primary fl" value="Upload" />
					</form>
				</td>
				<td class="mdl-data-table__cell--non-numeric">
					<div data-object="select" data-field="category_id" data-validation="mandatory" data-value="<?php echo $article->category_id; ?>"></div>
				</td>
				<td class="mdl-data-table__cell--non-numeric">
					<div data-object="text-input" data-field="title" data-validation="mandatory,minlength:2" data-value="<?php echo $article->title; ?>"></div>
				</td>
				<td class="mdl-data-table__cell--non-numeric">
					<div data-dialog="edit-description"><?php echo Application\Services\StringsService::shorten(strip_tags($article->description)); ?></div>
				</td>
				<td><div data-object="text-input" data-field="date_added" data-validation="date,mandatory" data-value="<?php echo $article->date_added; ?>"></div></td>
				<td><div data-object="text-input" data-field="views" data-validation="number,mandatory,min:0" data-value="<?php echo $article->views; ?>"></div></td>
				<td><div data-object="text-input" data-field="likes" data-validation="number,mandatory,min:0" data-value="<?php echo $article->likes; ?>"></div></td>
				<td title="Double click to view" style="cursor:help;"><div data-dialog="comments"><?php echo $article->comments_no; ?></div></td>
				<td><div data-object="button-on-off" data-field="enabled" data-checked="<?php echo ($article->enabled) ? 'checked="checked"' : ''; ?>"></div></td>
				<td><div data-object="button-delete" data-save-path="Articles/DeleteExec"></div></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<nav class="paginator"><?php echo $pager->paginator; ?></nav>

<dialog class="mdl-dialog" id="dialogEditDescription" style="width:930px;">
	<h4 class="mdl-dialog__title">Edit Description for '<span id="descriptionArticleTitle">...</span>'</h4>
	<div class="mdl-dialog__content">
		<p>
			<div class="descriptionImages">
				<form action="<?php echo Core\Config::get('path.web'); ?>Articles/DescriptionFileUploadExec" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $article->id; ?>" />
					<input type="file" multiple="multiple" name="file[]" class="fl" />
					<input type="submit" class="btn btn-primary fl" value="Upload" />
				</form>

				<div id="descriptionPhotos"></div>
			</div>
			<div style="float:none; clear:both;"></div>
			<textarea class="form-control" id="descriptionEditField" style="min-height:300px; max-width:857px;width:857px;"></textarea>
		</p>
	</div>
	<div class="mdl-dialog__actions">
		<button type="button" class="mdl-button save">Save</button>
		<button type="button" class="mdl-button discard">Discard</button>
	</div>
</dialog>

<dialog class="mdl-dialog" id="dialogComments" style="width:930px;">
	<h4 class="mdl-dialog__title">Comments for '<span id="commentsArticleTitle">...</span>'</h4>
	<div class="mdl-dialog__content"><p><div id="commentsArticleBody"></div></p></div>
	<div class="mdl-dialog__actions">
		<button type="button" class="mdl-button close">Close</button>
	</div>
</dialog>