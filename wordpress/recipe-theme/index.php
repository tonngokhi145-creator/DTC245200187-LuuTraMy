<?php get_header(); ?>

<section class="hero">
    <div class="container">

        <h1>Khám phá công thức nấu ăn ngon 🍲</h1>

        <p>
            Chia sẻ những món ăn ngon, đơn giản
            và dễ thực hiện mỗi ngày.
        </p>

        <form class="search-box"
              method="get"
              action="<?php echo esc_url(home_url('/')); ?>">

            <input type="search"
                   name="s"
                   value="<?php echo esc_attr(get_search_query()); ?>"
                   placeholder="Tìm kiếm món ăn...">

            <button type="submit">Tìm kiếm</button>
        </form>

    </div>
</section>

<main class="container">

    <h2 class="section-title">
        <?php
        if (is_search()) {
            echo 'Kết quả tìm kiếm';
        } elseif (is_category()) {
            single_cat_title();
        } else {
            echo '🍽️ Công thức mới nhất';
        }
        ?>
    </h2>

    <?php if (have_posts()) : ?>

        <div class="recipe-grid">

            <?php while (have_posts()) : the_post(); ?>

                <article class="recipe-card">

                    <?php if (has_post_thumbnail()) : ?>

                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </a>

                    <?php else : ?>

                        <div class="recipe-cover">🍲</div>

                    <?php endif; ?>

                    <div class="recipe-content">

                        <h3>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <p>
                            <?php
                            echo esc_html(
                                wp_trim_words(get_the_excerpt(), 18)
                            );
                            ?>
                        </p>

                        <a href="<?php the_permalink(); ?>">
                            Xem công thức →
                        </a>

                    </div>

                </article>

            <?php endwhile; ?>

        </div>

        <?php the_posts_pagination(); ?>

    <?php else : ?>

        <p>Chưa có công thức nào. Hãy thêm món ăn đầu tiên!</p>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
