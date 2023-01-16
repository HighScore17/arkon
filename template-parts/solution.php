<?php
$features = [

    ["icon"=>"folder", "title"=>"GOVERNANCE", "txt"=>"Vestibulum rutrum quam vitae fringilla tincidunt. Suspendisse nec tortor urna. Ut laoreet sodales nisi, quis iaculis nulla iaculis vitae."],
    ["icon"=>"dataops", "title"=>"DATAOPS", "txt"=>"Vestibulum rutrum quam vitae fringilla tincidunt. Suspendisse nec tortor urna. Ut laoreet sodales nisi, quis iaculis nulla iaculis ."],
    ["icon"=>"visualization", "title"=>"VISUALIZATION", "txt"=>"Vestibulum rutrum quam vitae fringilla tincidunt. Suspendisse nec tortor urna. Ut laoreet sodales nisi, quis iaculis nulla iaculis vitae. "],
    ["icon"=>"preparation", "title"=>"PREPARATION", "txt"=>"Vestibulum rutrum quam vitae fringilla tincidunt. Suspendisse nec tortor urna. Ut laoreet sodales nisi, quis iaculis nulla iaculis ."],
];
?>

<div class="solution">
    <div class="left-side">
        <img src=<?php echo get_template_directory_uri()."/assets/img/arkon-solutions.png"; ?> alt="">
    </div>
    <div class="right-side">
        <p>Our</p>
        <h1>Solution</h1>
        <div class="items">
            <?php
            foreach ($features as $item) { ?>
                <div class="feature_card">
                    <img src="<?php echo get_template_directory_uri()."/assets/icons/".$item['icon'].".png"; ?>" />
                    <div>
                        <h4 class=<?php echo $item['icon']; ?>><?php echo $item['title']; ?></h4>
                        <p><?php echo $item['txt']; ?></p>
                    </div>
                </div><!-- ./feature -->
            <?php } ?>
        </div>
    </div>
</div>