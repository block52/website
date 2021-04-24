<!-- Button trigger modal -->
<button class="btn btn-primary btn-sm button primary" id="view-src-btn" type="button">
    View source code
</button>
<!-- Modal -->
<div id="code-modal" class="modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h4 modal-title">
                    <?php echo $title; ?>
                </h2>
                <span class="close" data-dismiss="modal">×</span>
            </div>
            <div class="modal-body">
                <pre><code class="language-php"><?php echo $source_code; ?></code></pre>
            </div>
            <div class="modal-footer">
                <button class="close" data-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
<!-- Footer -->
<?php
$frameworks = array(
    'bootstrap-3-forms' => 'Bootstrap 3',
    'bootstrap-4-forms' => 'Bootstrap 4',
    'material-forms' => 'Material Design',
    'material-bootstrap-forms' => 'Material Bootstrap',
    'foundation-forms' => 'Foundation'
);
$framework = '';
foreach ($frameworks as $key => $value) {
    if (strstr($_SERVER['REQUEST_URI'], $key) !== false) {
        $framework = $value;
    }
}

$share_url = 'https://www.phpformbuilder.pro' . $_SERVER['REQUEST_URI'];
$share_title = 'PHP Form Builder';
$share_text = 'Create ' . $framework . ' Forms with strong code and the very best jQuery plugins';
$hash_tags = '#php#bootstrap#form#phpformbuilder';
?>
<footer class="bg-light border-top border-secondary text-center text-md-left mt-5">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-3 pb-4">
				<p class="text-dark h4 mb-4">
					About
				</p>
				<ul class="list-unstyled">
					<li>
						<a href="https://www.phpformbuilder.pro" class="text-dark"><?php echo $framework; ?> Form Builder</a>
					</li>
				</ul>
			</div>
			<div class="col-sm-6 col-md-3 pb-4">
				<p class="text-dark h4 mb-4">
					Templates
				</p>
				<ul class="list-unstyled">
					<li>
						<a href="https://www.phpformbuilder.pro/templates/index.php" class="text-dark"><?php echo $framework; ?> Form Templates</a>
					</li>
				</ul>
			</div>
			<div class="col-sm-6 col-md-3 pb-4">
				<p class="text-dark h4 mb-4">
					Drag &amp; drop
				</p>
				<ul class="list-unstyled">
					<li>
						<a href="https://www.phpformbuilder.pro/drag-n-drop-form-builder/index.html" class="text-dark"><?php echo $framework; ?> Drag &amp; drop Form Builder</a>
					</li>
				</ul>
            </div>
            <div class="col-sm-6 col-md-3 pb-4">
				<p class="text-dark h4 mb-4">
					Documentation
				</p>
				<ul class="list-unstyled">
					<li>
						<a href="https://www.phpformbuilder.pro/documentation/class-doc.php" class="text-dark"><?php echo $framework; ?> <?php echo $framework; ?> Forms documentation</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col d-flex justify-content-center align-items-center mb-4">
                    <!-- fb like -->
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.3"></script>
            <div class="fb-like d-block px-3" data-href="<?php echo $_SERVER['REQUEST_URI']; ?>" data-width="" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
            <a href="#" class="d-block px-3" href="https://www.facebook.com/sharer.php?u=<?php echo $share_url ?>&amp;t=<?php echo $share_title; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Facebook"><img src="https://cdnjs.cloudflare.com/ajax/libs/webicons/2.0.0/webicons/webicon-facebook-m.png" alt="Facebook" /></a>
            <a href="#" class="d-block px-3" href="https://pinterest.com/pin/create/button/?url=<?php echo $share_url ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Pinterest"><img src="https://cdnjs.cloudflare.com/ajax/libs/webicons/2.0.0/webicons/webicon-pinterest-m.png" alt="Twitter" /></a>
            <a href="#" class="d-block px-3" href="https://reddit.com/submit?url=<?php echo $share_url ?>&title=<?php echo $share_title; ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Share on Reddit"><img src="https://cdnjs.cloudflare.com/ajax/libs/webicons/2.0.0/webicons/webicon-reddit-m.png" alt="Instagram" /></a>
            <a href="#" class="d-block px-3" href="https://twitter.com/share?url=<?php echo $share_url ?>" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="left" title="Tweet this page!"><img src="https://cdnjs.cloudflare.com/ajax/libs/webicons/2.0.0/webicons/webicon-twitter-m.png" alt="Linkedin" /></a>
		</div>
	</div>
    <p class="text-center text-secondary border-top border-secondary py-4 mb-0">
        PHP Form Builder © <?php echo date('Y'); ?>
    </p>
