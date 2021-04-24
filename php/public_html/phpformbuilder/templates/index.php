<?php
use phpformbuilder\Form;

session_start();
if (isset($_COOKIE['prefered_framework']) && preg_match('`[a-z-]+`', $_COOKIE['prefered_framework'])) {
    $prefered_framework = $_COOKIE['prefered_framework'];
} else {
    $prefered_framework = 'bootstrap-4';
    setcookie('prefered_framework', $prefered_framework, time() + (86400 * 30), "/");
}

$bs3_checked                = '';
$bs3_on                     = '';
$bs4_checked                = '';
$bs4_on                     = '';
$material_checked           = '';
$material_on                = '';
$material_bootstrap_checked = '';
$material_bootstrap_on      = '';
$foundation_checked         = '';
$foundation_on              = '';

switch ($prefered_framework) {
    case 'bootstrap-3':
        $bs3_checked = 'checked=checked';
        $bs3_on      = 'framework-on';
        break;

    case 'material':
        $material_checked = 'checked=checked';
        $material_on      = 'framework-on';
        break;

    case 'material-bootstrap':
        $material_bootstrap_checked = 'checked=checked';
        $material_bootstrap_on      = 'framework-on';
        break;

    case 'foundation':
        $foundation_checked = 'checked=checked';
        $foundation_on      = 'framework-on';
        break;

    default:
        $bs4_checked = 'checked=checked';
        $bs4_on      = 'framework-on';
        break;
}

/* =============================================
    Forms
============================================= */

