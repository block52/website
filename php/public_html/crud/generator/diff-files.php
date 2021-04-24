<?php
use phpformbuilder\Form;

if (!file_exists('../conf/conf.php')) {
    exit('Configuration file not found (3)');
}
include_once '../conf/conf.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('diff-files') === true && file_exists(BACKUP_DIR . $_POST['file-to-diff'])) {
    include_once 'class/phpdiff/Diff.php';
    $file_to_diff = addslashes($_POST['file-to-diff']);
    $old_file = explode("\n", file_get_contents(BACKUP_DIR . $file_to_diff));
    $new_file = explode("\n", file_get_contents(ADMIN_DIR . $file_to_diff));
    $diff = new \Diff($old_file, $new_file);
} else {
    exit('Unable to locate ' . addslashes($_POST['file-to-diff']) . ' in the backup directory.');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>php CRUD Generator - file comparison and merge</title>
    <meta name="description" content="compare and merge the different versions of the files generated for your admin panel by PHP CRUD Generator">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/themes/default/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/ripple.min.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="<?php echo ADMIN_URL; ?>assets/stylesheets/fa-svg-with-js.min.css">
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/stylesheets/generator.min.css">
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/lib/php-diff/jquery.phpdiffmerge.css">
    <link rel="stylesheet" href="<?php echo GENERATOR_URL; ?>generator-assets/lib/php-diff/php-diff.css">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-15">
                <div class="card card-default">
                    <div class="card-header"><h4 class="card-title text-semibold"><?php echo DIFF_FILES; ?></h4></div>
                    <div class="card-body">
                        <div id="merge-result"></div>
                        <h2><?php echo SIDE_BY_SIDE_COMPARISON ?> - <?php echo $file_to_diff; ?></h2>
                        <p><?php echo SIDE_BY_SIDE_COMPARISON_HELPER; ?></p>
                        <?php

                        // Generate a side by side diff
                        require_once 'class/phpdiff/Diff/Renderer/Html/SideBySide.php';
                        $renderer = new \Diff_Renderer_Html_SideBySide;
                        $html = $diff->Render($renderer);
                        if (!empty($html)) {
                            echo $html;
                            if (DEMO !== true) {
                                ?>
                                <div class="text-center mt-4">
                                    <button type="button" id="do-merge" class="btn btn-primary">Merge</button>
                                </div>
                                <?php
                            } else {
                                ?>
                                    <div class="alert alert-info has-icon">
                                        <h4 class="mb-0">The Side by side comparison module is disabled in this demo.</h4>
                                    </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="alert alert-info has-icon my-5">
                                <p>Source &amp; target file are identical.</p>
                                <p>There's nothing to merge.</p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/popper.min.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_URL; ?>assets/javascripts/bootstrap.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/pace.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/plugins/ripple.min.js"></script>
    <script type="text/javascript" defer src="<?php echo ADMIN_URL; ?>assets/javascripts/fontawesome-all.min.js"></script>
    <script type="text/javascript" defer src="<?php echo GENERATOR_URL; ?>generator-assets/javascripts/generator.js"></script>
    <script type="text/javascript" src="<?php echo GENERATOR_URL; ?>generator-assets/lib/php-diff/jquery.phpdiffmerge.min.js"></script>
    <?php
    /* Pass $a and $b to javascript */
    echo '<script type="text/javascript">var left=' . json_encode($old_file) . ', right=' . json_encode($new_file) . ';</script>';
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.Differences').phpdiffmerge({
                left: left,
                right: right,
                merged: function(merge, left, right) {
                    /* Do something with the merge */
                    $.post(
                        'inc/ajax-diff-merge.php',
                        {
                            action: 'register_merged_content',
                            merge: merge,
                            filepath: '<?php echo $_POST['file-to-diff'] ?>'
                        },
                        function() {
                            $('#merge-result').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span class="font-weight-bold">Done!</strong></div>');
                            window.scrollTo(0, 0);
                        }
                        );
                },
                button: '#do-merge'
                /* Use your own "Merge now" button */
// ,button: '#myButtonId'
// ,pupupResult: true
/* uncomment to see the complete merge in a pop-up window */
/* uncomment to pass additional infos to the console. */
// ,debug: true
});
            $('.Differences thead th:first-child').append(' (Generator <em>backup-files</em> dir)');
            $('.Differences thead th:nth-child(2)').append(' (Admin dir)');
        });
    </script>
</body>
</html>
