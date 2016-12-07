<?php

the_post();
$options = get_option('swp_print_button_options', false);
$page_margin_top = $options['general']['page_margin_top'];
$page_margin_bottom = $options['general']['page_margin_bottom'];
$page_margin_left = $options['general']['page_margin_left'];
$page_margin_right = $options['general']['page_margin_right'];

$print_post_date = (bool)$options['general']['print_post_date'];
$print_modified_date = (bool)$options['general']['print_modified_date'];
$print_post_title = (bool)$options['general']['print_post_title'];
$print_post_links = (bool)$options['general']['print_post_links'];
$print_post_images = (bool)$options['general']['print_post_images'];
$print_header = (bool)$options['general']['print_header'];
$print_footer = (bool)$options['general']['print_footer'];





?>
<html>
<head>
    <style>
        @page {
            display: block;
            size: 8.27in 11.69in;
            margin: <?php echo sprintf('%s %s %s %s',$page_margin_top,$page_margin_right,$page_margin_bottom,$page_margin_left) ?>;
        }

        @page img {
            max-width: 100%;
        }

        .center {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #000000;
        }

        <?php if(!$print_post_images){ ?>
        img {
            display: none;
        }

        <?php }else{ ?>
        img {
            max-width: 100%;
        }

        <?php } ?>
        <?php if(!$print_post_links): ?>
        a {
            display: none;
        }

        <?php endif ?>
    </style>
    <script>
        window.print();
    </script>
</head>
<body>
<div>


    <header>
        <?php if ($print_header) echo stripslashes($options['header_html']); ?>
    </header>

    <h2 class="center">
        <?php if ($print_post_title) the_title(); ?>

    </h2>


    <p>
        <?php the_content() ?>
    </p>
    <?php if ($print_post_date): ?>
        <p>
            Created: <strong><?php echo the_date(); ?></strong>
        </p>
    <?php endif; ?>
    <?php if ($print_modified_date): ?>
        <p>
            Last Updated: <strong><?php echo the_modified_date(); ?></strong>
        </p>
    <?php endif; ?>
    <footer>
        <?php if ($print_footer) echo stripslashes($options['footer_html']); ?>
    </footer>
</div>
</body>
</html>
