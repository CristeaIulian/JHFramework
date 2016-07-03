// var _editorInline = '<input type="text" id="inline_editor" data-id="" data-field="" onkeyup="inlineEditorControls(event);" onblur="updateRecord();" class="form-control" />';
// var _objectInEditMode = null;
// var _oldValue = null;

// var editField = function(obj, field) {

// 	if (!document.getElementById('inline_editor')) {
		
// 		_dataID = $(obj).parent().attr('data-id');

// 		_oldValue = $(obj).html();

// 		$(obj).html(_editorInline);

// 		$('#inline_editor').val(_oldValue);

// 		$('#inline_editor').attr('data-field', field);
// 		$('#inline_editor').attr('data-id', _dataID);

// 		_objectInEditMode = obj;
// 	}
// }

// var editDescription = function(obj, field) {
	
// 	if (!document.getElementById('inline_editor')) {
		
// 		_dataID = $(obj).parent().attr('data-id');
// 		_objectInEditMode = obj;

// 		var _requestData = {id:_dataID, field: 'title'};

// 		ajaxCall(config.webpath + 'Articles/GetFieldData', 'post', function(response) {

// 			if (response.success) {
// 				$('#descriptionArticleTitle').html(response.data);
// 			}

// 		}, _requestData);

// 		var _requestData = {id:_dataID, field: field};

// 		ajaxCall(config.webpath + 'Articles/GetFieldData', 'post', function(response) {

// 			if (response.success) {

// 				$('#descriptionEditField').val(response.data);
// 				$('#editDescriptionID').val(_dataID);

// 				new nicEditor({
// 					fullPanel : true, 
// 					iconsPath : config.webpath + 'Assets/Resources/nicEdit/nicEditorIcons.gif'
// 				}).panelInstance('descriptionEditField');

// 			}

// 		}, _requestData);


// 		var _requestData = {id:_dataID};

// 		ajaxCall(config.webpath + 'Articles/GetArticlePhotos', 'post', function(response) {

// 			if (response.success) {

// 				var result = [];

// 				for (el in response.images) {
// 					result[result.length] = '\
// 						<div>\
// 							<img src="UserData/Articles/Detailed/' + response.images[el]['filename'] + '" class="thumbnail" height="100" /><br />\
// 							' + response.images[el]['filename'] + '\
// 							<span class="fa fa-times dangerColor f20 cp" onclick="deleteDescriptionImage(this, ' + response.images[el]['id'] + ');"></span>\
// 						</div>\
// 					';
// 				}

// 				$('#descriptionPhotos').html(result.join(''));
// 			}

// 		}, _requestData);

// 		$('#descriptionEdit').modal('show');
// 	}
// }

// var saveDescription = function() {

// 	var _newValue = nicEditors.findEditor('descriptionEditField').getContent();

// 	var _recordId = $('#editDescriptionID').val();

// 	var _requestData = {id:_recordId, description: _newValue};

// 	ajaxCall(config.webpath + 'Articles/UpdateFieldExec', 'post', function(response) {

// 		if (response.success) {

// 			var _requestData = {id:_recordId, field: 'description', shorten: true};

// 			ajaxCall(config.webpath + 'Articles/GetFieldData', 'post', function(response2) {

// 				if (response2.success) {

// 					$('#descriptionEdit').modal('hide');
// 					$(_objectInEditMode).html(response2.data);

// 					display_message(response2.message, (response.success && response2.success) ? 'success' : 'danger');
// 				}

// 			}, _requestData);
// 		}

// 	}, _requestData);
// }

// var inlineEditorControls = function(e) {
// 	if (e.keyCode == 13 || e.keyCode == 27) {
// 		updateRecord();
// 	}
// }

// var updateRecord = function() {

// 	var _newValue = $('#inline_editor').val();

// 	var _recordId = $('#inline_editor').attr('data-id');
// 	var _fieldName = $('#inline_editor').attr('data-field');

// 	var _requestData = {id:_recordId, [_fieldName]: _newValue};

// 	ajaxCall(config.webpath + 'Articles/UpdateFieldExec', 'post', function(response) {

// 		console.log(response);
// 		if (response.success) {
// 			$(_objectInEditMode).html(_newValue);
// 		}

// 		display_message(response.message, (response.success) ? 'success' : 'danger');

// 	}, _requestData);
// };

// var updateCategory = function(obj) {

// 	var _newValue = $(obj).val();

// 	var _recordId = $(obj).parent().parent().attr('data-id');

// 	var _requestData = {id:_recordId, category_id: _newValue};

// 	ajaxCall(config.webpath + 'Articles/UpdateFieldExec', 'post', function(response) {

// 		console.log(response);
// 		if (response.success) {
// 			// $(_objectInEditMode).html(_newValue);
// 		}

// 		display_message(response.message, (response.success) ? 'success' : 'danger');

// 	}, _requestData);
// }

// $('.enabledDisabled').change(function() {
	
// 	var _newValue = $(this).prop('checked') ? "1" : "0";

// 	var _recordId = $(this).parent().parent().parent().attr('data-id');

// 	var _requestData = {id:_recordId, enabled: _newValue};

