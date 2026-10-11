<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container header-inner">

        <a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
            🍳 Recipe Việt
        </a>

        <nav>
            <a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>

            <?php
            $categories = get_categories(array(
                'hide_empty' => true,
                'number' => 5
            ));

            foreach ($categories as $category) {
                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">'
                    . esc_html($category->name)
                    . '</a>';
            }
            ?>
        </nav>

    </div>
</header>
