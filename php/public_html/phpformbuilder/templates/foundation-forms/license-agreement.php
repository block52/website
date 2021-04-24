<?php
use phpformbuilder\Form;
use phpformbuilder\Validator\Validator;

/* =============================================
    start session and include form class
============================================= */

session_start();
include_once rtrim($_SERVER['DOCUMENT_ROOT'], DIRECTORY_SEPARATOR) . '/phpformbuilder/Form.php';

/* =============================================
    validation if posted
============================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST" && Form::testToken('license-agreement-form') === true) {
    // create validator & auto-validate required fields
    $validator = Form::validate('license-agreement-form');

    // additional validation
    $validator->email()->validate('user-email');

    // recaptcha validation
    $validator->recaptcha('6LeNWaQUAAAAAOnei_86FAp7aRZCOhNwK3e2o2x2', 'Recaptcha Error')->validate('g-recaptcha-response');

    // check for errors
    if ($validator->hasErrors()) {
        $_SESSION['errors']['license-agreement-form'] = $validator->getAllErrors();
    } else {
        $data_uri = $_POST['user-signature'];
        $encoded_image = explode(',', $data_uri)[1];
        $decoded_image = base64_decode($encoded_image);

        // remove comments to save the signature on your server
        // file_put_contents('signature.png', $decoded_image);

        // wrap the data:image/png;base64 into an <img> tag to send it in the email
        $values = $_POST;
        $values['user-signature'] = '<img src="' . $_POST['user-signature'] . '" alt="user signature" />';

        $email_config = array(
            'sender_email'    => 'contact@phpformbuilder.pro',
            'sender_name'     => 'Php Form Builder',
            'recipient_email' => addslashes($_POST['user-email']),
            'subject'         => 'License agreement from Php Form Builder',
            'values'          => $values,
            'filter_values'   => 'license-agreement-form'
        );
        $sent_message = Form::sendMail($email_config);
        Form::clear('license-agreement-form');
    }
}

/* ==================================================
    The Form
================================================== */

