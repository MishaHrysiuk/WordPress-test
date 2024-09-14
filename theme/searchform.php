<form role="search" method="get" id="searchform" class="form-group search" action="<?php echo esc_url(home_url('/')); ?>">
    <input type="text" placeholder="поиск" class="form-control" value="<?php echo get_search_query(); ?>" name="s" id="s">
    <i class="fa fa-search"></i>
</form>