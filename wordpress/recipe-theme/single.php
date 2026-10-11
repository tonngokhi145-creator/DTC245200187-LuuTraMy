<?php get_header(); ?>

<main class="container">
    <?php while (have_posts()) : the_post(); ?>

        <article class="single-recipe">

            <h1><?php the_title(); ?></h1>

            <p>
                📅 Ngày đăng:
                <?php echo esc_html(get_the_date('d/m/Y')); ?>
            </p>

            <p>
                📂 Danh mục:
                <?php the_category(', '); ?>
            </p>

            <?php if (has_post_thumbnail()) : ?>
                <div class="recipe-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="recipe-detail">
                <?php the_content(); ?>
            </div>

            <hr>

            <a class="btn"
               href="<?php echo esc_url(home_url('/')); ?>">
                ← Quay lại danh sách món ăn
            </a>

        </article>

        <?php
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