// 	ajaxCall(config.webpath + 'Articles/UpdateFieldExec', 'post', function(response) {

// 		console.log(response);
// 		display_message(response.message, (response.success) ? 'success' : 'danger');

// 	}, _requestData);
// });

// var deleteArticle = function(object, id){
// 	if (confirm('Are you sure you want to delete this record?')) {
// 		ajaxCall(config.webpath + 'Articles/DeleteExec/' + id, 'DELETE', function(response){
// 	        $(object).parent().parent().remove();
// 	        display_message(response.message, (response.success) ? 'success' : 'danger');
// 		});
// 	}
// }

var deleteImage = function(object) {

	var id = $(object).parent().parent().attr('data-id');

	if (confirm('Are you sure you want to delete this image?')) {
		ajaxCall(config.webpath + 'Articles/DeleteImageExec/' + id, 'DELETE', function(response){
	        $(object).prev().remove();
	        $(object).remove();
	        display_message(response.message, (response.success) ? 'success' : 'danger');
		});
	}
}

// var deleteDescriptionImage = function(object, id) {

// 	if (confirm('Are you sure you want to delete this image?')) {
// 		ajaxCall(config.webpath + 'Articles/DeleteDescriptionImageExec/' + id, 'DELETE', function(response){
// 	        $(object).parent().remove();
// 	        display_message(response.message, (response.success) ? 'success' : 'danger');
// 		});
// 	}
// }

// var deleteComment = function(object, id){
// 	if (confirm('Are you sure you want to delete this record?')) {
// 		ajaxCall(config.webpath + 'Articles/DeleteCommentExec/' + id, 'DELETE', function(response){
// 	        $(object).parent().parent().remove();
// 	        display_message(response.message, (response.success) ? 'success' : 'danger');
// 		});
// 	}
// }

// var showComments = function(obj) {

// 	var _recordId = $(obj).parent().parent().attr('data-id');
	
// 	$('#commentsModal').modal('show');

// 	var _requestData = {id:_recordId, field: 'title'};

// 	ajaxCall(config.webpath + 'Articles/GetFieldData', 'post', function(response) {

// 		if (response.success) {
// 			$('#commentsArticleTitle').html(response.data);
// 		}

// 	}, _requestData);

// 	ajaxCall(config.webpath + 'Articles/GetComments/' + _recordId, 'get', function(response) {

// 		if (response.success) {

// 			$('#commentsArticleBody').html(response.view);
// 		}
// 	});
// }

// var addArticle = function() {

// 	var _requestData = {};

// 	ajaxCall(config.webpath + 'Articles/AddExec', 'get', function(response) {
// 		console.log(response);
// 		display_message(response.message, (response.success) ? 'success' : 'danger');

// 		_recordId = response.insertId;

// 		articleCategories = [];

// 		for (el in response.articleCategories) {
// 			articleCategories[articleCategories.length] = '<option value="' + response.articleCategories[el]['id'] + '">' + response.articleCategories[el]['name'] + '</option>';
// 		}

// 		var _record = '\
// 			<tr data-id="' + _recordId + '">\
// 				<td>' + _recordId + '.</td>\
// 				<td>\
// 					<form action="' + config.webpath + 'Articles/FileUploadExec" method="post" enctype="multipart/form-data">\
// 						<input type="hidden" name="id" value="' + _recordId + '">\
// 						<input type="file" name="file" class="fl">\
// 						<input type="submit" class="btn btn-primary fl" value="Upload">\
// 					</form>\
// 				</td>\
// 				<td>\
// 					<select class="form-control" onchange="updateCategory(this)">\
// 						<option value="0">-----</option>\
// 						' + articleCategories.join(' ') + '\
// 					</select>\
// 				</td>\
// 				<td title="Double click to edit" style="cursor:help;" ondblclick="editField(this, \'title\')"></td>\
// 				<td title="Double click to edit" style="cursor:help;" ondblclick="editDescription(this, \'description\')"></td>\
// 				<td title="Double click to edit" style="cursor:help;" ondblclick="editField(this, \'date_added\')">' + response.dateAdded + '</td>\
// 				<td title="Double click to edit" style="cursor:help;" ondblclick="editField(this, \'views\')">0</td>\
// 				<td title="Double click to edit" style="cursor:help;" ondblclick="editField(this, \'likes\')">0</td>\
// 				<td title="Double click to view" style="cursor:help;"><a href="#" onclick="showComments(this);">0</a></td>\
// 				<td><input type="checkbox" class="enabledDisabled" data-toggle="toggle" data-onstyle="success" data-offstyle="default" data-on="<i class=\'fa fa-check\'></i> Enabled" data-off="<i class=\'fa fa-ban\'></i> Disabled" /></td>\
// 				<td><a class="fa fa-times dangerColor f20 cp" href="javascript:void(0);" onclick="deleteArticle(this, \'' + _recordId + '\')"></a></td>\
// 			</tr>\
// 		';

// 		$('#datagrid tbody').append(_record);

// 		$('#datagrid').find('[data-id="' + _recordId + '"]').find('.enabledDisabled').bootstrapToggle();


// 	}, _requestData);



// }