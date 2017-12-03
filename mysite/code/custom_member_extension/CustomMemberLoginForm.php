<?php

class CustomMemberLoginForm extends MemberLoginForm {

    /*public function __construct($controller, $name, $fields = null, $actions = null, $checkCurrentUser = true) {

        $actions = FieldList::create(

            FormAction::create('dologin', _t('Member.BUTTONLOGIN', 'Log in'))->addExtraClass('myClass'),
            LiteralField::create(
                'forgotPassword',
                '<p id="ForgotPassword" ><a href="Security/lostpassword">'
                . _t('Member.BUTTONLOSTPASSWORD', "I've lost my password") . '</a></p>'
            )
        );

    }*/

    public function __construct($controller, $name, $fields = null, $actions = null,
                                $checkCurrentUser = true) {

        // This is now set on the class directly to make it easier to create subclasses
        // $this->authenticator_class = $authenticatorClassName;

        $customCSS = project() . '/css/member_login.css';
        if(Director::fileExists($customCSS)) {
            Requirements::css($customCSS);
        }

        if(isset($_REQUEST['BackURL'])) {
            $backURL = $_REQUEST['BackURL'];
        } else {
            $backURL = Session::get('BackURL');
        }

        if($checkCurrentUser && Member::currentUser() && Member::logged_in_session_exists()) {
            $fields = FieldList::create(
                HiddenField::create("AuthenticationMethod", null, $this->authenticator_class, $this)
            );
            $actions = FieldList::create(
                FormAction::create("logout", _t('Member.BUTTONLOGINOTHER', "Log in as someone else"))
            );
        } else {
            if(!$fields) {
                $label=singleton('Member')->fieldLabel(Member::config()->unique_identifier_field);
                $fields = FieldList::create(
                    HiddenField::create("AuthenticationMethod", null, $this->authenticator_class, $this),
                    // Regardless of what the unique identifer field is (usually 'Email'), it will be held in the
                    // 'Email' value, below:
                    $emailField = TextField::create("Email", $label, null, null, $this),
                    PasswordField::create("Password", _t('Member.PASSWORD', 'Password'))
                );
                if(Security::config()->remember_username) {
                    $emailField->setValue(Session::get('SessionForms.MemberLoginForm.Email'));
                } else {
                    // Some browsers won't respect this attribute unless it's added to the form
                    $this->setAttribute('autocomplete', 'off');
                    $emailField->setAttribute('autocomplete', 'off');
                }
                if(Security::config()->autologin_enabled) {
                    $fields->push(CheckboxField::create(
                        "Remember",
                        _t('Member.REMEMBERME', "Remember me next time?")
                    ));
                }
            }
            if(!$actions) {
                $actions = FieldList::create(
                    FormAction::create('dologin', _t('Member.BUTTONLOGIN', "Log in")),
                    LiteralField::create(
                        'forgotPassword',
                        '<p id="ForgotPassword"><a href="' . Security::lost_password_url() . '">'
                        . _t('Member.BUTTONLOSTPASSWORD', "I've lost my password") . '</a></p>'
                    )
                );
            }
        }

        if(isset($backURL)) {
            $fields->push(HiddenField::create('BackURL', 'BackURL', $backURL));
        }

        // Reduce attack surface by enforcing POST requests
        $this->setFormMethod('POST', true);

        parent::__construct($controller, $name, $fields, $actions);

        $this->setValidator(RequiredFields::create('Email', 'Password'));

        // Focus on the email input when the page is loaded
        $js = <<<JS
			(function() {
				var el = document.getElementById("MemberLoginForm_LoginForm_Email");
				if(el && el.focus && (typeof jQuery == 'undefined' || jQuery(el).is(':visible'))) el.focus();
			})();
JS;
        Requirements::customScript($js, 'MemberLoginFormFieldFocus');


        parent::__construct($controller, $name, $fields, $actions);
    }


}