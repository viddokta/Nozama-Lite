jQuery( document ).ready( function( $ ) {
	"use strict";

	$( '.ci-cf-wrap .nozama-lite-color-picker' ).each( function() {
		$( this ).wpColorPicker();
	} );

	//
	// Metabox tabs
	//
	var wrap = $( '.ci-cf-wrap' );

	wrap.each( function() {

		var sectionsLen = $( this ).find( '.ci-cf-section' ).length;

		if ( sectionsLen > 1 ) {

			var root = $( this );
			var sections = root.find( '.ci-cf-section' );

			sections.not( ':first' ).hide();

			var tabs = $( '<ul class="ci-cf-tabs"></ul>' ).prependTo( root );

			sections.each( function() {
				var sectionTitle = $( this ).find( '.ci-cf-title' ).text();
				var tab = $( '<li class="ci-cf-tab"></li>' ).html( sectionTitle );
				var tabs = $( '.ci-cf-tabs', root );
				tabs.append( tab );
			} );

			var tab = $( '.ci-cf-tab', root );

			tab.first().addClass( 'ci-cf-tab-active' );

			tab.on( 'click', function( e ) {
				$( this ).addClass( 'ci-cf-tab-active' ).siblings( '.ci-cf-tab' ).removeClass( 'ci-cf-tab-active' );

				var idx = $( this ).index();
				var section = $( this ).parents( '.ci-cf-wrap' ).children( '.ci-cf-section' ).get( idx );

				$( section ).show().siblings( '.ci-cf-section' ).hide();

				if ( typeof google === 'object' && typeof google.maps === 'object' ) {
					if ( $( section ).find( '.gllpLatlonPicker' ).length > 0 ) {
						google.maps.event.trigger( window, 'resize', {} );
					}
				}

				e.preventDefault();
			});
		}
	});


	//
	// Media Manager links
	//
	$( 'body' ).on( 'click', '.ci-media-button', function( e ) {
		e.preventDefault();

		var ciButton = $( this );

		var target_id      = ciButton.siblings( '.ci-uploaded-id' );
		var target_url     = ciButton.siblings( '.ci-uploaded-url' );
		var target_preview = ciButton.siblings( '.upload-preview' );

		var bMulti = ciButton.data( 'multi' ); // Although data-multi="true" works, it's not handled.
		var bFrame = ciButton.data( 'frame' );

		if( typeof bMulti == 'undefined' ) {
			bMulti = false;
		}
		if( typeof bFrame == 'undefined' ) {
			bFrame = 'select';
		}

		var ciMediaUpload = wp.media( {
			frame: bFrame, // Only 'post' and 'select' seem to work with the set of options below.
			title: bMulti == true ? nozama_lite_PostMeta.tSelectFiles : nozama_lite_PostMeta.tSelectFile,
			button: {
				text: bMulti == true ? nozama_lite_PostMeta.tUseTheseFiles : nozama_lite_PostMeta.tUseThisFile
			},
			multiple: bMulti
		} ).on( 'select', function(){
			// grab the selected images object
			var selection = ciMediaUpload.state().get( 'selection' );

			// grab object properties for each image
			selection.map( function( attachment ){
				var attachment = attachment.toJSON();
				/*
				// Properties exposed
				alt: "",
				author: "2",
				authorName: "Anastis",
				caption: "",
				date: 1441717373000,
				dateFormatted: "September 8, 2015",
				editLink:"http://.../wp-admin/post.php?post=181&action=edit",
				filename: "las-erinias-fotoviajero.jpg",
				filesizeHumanReadable: "63 kB",
				filesizeInBytes: 64881,
				height: 600,
				icon:"http://.../wp-includes/images/media/default.png",
				id: 181,
				link: "http://.../las-erinias-fotoviajero/",
				menuOrder: 0,
				meta: false,
				modified: 1441717373000,
				name: "las-erinias-fotoviajero",
				orientation: "portrait",
				sizes:Object {
					full:Object {
						height:600,
						orientation:"portrait",
						url:"http://.../las-erinias-fotoviajero.jpg",
						width:504
					},
					medium:Object {
						height:300,
						orientation:"portrait",
						url:"http://.../las-erinias-fotoviajero-252x300.jpg"
						width:252
					},
					...
				},
				status:"inherit",
				subtype:"jpeg",
				title:"las-erinias-fotoviajero",
				type:"image",
				uploadedTo:66,
				uploadedToLink:"http://.../wp-admin/post.php?post=66&action=edit",
				uploadedToTitle:"Manchester City needs huge performance against Barcelona",
				uploading:false,
				url:"http://.../las-erinias-fotoviajero.jpg",
				width:504,
				*/

				if( bMulti == false ) {
					if( target_id.length > 0 ) {
						target_id.val( attachment.id ).trigger( 'change' );
					}
					if( target_url.length > 0 ) {
						target_url.val( attachment.url ).trigger( 'change' );
					}
					if( target_preview.length > 0 && attachment.type === 'image' ) {
						// For some reason, attachment.sizes doesn't include additional image sizes.
						// Only 'thumbnail', 'medium' and 'full' are exposed, so we use 'thumbnail' instead of 'nozama_lite_plugin_featgal_small_thumb'
						var html = '<img src="' + attachment.sizes.thumbnail.url + '" /><a href="#" class="close media-modal-icon" title="' + nozama_lite_PostMeta.tRemoveImage + '"></a>';
						target_preview.html( html );
					}
				}
			});
		} ).open();


	}); // on click

}); // document.ready
