<?php
namespace phpformbuilder;

use phpformbuilder\Validator\Validator;

class FormExtended extends Form
{

    /* =============================================
        Complete contact form
    ============================================= */

    public function createContactForm()
    {
        $email_icon = '<i class="fa fa-envelope" aria-hidden="true"></i>';
        $phone_icon = '<i class="fa fa-phone" aria-hidden="true"></i>';
        $send_icon  = '<i class="fa fa-envelope append" aria-hidden="true"></i>';
        $user_icon  = '<i class="fa fa-user" aria-hidden="true" aria-hidden="true"></i>';
        if ($this->framework == 'bs3') {
            $email_icon = '<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>';
            $phone_icon = '<span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>';
            $send_icon  = '<span class="glyphicon glyphicon-envelope append"></span>';
            $user_icon  = '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>';
        } elseif ($this->framework == 'foundation') {
            $email_icon = '<i class="input-group-label fi-mail" aria-hidden="true"></i>';
            $phone_icon = '<i class="input-group-label fi-telephone" aria-hidden="true"></i>';
            $send_icon  = '<i class="fi-mail append"></i>';
            $user_icon  = '<i class="input-group-label fi-torso" aria-hidden="true"></i>';
        } elseif ($this->framework == 'material' && !in_array('materialize', $this->js_plugins)) {
            $email_icon = '<i class="material-icons" aria-hidden="true">alternate_email</i>';
            $phone_icon = '<i class="material-icons" aria-hidden="true">phone</i>';
            $send_icon  = '<i class="material-icons right">email</i>';
            $user_icon  = '<i class="material-icons" aria-hidden="true">person</i>';
        }

        $this->startFieldset('Please fill in this form to contact us');
        $this->addHtml('<p class="text-warning">All fields are required</p>');
        $this->groupInputs('user-name', 'user-first-name');
        $this->setCols(0, 6);
        $this->addIcon('user-name', $user_icon, 'before');
        $this->addInput('text', 'user-name', '', '', 'class=input-group-field, placeholder=Name, required');
        $this->addIcon('user-first-name', $user_icon, 'before');
        $this->addInput('text', 'user-first-name', '', '', 'class=input-group-field, placeholder=First Name, required');
        $this->setCols(0, 12);
        $this->addIcon('user-email', $email_icon, 'before');
        $this->addInput('email', 'user-email', '', '', 'class=input-group-field, placeholder=Email, required');
        $this->addIcon('user-phone', $phone_icon, 'before');
        $this->addInput('text', 'user-phone', '', '', 'class=input-group-field, placeholder=Phone, required');
        if ($this->framework == 'material') {
            $this->addTextarea('message', '', 'Your message', 'cols=30, rows=4, required');
        } else {
            $this->addTextarea('message', '', '', 'cols=30, rows=4, required, placeholder=Message');
        }
        $this->addPlugin('word-character-count', '#message', 'default', array('%maxAuthorized%' => 100));
        $this->addCheckbox('newsletter', 'Suscribe to Newsletter', 1, 'checked=checked');
        $this->printCheckboxGroup('newsletter', '');
        $this->setCols(3, 9);
        $this->addInput('text', 'captcha', '', 'Type the following characters :', 'size=15');
        $this->addPlugin('captcha', '#captcha');
        $this->setCols(0, 12);
        $this->centerButtons(true);
        $this->addBtn('submit', 'submit-btn', 1, 'Send ' . $send_icon, 'class=btn btn-lg btn-success success button');
        $this->endFieldset();

        // Custom radio & checkbox css
        if ($this->framework != 'material') {
            $this->addPlugin('nice-check', 'form', 'default', ['%skin%' => 'green']);
        }

        // jQuery validation
        $this->addPlugin('formvalidation', '#' . $this->form_ID);

        return $this;
    }

    /* Contact form validation */

    public static function validateContactForm($form_name)
    {
        // create validator & auto-validate required fields
        $validator = self::validate($form_name);

        // additional validation
        $validator->maxLength(100)->validate('message');
        $validator->email()->validate('user-email');
        $validator->captcha('captcha')->validate('captcha');

        // check for errors

        if ($validator->hasErrors()) {
            $_SESSION['errors'][$form_name] = $validator->getAllErrors();

            return false;
        } else {
            return true;
        }
    }

    /* Contact form e-mail sending */

    public static function sendContactEmail($email_config, $form_ID)
    {

        // get hostname
        $email_config['filter_values'] =  $form_ID . ', captcha, submit-btn, captchaHash';
        $sent_message = self::sendMail($email_config);
        self::clear($form_ID);

        return $sent_message;
    }

    /* =============================================
        Fields shorcuts and groups for users
    ============================================= */

