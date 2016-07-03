class ArticlesController extends BaseController {

	constructor() {
		super();
		this.mountDialogEditDescription();
		this.mountWYSIWYG();
		this.getDescriptionData();

		this.mountCommentsDialog();
		this.mountWYSIWYG();
		this.getCommentsData();
	}

	mountDialogEditDescription() {

		var thisClass = this;

		this.dialogDescription = document.querySelector('#dialogEditDescription');

		this.dialogDescription.querySelector('.discard').addEventListener('click', function() {
			thisClass.dialogDescription.close();
		});

		this.dialogDescription.querySelector('.save').addEventListener('click', function() {

			thisClass.updateDescription();

			thisClass.dialogDescription.close();
		});
	}

	mountWYSIWYG() {
		tinymce.init({
			selector: '#descriptionEditField',
		});
	}

	getDescriptionData() {

		var thisClass = this;

		$('[data-grid]').find('[data-dialog="edit-description"]').bind('click', function() {

			thisClass.editCell = this;

			AjaxService.call(config.webpath + 'Articles/GetDescriptionDetails', 'post', function(response) {

				if (response.success) {

					$('#descriptionArticleTitle').html(response.data.title);

					tinyMCE.activeEditor.setContent(response.data.description);

					var result = [];

					for (var el in response.data.images) {
						result[result.length] = '\
							<div>\
								<img src="UserData/Articles/Detailed/' + response.data.images[el]['filename'] + '" class="thumbnail" height="100" /><br />\
								' + response.data.images[el]['filename'] + '\
								<span class="fa fa-times dangerColor f20 cp" onclick="Controller.deleteDescriptionImage(this, ' + response.data.images[el]['id'] + ');"></span>\
							</div>\
						';
					}

					$('#descriptionPhotos').html(result.join(''));

					thisClass.dialogDescription.showModal();
				}

			}, {id:$(this).closest('tr').attr('data-id')});
		})
	}

	updateDatagridDescription() {

		var thisClass = this;

		AjaxService.call(config.webpath + 'Articles/GetFieldData', 'post', function(response) {

			if (response.success) {
				$(thisClass.editCell).html(response.data);
			}

		}, {id:$(thisClass.editCell).closest('tr').attr('data-id'), field: 'description', shorten: true});
	}

	updateDescription() {

		var thisClass = this;

		var _requestData = {id:$(thisClass.editCell).closest('tr').attr('data-id'), description: tinyMCE.activeEditor.getContent()};

		AjaxService.call(config.webpath + 'Articles/UpdateFieldExec', 'post', function(response) {

			if (response.success) {

				NotifierComponent.show(response.message, response.success ? 'success' : 'danger');

				thisClass.updateDatagridDescription();
			}

		}, _requestData);
	}

	deleteDescriptionImage(object, id) {

		if (confirm('Are you sure you want to delete this image?')) {
			AjaxService.call(config.webpath + 'Articles/DeleteDescriptionImageExec/' + id, 'DELETE', function(response){
		        $(object).parent().remove();
		        NotifierComponent.show(response.message, (response.success) ? 'success' : 'danger');
			});
		}
	}

	mountCommentsDialog() {

		var thisClass = this;

		this.dialogComments = document.querySelector('#dialogComments');

		this.dialogComments.querySelector('.close').addEventListener('click', function() {
			thisClass.dialogComments.close();
		});
	}

	getCommentsData() {

		var thisClass = this;

		$('[data-grid]').find('[data-dialog="comments"]').bind('click', function() {

			AjaxService.call(config.webpath + 'Articles/GetComments/' + $(this).closest('tr').attr('data-id'), 'get', function(response) {

				if (response.success) {

					$('#commentsArticleTitle').html(response.data.title);
					$('#commentsArticleBody').html(response.data.view);

					thisClass.dialogComments.showModal();
				}

			});
		})
	}

	deleteComment(object, id){
		if (confirm('Are you sure you want to delete this record?')) {
			AjaxService.call(config.webpath + 'Articles/DeleteCommentExec/' + id, 'DELETE', function(response){
		        $(object).parent().parent().remove();
		        NotifierComponent.show(response.message, (response.success) ? 'success' : 'danger');
			});
		}
	}
}