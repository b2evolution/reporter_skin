<?php
/**
 * This skin only uses one single template which includes most of its features.
 * It will also rely on default includes for specific dispays (like the comment form).
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * The main page template is used to display the blog when no specific page template is available
 * to handle the request (based on $disp).
 *
 * @package evoskins
 * @subpackage bootstrap
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

if( evo_version_compare( $app_version, '6.4' ) < 0 )
{ // Older skins (versions 2.x and above) should work on newer b2evo versions, but newer skins may not work on older b2evo versions.
	die( 'This skin is designed for b2evolution 6.4 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );


// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php', array() );
// -------------------------------- END OF HEADER --------------------------------


// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------
?>


<header id="single_header">

	<?php
	if( $Item = & mainlist_get_item() )
	{ // Get a cover image of the current post
		$cover_image_url = $Item->get_cover_image_url();
	}

	if( empty( $cover_image_url ) )
	{ // No cover of the post
		$main_full_image_div_attrs = ' class="single_bg nocover"';
	}
	else
	{ // Use a cover image as main background only when it exists for the post
		$main_full_image_div_attrs = ' class="single_bg" style="background-image:url(\''.$cover_image_url.'\')"';
	}
	?>

  <!-- Main Full Image  -->
  <div<?php echo $main_full_image_div_attrs; ?>>

  <!-- container Page Top -->
  <div class="single_menu">
    <div class="container">

      <nav class="row" id="nav">
    		<div class="col-md-12">
          <div class="row">
      			<div class="navbar-header">
      				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#reporter_nav">
      					<span class="sr-only">Toggle navigation</span>
      					<span class="icon-bar"></span>
      					<span class="icon-bar"></span>
      					<span class="icon-bar"></span>
      				</button>
      				<!-- <a class="navbar-brand" href="#">Brand</a> -->
      			</div>

						<?php
							// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
							// Display container and contents:
							// Note: this container is designed to be a single <ul> list
							widget_container( 'menu', array(
									// The following params will be used as defaults for widgets included in this container:
									'container_display_if_empty' => true, // Display container anyway even if no widget
									'container_start'     => '<div class="col-md-12 collapse navbar-collapse" id="reporter_nav"><ul class="nav nav-tabs main_nav evo_container $wico_class$">',
									'container_end'       => '</ul></div>',
									'block_start'         => '',
									'block_end'           => '',
									'block_display_title' => false,
									'list_start'          => '',
									'list_end'            => '',
									'item_start'          => '<li class="evo_widget $wi_class$">',
									'item_end'            => '</li>',
									'item_selected_start' => '<li class="evo_widget $wi_class$ active">',
									'item_selected_end'   => '</li>',
									'item_title_before'   => '',
									'item_title_after'    => '',
								) );
							// ----------------------------- END OF "Menu" CONTAINER -----------------------------
						?>
      		</div>
        </div>
    	</nav>

    </div><!-- End container PageTop -->
  </div> <!-- End Single Menu -->

  <div class="single_bg_content">
    <?php
    // ------------------------- "Item Single - Header" CONTAINER EMBEDDED HERE --------------------------
    // Display container contents:
    widget_container( 'item_single_header', array(
      'widget_context' => 'item',	// Signal that we are displaying within an Item
      // The following (optional) params will be used as defaults for widgets included in this container:
      'container_display_if_empty' => false, // If no widget, don't display container at all
      // This will enclose each widget in a block:
      'block_start' => '<div class="evo_widget $wi_class$">',
      'block_end' => '</div>',
      // This will enclose the title of each widget:
      'block_title_start' => '<h3>',
      'block_title_end' => '</h3>',

      // Template params for "Item Title" widget:
      'widget_item_title_params'  => array(
          'before' => '<h2 class="entry-title-full">',
          'after' => '</h2>',
        ),
      // Template params for "Item Visibility Badge" widget:
      'widget_item_visibility_badge_display' => ( ! $Item->is_intro() && $Item->status != 'published' ),
      'widget_item_visibility_badge_params'  => array(
          'template' => '<div class="center"><div class="evo_status evo_status__$status$ badge" data-toggle="tooltip" data-placement="top" title="$tooltip_title$">$status_title$</div></div>',
        ),
      // Template params for "Item Info Line" widget:
      'widget_item_info_line_before' => '',
      'widget_item_info_line_after'  => '',
      'widget_item_info_line_params' => array(
          'before_flag'         => '',
          'after_flag'          => ' ',
          'before_permalink'    => '',
          'after_permalink'     => ' ',
          'before_author'       => 'By ',
          'after_author'        => '',
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
          'format'              => '<p>$flag$$permalink$$post_time$$author$$categories$$edit_link$</p>',
        ),
    ) );
    // ----------------------------- END OF "Item Single - Header" CONTAINER -----------------------------
    ?>
  </div>

    <div class="divider"></div>
  </div>
  <!-- End Main Full Image -->

</header>
<!-- End Single Header -->

<!-- =================================== START OF MAIN AREA =================================== -->

<!-- Container Main Area -->
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 ">

    <?php
      // ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
      messages( array(
          'block_start' => '<div class="action_messages">',
          'block_end'   => '</div>',
        ) );
      // --------------------------------- END OF MESSAGES ---------------------------------
    ?>

    <?php
      // -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------
      mainlist_page_links( array(
						'block_start'           => '<div class="center"><ul class="pagination">',
						'block_end'             => '</ul></div>',
						'page_current_template' => '<span>$page_num$</span>',
						'page_item_before'      => '<li>',
						'page_item_after'       => '</li>',
						'page_item_current_before' => '<li class="active">',
						'page_item_current_after'  => '</li>',
						'prev_text'             => '<i class="fa fa-angle-double-left"></i>',
						'next_text'             => '<i class="fa fa-angle-double-right"></i>',
        ) );
      // ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
    ?>


    <?php
      // --------------------------------- START OF POSTS -------------------------------------
      // Display message if no post:
      display_if_empty();

      if( $Item )
      { // For each blog post, do everything below up to the closing curly brace "}"

        // ---------------------- ITEM BLOCK INCLUDED HERE ------------------------
        skin_include( '_item_block.inc.php', array(
            'content_mode' => 'auto',   // 'auto' will auto select depending on $disp-detail
            // Comment template
            'comment_start'         => '<div class="evoComment panel panel-default page_comment">',
            'comment_end'           => '</div>',
            'comment_title_before'  => '<div class="panel-heading"><h4 class="evoComment-title panel-title">',
            'comment_title_after'   => '</h4></div><div class="panel-body">',
            'comment_rating_before' => '<div class="evoComment-rating floatright">',
            'comment_rating_after'  => '</div>',
            'comment_avatar_after'  => '</div>',
            'comment_avatar_before' => '<div class="evoComment-avatar">',
            'comment_text_before'   => '<div class="evoComment-text">',
            'comment_text_after'    => '</div>',
            'comment_info_before'   => '<div class="evoComment-info clear text-muted"><small>',
            'comment_info_after'    => '</small></div></div>',
            'preview_start'         => '<div class="panel panel-warning" id="comment_preview">',
            'preview_end'           => '</div>',
            'comment_attach_info'   => get_icon( 'help', 'imgtag', array(
                'data-toggle'    => 'tooltip',
                'data-placement' => 'bottom',
                'data-html'      => 'true',
                'title'          => htmlspecialchars( get_upload_restriction( array(
                    'block_after'     => '',
                    'block_separator' => '<br /><br />' ) ) )
              ) ),
            // Comment form
            'form_title_start'      => '<div class="panel '.( $Session->get('core.preview_Comment') ? 'panel-danger' : 'panel-default' )
                                       .' comment_form"><div class="panel-heading"><h3>',
            'form_title_end'        => '</h3></div>',
            'after_comment_form'    => '</div>',
            'include_cover_images'  => false,
          ) );
        // ----------------------------END ITEM BLOCK  ----------------------------

      } // ---------------------------------- END OF POSTS ------------------------------------
    ?>

    <?php
      // -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------
      mainlist_page_links( array(
						'block_start'           => '<div class="center"><ul class="pagination">',
						'block_end'             => '</ul></div>',
						'page_current_template' => '<span>$page_num$</span>',
						'page_item_before'      => '<li>',
						'page_item_after'       => '</li>',
						'page_item_current_before' => '<li class="active">',
						'page_item_current_after'  => '</li>',
						'prev_text'             => '<i class="fa fa-angle-double-left"></i>',
						'next_text'             => '<i class="fa fa-angle-double-right"></i>',
        ) );
      // ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
    ?>

    </div>

  </div> <!-- end row -->
</div> <!-- End Container Main Area -->

<!-- =================================== START OF FOOTER =================================== -->
<!-- Container Footer -->
<div class="container">

  <footer class="row">
    <div class="col-md-12 center">
        <div class="main_footer">
          <?php
            // Display container and contents:
            widget_container( 'footer', array(
                // The following params will be used as defaults for widgets included in this container:
				'container_display_if_empty' => false, // If no widget, don't display container at all
				'container_start'     => '<div class="evo_container $wico_class$">',
				'container_end'       => '</div>',
              ) );
            // Note: Double quotes have been used around "Footer" only for test purposes.
          ?>

          <div class="copyright">
            <?php
              // Display footer text (text can be edited in Blog Settings):
              $Blog->footer_text( array(
                  'before'      => '',
                  'after'       => ' &bull; ',
                ) );

            // TODO: dh> provide a default class for pTyp, too. Should be a name and not the ityp_ID though..?!
            ?>

            <?php
              // Display a link to contact the owner of this blog (if owner accepts messages):
              $Blog->contact_link( array(
                  'before'      => '',
                  'after'       => ' &bull; ',
                  'text'   => T_('Contact'),
                  'title'  => T_('Send a message to the owner of this blog...'),
                ) );
              // Display a link to help page:
              $Blog->help_link( array(
                  'before'      => ' ',
                  'after'       => ' ',
                  'text'        => T_('Help'),
                ) );
            ?>

            <?php
              // Display additional credits:
              // If you can add your own credits without removing the defaults, you'll be very cool :))
              // Please leave this at the bottom of the page to make sure your blog gets listed on b2evolution.net
              credits( array(
                  'list_start'  => '&bull;',
                  'list_end'    => ' ',
                  'separator'   => '&bull;',
                  'item_start'  => ' ',
                  'item_end'    => ' ',
                ) );
            ?>
          </div>

          <?php
            // Please help us promote b2evolution and leave this logo on your blog:
            powered_by( array(
                'block_start' => '<div class="powered_by">',
                'block_end'   => '</div>',
                // Check /rsc/img/ for other possible images -- Don't forget to change or remove width & height too
                'img_url'     => '$rsc$img/powered-by-b2evolution-120t.gif',
                'img_width'   => 120,
                'img_height'  => 32,
              ) );
          ?>
      </div> <!-- End Main_footer -->

    </div>
  </footer>
</div>

<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
siteskin_include( '_site_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------


// ------------------------- HTML FOOTER INCLUDED HERE --------------------------
skin_include( '_html_footer.inc.php' );
// Note: You can customize the default HTML footer by copying the
// _html_footer.inc.php file into the current skin folder.
// ------------------------------- END OF FOOTER --------------------------------
?>