$license_text = "License Agreement\n \n This License Agreement is made and effective as of now by and between Sender Company, a company organized and existing in Sender Country, with a registered address at Sender Address (\"Licensor\") and Client Company, a company organized and existing in Client Country, with a registered address at Client Address (\"Licensee\").\n \n WHEREAS:\n \n Licensee wishes to obtain a license to use Description of product (hereinafter, the \"Asset\"), and\n Licensor is willing to grant to the Licensee a non-exclusive, non-transferable License to use the Asset for the term and specific purpose set forth in this Agreement,\n NOW, THEREFORE, in consideration of the foregoing, and of the mutual promises and undertakings contained herein, and other good and valuable consideration, the parties agree as follows:\n \n 1. Definitions\n 1.1 \"Agreement\" means this License Agreement including the attached Schedule.\n \n 1.2 \"Confidential Information\" means information that:\n a. is by its nature confidential;\n b. is designated in writing by Licensor as confidential;\n c. the Licensee knows or reasonably ought to know is confidential;\n d. Information comprised in or relating to any Intellectual Property Rights of Licensor.\n \n 1.3 \"Asset\" means the Asset provided by Licensor as specified in Item 6 of the Schedule in the form as stated in Item 7 of the Schedule.\n \n 1.4 \"Intellectual Property Rights\" means all rights in and to any copyright, trademark, trading name, design, patent, know how (trade secrets) and all other rights resulting from intellectual activity in the industrial, scientific, literary or artistic field and any application or right to apply for registration of any of these rights and any right to protect or enforce any of these rights, as further specified in clause 5.\n \n 1.5 \"Party\" means a person or business entity who has executed this Agreement; details of the Parties are specified in Item 2 of the Schedule.\n \n 1.6 \"Term\" means the term of this Agreement commencing on the Commencement Date as specified in Item 4 of the Schedule and expiring on the Expiry Date specified in Item 5 of the Schedule.\n \n 2. License Grant\n 2.1 Licensor grants to the Licensee a non-exclusive, non-transferable License for the Term to use the Asset for the specific purpose specified in this Agreement, subject to the terms and conditions set out in this Agreement.\n \n 3. Charges\n 3.1 In consideration of the Licensor providing the License under clause 2 of this License Agreement, the Licensee agrees to pay Licensor the amount of the License Charge as specified in Item 9 of the Schedule.\n \n 4. Licensee’s Obligations\n 4.1 The Licensee cannot use the Asset, for purposes other than as specified in this Agreement and in Item 8 of the Schedule.\n \n 4.2 The Licensee may permit its employees to use the Asset for the purposes described in Item 8, provided that the Licensee takes all necessary steps and imposes the necessary conditions to ensure that all employees using the Asset do not commercialise or disclose the contents of it to any third person, or use it other than in accordance with the terms of this Agreement.\n \n 4.3 The Licensee will not distribute, sell, License or sub-License, let, trade or expose for sale the Asset to a third party.\n \n 4.4 No copies of the Asset are to be made other than as expressly approved by Licensor.\n \n 4.5 No changes to the Asset or its content may be made by Licensee.\n \n 4.6 The Licensee will provide technological and security measures to ensure that the Asset which the Licensee is responsible for is physically and electronically secure from unauthorised use or access.\n \n 4.7 Licensee shall ensure that the Asset retains all Licensor copyright notices and other proprietary legends and all trademarks or service marks of Licensor.\n \n 5. Intellectual Property Rights\n 5.1 All Intellectual Property Rights over and in respect of the Asset are owned by Licensor. The Licensee does not acquire any rights of ownership in the Asset.\n \n 6. Limitation of Liability\n 6.1 The Licensee acknowledges and agrees that neither Licensor nor its board members, officers, employees or agents, will be liable for any loss or damage arising out of or resulting from Licensor’s provision of the Asset under this Agreement, or any use of the Asset by the Licensee or its employees; and Licensee hereby releases Licensor to the fullest extent from any such liability, loss, damage or claim.\n \n 7. Confidentiality\n 7.1 Neither Party may use, disclose or make available to any third party the other Party’s Confidential Information, unless such use or disclosure is done in accordance with the terms of this Agreement.\n \n 7.2 Each Party must hold the other Party’s Confidential Information secure and in confidence, except to the extent that such Confidential Information:\n a. is required to be disclosed according to the requirements of any law, judicial or legislative body or government agency; or\n b. was approved for release in writing by the other Party, but only to the extent of and subject to such conditions as may be imposed in such written authorisation.\n \n 7.3 This clause 7 will survive termination of this Agreement.\n \n 8. Disclaimers & Release\n 8.1 To the extent permitted by law, Licensor will in no way be liable to the Licensee or any third party for any loss or damage, however caused (including through negligence) which may be directly or indirectly suffered in connection with any use of the Asset.\n \n 8.2 The Asset is provided by Licensor on an \"as is\" basis.\n \n 8.3 Licensor will not be held liable by the Licensee in any way, for any loss, damage or injury suffered by the Licensee or by any other person related to any use of the Asset or any part thereof.\n \n 8.4 Notwithstanding anything contained in this Agreement, in no event shall Licensor be liable for any claims, damages or loss which may arise from the modification, combination, operation or use of the Asset with Licensee computer programs.\n \n 8.5 Licensor does not warrant that the Asset will function in any environment.\n \n 8.6 The Licensee acknowledges that: a. The Asset has not been prepared to meet any specific requirements of any party, including any requirements of Licensee; and b. it is therefore the responsibility of the Licensee to ensure that the Asset meets its own individual requirements.\n \n 8.7 To the extent permitted by law, no express or implied warranty, term, condition or undertaking is given or assumed by Licensor, including any implied warranty of merchantability or fitness for a particular purpose.\n \n 9. Indemnification\n 9.1 The Licensee must indemnify, defend and hold harmless Licensor, its board members, officers, employees and agents from and against any and all claims (including third party claims), demands, actions, suits, expenses (including attorney’s fees) and damages (including indirect or consequential loss) resulting in any way from:\n \n a. Licensee’s and Licensee’s employee’s use or reliance on the Asset,\n b. any breach of the terms of this License Agreement by the Licensee or any Licensee employee, and\n c. any other act of Licensee.\n \n 9.2 This clause 9 will survive termination of this Agreement.\n \n 10. Waiver\n 10.1 Any failure or delay by either Party to exercise any right, power or privilege hereunder or to insist upon observance or performance by the other of the provisions of this License Agreement shall not operate or be construed as a waiver thereof.\n \n 11. Governing Law\n 11.1 This Agreement will be construed by and governed in accordance with the laws of [County]. The Parties submit to exclusive jurisdiction of the courts of [County].\n \n 12. Termination\n 12.1 This Agreement and the License granted herein commences upon the Commencement Date and is granted for the Term, unless otherwise terminated by Licensor in the event of any of the following:\n \n a. if the Licensee is in breach of any term of this License Agreement and has not corrected such breach to Licensor’s reasonable satisfaction within 7 days of Licensor’s notice of the same;\n b. if the Licensee becomes insolvent, or institutes (or there is instituted against it) proceedings in bankruptcy, insolvency, reorganization or dissolution, or makes an assignment for the benefit of creditors; or\n c. the Licensee is in breach of clause 5 or 7 of this Agreement.\n \n 12.2 Termination under this clause shall not affect any other rights or remedies Licensor may have.\n \n 13. License Fee\n 13.1 In consideration for the License grant described in this License Agreement, Licensee shall pay the yearly License fee as stated in Item 9 of the Schedule immediately upon execution of this Agreement and upon each anniversary date of this Agreement.\n \n 13.2 The License fee and any other amounts payable by the Licensee to the Licensor, under this Agreement, are exclusive of any and all foreign and domestic taxes, which if found to be applicable, will be invoiced to Licensee and paid by Licensee within 30 days of such invoice.\n \n 14. Assignment\n 14.1 Licensee shall not assign any rights of this License Agreement, without the prior written consent of Licensor.\n \n 15. Notices\n 15.1 All notices required under this Agreement shall be in writing and shall be deemed given (i) when delivered personally; (ii) five (5) days after mailing, when sent certified mail, return receipt requested and postage prepaid; or (iii) one (1) business day after dispatch, when sent via a commercial overnight carrier, fees prepaid. All notices given by either Party must be sent to the address of the other as first written above (unless otherwise changed by written notice).\n \n 16. Counterparts\n 16.1 This Agreement may be executed in any number of counterparts, each of which shall be deemed to be an original and all of which taken together shall constitute one instrument.\n \n 17. Severability\n 17.1 The Parties recognize the uncertainty of the law with respect to certain provisions of this Agreement and expressly stipulate that this Agreement will be construed in a manner that renders its provisions valid and enforceable to the maximum extent possible under applicable law. To the extent that any provisions of this Agreement are determined by a court of competent jurisdiction to be invalid or unenforceable, such provisions will be deleted from this Agreement or \nmodified so as to make them enforceable and the validity and enforceability of the remainder of such provisions and of this Agreement will be unaffected.\n \n 18. Entire Agreement\n 18.1 This Agreement contains the entire agreement between the Parties and supersedes any previous understanding, commitments or agreements, oral or written. Further, this Agreement may not be modified, changed, or otherwise altered in any respect except by a written agreement signed by both Parties.\n";

