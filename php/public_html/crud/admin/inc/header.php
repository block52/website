<?php

/* Build breadcrumb*/

$breadcrumb = array();

// get Home link class
$home_active = false;
if (!isset($match['params']['item'])) {
    $home_active = true;
}

// Add Home link
$breadcrumb[] = array(
    'active' => $home_active,
    'link'   => 'home',
    'text'   => '<i class="' . ICON_HOME . '"></i>'
);

// get current item
if (isset($match['params']['item'])) {
    $text         = '';
    $json         = file_get_contents('crud-data/db-data.json');
    $json_data    = json_decode($json, true);
    $current_item = $match['params']['item'];
    foreach ($json_data as $table => $data) {
        if ($data['item'] == $current_item) {
            $text = $data['table_label'];
        }
    }
    $breadcrumb[] = array(
        'active' => true,
        'link'   => $current_item,
        'text'   => $text
    );
}
if (DEMO === true) {
    include_once '../inc/navbar-main.php';
    echo '<div style="height: 48px;"></div>';
}
?>
<div class="page-header <?php echo DEFAULT_HEADER_CLASS; ?> has-cover">

    <div class="d-flex align-items-center py-4 px-3">
        <a href="<?php echo ADMIN_URL . 'home'; ?>" title="<?php echo SITENAME ?>"><img src="<?php echo ADMIN_URL; ?>assets/images/<?php echo ADMIN_LOGO; ?>" alt="<?php echo SITENAME ?>"><span class="sr-only">PHP CRUD</span></a>
        <!-- /page title -->
        <hgroup class="w-100 m-auto text-center">
            <?php if (DEMO === true) { ?>
                    <h1>PHP CRUD - Bootstrap 4 Dashboard Generator<br><span class="text-secondary d-block mt-2"><?php echo $desc; ?></span></h1>
            <?php } else { ?>
                <h1><?php echo SITENAME ?></h1>
            <?php } ?>
        </hgroup>

        <!-- Header elements -->
        <div class="heading-elements">
            <div class="btn-group heading-btn">
                <button class="btn <?php echo DEFAULT_BUTTONS_BACKGROUND; ?> btn-icon dropdown-toggle legitRipple" data-toggle="dropdown" aria-expanded="false">
                    <i class="<?php echo ICON_USER ?> mr-3"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a  class="dropdown-item" href="<?php echo ADMIN_URL . 'logout'; ?>"><i class="<?php echo ICON_LOGOUT; ?> pull-right"></i> <?php echo LOGOUT; ?></a></li>
                </ul>
            </div>
        </div>
        <!-- /header elements -->
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item d-block d-lg-none">
                <!-- toggler only for small screens -->
                <a href="#" class="sidebar-toggler d-flex align-items-center bg-gray-100 collapsed" data-toggle="collapse" data-target="#sidebar-main" aria-controls="sidebar-main" aria-expanded="false" aria-label="Toggle navigation">
                    <small class="sidebar-toggler-icon"></small>
                </a>
            </li>
<?php
foreach ($breadcrumb as $bc) {
    // links
    if ($bc['active'] !== true) {
        ?>
            <li class="breadcrumb-item"><a href="<?php echo ADMIN_URL . $bc['link']; ?>"><?php echo $bc['text']; ?></a></li>
        <?php
    } else {
        ?>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $bc['text']; ?></li>
        <?php
    }
}
?>
        </ol>
        <!-- /Breadcrumb -->
    </nav>

</div>