$forms_base = array(
    array(
        'title'      =>  'Ajax Loaded Contact Form 1',
        'desc'       =>  'Contact form in HTML file loaded with Ajax',
        'desc-class' =>  '',
        'link'       =>  '/ajax-loaded-contact-form-1.html',
        'class'      =>  'ajax contact-form has-captcha has-checkbox has-validation has-intl-tel-input',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-mail'
    ),
    array(
        'title'      =>  'Contact Form 1',
        'desc'       =>  'Horizontal contact form with captcha',
        'desc-class' =>  '',
        'link'       =>  '/contact-form-1.php',
        'class'      =>  'contact-form has-captcha has-checkbox has-validation has-intl-tel-input',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-mail'
    ),
    array(
        'title'      =>  'Contact Form 1 loaded with Loadjs',
        'desc'       =>  'Horizontal contact form with captcha',
        'desc-class' =>  '',
        'link'       =>  '/contact-form-1-loadjs.php',
        'class'      =>  'contact-form has-captcha has-checkbox loadjs has-validation has-intl-tel-input',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-mail'
    ),
    array(
        'title'      =>  'Contact Form 1 Modal',
        'desc'       =>  'Horizontal contact form with captcha',
        'desc-class' =>  '',
        'link'       =>  '/contact-form-1-modal.php',
        'class'      =>  'contact-form has-captcha has-checkbox modal-form has-validation has-intl-tel-input',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-mail'
    ),
    array(
        'title'      =>  'Contact Form 1 Popover',
        'desc'       =>  'Horizontal contact form with captcha',
        'desc-class' =>  '',
        'link'       =>  '/contact-form-1-popover.php',
        'class'      =>  'contact-form popover-form has-captcha has-checkbox has-validation has-intl-tel-input',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-mail'
    ),
    array(
        'title'      =>  'Contact Form 2',
        'desc'       =>  'Vertical contact form with captcha',
        'desc-class' =>  '',
        'link'       =>  '/contact-form-2.php',
        'class'      =>  'contact-form has-captcha has-checkbox has-validation has-intl-tel-input',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-address-book'
    ),
    array(
        'title'      =>  'Contact Form 3',
        'desc'       =>  'Contact form with rich text editor &amp; dependent field',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/contact-form-3.php',
        'class'      =>  'contact-form has-dependent-fields has-select has-tinymce has-checkbox has-intl-tel-input has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-phone'
    ),
    array(
        'title'      =>  'Car Rental Form',
        'desc'       =>  'Step form with accordion &amp; step validation',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/car-rental-form.php',
        'class'      =>  'order-rental step accordion has-checkbox has-picker has-select has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-car'
    ),
    array(
        'title'      =>  'Custom Radio/Checkbox Form',
        'desc'       =>  'With Custom CSS plugin',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/custom-radio-checkbox-css-form.php',
        'class'      =>  'has-checkbox',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'foundation'),
        'icon'       =>  'icon-check-square-o'
    ),
    array(
        'title'      =>  'Switches Radio/Checkbox Form',
        'desc'       =>  'On/Off with LC-Switch plugin',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/switches-form.php',
        'class'      =>  'has-checkbox',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-toggle-on'
    ),
    array(
        'title'      =>  'Customer Feedback Form',
        'desc'       =>  '2 columns<br>Feedback Form<br>with multiselect',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/customer-feedback-form.php',
        'class'      =>  'survey has-select has-checkbox has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-comments'
    ),
    array(
        'title'      =>  'Customer Satisfaction Step Form',
        'desc'       =>  'Ajax step form with sliding transitions',
        'desc-class' =>  '',
        'link'       =>  '/customer-satisfaction-step-form.php',
        'class'      =>  'survey step ajax has-select has-checkbox',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-chart'
    ),
    array(
        'title'      =>  'Customer Support Form',
        'desc'       =>  'Ajax step form with sliding transitions',
        'desc-class' =>  '',
        'link'       =>  '/customer-support-form.php',
        'class'      =>  'ajax contact-form has-select has-checkbox has-dependent-fields has-file-upload has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-lifebuoy'
    ),
    array(
        'title'      =>  'CV Submission Form',
        'desc'       =>  'Horizontal form with rich text editor &amp; file upload',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/cv-submission-form.php',
        'class'      =>  'has-file-upload has-tinymce has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-profile'
    ),
    array(
        'title'      =>  'Dependent fields Form',
        'desc'       =>  'Form with several conditional fields',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/dependent-fields.php',
        'class'      =>  'has-dependent-fields has-select has-validation has-captcha has-checkbox',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-tree'
    ),
    array(
        'title'      =>  'Send customized Emails',
        'desc'       =>  'Contact form with styled emails',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/email-styles.php',
        'class'      =>  'contact-form has-select has-captcha has-checkbox has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-mail-read'
    ),
    array(
        'title'      =>  'File Upload Test Form',
        'desc'       =>  '3 File upload forms for files|images|images + captions',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/fileupload-test-form.php',
        'class'      =>  'has-file-upload',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-upload'
    ),
    array(
        'title'      =>  'Values from database',
        'desc'       =>  'Retrieve default values from database',
        'desc-class' =>  '',
        'link'       =>  '/default-db-values-form.php',
        'class'      =>  'prefilled-form has-checkbox has-select has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-database'
    ),
    array(
        'title'      =>  'Dynamic fields Form 1',
        'desc'       =>  'Horizontal form with dynalic fields',
        'desc-class' =>  '',
        'link'       =>  '/dynamic-fields-form-1.php',
        'class'      =>  'dynamic-fields ajax has-select has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-dynamic'
    ),
    array(
        'title'      =>  'Dynamic fields Form 2',
        'desc'       =>  'Horizontal form with dynalic fields',
        'desc-class' =>  '',
        'link'       =>  '/dynamic-fields-form-2.php',
        'class'      =>  'dynamic-fields ajax has-select has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-spinner4'
    ),
    array(
        'title'      =>  'Employment Application Form',
        'desc'       =>  'Horizontal form with Image upload',
        'desc-class' =>  '',
        'link'       =>  '/employment-application-form.php',
        'class'      =>  'has-file-upload has-checkbox has-select has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-profile'
    ),
    array(
        'title'      =>  'Image Picker Form',
        'desc'       =>  'Replace Select Element with Image Picker',
        'desc-class' =>  '',
        'link'       =>  '/image-picker-form.php',
        'class'      =>  'has-select has-image-picker',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-images'
    ),
    array(
        'title'      =>  'Input with Addons',
        'desc'       =>  'Input &amp; Select with Icon, Button &amp; Text addons',
        'desc-class' =>  '',
        'link'       =>  '/input-with-addons.php',
        'class'      =>  'has-select has-picker has-select',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap'),
        'icon'       =>  'icon-glass'
    ),
    array(
        'title'      =>  'License agreement form',
        'desc'       =>  'License agreement form with signature pad',
        'desc-class' =>  '',
        'link'       =>  '/license-agreement.php',
        'class'      =>  'license-form has-signature',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-pencil2'
    ),
    array(
        'title'      =>  'Join Us Form',
        'desc'       =>  'Horizontal<br>suscribe form',
        'desc-class' =>  '',
        'link'       =>  '/join-us-form.php',
        'class'      =>  'sign-in has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-user-plus'
    ),
    array(
        'title'      =>  'Join Us Form Modal',
        'desc'       =>  'Horizontal suscribe Modal form',
        'desc-class' =>  '',
        'link'       =>  '/join-us-form-modal.php',
        'class'      =>  'modal-form sign-in has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-user-plus'
    ),
    array(
        'title'      =>  'Join Us Form Popover',
        'desc'       =>  'Horizontal suscribe Popover form',
        'desc-class' =>  '',
        'link'       =>  '/join-us-form-popover.php',
        'class'      =>  'sign-in has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-user-plus'
    ),
    array(
        'title'      =>  'Newsletter Suscribe Form',
        'desc'       =>  'Horizontal Newsletter suscribe form',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/newsletter-suscribe-form.php',
        'class'      =>  'sign-in has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-newspaper'
    ),
    array(
        'title'      =>  'Order Form',
        'desc'       =>  'Order Form with Payment Method<br>&amp Country select',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/order-form.php',
        'class'      =>  'order-rental has-dependent-fields has-country-select has-checkbox has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-cart'
    ),
    array(
        'title'      =>  'Booking Form',
        'desc'       =>  'Booking Form date &amp; time pickers, icon select list',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/booking-form.php',
        'class'      =>  'reservation-booking has-dependent-fields has-picker has-select  has-intl-tel-input has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-food'
    ),
    array(
        'title'      =>  'Room Booking Form',
        'desc'       =>  'Booking Form<br>Date Picker,<br>Rich Text Editor',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/room-booking-form.php',
        'class'      =>  'reservation-booking has-tinymce has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-bed'
    ),
    array(
        'title'      =>  'Search Form',
        'desc'       =>  'Search Form with 2 Autocomplete - 2<sup>nd</sup> with ajax search',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/search-form.php',
        'class'      =>  'search has-autocomplete ajax',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-search'
    ),
    array(
        'title'      =>  'Sign Up Form',
        'desc'       =>  'Vertical Form<br>password generator &amp; validation',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/sign-up-form.php',
        'class'      =>  'sign-in has-password has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-key'
    ),
    array(
        'title'      =>  'Sign Up Form Modal',
        'desc'       =>  'Vertical Form Modal password generator',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/sign-up-form-modal.php',
        'class'      =>  'modal-form sign-in has-password has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-key'
    ),
    array(
        'title'      =>  'Sign Up Form Popover',
        'desc'       =>  'Vertical Form<br>password generator &amp; validation',
        'desc-class' =>  ' class="small"',
        'link'       =>  '/sign-up-form-popover.php',
        'class'      =>  'popover-form sign-in has-password has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-key'
    ),
    array(
        'title'      =>  'Simple Step Form',
        'desc'       =>  'Simple Step Form with step validation',
        'desc-class' =>  '',
        'link'       =>  '/simple-step-form.php',
        'class'      =>  'step has-checkbox has-select has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-rocket'
    ),
    array(
        'title'      =>  'Special Offer Sign Up',
        'desc'       =>  'Simple Vertical<br>Sign Up Form',
        'desc-class' =>  '',
        'link'       =>  '/special-offer-sign-up.php',
        'class'      =>  'sign-in has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-gift'
    ),
    array(
        'title'      =>  'Multiple modal forms on same page',
        'desc'       =>  'Multiple modal forms<br>on same page',
        'desc-class' =>  '',
        'link'       =>  '/multiple-modals.php',
        'class'      =>  'sign-in contact-form modal-form has-password has-captcha has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-stack'
    ),
    array(
        'title'      =>  'Multiple popover forms on same page',
        'desc'       =>  'Multiple popover forms<br>on same page',
        'desc-class' =>  '',
        'link'       =>  '/multiple-popovers.php',
        'class'      =>  'sign-in contact-form popover-form has-password has-captcha has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-stack'
    ),
    array(
        'title'      =>  'Post with Ajax Form',
        'desc'       =>  'Horizontal suscribe Popover form',
        'desc-class' =>  '',
        'link'       =>  '/post-with-ajax-form.php',
        'class'      =>  'ajax sign-in has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-newspaper '
    ),
    array(
        'title'      =>  'Date range picker examples',
        'desc'       =>  'Date range picker examples',
        'desc-class' =>  '',
        'link'       =>  '/date-range-picker-form.php',
        'class'      =>  'has-picker',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-calendar'
    ),
    array(
        'title'      =>  'jQuery validation examples',
        'desc'       =>  'jQuery validation examples',
        'desc-class' =>  '',
        'link'       =>  '/validation-with-jquery-example-form.php',
        'class'      =>  'has-validation',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-check-square-o'
    ),
    array(
        'title'      =>  'jQuery tooltip examples',
        'desc'       =>  'jQuery tooltip examples',
        'desc-class' =>  '',
        'link'       =>  '/tooltip-form.php',
        'class'      =>  'has-tooltip has-checkbox',
        'frameworks' =>  array('bootstrap3', 'bootstrap4', 'material', 'material-bootstrap', 'foundation'),
        'icon'       =>  'icon-comments'
    )
);

