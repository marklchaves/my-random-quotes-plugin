<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://caughtmyeye.dev/about
 * @since      1.0.0
 *
 * @package    My_Random_Quotes
 * @subpackage My_Random_Quotes/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<!-- ~mlc 4 Feb 2020 -->

<?php
$options = get_option('my-random-quotes');
if ($options['quo-title']) {
    echo ('<h2>' . $args['quotes-title'] . '</h2>');
}
?>
<ul style="list-style: none;">
    <?php foreach ($items as $item) { ?>
        <li>
            <h3><?php echo ($item->post_title) ?></h3> <?php echo ($item->post_content) ?>
        </li>
    <?php } ?>
</ul>