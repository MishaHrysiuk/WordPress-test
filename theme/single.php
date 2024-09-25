<?php 
get_header(); 
the_post();
?>

<!--MAIN BANNER AREA START -->
<div class="page-banner-area page-contact" id="page-banner" style="background: url(<?the_post_thumbnail_url()?>) no-repeat center / cover">
    <div class="overlay dark-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="banner-content content-padding">
                    <h1 class="text-white"><?the_title()?></h1>
                    <p><?the_excerpt()?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MAIN HEADER AREA END -->

<section class="section blog-wrap">
    <div class="container">
        <div class="row">
            <main class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        
                        <? 
                            get_template_part( "template-parts/content", get_post_type());
                            comments_template();
                        ?>
    
                    </div>
                </div>
            </main>
            <? get_sidebar() ?>
        </div>
    </div>
    </div>
</section>

<?php get_footer(); ?>