</footer>
<!-- /Footer -->

<!-- Prism code -->
<script defer="" src="../assets/js/prism.min.js">
</script>
<!-- Demo selectpicker -->
<?php if (isset($form_theme_switcher) && (!preg_match('`selectpicker`', $source_code) || preg_match('`form-step-1`', $source_code))) { // if no selectpicker in main form?>
<?php if (isset($is_loadjs_form)) { ?>
    <script type="text/javascript">
        loadjs(['<?php echo $form_theme_switcher->plugins_url; ?>bootstrap-select/dist/js/bootstrap-select.min.js'], 'bootstrap-select', {async: false});
    </script>
<?php } else {
?>
    <script type="text/javascript" src="<?php echo $form_theme_switcher->plugins_url; ?>bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<?php
}
?>
<?php
} ?>
<script type="text/javascript">
    function hideModal($modal) {
        $modal.removeClass('fadeIn').addClass('fadeOut');
        setTimeout(function() {
            $modal.css('display', 'none').removeClass('fadeOut');
        }, 400);
    }
<?php
if (isset($is_loadjs_form)) {
    if (isset($form_theme_switcher) && (!preg_match('`selectpicker`', $source_code) || preg_match('`form-step-1`', $source_code))) { // if no selectpicker in main form
        ?>
    loadjs.ready(['core', 'bootstrap-select'], function() {
        // console.log('core, bootstrap-select ready');
<?php
    } else {
?>
    loadjs.ready('core', function() {
        // console.log('core ready');
<?php
    }
} else {
?>
    $(document).ready(function() {
        // console.log('document ready');
<?php
}
?>
        if (top == self && location.hostname == 'www.phpformbuilder.pro') {
            var templateBuyBtn = '<div id="template-buy-div"><a href="https://1.envato.market/qKq4g" class="btn btn-primary btn-sm button primary" id="template-buy-btn" rel="nofollow">Buy Php Form Builder</a></div>';
            $('body h1').after(templateBuyBtn);
            var templateLogo = '<br><a href="https://www.phpformbuilder.pro/templates/index.php" style="display: inline-flex; margin-top: 10px; vertical-align: middle;" title="Php Form Builder"><img src="https://www.phpformbuilder.pro/documentation/assets/images/phpformbuilder-logo-mini.png" width="36" height="36" style="margin-right:20px;" alt="Php Form Builder"><small style="line-height: 36px;">Php Form Builder</small></a>';
            $('body h1').append(templateLogo);
        }
        <?php if (isset($form_theme_switcher)) {
    ?>
            $('body > .container').prepend('<?php echo $form_theme_switcher_output; // render theme select?>');
            $('select[name="theme"]').on('change', function() {
                window.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?theme=' + $(this).val();
            });
        <?php
    } ?>
        var $modal = $('#code-modal');
        $('#view-src-btn').on('click', function() {
            $modal.addClass('fadeIn').css('display', 'block');
        });
        $('.modal-content').on('click', function() {
            if($(event.target).attr('data-dismiss') != 'modal') {
                return false;
            }
        });
        $('#code-modal').on('click', function() {
            hideModal($modal);
        });
        $(document).on('click', function(event) {
            if ($(event.target).attr('id') == 'code-modal' || $(event.target).attr('data-dismiss') == 'modal') {
                hideModal($modal);
            }
        });
        if($('#material-collapsible-notice')[0]) {
            $('#material-collapsible-notice').collapsible();
        }
    });
</script>
<?php
if (isset($form_theme_switcher)) {
    if (isset($is_loadjs_form)) {
        // $form_theme_switcher->setMode('development');
        $form_theme_switcher->useLoadJs('core');
    }
    $form_theme_switcher->printJsCode();
}