$list = '';
$forms = array();
$forms_base_props = array(
    array(
        'framework'  => 'bootstrap3',
        'class'      => 'bootstrap-3 active ' . $bs3_on . ' ',
        'link'       => 'bootstrap-3-forms',
        'card-class' => 'primary',
        'badge-text' => 'Bootstrap 3'
    ),
    array(
        'framework'  => 'bootstrap4',
        'class'      => 'bootstrap-4 active ' . $bs4_on . ' ',
        'link'       => 'bootstrap-4-forms',
        'card-class' => 'indigo',
        'badge-text' => 'Bootstrap 4'
    ),
    array(
        'framework'  => 'material',
        'class'      => 'material active ' . $material_on . ' ',
        'link'       => 'material-forms',
        'card-class' => 'success',
        'badge-text' => 'Material'
    ),
    array(
        'framework'  => 'material-bootstrap',
        'class'      => 'material-bootstrap active ' . $material_bootstrap_on . ' ',
        'link'       => 'material-bootstrap-forms',
        'card-class' => 'pink',
        'badge-text' => 'Material<br>Bootstrap'
    ),
    array(
        'framework'  => 'foundation',
        'class'      => 'foundation active ' . $foundation_on . ' ',
        'link'       => 'foundation-forms',
        'card-class' => 'info',
        'badge-text' => 'Foundation'
    )
);

foreach ($forms_base as $form) {
    foreach ($forms_base_props as $base_prop) {
        if (in_array($base_prop['framework'], $form['frameworks'])) {
            $list .= '<div class="col-12 col-sm-6 col-xl-4 grid-item ' . $base_prop['class'] . ' ' . $form['class'] . '">' . "\n";
            $list .= '  <div class="grid-item-content">';
            $list .= '      <a href="' . $base_prop['link'] . $form['link'] . '" class="card card-' . $base_prop['card-class'] . ' ' . $form['icon'] . ' has-icon" target="_blank">' . "\n";
            $list .= '          <p class="item condensed m-0">' . $form['title'] . '<span class="badge badge-xs badge-' . $base_prop['card-class'] . ' ">' . $base_prop['badge-text'] . '</span></p>' . "\n";
            $list .= '      </a>' . "\n";
            $list .= '  </div>' . "\n";
            $list .= '</div>' . "\n";
        }
    }
}
include_once '../phpformbuilder/Form.php';
$toggle_templates = new Form('toggle-templates', 'vertical', '', 'material');
$toggle_templates->useLoadJs('core');
$toggle_templates->addPlugin('materialize', '#toggle-templates');
/*
bootstrap 3
bootstrap 4
material
material bootstrap
foundation

accordion
ajax
contact-form
modal-form
order-rental
popover-form
prefilled-form
reservation-booking
search
sign-in
step
survey

has-autocomplete
has-captcha
has-checkbox
has-country-select
has-dependent-fields
has-file-upload
has-image-picker
has-password
has-picker
has-select
has-signature
has-tinymce
has-tooltip
has-validation
 */

