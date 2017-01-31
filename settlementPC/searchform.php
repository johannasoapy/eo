<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
    <div>
        <label for="s" class="screen-reader-text"><?php _e('Search for:','bonestheme'); ?></label>
        <input onfocus="jQuery('.site-header').addClass('search');" type="search" id="s" name="s" name="s" value="" placeholder="Search site&hellip;" />

        <input id="searchsubmit" type="submit" value="s" class="orange-btn">
        
        <!--filter from http://www.wpbeginner.com/wp-tutorials/how-to-create-advanced-search-form-in-wordpress-for-custom-post-types/-->   
        <input type="hidden" name="post_type[]" value="article">
        <input type="hidden" name="post_type[]" value="sfwd-courses">
        <input type="hidden" name="post_type[]" value="themepage"> 
        <input type="hidden" name="post_type[]" value="tribe_events">
        <input type="hidden" name="post_type[]" value="post">
        <input type="hidden" name="post_type[]" value="sfwd-lessons">
    </div>
</form>