$form = new Form('license-agreement-form', 'vertical', 'data-fv-no-icon=true, novalidate', 'foundation');
$form->setMode('development');
$form->startFieldset('Please read the terms and conditions of the license carefully');
$form->addIcon('user-email', '<i class="input-group-label fi-mail"></i>', 'before');
$form->addInput('email', 'user-email', '', '', 'class=input-group-field, placeholder=Email, required');
$form->addTextarea('license', $license_text, 'Terms & conditions', 'cols=20, rows=5, style=font-size:11px, readonly');
$form->addInput('hidden', 'user-signature', '', 'Sign to confirm your agreement', 'class=signature-pad, data-background-color=#F7F7F7, data-pen-color=#333, data-width=100%, data-clear-button=true, data-clear-button-class=button warning small, data-clear-button-text=clear, data-fv-not-empty___message=You must sign to accept the license agreement, required');
$form->addRecaptchaV3('6LeNWaQUAAAAAGO_c1ORq2wla-PEFlJruMzyH5L6');
$form->centerButtons(true);
$form->addBtn('submit', 'submit-btn', 1, 'Agree <i class="fi-check append" aria-hidden="true"></i>', 'class=success button ladda-button, data-style=zoom-in');
$form->endFieldset();

// jQuery validation
$form->addPlugin('formvalidation', '#license-agreement-form');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foundation License agreement Form - How to create PHP forms easily</title>
    <meta name="description" content="Foundation Form Generator - how to create a License agreement Form with Php Form Builder Class">
    <link rel="canonical" href="https://www.phpformbuilder.pro/templates/foundation-forms/license-agreement-form.php" />

    <!-- Foundation CSS -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.5.0/css/foundation.min.css" rel="stylesheet">

    <!-- foundation icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css">
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-head.php';
    ?>
    <?php $form->printIncludes('css'); ?>
</head>
<body>
    <h1 class="text-center">Php Form Builder - Foundation License agreement Form<br><small>with electronic signature</small></h1>
    <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
            <?php
            if (isset($sent_message)) {
                echo $sent_message;
            }
            $form->render();
            ?>
            </div>
        </div>
    </div>

    <!-- jQuery -->

    <script src="//code.jquery.com/jquery.min.js"></script>
    <?php
        $form->printIncludes('js');
        $form->printJsCode();
    ?>
    <?php

        /* =============================================
            CODE PREVIEW - REMOVE THIS IN YOUR FORMS
        ============================================= */

        include_once '../assets/code-preview-body.php';
    ?>
</body>
</html>