$toggle_templates->startFieldset('Frameworks');
$toggle_templates->addRadio('templates-framework', 'Bootstrap 3', 'bootstrap-3', $bs3_checked);
$toggle_templates->addRadio('templates-framework', 'Bootstrap 4', 'bootstrap-4', $bs4_checked);
$toggle_templates->addRadio('templates-framework', 'Material Design', 'material', $material_checked);
$toggle_templates->addRadio('templates-framework', 'Material Bootstrap', 'material-bootstrap', $material_bootstrap_checked);
$toggle_templates->addRadio('templates-framework', 'Foundation', 'foundation', $foundation_checked);
$toggle_templates->printRadioGroup('templates-framework', '', false);
$toggle_templates->endFieldset();
$toggle_templates->startFieldset('Forms');
$toggle_templates->addCheckbox('templates-chk', 'Accordion', 'accordion', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Ajax', 'ajax', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Contact', 'contact-form', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Dynamic Fields', 'dynamic-fields', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Loaded with Loadjs', 'loadjs', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'License agreement', 'license-form', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Modal', 'modal-form', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Order / Rental', 'order-rental', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Prefilled from Db', 'prefilled-form', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Popover', 'popover-form', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Reservation / Booking', 'reservation-booking', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Search Form', 'search', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Sign-in', 'sign-in', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Step Form', 'step', 'checked=checked');
$toggle_templates->addCheckbox('templates-chk', 'Survey', 'survey', 'checked=checked');
$toggle_templates->printCheckboxGroup('templates-chk', '', false);
$toggle_templates->endFieldset();
$toggle_templates->startFieldset('Plugins');
$toggle_templates->addCheckbox('plugins-chk', 'Autocomplete', 'has-autocomplete', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Captcha', 'has-captcha', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Checkbox &amp; radio buttons', 'has-checkbox', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Country Select', 'has-country-select', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Dependent Fields', 'has-dependent-fields', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'File Upload', 'has-file-upload', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Image Picker', 'has-image-picker', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Intl Tel Input', 'has-intl-tel-input', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Password', 'has-password', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Pickers', 'has-picker', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Select', 'has-select', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Signature pad', 'has-signature', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Text editor (tinyMce)', 'has-tinymce', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Tooltip', 'has-tooltip', 'checked=checked');
$toggle_templates->addCheckbox('plugins-chk', 'Validation', 'has-validation', 'checked=checked');
$toggle_templates->printCheckboxGroup('plugins-chk', '', false);
$toggle_templates->endFieldset();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 3/4, Material Design and Foundation Form Templates</title>
    <meta name="description" content="Php Form Builder - Bootstrap 3, Bootstrap 4, Material Design, Material Bootstrap and Foundation Template Forms with source code">
    <meta name="author" content="Gilles Migliori">
    <meta name="copyright" content="Gilles Migliori">
    <?php
    if ($_SERVER['HTTP_HOST'] === 'www.phpformbuilder.pro') {
        ?>
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/index.php" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <?php
    } else {
        ?>
    <meta name="robots" content="noindex, nofollow">
        <?php
    } // end if
    ?>
    <style type="text/css">
        @charset "UTF-8";@-ms-viewport{width:device-width}@font-face{font-family:icomoon;src:url(../documentation/assets/fonts/icomoon.eot?rnh868);src:url(../documentation/assets/fonts/icomoon.eot?rnh868#iefix) format("embedded-opentype"),url(../documentation/assets/fonts/icomoon.ttf?rnh868) format("truetype"),url(../documentation/assets/fonts/icomoon.woff?rnh868) format("woff"),url(../documentation/assets/fonts/icomoon.svg?rnh868#icomoon) format("svg");font-weight:400;font-style:normal}@font-face{font-family:Roboto;font-style:normal;font-weight:300;src:local("Roboto Light"),local("Roboto-Light"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-300.woff) format("woff")}@font-face{font-family:Roboto;font-style:normal;font-weight:400;src:local("Roboto"),local("Roboto-Regular"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-regular.woff) format("woff")}@font-face{font-family:Roboto;font-style:normal;font-weight:500;src:local("Roboto Medium"),local("Roboto-Medium"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-v18-latin-500.woff) format("woff")}@font-face{font-family:'Roboto Condensed';font-style:normal;font-weight:400;src:local("Roboto Condensed"),local("RobotoCondensed-Regular"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff2) format("woff2"),url(../documentation/assets/fonts/roboto-condensed-v16-latin-regular.woff) format("woff")}.mb-2{margin-bottom:.5rem!important}.text-center{text-align:center!important}.dmca-badge{min-height:100px}*,::after,::before{-webkit-box-sizing:border-box;box-sizing:border-box}html{font-family:sans-serif;line-height:1.15;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;-ms-overflow-style:scrollbar;-webkit-tap-highlight-color:transparent}nav{display:block}body{margin:0;font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";font-size:15px;font-weight:400;line-height:1.5;color:#2a2d2d;text-align:left;background-color:#fff}h1{margin-top:0;margin-bottom:.5rem}p{margin-top:0;margin-bottom:1rem}ul{margin-top:0;margin-bottom:1rem}small{font-size:80%}a{color:#007bff;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects}img{vertical-align:middle;border-style:none}label{display:inline-block;margin-bottom:.5rem}button{border-radius:0}button,input{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button,input{overflow:visible}button{text-transform:none}button{-webkit-appearance:button}button::-moz-focus-inner{padding:0;border-style:none}input[type=checkbox],input[type=radio]{-webkit-box-sizing:border-box;box-sizing:border-box;padding:0}fieldset{min-width:0;padding:0;margin:0;border:0}legend{display:block;width:100%;max-width:100%;padding:0;margin-bottom:.5rem;font-size:1.5rem;line-height:inherit;color:inherit;white-space:normal}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}.h3,h1{margin-bottom:.5rem;font-family:inherit;font-weight:500;line-height:1.2;color:inherit}h1{font-size:40px}.h3{font-size:26.25px}small{font-size:80%;font-weight:400}.container-fluid{width:100%;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.row{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px}.col,.col-12,.col-sm-6,.col-xl-4{position:relative;width:100%;min-height:1px;padding-right:15px;padding-left:15px}.col{-ms-flex-preferred-size:0;flex-basis:0;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;max-width:100%}.col-12{-webkit-box-flex:0;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}@media (min-width:576px){.col-sm-6{-webkit-box-flex:0;-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}}@media (min-width:1200px){.col-xl-4{-webkit-box-flex:0;-ms-flex:0 0 33.33333%;flex:0 0 33.33333%;max-width:33.33333%}}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:15px;line-height:1.5;border-radius:.25rem;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;-o-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out}@media screen and (prefers-reduced-motion:reduce){.btn{-webkit-transition:none;-o-transition:none;transition:none}}.btn:not(:disabled):not(.disabled){cursor:pointer}.btn-success{color:#fff;background-color:#0f9e7b;border-color:#0f9e7b;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 1px rgba(0,0,0,.075)}.btn-block{display:block;width:100%}.collapse:not(.show){display:none}.nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;padding-left:0;margin-bottom:0;list-style:none}.nav-link{display:block;padding:.5rem 1rem}.navbar{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem}.navbar>.container-fluid{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}.navbar-brand{display:inline-block;padding-top:0;padding-bottom:0;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap}.navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none}.navbar-nav .nav-link{padding-right:0;padding-left:0}.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem}.navbar-toggler:not(:disabled):not(.disabled){cursor:pointer}.navbar-toggler-icon{display:inline-block;width:1.5em;height:1.5em;vertical-align:middle;content:"";background:center center no-repeat;background-size:100% 100%}@media (min-width:992px){.navbar-expand-lg{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-flow:row nowrap;flex-flow:row nowrap;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start}.navbar-expand-lg .navbar-nav{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}.navbar-expand-lg .navbar-nav .nav-link{padding-right:1rem;padding-left:1rem}.navbar-expand-lg>.container-fluid{-ms-flex-wrap:nowrap;flex-wrap:nowrap}.navbar-expand-lg .navbar-collapse{display:-webkit-box!important;display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto}.navbar-expand-lg .navbar-toggler{display:none}}.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1)}.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.navbar-dark .navbar-brand{color:#fff}.navbar-dark .navbar-nav .nav-link{color:rgba(255,255,255,.5)}.navbar-dark .navbar-nav .nav-link.active{color:#fff}.navbar-dark .navbar-toggler{color:rgba(255,255,255,.5);border-color:rgba(255,255,255,.1)}.navbar-dark .navbar-toggler-icon{background-image:url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E")}.card{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;min-width:0;word-wrap:break-word;background-color:#fff;background-clip:border-box;border:1px solid rgba(0,0,0,.125);border-radius:.25rem}.badge{display:inline-block;padding:.15em .5em;font-size:75%;font-weight:500;line-height:1;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.2rem}.badge-primary{color:#fff;background-color:#0e73cc}.badge-success{color:#fff;background-color:#0f9e7b}.badge-info{color:#fff;background-color:#00c2db}.mb-4{margin-bottom:1.5rem!important}.bg-dark{background-color:#343a40!important}h1{color:#007bff!important}.bg-dark{background-color:#23211e!important}.d-inline-block{display:inline-block!important}.float-right{float:right!important}.fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}.shadow{-webkit-box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important;box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important}.m-0{margin:0!important}.mr-2{margin-right:.5rem!important}.my-3{margin-top:1rem!important}.mr-3{margin-right:1rem!important}.my-3{margin-bottom:1rem!important}.h3,.mb-4{margin-bottom:1.5rem!important}.px-0{padding-right:0!important}.px-0{padding-left:0!important}.p-2{padding:.5rem!important}.py-2{padding-top:.5rem!important}.py-2{padding-bottom:.5rem!important}.px-3{padding-right:1rem!important}.px-3{padding-left:1rem!important}.p-4{padding:1.5rem!important}.pb-6{padding-bottom:6.25rem!important}.ml-auto{margin-left:auto!important}.text-white{color:#fff!important}h1{color:#0e73cc!important}#website-navbar{font-family:'Roboto Condensed';-webkit-box-shadow:0 .5rem 1rem rgba(0,0,0,.15);box-shadow:0 .5rem 1rem rgba(0,0,0,.15)}#website-navbar .navbar-nav{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:nowrap;flex-wrap:nowrap;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;width:100%;margin-top:1rem}#website-navbar .navbar-nav .nav-item{line-height:1.25rem;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:stretch;-ms-flex-align:stretch;align-items:stretch;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1}#website-navbar .navbar-nav .nav-link{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;text-align:center;text-transform:uppercase;font-size:.875rem;padding-left:1rem;padding-right:1rem;padding-top:.5rem;padding-bottom:.5rem}#website-navbar .navbar-nav .nav-link.active{text-decoration:none;background-color:#46423b}@media (min-width:992px){.d-lg-none{display:none!important}#website-navbar{-webkit-box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24);box-shadow:0 2px 1px rgba(0,0,0,.12),0 1px 1px rgba(0,0,0,.24)}#website-navbar .navbar-nav{margin-top:0}#website-navbar .navbar-nav .nav-link{font-size:.8125rem;padding-left:.75rem;padding-right:.75rem;height:100%}#website-navbar .navbar-brand{margin-bottom:0;font-size:1.0625rem}}#navbar-left-wrapper{display:none;position:fixed;top:72px;padding-right:0;width:230px;height:100%;background-color:#23211e;z-index:2;-webkit-box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24);box-shadow:2px 0 1px rgba(0,0,0,.12),1px 0 1px rgba(0,0,0,.24)}#navbar-left-wrapper #navbar-left-collapse{display:none}@media (min-width:992px){#navbar-left-wrapper{display:block}#navbar-left-wrapper~.container-fluid{padding-left:245px}}@media (max-width:991.98px){.navbar-expand-lg>.container-fluid{padding-right:0;padding-left:0}#navbar-left-wrapper #navbar-left-collapse{display:block}.w3-animate-left{position:relative;-webkit-animation:.4s animateleft;animation:.4s animateleft}@-webkit-keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}@keyframes animateleft{from{left:-230px;opacity:0}to{left:0;opacity:1}}}.grid .card{display:block;position:relative;margin:0 0 2rem;-webkit-transition:-webkit-box-shadow .25s;transition:-webkit-box-shadow .25s;-o-transition:box-shadow .25s;transition:box-shadow .25s;transition:box-shadow .25s,-webkit-box-shadow .25s;border-radius:2px;padding:20px;display:block;color:#38352f;min-height:60px;-webkit-box-shadow:0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);box-shadow:0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12)}.grid .card .badge{position:absolute;right:20px;font-size:12px;top:50%;margin-top:-9px}.grid .card.card-indigo{background-color:#3f51b5}.grid .card.card-indigo .badge{background:#2b387c}.grid .card.card-pink{background-color:#e91e63}.grid .card.card-pink .badge{background:#aa1145}.grid .card.card-info{background-color:#00c2db}.grid .card.card-info .badge{background:#007e8f}.grid .card.card-primary{background-color:#0e73cc}.grid .card.card-primary .badge{background:#094b84}.grid .card.card-success{background-color:#0f9e7b}.grid .card.card-success .badge{background:#085845}.grid .card .item{color:#fff;font-size:1.0625rem}.grid .card.has-icon{padding-left:85px;padding-right:95px}.grid .card.has-icon:before{font-family:icomoon;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;font-size:1.75rem;color:#fff;border-radius:.25rem 0 0 .25rem;width:54px;height:100%}.grid .card.has-icon:after{content:' ';position:absolute;top:calc(50% - 6px);left:54px;width:0;height:0;border-style:solid;border-width:6px 0 6px 6px}.grid .card.has-icon.card-indigo:before{text-shadow:1px 1px 3px #171e44;background:#2b387c}.grid .card.has-icon.card-indigo:after{border-color:transparent transparent transparent #2b387c}.grid .card.has-icon.card-pink:before{text-shadow:1px 1px 3px #640a29;background:#aa1145}.grid .card.has-icon.card-pink:after{border-color:transparent transparent transparent #aa1145}.grid .card.has-icon.card-info:before{text-shadow:1px 1px 3px #003a42;background:#007e8f}.grid .card.has-icon.card-info:after{border-color:transparent transparent transparent #007e8f}.grid .card.has-icon.card-primary:before{text-shadow:1px 1px 3px #04223d;background:#094b84}.grid .card.has-icon.card-primary:after{border-color:transparent transparent transparent #094b84}.grid .card.has-icon.card-success:before{text-shadow:1px 1px 3px #02120e;background:#085845}.grid .card.has-icon.card-success:after{border-color:transparent transparent transparent #085845}[class*=' icon-'],[class^=icon-]{font-family:icomoon;speak:none;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:1;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.icon-mail:before{content:'\f03b'}.icon-address-book:before{content:'\e944'}.icon-checkbox-unchecked:before{content:'\ea53'}.has-icon{position:relative}.has-icon:before{position:absolute;top:0;left:0;display:inline-block;width:50px;height:100%;border-radius:3px 0 0 3px;background-repeat:no-repeat;background-position:center center}html{position:relative;min-height:100%}body{counter-reset:section}.h3,h1{font-family:Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}h1{line-height:.9;margin-bottom:2.5rem;font-weight:400}h1::first-letter{font-size:2em;font-weight:500}h1 small{font-size:1.3125rem;font-weight:300;line-height:1;margin-left:.75rem}.h3{font-weight:300;color:#a9a398}.h3{font-variant:small-caps}#filter-forms#filter-forms legend{color:#fff;font-variant:small-caps;font-weight:300;border-bottom:1px solid #c6c2bb;margin-bottom:.5rem}#filter-forms#filter-forms .material-form [type=checkbox]+span:not(.lever),#filter-forms#filter-forms .material-form [type=radio]:checked+span,#filter-forms#filter-forms .material-form [type=radio]:not(:checked)+span{font-size:.875rem}#filter-forms#filter-forms label{font-weight:300;margin-bottom:0}#filter-forms#filter-forms label [type=checkbox]:checked+span,#filter-forms#filter-forms label [type=radio]:checked+span{color:rgba(255,255,255,.9)}.badge:not(.badge-circle){border-radius:0}.condensed{font-family:'Roboto Condensed'}.material-form .row{display:block}html{box-sizing:border-box}*,:after,:before{box-sizing:inherit}.material-form input{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif}.material-form .row{margin-left:auto;margin-right:auto;margin-bottom:20px}.material-form .row:after{content:"";display:table;clear:both}.material-form .row .col{float:left;box-sizing:border-box;padding:0 .75rem;min-height:1px}.material-form .row .col.s12{width:100%;margin-left:auto;left:auto;right:auto}.material-form label{font-size:.8rem;color:#9e9e9e}.material-form ::-webkit-input-placeholder{color:#d1d1d1}.material-form :-ms-input-placeholder,.material-form ::-ms-input-placeholder{color:#d1d1d1}.material-form .input-field{position:relative;margin-top:1rem;margin-bottom:1rem}.material-form .input-field.col label{left:.75rem}.material-form [type=radio]:checked,.material-form [type=radio]:not(:checked){position:absolute;opacity:0;pointer-events:none}.material-form [type=radio]:checked+span,.material-form [type=radio]:not(:checked)+span{position:relative;padding-left:35px;cursor:pointer;display:inline-block;height:25px;line-height:25px;font-size:1rem;transition:.28s;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.material-form [type=radio]+span:after,.material-form [type=radio]+span:before{content:"";position:absolute;left:0;top:0;margin:4px;width:16px;height:16px;z-index:0;transition:.28s}.material-form [type=radio].with-gap:checked+span:after,.material-form [type=radio].with-gap:checked+span:before,.material-form [type=radio]:checked+span:after,.material-form [type=radio]:checked+span:before,.material-form [type=radio]:not(:checked)+span:after,.material-form [type=radio]:not(:checked)+span:before{border-radius:50%}.material-form [type=radio]:not(:checked)+span:after,.material-form [type=radio]:not(:checked)+span:before{border:2px solid #5a5a5a}.material-form [type=radio]:not(:checked)+span:after{transform:scale(0)}.material-form [type=radio]:checked+span:before{border:2px solid transparent}.material-form [type=radio].with-gap:checked+span:after,.material-form [type=radio].with-gap:checked+span:before,.material-form [type=radio]:checked+span:after{border:2px solid #26a69a}.material-form [type=radio].with-gap:checked+span:after,.material-form [type=radio]:checked+span:after{background-color:#26a69a}.material-form [type=radio]:checked+span:after{transform:scale(1.02)}.material-form [type=radio].with-gap:checked+span:after{transform:scale(.5)}.material-form [type=checkbox]:checked{position:absolute;opacity:0;pointer-events:none}.material-form [type=checkbox]+span:not(.lever){position:relative;padding-left:35px;cursor:pointer;display:inline-block;height:25px;line-height:25px;font-size:1rem;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.material-form [type=checkbox]+span:not(.lever):before,.material-form [type=checkbox]:not(.filled-in)+span:not(.lever):after{content:"";position:absolute;top:0;left:0;width:18px;height:18px;z-index:0;border:2px solid #5a5a5a;border-radius:1px;margin-top:3px;transition:.2s}.material-form [type=checkbox]:not(.filled-in)+span:not(.lever):after{border:0;transform:scale(0)}.material-form [type=checkbox]:checked+span:not(.lever):before{top:-4px;left:-5px;width:12px;height:22px;border-top:2px solid transparent;border-left:2px solid transparent;border-right:2px solid #26a69a;border-bottom:2px solid #26a69a;transform:rotate(40deg);-webkit-backface-visibility:hidden;backface-visibility:hidden;transform-origin:100% 100%}
    </style>
    <?php require_once '../documentation/inc/css-includes.php'; ?>
    <?php $toggle_templates->printIncludes('css'); ?>
</head>
<body style="padding-top:76px;" data-spy="scroll" data-target="#navbar-left-wrapper" data-offset="180">

    <!-- Main navbar -->

    <!--LSHIDE-->

    <nav id="website-navbar" class="navbar navbar-dark bg-dark navbar-expand-lg fixed-top">
        <div class="container-fluid px-0">
            <a class="navbar-brand mr-3" href="../index.html"><img src="https://www.phpformbuilder.pro/documentation/assets/images/phpformbuilder-logo.png" width="60" height="60" class="mr-3" alt="PHP Form Builder" title="PHP Form Builder">PHP Form Builder</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">

                    <!-- https://www.phpformbuilder.pro navbar -->

                    <li class="nav-item" role="presentation"><a class="nav-link" href="../index.html">Home</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../drag-n-drop-form-builder/index.html">Drag &amp; drop Form Builder</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../documentation/quick-start-guide.php">Quick Start Guide</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="index.php">Form Templates</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../documentation/jquery-plugins.php">jQuery Plugins</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../documentation/code-samples.php">Code Samples</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../documentation/class-doc.php">Class Doc.</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../documentation/functions-reference.php">Functions Reference</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="../documentation/help-center.php">Help Center</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!--/LSHIDE-->

    <!-- Main sidebar -->
    <div class="navbar-light p-2 d-lg-none d-xlg-none">
        <button id="navbar-left-toggler" class="navbar-toggler"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
    </div>
    <div id="navbar-left-wrapper" class="w3-animate-left pb-6">
        <a href="#" id="navbar-left-collapse" class="d-inline-block d-lg-none d-xlg-none float-right text-white p-4"><i class="fas fa-times"></i></a>
        <div id="filter-forms" class="px-3 py-2">
            <p class="h3 my-3">filter form list</p>
            <a href="#" id="toggle-all-forms" class="btn btn-success btn-block shadow btn-toggle mb-4"><span class="icon-checkbox-unchecked mr-2"></span>Toggle All</a>
            <?php $toggle_templates->render(); ?>
        </div>
        <div class="text-center mb-2"><a href="//www.dmca.com/Protection/Status.aspx?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" title="DMCA.com Protection Status" class="dmca-badge"> <img src="//images.dmca.com/Badges/dmca-badge-w100-1x1-01.png?ID=93cc7d61-a9d4-4474-a327-a29620d661fb" alt="DMCA.com Protection Status"></a> <script defer src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script></div>
        <div class="text-center">
            <a href="https://www.hack-hunt.com" title="Send DMCA Takedown Notice" class="text-white">www.hack-hunt.com</a>
        </div>
        <!-- navbar-left -->
    </div>
    <!-- /main sidebar -->

    <div class="container-fluid">
        <div class="d-lg-flex align-items-center">
            <h1>Forms Templates</h1>
            <p class="h3 ml-2 mt-lg-3"> - Use left nav checkboxes to filter list</p>
        </div>
        <div class="grid row" id="grid-forms">
            <?php echo $list; ?>
        </div>
    </div>
    <?php require_once '../documentation/inc/js-includes.php'; ?>
    <?php $toggle_templates->printIncludes('js'); ?>

    <script type="text/javascript">
        loadjs([
            'assets/js/isotope.pkgd.min.js'
            ], 'isotope',
            {
                async: false
            }
        );
        loadjs.ready(['core', 'isotope'], function() {
            /* jshint jquery: true, browser: true */
            'use strict';

            var gridForms = $('#navbar a[href="#grid-forms"]');

            // isotope
            $('#grid-forms').isotope({
              itemSelector: '.grid-item',
              layoutMode: 'masonry'
            });

            var updateToggleFormsBtn = function () {
                if ($('#grid-forms').find('.framework-on.active')[0]) {
                    $('#toggle-all-forms span').removeClass('icon-check-square-o').addClass('icon-checkbox-unchecked');
                } else {
                    $('#toggle-all-forms span').addClass('icon-check-square-o').removeClass('icon-checkbox-unchecked');
                }
            };

            var chooseHint = function () {
                if ($('#grid-forms').find('.framework-on.active')[0]) {
                    $('#grid-forms #choose-hint').remove();
                } else if(!$('#choose-hint')[0]) {
                    $('#grid-forms').prepend('<div id="choose-hint" class="card card-info icon-lifebuoy has-icon ml-3"><h4 class="text-white mb-0">Choose at least one Framework and one form/plugin</h4>');
                }
            };

            var filterFramework = function() {

                // remove unchecked framework(s)
                $('input[name="templates-framework"]').each(function() {
                    if(this.checked === true) {
                        $('#grid-forms').find('.' + $(this).val()).addClass('framework-on');
                    } else {
                        $('#grid-forms').find('.' + $(this).val()).removeClass('framework-on');
                    }
                });

                // store user's preference
                $.ajax({
                    url: 'assets/ajax-prefered-framework.php',
                    type: 'GET',
                    data: {
                        'framework': $('input[name="templates-framework"]:checked').val()
                    }
                }).done(function(data) {
                }).fail(function(data, statut, error) {
                    console.log(error);
                });
            };

            // Filter all
            $('#toggle-all-forms').on('click', function (e) {
                e.preventDefault();
                if ($('#grid-forms').find('.active')[0]) {
                    $('#filter-forms .checkbox input').prop('checked', false);
                    $(this).removeClass('btn-success').addClass('btn-danger');
                } else {
                    $('#filter-forms .checkbox input').prop('checked', true);
                    $(this).removeClass('btn-danger').addClass('btn-success');
                }
                $('#filter-forms input').trigger('change');
                updateToggleFormsBtn();
                chooseHint();
            });

            // filter by template/plugin
            $('#filter-forms input:not([name="templates-framework"])').on('change', function () {
                if (this.checked) {
                    $('#grid-forms').find('.' + $(this).val()).addClass('active');
                } else {
                    $('#grid-forms').find('.' + $(this).val()).removeClass('active');
                }

                $('#grid-forms').isotope({filter: '.grid-item.framework-on.active'});
                updateToggleFormsBtn();
                chooseHint();
            });

            // filter by framework
            $('#filter-forms input[name="templates-framework"]').on('change', function () {
                filterFramework();
                $('#grid-forms').isotope({filter: '.grid-item.framework-on.active'});
                updateToggleFormsBtn();
                chooseHint();
            });

            $('#templates-framework_0').trigger('change');
        });
    </script>
</body>
</html>