    public function addAddress($i = '')
    {
        $index = $this->getIndex($i);
        $index_text = $this->getIndexText($i);
        $this->setCols(3, 9, 'md');
        $this->addTextarea('address' . $index, '', 'Address' . $index_text, 'required');
        $this->groupInputs('zip_code' . $index, 'city' . $index);
        $this->setCols(3, 4, 'md');
        $this->addInput('text', 'zip_code' . $index, '', 'Zip Code' . $index_text, 'required');
        $this->setCols(2, 3, 'md');
        $this->addInput('text', 'city' . $index, '', 'City' . $index_text, 'required');
        $this->setCols(3, 9, 'md');
        $this->addCountrySelect('country' . $index, 'Country' . $index_text, 'class=no-autoinit, data-width=100%, required');

        return $this;
    }

    public function addBirth($i = '')
    {
        $index = $this->getIndex($i);
        $index_text = $this->getIndexText($i);
        $this->setCols(3, 4, 'md');
        $this->groupInputs('birth_date' . $index, 'birth_zip_code' . $index);
        $this->addInput('text', 'birth_date' . $index, '', 'Birth Date' . $index_text, 'placeholder=click to open calendar');
        if ($this->framework == 'material') {
            $date_plugin = 'material-datepicker';
        } else {
            $date_plugin = 'pickadate';
        }
        $this->addPlugin($date_plugin, '#birth_date' . $index);
        $this->setCols(2, 3, 'md');
        $this->addInput('text', 'birth_zip_code' . $index, '', 'Birth Zip Code' . $index_text);
        $this->setCols(3, 4, 'md');
        $this->groupInputs('birth_city' . $index, 'birth_country' . $index);
        $this->addInput('text', 'birth_city' . $index, '', 'Birth  City' . $index_text);
        $this->setCols(2, 3, 'md');
        $this->addCountrySelect('birth_country' . $index, 'Birth Country' . $index_text, 'class=no-autoinit, data-width=100%');

        return $this;
    }

    public function addCivilitySelect($i = '')
    {
        $index = $this->getIndex($i);
        $index_text = $this->getIndexText($i);
        $this->addOption('civility' . $index, 'M.', 'M.');
        $this->addOption('civility' . $index, 'M<sup>rs</sup>', 'Mrs');
        $this->addOption('civility' . $index, 'M<sup>s</sup>', 'Ms');
        $this->addSelect('civility' . $index, 'Civility' . $index_text, 'class=select2 no-autoinit, data-minimum-results-for-search=Infinity, required');

        return $this;
    }

    public function addContact($i = '')
    {
        $index = $this->getIndex($i);
        $index_text = $this->getIndexText($i);
        $this->groupInputs('phone' . $index, 'mobile_phone' . $index);
        $this->setCols(3, 4, 'md');
        $this->addInput('text', 'phone' . $index, '', 'Phone' . $index_text);
        $this->setCols(2, 3, 'md');
        $this->addInput('text', 'mobile_phone' . $index, '', 'Mobile' . $index_text, 'required');
        $this->setCols(3, 9, 'md');
        $this->addInput('email', 'email_professional' . $index, '', 'BuisnessE-mail' . $index_text, 'required');
        $this->addInput('email', 'email_private' . $index, '', 'Personal E-mail' . $index_text);

        return $this;
    }

    public function addIdentity($i = '')
    {
        $index = $this->getIndex($i);
        $index_text = $this->getIndexText($i);
        $this->groupInputs('civility' . $index, 'name' . $index);
        $this->setCols(3, 2, 'md');
        $this->addCivilitySelect($i);
        $this->setCols(2, 5, 'md');
        $this->addInput('text', 'name' . $index, '', 'Name' . $index_text, 'required');
        $this->setCols(3, 9, 'md');
        $this->startDependentFields('civility' . $index, 'Mrs');
        $this->addInput('text', 'maiden_name' . $index, '', 'Maiden Name' . $index_text);
        $this->endDependentFields();
        $this->groupInputs('firstnames' . $index, 'citizenship' . $index);
        $this->setCols(3, 4, 'md');
        $this->addInput('text', 'firstnames' . $index, '', 'Firstnames' . $index_text, 'required');
        $this->setCols(2, 3, 'md');
        $this->addInput('text', 'citizenship' . $index, '', 'Citizenship' . $index_text);

        return $this;
    }

    /* Submit buttons */

    public function addBackSubmit()
    {
        $this->setCols(0, 12);
        $this->addHtml('<p>&nbsp;</p>');
        $this->addBtn('submit', 'back-btn', 1, 'Back', 'class=btn btn-warning button warning', 'submit_group');
        $this->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success button success', 'submit_group');
        $this->printBtnGroup('submit_group');

        return $this;
    }

    public function addCancelSubmit()
    {
        $this->setCols(3, 9);
        $this->addHtml('<p>&nbsp;</p>');
        $this->addBtn('button', 'cancel-btn', 1, 'Cancel', 'class=btn btn-default button warning', 'submit_group');
        $this->addBtn('submit', 'submit-btn', 1, 'Submit', 'class=btn btn-success button primary', 'submit_group');
        $this->printBtnGroup('submit_group');

        return $this;
    }

    private function getIndex($i)
    {
        if ($i !== '') {
            return '-' . $i;
        }

        return false;
    }
    private function getIndexText($i)
    {
        if ($i !== '') {
            return ' ' . $i;
        }

        return false;
    }
}
