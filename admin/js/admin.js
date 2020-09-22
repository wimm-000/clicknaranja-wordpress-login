jQuery(document).ready(function ($) {
	var mediaUploader;
	$('#upload_image_button').click(function (e) {
		e.preventDefault();
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}
		const itemContainer = $(e.target).parent().parent()
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Selecciona Image',
			button: {
				text: 'Selecciona Imagen de fondo a mostrar'
			},
			multiple: false
		});
		mediaUploader.on('select', function () {
			var attachment = mediaUploader.state().get('selection').first().toJSON();
			// show image
			itemContainer.find('.cncl__thumbnail').attr('src', attachment.url)
			itemContainer.find('.cncl__image-path').text(attachment.url)
			itemContainer.find('.cncl__image-container').show()
			$('#background_image').val(attachment.url);
			mediaUploader.off()
		});
		mediaUploader.open();
	});
	// Logo image
	$('#upload_logo_image_button').click(function (e) {
		e.preventDefault();
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}
		const itemContainer = $(e.target).parent().parent()
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Selecciona Image',
			button: {
				text: 'Selecciona Logotipo a mostrar'
			},
			multiple: false
		});
		mediaUploader.on('select', function () {
			var attachment = mediaUploader.state().get('selection').first().toJSON();
			// show image
			itemContainer.find('.cncl__thumbnail-logo').attr('src', attachment.url)
			itemContainer.find('.cncl__logo-image-path').text(attachment.url)
			itemContainer.find('.cncl__image-logo-container').show()
			$('#logo_image').val(attachment.url);
			mediaUploader.off()
		});
		mediaUploader.open();
	});
	// Al pulsar el boton de cerrar que elimine la imagen que le corresponde
	$('.cncl__remove').click(removeImage)
	$('.cncl__remove-logo').click(function (ev) {
		console.log("remove");
		const itemContainer = $(ev.target).parent().parent()
		const image = itemContainer.find('.cncl__thumbnail-logo')
		image.attr('src', "");
		itemContainer.find('.cncl__logo-image-path').text('')
		itemContainer.find('#logo_image').val('')
		itemContainer.find('.cncl__image-logo-container').hide()
	})

	function removeImage(ev) {
		const itemContainer = $(ev.target).parent().parent()
		const image = itemContainer.find('.cncl__thumbnail')
		image.attr('src', "");
		itemContainer.find('.cncl__image-path').text('')
		itemContainer.find('#background_image').val('')
		itemContainer.find('.cncl__image-container').hide()
	}
});
