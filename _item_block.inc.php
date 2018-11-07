<?php
/**
 * This is the template that displays the item block: title, author, content (sub-template), tags, comments (sub-template)
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template (or other templates)
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $Item, $Skin, $app_version;

// Default params:
$params = array_merge( array(
		'feature_block'    => false,
		'content_mode'     => 'auto',		// 'auto' will auto select depending on $disp-detail
		'item_class'       => 'bPost',
		'image_class'      => 'img-responsive',
		'image_size'       => 'fit-1280x720',
		'author_link_text' => 'auto',
	), $params );

echo '<div class="styled_content_block">'; // Beginning of post display TODO: get rid of this ID, use class .evo_content_block instead
?>

<div id="<?php $Item->anchor_id() ?>" class="<?php $Item->div_classes( $params ) ?>" lang="<?php $Item->lang() ?>">

	<?php
		$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)

		if( $Item->is_intro() )
		{	// Display a link to edit the post only for intro post, because for all other posts it is displayed below under title
			$title_before = '<div class="post_title"><h2>';
			$title_after = '</h2>'.$Item->get_edit_link( array(
					'before' => '<div class="'.button_class( 'group' ).'">',
					'after'  => '</div>',
					'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
					'class'  => button_class( 'text' ),
				) ).'</div>';
		}

		if( ! $Item->is_intro() )
		{
			$title_before = '<h2 class="title_posts">';
			$title_after = '</h2>';

			if( $disp == 'posts' )
			{
				// ------------------------- "Item in List" CONTAINER EMBEDDED HERE --------------------------
				// Display container contents:
				widget_container( 'item_in_list', array(
					'widget_context' => 'item',	// Signal that we are displaying within an Item
					// The following (optional) params will be used as defaults for widgets included in this container:
					'container_display_if_empty' => false, // If no widget, don't display container at all
					// This will enclose each widget in a block:
					'block_start' => '<div class="evo_widget $wi_class$">',
					'block_end' => '</div>',
					// This will enclose the title of each widget:
					'block_title_start' => '<h3>',
					'block_title_end' => '</h3>',
					'author_link_text' => $params['author_link_text'],
					// Template params for "Item Title" widget:
					'widget_item_title_params'  => array(
							'before' => $title_before,
							'after' => $title_after,
						),
					// Template params for "Item Visibility Badge" widget:
					'widget_item_visibility_badge_display' => ( ! $Item->is_intro() && $Item->status != 'published' ),
					'widget_item_visibility_badge_params'  => array(
							'template' => '<div class="evo_status evo_status__$status$ badge pull-right" data-toggle="tooltip" data-placement="top" title="$tooltip_title$">$status_title$</div>',
						),
					// Template params for "Item Info Line" widget:
					'widget_item_info_line_params' => array(
							'before_flag'         => '',
							'after_flag'          => ' ',
							'before_permalink'    => '',
							'after_permalink'     => ' ',
							'before_author'       => 'by <span class="identity_link_username">',
							'after_author'        => '</span>',
							'before_post_time'    => 'Posted on <span>',
							'after_post_time'     => '</span>',
							'before_categories'   => 'in <span>',
							'after_categories'    => '</span>',
							'before_last_touched' => '<span class="text-muted"> &ndash; '.T_('Last touched').': ',
							'after_last_touched'  => '</span>',
							'before_last_updated' => '<span class="text-muted"> &ndash; '.T_('Contents updated').': ',
							'after_last_updated'  => '</span>',
							'before_edit_link'    => ' &bull; ',
							'after_edit_link'     => '',
							'format'              => '$flag$ $permalink$ $post_time$ $author$ $categories$ $edit_link$',
						),
				) );
				// ----------------------------- END OF "Item in List" CONTAINER -----------------------------
			}
			elseif( $disp != 'single' && $disp != 'page' )
			{ // Don't display this on disp=single because there is already title header in h2
				if( ! $Item->is_intro() )
				{
					$Item->title( array(
							'before'    => $title_before,
							'after'     => $title_after,
							'link_type' => 'permalink'
						) );
				}
				else
				{
					$Item->title( array(
							'before'    => $title_before,
							'after'     => $title_after,
							'link_type' => '#'
						) );
				}
			}
		}
		else
		{	// Display a link to edit the post only for intro post, because for all other posts it is displayed below under title
			$title_before = '<div class="post_title"><h2>';
			$title_after = '</h2>'.$Item->get_edit_link( array(
					'before' => '<div class="'.button_class( 'group' ).'">',
					'after'  => '</div>',
					'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
					'class'  => button_class( 'text' ),
				) ).'</div>';

			$Item->title( array(
					'before'    => $title_before,
					'after'     => $title_after,
					'link_type' => '#'
				) );
		}
	?>

	<?php
	if( $disp == 'single' )
	{
		// ------------------------- "Item Single" CONTAINER EMBEDDED HERE --------------------------
		// Display container contents:
		widget_container( 'item_single', array(
			'widget_context' => 'item',	// Signal that we are displaying within an Item
			// The following (optional) params will be used as defaults for widgets included in this container:
			'container_display_if_empty' => false, // If no widget, don't display container at all
			'container_start' => '<div class="evo_container $wico_class$">',
			'container_end'   => '</div>',
			// This will enclose each widget in a block:
			'block_start' => '<div class="evo_widget $wi_class$">',
			'block_end' => '</div>',
			// This will enclose the title of each widget:
			'block_title_start' => '<h3>',
			'block_title_end' => '</h3>',
			// Template params for "Item Tags" widget
			'widget_item_tags_before'    => '<div class="small">'.T_('Tags').': ',
			'widget_item_tags_after'     => '</div>',
			// Params for skin file "_item_content.inc.php"
			'widget_item_content_params' => $params,
		) );
		// ----------------------------- END OF "Item Single" CONTAINER -----------------------------
	}
	elseif( $disp == 'page' )
	{
		// ------------------------- "Item Page" CONTAINER EMBEDDED HERE --------------------------
		// Display container contents:
		widget_container( 'item_page', array(
			'widget_context' => 'item',	// Signal that we are displaying within an Item
			// The following (optional) params will be used as defaults for widgets included in this container:
			'container_display_if_empty' => false, // If no widget, don't display container at all
			// This will enclose each widget in a block:
			'block_start' => '<div class="evo_widget $wi_class$">',
			'block_end' => '</div>',
			// This will enclose the title of each widget:
			'block_title_start' => '<h3>',
			'block_title_end' => '</h3>',
			// Template params for "Item Link" widget
			'widget_item_link_before'    => '<p class="evo_post_link">',
			'widget_item_link_after'     => '</p>',
			// Template params for "Item Tags" widget
			'widget_item_tags_before'    => '<nav class="small post_tags">'.T_('Tags').': ',
			'widget_item_tags_after'     => '</nav>',
			// Params for skin file "_item_content.inc.php"
			'widget_item_content_params' => $params,
			// Template params for "Item Attachments" widget:
			'widget_item_attachments_params' => array(
					'limit_attach'       => 1000,
					'before'             => '<div class="evo_post_attachments"><h3>'.T_('Attachments').':</h3><ul class="evo_files">',
					'after'              => '</ul></div>',
					'before_attach'      => '<li class="evo_file">',
					'after_attach'       => '</li>',
					'before_attach_size' => ' <span class="evo_file_size">(',
					'after_attach_size'  => ')</span>',
				),
			// Controlling the title:
			'widget_item_title_params'  => array(
				'before' => '<div class="evo_post_title">'.( in_array( $disp, array( 'single', 'page' ) ) ? '<h1>' : '<h2>' ),
				'after' => ( in_array( $disp, array( 'single', 'page' ) ) ? '</h1>' : '</h2>' ).'</div>',
			),
		) );
		// ----------------------------- END OF "Item Page" CONTAINER -----------------------------
	}
	else
	{
	// this will create a <section>
		// ---------------------- POST CONTENT INCLUDED HERE ----------------------
		skin_include( '_item_content.inc.php', $params );
		// Note: You can customize the default item content by copying the generic
		// /skins/_item_content.inc.php file into the current skin folder.
		// -------------------------- END OF POST CONTENT -------------------------
	// this will end a </section>
	}
	?>


	<?php
		if( ! $Item->is_intro() )
		{ // List all tags attached to this post:
		$Item->tags( array(
				'before'    => '<div class="small tags_single">'.T_('Tags').': ',
				'after'     => '</div>',
				'separator' => ', ',
			) );
		}
	?>

	<div class="post-comments">
		<?php
			// Link to comments, trackbacks, etc.:
			$Item->feedback_link( array(
							'type' => 'comments',
							'link_before' => '',
							'link_after' => '',
							'link_text_zero' => '#',
							'link_text_one' => '#',
							'link_text_more' => '#',
							'link_title' => '#',
						) );

			// Link to comments, trackbacks, etc.:
			$Item->feedback_link( array(
							'type' => 'trackbacks',
							'link_before' => ' &bull; ',
							'link_after' => '',
							'link_text_zero' => '#',
							'link_text_one' => '#',
							'link_text_more' => '#',
							'link_title' => '#',
						) );
		?>
	</div>

	<?php
		// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
		skin_include( '_item_feedback.inc.php', array_merge( array(
				'before_section_title' => '<div class="clearfix"></div><h4 class="comment_text">',
				'after_section_title'  => '</h4>',
				'author_link_text' => $params['author_link_text'],
			), $params ) );
		// Note: You can customize the default item feedback by copying the generic
		// /skins/_item_feedback.inc.php file into the current skin folder.
		// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
	?>

	<?php
	if( evo_version_compare( $app_version, '6.7' ) >= 0 )
	{	// We are running at least b2evo 6.7, so we can include this file:
		// ------------------ WORKFLOW PROPERTIES INCLUDED HERE ------------------
		skin_include( '_item_workflow.inc.php' );
		// ---------------------- END OF WORKFLOW PROPERTIES ---------------------
	}
	?>

	<?php
	if( evo_version_compare( $app_version, '6.7' ) >= 0 )
	{	// We are running at least b2evo 6.7, so we can include this file:
		// ------------------ META COMMENTS INCLUDED HERE ------------------
		skin_include( '_item_meta_comments.inc.php', array(
				'comment_start'         => '<article class="evo_comment evo_comment__meta panel panel-default">',
				'comment_end'           => '</article>',
			) );
		// ---------------------- END OF META COMMENTS ---------------------
	}
	?>

	<?php
		locale_restore_previous();	// Restore previous locale (Blog locale)
	?>
</div>

<?php echo '</div>'; // End of post display ?>