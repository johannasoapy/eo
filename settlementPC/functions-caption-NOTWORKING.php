<?php 
/**
 * Add image credits to captions
 *
 * Add the "Credit" custom fields to media attachments with captions
 *
 * Uses get_post_custom() http://codex.wordpress.org/Function_Reference/get_post_custom
 */
function base_image_credit_to_captions($attr, $content = null) {
	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	
	if ( $output != '' )
		return $output;
		
	extract( shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr) );
	
	if ( 1 > (int) $width || empty($caption) )
		return $content;
	
	if ( $id ) {
		$attachment_id = intval( str_replace( 'attachment_', '', $id ) );
		$id = 'id="' . $id . '" ';
	}
		
	$caption_content = '';
	$caption_content .= do_shortcode( $content );
	$caption_content .= '' . $caption . '';
	
	// Get image credit custom attachment fields
	$attachment_fields = get_post_custom( $attachment_id );
	$credit_text = ( isset($attachment_fields['_cc_author']) && !empty($attachment_fields['_cc_author']) ) ? esc_attr($attachment_fields['_cc_author']) : '';
	$credit_link = ( isset($attachment_fields['_cc_author_link']) && !empty($attachment_fields['_cc_author_link']) ) ? esc_url($attachment_fields['_cc_author_link']) : '';
	
	// If image credit fields have data then attach the image credit
	if ( $credit_text && $credit_link )
		$caption_content .= 'Image provided by ' . $credit_text . '';
	
	$caption_content .= '';
	
	return $caption_content;
}
add_shortcode('wp_caption', 'base_image_credit_to_captions');
add_shortcode('caption', 'base_image_credit_to_captions');


/**
 * Display image credit
 *
 * Display the "Credit" custom fields added to media attachments
 *
 * Uses get_children() http://codex.wordpress.org/Function_Reference/get_children
 * Uses get_post_custom() http://codex.wordpress.org/Function_Reference/get_post_custom
 * @global $post The current post data
 * @return Prints the caption HTML
 */
function base_image_credit( $post_ID = null ) {
	// Get the post ID of the current post if not set
	if ( !$post_ID ) {
		global $post;
		$post_ID = $post->ID;
	}
	
	// Get all the attachments for the current post (object stdClass)
	$attachments = get_children('post_type=attachment&post_parent=' . $post->ID);
	
	// If attachments are found
	if ( isset($attachments) && !empty($attachments) ) {
		foreach ($attachments as $attachment) :
		
		// Get the first attachment
		$attachment_fields = get_post_custom( $attachment->ID ); ?>
		<?php echo $attachment_fields; ?>
		<p class="wp-caption-text">

			<?php if( get_field('cc_title', $attachment_fields ) ): ?>
				<span>
					<?php if( get_field('cc_title_link', $attachment_fields) ): ?>
				<a href="<?php echo the_field('cc_title_link', $attachment_fields); ?>" target="_blank"><?php echo the_field('cc_title', $attachment_fields); ?></a>
					<?php else: ?>
						<?php echo the_field('cc_title', $attachment_fields); ?>
					<?php endif; ?>
				</span>
			<?php endif; ?>

			<?php if( get_field('cc_author', $attachment_fields ) ): ?>
				<span>
					<?php if( get_field('cc_author_link', $attachment_fields) ): ?>
				&nbsp;by <a href="<?php echo the_field('cc_author_link', $attachment_fields); ?>" target="_blank"><?php echo the_field('cc_author', $attachment_fields); ?></a>.
					<?php else: ?>
						&nbsp;by <?php echo the_field('cc_author', $attachment_fields); ?>.
					<?php endif; ?>
				</span>
			<?php endif; ?>

			<?php if( get_field('cc_license', $attachment_fields) ): ?>
				<?php $cclicense = get_field_object('field_5583260d7493e',$attachment_fields); ?>
				<?php $ccvalue = get_field('cc_license',$attachment_fields); ?>
				<?php $cclabel = $cclicense['choices'][ $ccvalue ]; ?>
				<?php if ( $ccvalue == 'copyright'): ?>
					<span>&nbsp;<?php echo $cclabel; ?></span>
				<?php else: ?>
					<span>&nbsp;<a href="<?php echo $ccvalue; ?>" target="_blank"><?php echo $cclabel; ?></a></span>
				<?php endif; ?>
			<?php endif; ?>
			</p> <?php
		
		endforeach;
	}
}