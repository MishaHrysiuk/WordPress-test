<?php get_header(); ?>

<!--MAIN BANNER AREA START -->
<div class="page-banner-area page-contact" id="page-banner">
    <div class="overlay dark-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 m-auto text-center col-sm-12 col-md-12">
                <div class="banner-content content-padding">
                    <h1 class="text-white">Promodise журнал</h1>
                    <p>Полезные статьи про маркетинг и диджитал</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MAIN HEADER AREA END -->

<section class="section blog-wrap ">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <?php if (have_posts()) :
                        $counter = 1;
                        while (have_posts()) : the_post(); ?>
                            <div class="<?php echo $counter++ % 3 == 0 ? "col-lg-12" : "col-lg-6"; ?>">
                                <div class="blog-post">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('post-thumbnail', [
                                            'class' => 'img-fluid w-100'
                                        ]);
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/images/blog/blog-1.jpg" alt="" class="img-fluid w-100">';
                                    }
                                    ?>
                                    <img src="/images/blog/blog-1.jpg" alt="" class="img-fluid w-100">
                                    <div class="mt-4 mb-3 d-flex">
                                        <div class="post-author mr-3">
                                            <i class="fa fa-user"></i>
                                            <span class="h6 text-uppercase"><?php the_author(); ?></span>
                                        </div>

                                        <div class="post-info">
                                            <i class="fa fa-calendar-check"></i>
                                            <span><?php the_time('j F Y'); ?></span>
                                        </div>
                                    </div>
                                    <a href="<?php echo get_the_permalink(); ?>" class=" h4 "><?php the_title(); ?></a>
                                    <p class=" mt-3"><?php the_excerpt() ?></p>
                                    <a href="<?php echo get_the_permalink(); ?>" class="read-more">Читать статью <i
                                            class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        <?php endwhile;
                    else: ?>
                        No posts.
                    <?php endif; ?>
                    <div class="col-lg-12">
                        <?php the_posts_pagination([
                            'show_all' => false, // all pages involved in pagination are shown
                            'end_size' => 1,     // number of pages at the ends
                            'mid_size' => 1,     // number of pages around the current page
                            'prev_next' => true, // whether to display 'previous/next page' side links.
                            'prev_text' => __('<<-Previous'),
                            'next_text' => __('Next->>'),
                            'add_args' => false,  // Array of arguments (query variables) to add to links.
                            'add_fragment' => '', // Text to be added to all links.
                            'screen_reader_text' => __('Posts navigation'),
                            'before_page_number' => '',
                            'after_page_number'  => ''
                        ]); ?>
                    </div>
                </div>
            </div>
            <?php get_sidebar() ?>
        </div>
    </div>
    </div>
</section>


<?php get_footer(); ?>