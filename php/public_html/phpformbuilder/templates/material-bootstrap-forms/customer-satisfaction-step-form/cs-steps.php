<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

$current_step = 1; // default if nothing posted

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['back_to_step']) && is_numeric($_POST['back_to_step'])) {
        $current_step = $_POST['back_to_step'];
    } elseif (isset($_POST['cs-step-1']) && Form::testToken('cs-step-1') === true) {
        /* Validate step 1 */

        // create validator & auto-validate required fields
        $validator = Form::validate('cs-step-1');
        if ($validator->hasErrors()) {
            $current_step = 1;
            $_SESSION['errors']['cs-step-1'] = $validator->getAllErrors();
        } else { // register posted values and go to next step
            Form::registerValues('cs-step-1');
            $current_step = 2;
        }
    } elseif (isset($_POST['cs-step-2']) && Form::testToken('cs-step-2') === true) {
        /* Validate step 2 */

        // create validator & auto-validate required fields
        $validator = Form::validate('cs-step-2');
        if ($validator->hasErrors()) {
            $current_step = 2;
            $_SESSION['errors']['cs-step-2'] = $validator->getAllErrors();
        } else { // register posted values and go to next step
            Form::registerValues('cs-step-2');
            $current_step = 3;
        }
    } elseif (isset($_POST['cs-step-3']) && Form::testToken('cs-step-3') === true) {
        /* Validate step 3 */

        // create validator & auto-validate required fields
        $validator = Form::validate('cs-step-3');
        if ($validator->hasErrors()) {
            $current_step = 3;
            $_SESSION['errors']['cs-step-3'] = $validator->getAllErrors();
        } else { // register posted values and go to next step
            Form::registerValues('cs-step-3');
            $current_step = 4;
        }
    } elseif (isset($_POST['cs-step-4']) && Form::testToken('cs-step-4') === true) {
        /* Validate step 4 */

        // create validator & auto-validate required fields
        $validator = Form::validate('cs-step-4');
        if ($validator->hasErrors()) {
            $current_step = 4;
            $_SESSION['errors']['cs-step-4'] = $validator->getAllErrors();
        } else { // register posted values and go to next step
            Form::registerValues('cs-step-4');
            $current_step = 5;
        }
    } elseif (isset($_POST['cs-step-5']) && Form::testToken('cs-step-5') === true) {
        /* Validate step 5 */

        // create validator & auto-validate required fields
        $validator = Form::validate('cs-step-5');
        if ($validator->hasErrors()) {
            $current_step = 5;
            $_SESSION['errors']['cs-step-5'] = $validator->getAllErrors();
        } else { // SEND ALL
            Form::registerValues('cs-step-5');
            $current_step = 1;

            $values = Form::mergeValues(array('cs-step-1', 'cs-step-2', 'cs-step-3', 'cs-step-4', 'cs-step-5'));
            $email_config = array(
                'sender_email'    => 'contact@phpformbuilder.pro',
                'sender_name'     => 'Php Form Builder',
                'recipient_email' => 'gilles.migliori@gmail.com',
                'subject'         => 'Php Form Builder - Step Customer Satisfaction Slide Form',
                'filter_values'   => 'cs-step-1, cs-step-2, cs-step-3, cs-step-4, cs-step-5',
                'values'          => $values
            );
            $sent_message = Form::sendMail($email_config);
            Form::clear('cs-step-1');
            Form::clear('cs-step-2');
            Form::clear('cs-step-3');
            Form::clear('cs-step-4');
            Form::clear('cs-step-5');
        }
    }
}
if ($current_step == 1) {
    /* ==================================================
        Step 1
    ================================================== */

    $form_id = 'cs-step-1';

    $form = new Form('cs-step-1', 'horizontal', 'novalidate', 'material');
    // $form->setMode('development');

    // materialize plugin
    $form->addPlugin('materialize', '#cs-step-1');

    $form->addRadio('satisfied-with-company', 'Very Satisfied', 'Very Satisfied');
    $form->addRadio('satisfied-with-company', 'Somewhat satisfied', 'Somewhat satisfied');
    $form->addRadio('satisfied-with-company', 'Neither satisfied nor dissatisfied', 'Neither satisfied nor dissatisfied', 'checked=checked');
    $form->addRadio('satisfied-with-company', 'Somewhat dissatisfied', 'Somewhat dissatisfied');
    $form->addRadio('satisfied-with-company', 'Very dissatisfied', 'Very dissatisfied');
    $form->printRadioGroup('satisfied-with-company', 'Overall, how satisfied or dissatisfied are you with our company ?', false, 'required');
    $form->addOption('words-to-describe-our-products[]', 'Reliable', 'Reliable');
    $form->addOption('words-to-describe-our-products[]', 'High quality', 'High quality');
    $form->addOption('words-to-describe-our-products[]', 'Useful', 'Useful');
    $form->addOption('words-to-describe-our-products[]', 'Unique', 'Unique');
    $form->addOption('words-to-describe-our-products[]', 'Good value for money', 'Good value for money');
    $form->addOption('words-to-describe-our-products[]', 'Overpriced', 'Overpriced');
    $form->addOption('words-to-describe-our-products[]', 'Impractical', 'Impractical');
    $form->addOption('words-to-describe-our-products[]', 'Ineffective', 'Ineffective');
    $form->addOption('words-to-describe-our-products[]', 'Poor quality', 'Poor quality');
    $form->addOption('words-to-describe-our-products[]', 'Unreliable', 'Unreliable');
    $form->addSelect('words-to-describe-our-products[]', 'Which of the following words would you use to describe our products ?', 'multiple, required');
    $form->addBtn('submit', 'submit-btn', 1, 'Next <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i>', 'class=btn btn-sm btn-success ladda-button, data-style=zoom-in');
    if (isset($sent_message)) {
        echo $sent_message;
    }
} elseif ($current_step == 2) {
    /* ==================================================
        Step 2
    ================================================== */

    $form_id = 'cs-step-2';
    $previous_form = new Form('cs-step-1');

    $form = new Form('cs-step-2', 'horizontal', 'novalidate', 'material');
    // $form->setMode('development');

    // materialize plugin
    $form->addPlugin('materialize', '#cs-step-2');

    $form->addOption('how-well-do-our-products-meet-your-needs[]', 'Extremely well', 'Extremely well');
    $form->addOption('how-well-do-our-products-meet-your-needs[]', 'Very well', 'Very well');
    $form->addOption('how-well-do-our-products-meet-your-needs[]', 'Somewhat well', 'Somewhat well');
    $form->addOption('how-well-do-our-products-meet-your-needs[]', 'Not so well', 'Not so well');
    $form->addOption('how-well-do-our-products-meet-your-needs[]', 'Not at all well', 'Not at all well');
    $form->addSelect('how-well-do-our-products-meet-your-needs[]', 'How well do our products meet your needs ?', 'multiple, required');
    $form->addRadio('rate-the-quality-of-our-products', 'Very high quality', 'Very high quality');
    $form->addRadio('rate-the-quality-of-our-products', 'High quality', 'High quality');
    $form->addRadio('rate-the-quality-of-our-products', 'Neither high nor low quality', 'Neither high nor low quality', 'checked=checked');
    $form->addRadio('rate-the-quality-of-our-products', 'Low quality', 'Low quality');
    $form->addRadio('rate-the-quality-of-our-products', 'Very low quality', 'Very low quality');
    $form->printRadioGroup('rate-the-quality-of-our-products', 'How would you rate the quality of our products ?', false, 'required');
    $form->addBtn('button', 'back-btn', 2, '<i class="fa fa-arrow-circle-o-left mr-2" aria-hidden="true"></i> Back', 'class=btn btn-sm btn-warning', 'btns');
    $form->addBtn('submit', 'submit-btn', 2, 'Next <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i>', 'class=btn btn-sm btn-success ladda-button, data-style=zoom-in', 'btns');
    $form->printBtnGroup('btns');
} elseif ($current_step == 3) {
    /* ==================================================
        Step 3
    ================================================== */

    $form_id = 'cs-step-3';
    $previous_form = new Form('cs-step-2');

    $form = new Form('cs-step-3', 'horizontal', 'novalidate', 'material');
    // $form->setMode('development');

    // materialize plugin
    $form->addPlugin('materialize', '#cs-step-3');

    $form->addRadio('rate-the-value-for-money-of-our-products', 'Excellent', 'Excellent');
    $form->addRadio('rate-the-value-for-money-of-our-products', 'Above average', 'Above average');
    $form->addRadio('rate-the-value-for-money-of-our-products', 'Average', 'Average', 'checked=checked');
    $form->addRadio('rate-the-value-for-money-of-our-products', 'Below average', 'Below average');
    $form->addRadio('rate-the-value-for-money-of-our-products', 'Poor', 'Poor');
    $form->printRadioGroup('rate-the-value-for-money-of-our-products', 'How would you rate the value for money of our products ?', false, 'required');
    $form->addRadio('responsive-to-questions-about-our-products', 'Extremely responsive', 'Extremely responsive');
    $form->addRadio('responsive-to-questions-about-our-products', 'Very responsive', 'Very responsive');
    $form->addRadio('responsive-to-questions-about-our-products', 'Moderately responsive', 'Moderately responsive', 'checked=checked');
    $form->addRadio('responsive-to-questions-about-our-products', 'Not so responsive', 'Not so responsive');
    $form->addRadio('responsive-to-questions-about-our-products', 'Not at all responsive', 'Not at all responsive');
    $form->addRadio('responsive-to-questions-about-our-products', 'Not applicable', 'Not applicable');
    $form->printRadioGroup('responsive-to-questions-about-our-products', 'How responsive have we been to your questions or concerns about our products ?', false, 'required');
    $form->addBtn('button', 'back-btn', 3, '<i class="fa fa-arrow-circle-o-left mr-2" aria-hidden="true"></i> Back', 'class=btn btn-sm btn-warning', 'btns');
    $form->addBtn('submit', 'submit-btn', 3, 'Next <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i>', 'class=btn btn-sm btn-success ladda-button, data-style=zoom-in', 'btns');
    $form->printBtnGroup('btns');
} elseif ($current_step == 4) {
    /* ==================================================
        Step 4
    ================================================== */

    $form_id = 'cs-step-4';
    $previous_form = new Form('cs-step-3');

    $form = new Form('cs-step-4', 'horizontal', 'novalidate', 'material');
    // $form->setMode('development');

    // materialize plugin
    $form->addPlugin('materialize', '#cs-step-4');

    $form->addRadio('how-long-have-you-been-a-customer-of-our-company', 'This is my first purchase', 'This is my first purchase');
    $form->addRadio('how-long-have-you-been-a-customer-of-our-company', 'Less than six months', 'Less than six months');
    $form->addRadio('how-long-have-you-been-a-customer-of-our-company', 'Six months to a year', 'Six months to a year');
    $form->addRadio('how-long-have-you-been-a-customer-of-our-company', '1 - 2 years', '1 - 2 years');
    $form->addRadio('how-long-have-you-been-a-customer-of-our-company', '3 or more years', '3 or more years');
    $form->addRadio('how-long-have-you-been-a-customer-of-our-company', 'I haven\'t made a purchase yet', 'I haven\'t made a purchase yet');
    $form->printRadioGroup('how-long-have-you-been-a-customer-of-our-company', 'How long have you been a customer of our company ?', false, 'required');
    $form->addRadio('how-likely-purchase-products-again', 'Extremely likely', 'Extremely likely');
    $form->addRadio('how-likely-purchase-products-again', 'Very likely', 'Very likely');
    $form->addRadio('how-likely-purchase-products-again', 'Somewhat likely', 'Somewhat likely', 'checked=checked');
    $form->addRadio('how-likely-purchase-products-again', 'Not so likely', 'Not so likely');
    $form->addRadio('how-likely-purchase-products-again', 'Not at all likely', 'Not at all likely');
    $form->printRadioGroup('how-likely-purchase-products-again', 'How likely are you to purchase any of our products again ?', false, 'required');
    $form->addBtn('button', 'back-btn', 4, '<i class="fa fa-arrow-circle-o-left mr-2" aria-hidden="true"></i> Back', 'class=btn btn-sm btn-warning', 'btns');
    $form->addBtn('submit', 'submit-btn', 4, 'Next <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i>', 'class=btn btn-sm btn-success ladda-button, data-style=zoom-in', 'btns');
    $form->printBtnGroup('btns');
} elseif ($current_step == 5) {
    /* ==================================================
        Step 5
    ================================================== */

    $form_id = 'cs-step-5';
    $previous_form = new Form('cs-step-4');

    $form = new Form('cs-step-5', 'vertical', 'novalidate', 'material');
    // $form->setMode('development');

    // materialize plugin
    $form->addPlugin('materialize', '#cs-step-5');

    $form->addRadio('recommend-to-a-friend-or-colleague', 0, '0');
    $form->addRadio('recommend-to-a-friend-or-colleague', 1, '1');
    $form->addRadio('recommend-to-a-friend-or-colleague', 2, '2');
    $form->addRadio('recommend-to-a-friend-or-colleague', 3, '3');
    $form->addRadio('recommend-to-a-friend-or-colleague', 4, '4');
    $form->addRadio('recommend-to-a-friend-or-colleague', 5, '5');
    $form->addRadio('recommend-to-a-friend-or-colleague', 6, '6');
    $form->addRadio('recommend-to-a-friend-or-colleague', 7, '7');
    $form->addRadio('recommend-to-a-friend-or-colleague', 8, '8');
    $form->addRadio('recommend-to-a-friend-or-colleague', 9, '9');
    $form->addRadio('recommend-to-a-friend-or-colleague', 10, '10');
    $form->printRadioGroup('recommend-to-a-friend-or-colleague', 'How likely is it that you would recommend this company to a friend or colleague ?', true, 'required');
    $form->addTextarea('other-comments', '', 'Do you have any other comments, questions, or concerns ?');
    $form->addBtn('button', 'back-btn', 5, '<i class="fa fa-arrow-circle-o-left mr-2" aria-hidden="true"></i> Back', 'class=btn btn-sm btn-warning', 'btns');
    $form->addBtn('submit', 'submit-btn', 5, 'Submit <i class="fa fa-arrow-circle-o-right ml-2" aria-hidden="true"></i>', 'class=btn btn-sm btn-success ladda-button, data-style=zoom-in', 'btns');
    $form->printBtnGroup('btns');
}
$form->render();

$form->printJsCode();
?>
<script type="text/javascript">
    $(document).ready(function () {
        initFormEvents('<?php echo $form_id; ?>');
    });
</script>
