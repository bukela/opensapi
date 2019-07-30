<?php
/**
 * Template Name: Admin Login Page
 *
 */
$userActivation = (isset($_GET['activate'])) ? $_GET['activate'] : 0;

if ($userActivation) {

    $user = get_user_by('email', $userActivation);

    if (isset($user)) {
        if ($user->active == 0) {
            update_user_meta($user->ID, 'active', 1);

            list( $rp_path ) = explode('?', wp_unslash($_SERVER['REQUEST_URI']));
            $rp_cookie = 'activate-' . COOKIEHASH;

            if (isset($_GET['activate'])) {
                $value = sprintf('%s:%s', wp_unslash($_GET['activate']), wp_unslash($_GET['key']));
                setcookie($rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true);
                wp_safe_redirect(remove_query_arg(array('activate', 'key')) . '?action=activated');
                exit;
            }
        } else {
            if (isset($_GET['activate'])) {
                $value = sprintf('%s:%s', wp_unslash($_GET['activate']), wp_unslash($_GET['key']));
                setcookie($rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true);
                wp_safe_redirect(remove_query_arg(array('activate', 'key')) . '?action=active');
                exit;
            }
        }
    }
}
?>

<?php
get_header('no-submeni');
?>


<?php $login = (isset($_GET['login']) ) ? $_GET['login'] : 0; ?>
<?php
$checkmail = isset($_GET['checkemail']) ? $_GET['checkemail'] : 0;
if ($checkmail === 'confirm') {
    ?>
    <div class="note open alert alert-info">
        <?php echo 'Check your email for reset password link.' ?>
    </div>
    <?php
}

$resetPassword = (isset($_GET['resetpassword'])) ? $_GET['resetpassword'] : 0;
?>

<?php $notActivated = (isset($_GET['errors']) ? $_GET['errors'] : 0) ?>
<?php if ($notActivated === 'not-active') { ?>
    <div class="note open alert alert-info">
        <?php echo 'Please activate your account. Check your email for the activation link..' ?>
    </div>
<?php } ?>

<?php $activated = (isset($_GET['action'])) ? $_GET['action'] : 0; ?>
<?php if ($activated === 'activated') { ?>
    <div class="note open alert alert-info">
        <?php echo 'You activated your account.' ?>
    </div>
<?php } elseif ($activated === 'active') { ?>
    <div class="note open alert alert-info">
        <?php echo 'Your account is already activated.' ?>
    </div>
<?php } ?>

<?php if ($resetPassword === 'confirm') { ?>
    <div class="note open alert alert-info">
        <?php echo 'You successfully changed your password.' ?>
    </div>
<?php } ?>

<?php if ($login === "false") : ?>
    <div class="note open alert alert-info">
        <?php echo 'You are logged out.' ?>
    </div>
<?php endif; ?>
<section class="inner">
    <div class="container">
        <div class="page-breadcrumb">
            <?php
            if (function_exists('yoast_breadcrumb')) {
                $breadcrumbs = yoast_breadcrumb('<a class="breadcrumbs">', '</a>', false);

                $search = array('<span class="breadcrumb_last">', '</span>');
                $replace = array('<a class="active">&nbsp', '</a>');
                $string = str_replace($search, $replace, $breadcrumbs);
                echo $string;
            }
            ?>
        </div>
        <div class="login">
            <div class="login__inner">
                <span lang="en-US"><a href="#" id="captureSignInLink1" onclick="janrain.capture.ui.renderScreen('signIn')">Sign In / Sign Up</a></span>
                <span lang="nl-NL"><a href="#" id="captureSignInLink" onclick="janrain.capture.ui.renderScreen('signIn')">Inloggen / Registreren</a></span>
                <a href="index.html?screenToRender=editProfile" id="captureProfileLink" style="display:none">Edit Profile</a>
                <span lang="en-US"><a href="#" id="captureSignOutLink1" style="display:none" onclick="janrain.capture.ui.endCaptureSession()">Sign Out</a></span>
                <span lang="nl-NL"><a href="#" id="captureSignOutLink" style="display:none" onclick="janrain.capture.ui.endCaptureSession()">Uitloggen</a></span>
                <div style="float: right; text-align: right;">
                    <select id="janrainSelectLanguage">     
                        <option value="nl-NL">nl-NL</option>             
                        <option value="en-US">en-US</option>
                    </select>
                </div>
                <br style="clear: right;"/>
                <div style="display:none;" id="createPassword">
                    <div class="capture_header">
                        <h1>  
                            <span lang="en-US">Create a password</span>
                            <span lang="nl-NL">Maak een wachtwoord</span>
                        </h1>     
                    </div>
                    {* #createPasswordFormNoAuth *}
                    {* #newPassword *}
                    {* #newPasswordConfirm *}
                    <div class="capture_footer">
                        <span lang="en-US"><input value="Submit" type="submit" class="capture_btn capture_primary"></span>
                        <span lang="nl-NL"><input value="Versturen" type="submit" class="capture_btn capture_primary"></span>
                    </div>
                    {* /createPasswordFormNoAuth *}
                </div>
                <div style="display:none;" id="createPasswordSuccess">
                    <div class="capture_header">
                        <h1>  
                            <span lang="en-US">Your password has set</span>
                            <span lang="nl-NL">Uw wachtwoord is ingesteld</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Password has been successfully updated.</span>
                        <span lang="nl-NL">Uw wachtwoord is succesvol geupdatet.</span>
                    </p>
                    <div class="capture_footer">
                        <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Sign in</a></span>
                        <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Inloggen</a></span>
                    </div>
                </div>
                <!-- emailVerificationNotification:
                  This screen is rendered after a user has registered. In the case of
                  traditional registration, this screen is always rendered after the user
                  completes registration on the traditionalRegistration screen. In the
                  case of social registration, this screen is only rendered if the data
                  returned from the IDP does not contain a verified email address.
                  Twitter is an example of an IDP that does not return a verified email.
                -->
                <div style="display:none;" id="emailVerificationNotification">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Thank You for Registering</span>
                            <span lang="nl-NL">Bedankt voor uw registratie</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">We have sent you a welcome email.</span>
                        <span lang="nl-NL">We hebben u een welkomstmail gestuurd.</span>
                    </p>
                    <div class="capture_footer">
                        <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Return to Login Page</a></span>
                        <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Naar inlogpagina</a></span>
                    </div>
                </div>
                <!-- emailVerificationRequired:
                  This screen is rendered if you have enabled the requirement for verified emails and the user's email has not yet been verified. This screen may appear immediately after registration and also on subsequent logins until the email is verified. Screen rendering is handled in the postLoginScreens Capture settings per API client. A value of "emailVerificationRequired" will enable the requirement of having a verified email. A value of "false" will disable the requirement of having a verified email.
                -->
                <div style="display:none;" id="emailVerificationRequired">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Email Verification Required</span>
                            <span lang="nl-NL">Bevestiging van uw e-mailadres is verplicht</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">You must verify your email address before signing in. Check your email for your verification email, or enter your email address in the form below to resend the email.</span>
                        <span lang="nl-NL">U moet uw e-mailadres bevestigen voordat u kunt inloggen. Check uw e-mail voor uw bevestigingsmail, of vul uw e-mailadres hieronder in om uw bevestigingsmail opnieuw te verzenden.</span> 
                    </p>
                    {* #resendVerificationForm *}
                    {* signInEmailAddress *}
                    <div class="capture_footer">
                        <span lang="en-US"><input value="Submit" type="submit" class="capture_btn capture_primary"></span>
                        <span lang="nl-NL"><input value="Versturen" type="submit" class="capture_btn capture_primary"></span>
                    </div>
                    {* /resendVerificationForm *}
                </div>
                <!--
                  ============================================================================
                      FORGOT PASSWORD SCREENS:
                      The following screens are part of the forgot password user workflow. For
                      a complete out-of-the-box registration experience, these screens must be
                      included on the page where you are implementing forgot password
                      functionality.
                  ============================================================================
                -->

                <!-- forgotPassword:
                    Entry point into the forgot password user workflow. This screen is
                    rendered when the user clicks on the 'Forgot your password?' link on the
                    signIn screen.
                -->
                <div style="display:none;" id="forgotPassword">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Create New Password</span>
                            <span lang="nl-NL">Maak een nieuw wachtwoord</span>
                        </h1>
                    </div>
                    <h2>
                        <span lang="en-US">We'll send you a link to create a new password.</span>
                        <span lang="nl-NL">We sturen u een link om een nieuw wachtwoord te maken.</span>
                    </h2>
                    {* #forgotPasswordForm *}
                    {* #signInEmailAddress *}
                    <div class="capture_footer">
                        <div class="capture_left">
                            <p>
                                <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Back</a></span>
                                <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Terug</a></span>
                            </p>
                        </div>
                        <div class="capture_right">
                            <span lang="en-US"><input value="Send" type="submit" class="capture_btn capture_primary"></span>
                            <span lang="nl-NL"><input value="Versturen" type="submit" class="capture_btn capture_primary"></span>
                        </div>
                    </div>
                    {* /forgotPasswordForm *}
                </div>
                <!-- forgotPasswordSuccess:
                  When the user submits an email address on the forgotPassword screen,
                  this screen is rendered.
                -->
                <div style="display:none;" id="forgotPasswordSuccess">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Create New Password</span>
                            <span lang="nl-NL">Maak nieuw wachtwoord</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">We've sent an email with instructions to create a new password. Your existing password has not been changed.</span>
                        <span lang="nl-NL">We hebben u een e-mail gestuurd met uitleg voor het maken van een nieuw wachtwoord. Uw huidige wachtwoord is niet veranderd.</span>
                    </p>
                    <div class="capture_footer">
                        <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Return to Login Page</a></span>
                        <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Naar inlogpagina</a></span>
                    </div>
                </div>
                <!-- inactive user -->
                <div style="display:none;" id="inactiveUser">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Inactive user status</span>
                            <span lang="nl-NL">Status inactief</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Unable to login, your account is inactive.</span>
                        <span lang="nl-NL">Het is niet gelukt om in te loggen. Meer informatie?<p> Neem dan contact met MSD Customer Contact Center:</p> Telefoon: 023-5153153 E-mail: info@msd.nl (op werkdagen van 09:00 tot 17:00)</span>
                    </p>
                    <div class="capture_footer">
                        <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Return to Login Page</a></span>
                        <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Naar inlogpagina</a></span>
                    </div>
                </div>
                <!-- invalidCountry -->
                <div style="display:none;" id="invalidCountry">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Invalid Country</span>
                            <span lang="nl-NL">Ongeldig land</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Unable to login, your account is not associated with permissions for this country.</span>
                        <span lang="nl-NL">Het is niet gelukt om in te loggen. Meer informatie?<p> Neem dan contact met MSD Customer Contact Center:</p> Telefoon: 023-5153153 E-mail: info@msd.nl (op werkdagen van 09:00 tot 17:00)</span>
                    </p>
                    <div class="capture_footer">
                        <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Return to Login Page</a></span>
                        <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Naar inlogpagina</a></span>
                    </div>
                </div>



                <!-- legal acceptance postlogin screen  -->

                <div style="display:none;" id="legalAcceptances">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Legal Acceptances</span>
                            <span lang="nl-NL">Wettelijke vereisten</span>
                        </h1>
                    </div>
                    {* #legalAcceptancesForm *}
                    <p> 
                        <span lang="en-US">Please accept our new Privacy Policy and Terms and Conditions.</span>
                        <span lang="nl-NL">Wij verzoeken u akkoord te gaan met onze Gebruiksvoorwaarden en Privacybeleid.</span>
                    </p>
                    <p>{* acceptTermsofUse *}</p>
                    <p>{* acceptPrivacyPolicy *}</p>
                    <div id="legalAcceptancesMessage" class="capture_tip_error"></div>
                    <div class="capture_footer">
                        <span lang="en-US"><input value="Submit" type="submit" class="capture_btn capture_primary"></span>
                        <span lang="nl-NL"><input value="Versturen" type="submit" class="capture_btn capture_primary"></span>
                    </div>
                    {* /legalAcceptancesForm *}
                </div>
                <!--
                ============================================================================
                    MERGE ACCOUNT SCREENS:
                    The following screens are part of the account merging user workflow. For
                    a complete out-of-the-box account merging experience, these screens must
                    be included on the page where you are implementing account merging
                    functionality.
                ============================================================================
                -->

                <!-- mergeAccounts:
                    This screen is rendered if the user created their account through
                    traditional registration and then tries to sign in with an IDP that
                    shares the same email address that exists in their user record.
                    NOTE! You will notice special tags you see on this screen. These tags,
                    such as '{| current_displayName |}' are rendered by the Janrain Capture
                    Widget in a way similar to JTL tags, but are more limited. We currently
                    only support modifying the text in this screen through the Flow. You
                    can, however, add your own markup and text throughout this screen as you
                    see fit.
                -->
                <div style="display:none;" id="mergeAccounts">
                    {* mergeAccounts {"custom": true} *}
                    <div id="capture_mergeAccounts_mergeAccounts_mergeOptionsContainer" class="capture_mergeAccounts_mergeOptionsContainer">
                        <div class="capture_header">
                            <div class="capture_icon_col">
                                {| rendered_current_photo |}
                            </div>
                            <div class="capture_displayName_col">
                                {| current_displayName |}<br />
                                {| current_emailAddress |}
                            </div>
                            <span class="capture_mergeProvider janrain-provider-icon-24 janrain-provider-icon-{| current_provider_lowerCase |}"></span>
                        </div>
                        <div class="capture_dashed">
                            <div class="capture_mergeCol capture_centerText capture_left">
                                <p class="capture_bigText">{| foundExistingAccountText |} <b>{| current_emailAddress |}</b>.</p>
                                <div class="capture_hover">
                                    <div class="capture_popup_container">
                                        <span class="capture_popup-arrow"></span>{| moreInfoHoverText |}<br />
                                        {| existing_displayName |} - {| existing_provider |} : {| existing_siteName |} {| existing_createdDate |}
                                    </div>
                                    {| moreInfoText |}
                                </div>
                            </div>
                            <div class="capture_mergeCol capture_mergeExisting_col capture_right">
                                <div class="capture_shadow capture_backgroundColor capture_border">
                                    {| rendered_existing_provider_photo |}
                                    <div class="capture_displayName_col">
                                        {| existing_displayName |}<br />
                                        {| existing_provider_emailAddress |}
                                    </div>
                                    <span class="capture_mergeProvider janrain-provider-icon-16 janrain-provider-icon-{| existing_provider_lowerCase |} "></span>
                                    <div class="capture_centerText capture_smallText">{| existingAccountCreatedText |}</div>
                                </div>
                            </div>
                        </div>
                        <div id="capture_mergeAccounts_form_collection_mergeAccounts_mergeRadio" class="capture_form_collection_merge_radioButtonCollection capture_form_collection capture_elementCollection capture_form_collection_mergeAccounts_mergeRadio" data-capturefield="undefined">
                            <div id="capture_mergeAccounts_form_item_mergeAccounts_mergeRadio_1_0" class="capture_form_item capture_form_item_mergeAccounts_mergeRadio capture_form_item_mergeAccounts_mergeRadio_1_0 capture_toggled" data-capturefield="undefined">
                                <label for="capture_mergeAccounts_mergeAccounts_mergeRadio_1_0">
                                    <input id="capture_mergeAccounts_mergeAccounts_mergeRadio_1_0" data-capturefield="undefined" data-capturecollection="true" value="1" type="radio" class="capture_mergeAccounts_mergeRadio_1_0 capture_input_radio" checked="checked" name="mergeAccounts_mergeRadio">
                                    {| connectLegacyRadioText |}
                                </label>
                            </div>
                            <div id="capture_mergeAccounts_form_item_mergeAccounts_mergeRadio_2_1" class="capture_form_item capture_form_item_mergeAccounts_mergeRadio capture_form_item_mergeAccounts_mergeRadio_2_1" data-capturefield="undefined">
                                <label for="capture_mergeAccounts_mergeAccounts_mergeRadio_2_1">
                                    <input id="capture_mergeAccounts_mergeAccounts_mergeRadio_2_1" data-capturefield="undefined" data-capturecollection="true" value="2" type="radio" class="capture_mergeAccounts_mergeRadio_2_1 capture_input_radio" name="mergeAccounts_mergeRadio">
                                    {| createRadioText |} {| current_provider |}
                                </label>
                            </div>
                            <div class="capture_tip" style="display:none;">
                            </div>
                            <div class="capture_tip_validating" data-elementname="mergeAccounts_mergeRadio">Validating</div>
                            <div class="capture_tip_error" data-elementname="mergeAccounts_mergeRadio"></div>
                        </div>
                        <div class="capture_footer">
                            {| connect_button |}
                            {| create_button |}
                        </div>
                    </div>
                </div>
                <!-- pending user -->
                <div style="display:none;" id="pendingUser">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Pending user status</span>
                            <span lang="nl-NL">Status in behandeling</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Unable to login, your account is pending.</span>
                        <span lang="nl-NL">Het is niet gelukt om in te loggen. Meer informatie?<p> Neem dan contact met MSD Customer Contact Center:</p> Telefoon: 023-5153153 E-mail: info@msd.nl (op werkdagen van 09:00 tot 17:00)</span>
                    </p>
                    <div class="capture_footer">
                        <p>
                            <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Return to Login Page</a></span>
                            <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Naar inlogpagina</a></span>
                        </p>
                    </div>
                </div>
                <div style="display:none;" id="preregCreatePasswordRequestCode">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Create a password</span>
                            <span lang="nl-NL">Maak een wachtwoord</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">We didn't recognize that password creation code. Enter your email address to get a new one.</span>
                        <span lang="nl-NL">Deze wachtwoord code is niet bij ons bekend. Noteer hieronder nogmaals uw e-mailadres, en we sturen u een nieuwe e-mail.</span>  
                    </p>
                    {* #resetPasswordForm *}
                    {* #signInEmailAddress *}
                    <div class="capture_footer">
                        <input value="Send" type="submit" class="capture_btn capture_primary">
                    </div>
                    {* /resetPasswordForm *}
                </div>
                <!-- resetPasswordRequestCodeSuccess:
                  This screen is rendered if the user submitted an email address on the
                  resetPasswordRequestCode screen.
                -->
                <div style="display:none;" id="preregCreatePasswordRequestCodeSuccess">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Create a password</span>
                            <span lang="nl-NL">Maak een wachtwoord</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">We already have your email address in our system but we need you to set a password first.</span>
                        <span lang="nl-NL">Uw e-mailadres is bekend, u moet alleen nog een wachtwoord maken.</span>
                    </p>
                    <p>
                        <span lang="en-US">We have sent an email with instructions to create a new password.</span>
                        <span lang="nl-NL">We hebben u een e-mail gestuurd met uitleg voor het maken van een wachtwoord.</span>
                    </p>
                    <p>
                        <span lang="en-US">Once you have verified ownership of your email address and set a password your account will be activated.</span>
                        <span lang="nl-NL">Uw account wordt geactiveerd zodra uw e-mailadres is bevestigd en uw wachtwoord is ingesteld.</span>
                    </p>

                    <div class="capture_footer">
                        <p>
                            <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Return to Login Page</a></span>
                            <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Naar inlogpagina</a></span>
                        </p>
                    </div>
                </div>
                <!--div style="display:none;" id="registrationCompletion">
                {* #registrationCompletionForm *}
                  {* #password *}
                  {* #passwordConfirm *}
                  {* #referral *}
                  {* #userStatusHidden *}
                  {* #preregEmailAddressHidden *}
                  <div class="capture_form_item">
                    {* saveButton *}
                  </div>
                {* /registrationCompletionForm *}
                </div-->
                <!-- rejected user -->
                <div style="display:none;" id="rejectedUser">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Status denied</span>
                            <span lang="nl-NL">Status afgewezen</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Your login was unsuccessful.Please contact MSD Customer Contact Center:<br><br>Telephone: +31 (0)235153153 (on working days from 09:00 to 17:00)<br><br> E-mail: info@msd.nl</span>
                        <span lang="nl-NL">Het is niet gelukt om in te loggen.Neem contact op met MSD Customer Contact Center:<br><br>Telefoon: 023-5153153 (werkdagen van 09:00 tot 17:00)<br><br> E-mail: info@msd.nl</span>
                    </p>
                    <div class="capture_footer">
                        <p>
                            <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Return to Login Page</a></span>
                            <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Naar inlogpagina</a></span>
                        </p>
                    </div>
                </div>
                <!-- resendVerificationSuccess:
                  This screen is rendered when a user enters an email address from the verifyEmail screen.
                -->
                <div style="display:none;" id="resendVerificationSuccess">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Verification Email Sent</span>
                            <span lang="nl-NL">Bevestigingsmail is verzonden</span>
                        </h1>
                    </div>
                    <div class="hr"></div>
                    <p>
                        <span lang="en-US">Check your email for a link to verify your email address.</span>
                        <span lang="nl-NL">Check uw e-mail voor een link om uw e-mailadres te bevestigen.</span>
                    </p>
                    <div class="capture_footer">
                        <p>
                            <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Sign in</a></span>
                            <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Inloggen</a></span>
                        </p>
                    </div>
                </div>
                <!--
                ============================================================================
                    RESET PASSWORD SCREENS:
                    The following screens are part of the password reset user workflow.
                    For a complete out-of-the-box password reset experience, these screens
                    must be included on the page where you are implementing password reset
                    functionality.
              
                    NOTE: The order in which these screens are rendered is as follows:
                    resetPasswordRequestCode
                    resetPasswordRequestCodeSuccess
                    resetPassword
                    resetPasswordSuccess
                ============================================================================
                -->

                <!-- resetPassword:
                    This screen is rendered when the user clicks the link in provided in the
                    password reset email and the code in the link is valid.
                -->
                <div style="display:none;" id="resetPassword">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Create a Password</span>
                            <span lang="nl-NL">Maak een wachtwoord</span>
                        </h1>
                    </div>
                    {* #changePasswordFormNoAuth *}
                    {* #newPassword *}
                    {* #newPasswordConfirm *}  
                    <div class="capture_footer">
                        <span lang="en-US"><input value="Submit password" type="submit" class="capture_btn capture_primary"></span>
                        <span lang="nl-NL"><input value="Verstuur wachtwoord" type="submit" class="capture_btn capture_primary"></span>
                    </div>
                    {* /changePasswordFormNoAuth *}
                </div>
                <!-- resetPasswordRequestCode:
                  This is the landing screen for the password reset workflow. When the
                  user clicks the link provided in the reset password email, a code is
                  supplied and is passed to Capture for verification. If the code is valid
                  the resetPassword screen is rendered immediately and the content of
                  this screen is not presented. If the code is not accepted for any reason
                  this screen is then presented, allowing the user to re-enter their
                  email address.
                -->
                <div style="display:none;" id="resetPasswordRequestCode">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Create New Password</span>
                            <span lang="nl-NL">Maak nieuw wachtwoord</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">We didn't recognize that password reset code. Enter your email below, and we'll send you another email.</span>
                        <span lang="nl-NL">Deze wachtwoord reset code is niet bij ons bekend. Noteer hieronder nogmaals uw e-mailadres, en we sturen u een nieuwe e-mail.</span>
                    </p>
                    {* #resetPasswordForm *}
                    {* #signInEmailAddress *}
                    <div class="capture_footer">
                        <span lang="en-US"><input value="Submit" type="submit" class="capture_btn capture_primary"></span>
                        <span lang="nl-NL"><input value="Versturen" type="submit" class="capture_btn capture_primary"></span>
                    </div>
                    {* /resetPasswordForm *}
                </div>
                <!-- resetPasswordRequestCodeSuccess:
                  This screen is rendered if the user submitted an email address on the
                  resetPasswordRequestCode screen.
                -->
                <div style="display:none;" id="resetPasswordRequestCodeSuccess">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Create New Password</span>
                            <span lang="nl-NL">Maak nieuw wachtwoord</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">We've sent you an email with instructions to create a new password. Your existing password has not been changed.</span>
                        <span lang="nl-NL">We hebben u een e-mail gestuurd met uitleg voor het maken van een nieuw wachtwoord. Uw huidige wachtwoord is niet veranderd.</span>
                    </p>
                    <div class="capture_footer">
                        <p>
                            <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Return to Login Page</a></span>
                            <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Naar inlogpagina</a></span>
                        </p>
                    </div>
                </div>
                <!-- resetPasswordSuccess:
                  This screen is rendered when the user successfully changes their
                  password from the resetPassword screen.
                -->
                <div style="display:none;" id="resetPasswordSuccess">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Password Changed</span>
                            <span lang="nl-NL">Wachtwoord veranderd</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Your password has been successfully updated.</span>
                        <span lang="nl-NL">Uw wachtwoord is succesvol veranderd.</span>
                    </p>
                    <div class="capture_footer">
                        <p>
                            <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Sign in</a></span>
                            <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Inloggen</a></span>
                        </p>
                    </div>
                </div>
                <!--
                ============================================================================
                    SIGNIN SCREENS:
                    The following screens are part of the sign in user workflow. For a
                    complete out-of-the-box sign in experience, these screens must be
                    included on the page where you are implementing sign in and registration.
                ============================================================================
                -->

                <!-- signIn:
                This is the starting point for sign in and registration. This screen is
                rendered by default. In order to change this behavior, the Flow must be
                edited.
                -->
                <div style="display:none;" id="signIn">
                    <div class="capture_header">
                        <h1>
                            <!--                            <label lang="en-US">Sign Up / Sign In</label>
                                                        <label lang="nl-NL">Inloggen / Registreren</label>-->
                        </h1>
                    </div>
                    <div class="capture_backgroundColor">
                        <div class="capture_signin">
                            <h2>
                                <label lang="en-US">With an email address . . .</label>
                                <label lang="nl-NL">Met een e-mailadres . . .</label>
                            </h2>
                            {* #signInForm *}
                            {* #signInEmailAddress *}
                            {* #currentPassword *}
                            <div class="capture_form_item">
                                <p>
                                    <span lang="en-US"><a href="#" data-capturescreen="forgotPassword">Forgot your password?</a></span>
                                    <span lang="nl-NL"><a href="#" data-capturescreen="forgotPassword">Wachtwoord vergeten?</a></span>
                                </p>
                            </div>
                            <div>
                                <span lang="en-US"><button class="capture_secondary capture_btn capture_primary" type="submit">Sign In</button></span>
                                <span lang="nl-NL"><button class="capture_secondary capture_btn capture_primary" type="submit">Inloggen</button></span>
                                <span lang="en-US"><a href="#" id="capture_signIn_createAccountButton" data-capturescreen="traditionalRegistration" class="capture_secondary capture_createAccountButton capture_btn capture_primary">Create Account</a></span>
                                <span lang="nl-NL"><a href="#" id="capture_signIn_createAccountButton" data-capturescreen="traditionalRegistration" class="capture_secondary capture_createAccountButton capture_btn capture_primary">Account aanmaken</a></span>
                                <div class="serviceMarks">
                                    {* poweredByJanrain *}
                                    <div id="adfdcb81-3fcc-4e89-807b-a54a89fab74d">
                                        <script type="text/javascript" src="http://privacy-policy.truste.com/privacy-seal/Janrain,-Inc-/asc?rid=adfdcb81-3fcc-4e89-807b-a54a89fab74d"></script>
                                        <a
                                            href="//privacy.truste.com/privacy-seal/Janrain,-Inc-/validation?rid=1b233149-fc3b-4e69-957a-ca7677ee4787" title="TRUSTe Privacy, Trusted Cloud, European Safe Harbor certification"
                                            target="_blank"
                                            >
                                            <img style="border:none;" src="http://privacy-policy.truste.com/privacy-seal/Janrain,-Inc-/seal?rid=7bc0f34d-9cf2-427d-af9e-15e2fc354825" alt="TRUSTe European Safe Harbor certification"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {* /signInForm *}
                        </div>
                    </div>
                </div>
                <!--
                ============================================================================
                    REGISTRATION SCREENS:
                    The following screens are part of the registration user workflow. For a
                    complete out-of-the-box registration experience, these screens must be
                    included on the page where you are implementing sign in and
                    registration.
                ============================================================================
                -->
                <!-- socialRegistration:
                    When a user clicks an IDP and does not already have an account in your
                    capture application, this screen is rendered. This behavior is defined
                    in the Flow.
                -->
                <div style="display:none;" id="socialRegistration">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Almost Done</span>
                            <span lang="nl-NL">Bijna klaar</span>
                        </h1>
                    </div>
                    <h2>
                        <span lang="en-US">Please confirm the information below before signing in.</span>
                        <span lang="nl-NL">Bevestig de onderstaande gegevens voordat u inlogt. Heeft u al een account?</span>
                    </h2>
                    {* #socialRegistrationForm *}
                    <p>
                        <span lang="en-US">By clicking below, you confirm that you accept our <a href="#">terms of service</a> and have read and understand <a href="#">privacy policy</a>.</span>
                        <span lang="nl-NL">Ik ga ermee akkoord om e-mails te ontvangen van MSD over promotionele productinformatie, nascholing, customer solutions en bedrijfsinformatie. Uw e-mailadres zal worden gebruikt om u te informeren over voor u relevante MSD-producten en medisch gerelateerde evenementen of initiatieven. We respecteren uw beroepsprivacy en zullen uw persoonlijke gegevens niet delen met derden. Zie ook ons privacy beleid op <a href="www.msd.nl/privacy">www.msd.nl/privacy</a>.</span>
                    </p>

                    <p>{* #acceptTermsofUse *}</p>
                    <p>{* #acceptPrivacyPolicy *}</p>
                    <div class="capture_footer">
                        <div class="capture_left">
                            {* backButton *}
                        </div>
                        <div class="capture_right">
                            <input value="Create Account" type="submit" class="capture_btn capture_primary">
                        </div>
                    </div>
                    {* /socialRegistrationForm *}
                </div>
                <!-- traditionalAuthenticateMerge:
                When the user elects to merge their traditional and social account, the
                user will see this screen. They will then enter their current sign in
                credentials and, upon successful authorization, the accounts will be
                merged.
                -->
                <div style="display:none;" id="traditionalAuthenticateMerge">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Sign In to Complete Account Merge</span>
                            <span lang="nl-NL">Sign In to Complete Account Merge</span>
                        </h1>
                    </div>
                    <div class="capture_signin">
                        {* #preregForm *}
                        {* #preregEmailAddress *}
                        <br />
                        {* /preregForm *}
                        {* #signInForm *}
                        {* #signInEmailAddress *}
                        {* #currentPassword *}
                        <div class="capture_footer">
                            <div class="capture_left">
                                {* backButton *}
                            </div>
                            <div class="capture_right">
                                <button class="capture_secondary capture_btn capture_primary" type="submit"><span class="janrain-icon-16 janrain-icon-key"></span>Sign In</button>
                            </div>
                        </div>
                        {* /signInForm *}
                    </div>
                </div>
                <!-- traditionalRegistration:
                  When a user clicks the 'Create Account' button this screen is rendered.
                -->
                <div style="display:none;" id="traditionalRegistration">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Almost Done</span>
                            <span lang="nl-NL">Bijna klaar</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Please confirm the information below before signing in. Already have an account? <a id="capture_traditionalRegistration_navSignIn" href="#" data-capturescreen="signIn">Sign In.</a></span>
                        <span lang="nl-NL">Bevestig de onderstaande gegevens voordat u inlogt. Heeft u al een account? <a id="capture_traditionalRegistration_navSignIn" href="#" data-capturescreen="signIn">Inloggen.</a></span>
                    </p> 
                    {* #preregForm *}
                    {* #preregEmailAddress *}
                    <br />
                    {* /preregForm *}
                    {* #registrationForm *}
                    <!-- The following fields are required by default and must be included in the registrationForm. In order to change any of these fields to optional, the Flow must be edited. -->
                    {* #emailAddress *}
                    {* #emailAddressConfirm *}
                    {* #newPassword *}
                    {* #newPasswordConfirm *}
                    {* #title *}
                    {* #firstName *}
                    {* #middleName *}
                    {* #lastName *}
                    {* #addressCity *}
                    {* #addressPostalCode *}
                    {* #gender *}
                    {* #birthdate *}
                    {* #phone *}
                    {* #customerType *}
                    {* #mainSpecialty *}
                    {* #licenseNumber *}
                    {* #brandedConsent *}
                    {* #MedicalProfessional *}
                    <p>
                        <span lang="en-US">By clicking below, you confirm that you accept our <a href="#">terms of service</a> and have read and understand <a href="#">privacy policy</a>.</span>
                        <!--span lang="nl-NL">Ik ga ermee akkoord om e-mails te ontvangen van MSD over promotionele productinformatie, nascholing, customer solutions en bedrijfsinformatie. Uw e-mailadres zal worden gebruikt om u te informeren over voor u relevante MSD-producten en medisch gerelateerde evenementen of initiatieven. We respecteren uw beroepsprivacy en zullen uw persoonlijke gegevens niet delen met derden. Zie ook ons privacy beleid op <a href="www.msd.nl/privacy">www.msd.nl/privacy</a>.</span-->
                    </p>
                    <p>{* acceptTermsofUse *}</p>
                    <p>{* acceptPrivacyPolicy *}</p>
                    <div class="capture_footer">
                        <div class="capture_left">
                            {* backButton *}
                        </div>
                        <div class="capture_right">
                            <span lang="en-US"><input value="Submit" type="submit" class="capture_btn capture_primary"></span>
                            <span lang="nl-NL"><input value="Account aanmaken" type="submit" class="capture_btn capture_primary"></span>
                        </div>
                    </div>
                    {* /registrationForm *}
                    <div style="display:none;">
                        {* #createPasswordForm *}
                        {* #preregEmailAddress *}
                        {* /createPasswordForm *}
                    </div>
                </div>
                <!--
                ============================================================================
                    EMAIL VERIFICATION SCREENS:
                    The following screens are part of the email verification user workflow.
                    For a complete out-of-the-box email verification experience, these
                    screens must be included on page where you are implementing email
                    verification.
                ============================================================================
                -->

                <!-- verifyEmail:
                    This is the landing screen after a user clicks on the link in the
                    verification email sent to the user when they've registered with a
                    non-verified email address.
                    HOW IT WORKS: The code that is generated by Capture and included in the
                    link sent in the verification email is sent to the server and, if valid,
                    the user's email will be marked as valid and the verifyEmailSuccess
                    screen will be rendered. If the code is not accepted for any reason,
                    the verifyEmail screen is shown and the user has another opportunity
                    to have the verification email sent to them.
                    NOTE: The links generated in the emails sent to users are based on
                    Capture settings found in Janrain's Capture Dashboard. In addition to
                    entering the URL of your email verification page, you will need to add
                    'screenToRender' as a parameter in the URL with a value of 'verifyEmail'
                    which is this screen.
                -->
                <div style="display:none;" id="verifyEmail">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Resend Verification Email</span>
                            <span lang="nl-NL">Verificatie email opnieuw versturen</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Sorry, we could not verify that email address. Enter your email below, and we'll send you another email.</span>
                        <span lang="nl-NL">Excuses, we konden dit email adres niet bevestigen. Noteer hieronder nogmaals uw e-mailadres, en we sturen u een nieuwe e-mail.</span>
                    </p>

                    {* #resendVerificationForm *}
                    {* #signInEmailAddress *}
                    <div class="capture_footer">
                        <span lang="en-US"><input value="Submit" type="submit" class="capture_btn capture_primary"></span>
                        <span lang="nl-NL"><input value="Versturen" type="submit" class="capture_btn capture_primary"></span>
                    </div>
                    {* /resendVerificationForm *}
                </div>
                <!-- verifyEmailSuccess:
                  This screen is rendered if the verification code provided in the link
                  sent to the user in the verification email is accepted and the user's
                  email address has been verified.
                -->
                <div style="display:none;" id="verifyEmailSuccess">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Email Verified</span>
                            <span lang="nl-NL">E-mail bevestigd</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Thank you for verifiying your email address.</span>
                        <span lang="nl-NL">Bedankt voor het bevestigen van uw e-mail adres.</span>
                    </p>
                    <div class="capture_footer">
                        <p>
                            <span lang="en-US"><a href="index.html" class="capture_btn capture_primary">Sign in</a></span>
                            <span lang="nl-NL"><a href="index.html" class="capture_btn capture_primary">Inloggen</a></span>
                        </p>
                    </div>
                </div>
                <!-- changePassword:
                  This screen is rendered when the user clicks the 'Change Password' link
                  on the edit profile page. After the user enters their new password,
                  the edit profile screen is refreshed and displayed.
                -->
                <div style="display:none;" id="changePassword">
                    <div class="capture_header">
                        <h1>
                            <span lang="nl-NL">Wachtwoord veranderen</span>
                            <span lang="en-US">Change a Password</span>
                        </h1>
                    </div>
                    {* #changePasswordForm *}
                    {* #currentPassword *}
                    {* #newPassword *}
                    {* #newPasswordConfirm *}
                    <div class="capture_footer">
                        <div class="capture_left">
                            <p>
                                <span lang="en-US"><a href="index.html?screenToRender=editProfile" class="capture_btn capture_primary">Back</a></span>
                                <span lang="nl-NL"><a href="index.html?screenToRender=editProfile" class="capture_btn capture_primary">Terug</a></span>
                            </p>
                        </div>
                        <div class="capture_right">
                            <span lang="en-US"><input value="Submit" type="submit" class="capture_btn capture_primary"></span>
                            <span lang="nl-NL"><input value="Versturen" type="submit" class="capture_btn capture_primary"></span>
                        </div>
                        {* /changePasswordForm *}
                    </div>
                </div>
                <div style="display:none;" id="changePasswordSuccessMessage">
                    <div class="capture_header">
                        <h1>
                            <span lang="en-US">Success</span>
                            <span lang="nl-NL">Succes!</span>
                        </h1>
                    </div>
                    <p>
                        <span lang="en-US">Your password has been successfully changed.</span>
                        <span lang="nl-NL">Uw wachtwoord is succesvol veranderd.</span>
                    </p>
                    <div class="capture_footer">
                        <p>
                            <span lang="en-US"><a href="http://eprofile.merck.com/preview/0024a3/merck-netherlands/index.html?screenToRender=editProfile" class="capture_btn capture_primary">Submit</a></span>
                            <span lang="nl-NL"><a href="http://eprofile.merck.com/preview/0024a3/merck-netherlands/index.html?screenToRender=editProfile" class="capture_btn capture_primary">Versturen</a></span>
                        </p>
                    </div>
                </div>
                <!--
                ============================================================================
                  EDIT PROFILE SCREENS:
                  The following screens are part of the profile editing user workflow.
                  For a complete out-of-the-box profile editing experience, these screens
                  must be included on the page where you are implementing profile editing
                  functionality.
                ============================================================================
                -->

                <!-- editProfile
                  This screen is where the user can edit their profile data. It can be
                  rendered in whatever way works best for your implementation, be it
                  using the data-capturescreen attribute, janrain.capture.ui.renderScreen
                  or passing in 'screenToRender' in the URL linking to the page where
                  you have implemented edit profile.
                -->
                <div style="display:none;" id="editProfile">
                    <h1>
                        <span lang="en-US">Edit Your Account</span>
                        <span lang="nl-NL">Bewerk uw account</span>
                    </h1>
                    <div class="capture_grid_block">
                        <div class="capture_col_4">
                            <!-- Only show this if it was from a traditional login !-->
                            <h3 class="janrain_traditional_account_only">
                                <span lang="en-US">Password</span>
                                <span lang="nl-NL">Wachtwoord</span>
                            </h3>
                            <div class="janrain_traditional_account_only contentBoxWhiteShadow">
                                <p>
                                    <span lang="en-US"><a href="#" data-capturescreen="changePassword">Change Password</a></span>
                                    <span lang="nl-NL"><a href="#" data-capturescreen="changePassword">Verander uw wachtwoord</a></span>
                                </p>
                            </div>
                        </div>

                        <div class="capture_col_8">
                            <h3>
                                <span lang="en-US">Account Info</span>
                                <span lang="nl-NL">Account informatie</span>
                            </h3>
                            <div class="contentBoxWhiteShadow">
                                <div class="capture_grid_block">
                                    <div class="capture_center_col capture_col_8">
                                        <div class="capture_editCol">
                                            {* #editProfileForm *}
                                            <!-- The following fields are required by default and must be included in the editProfileForm. In order to change any of these fields to optional, the Flow must be edited. -->
                                            {* #emailAddress *}
                                            {* #title *}
                                            {* #firstName *}
                                            {* #middleName *}
                                            {* #lastName *}
                                            {* #addressCity *}
                                            {* #addressPostalCode *}
                                            {* #gender *}
                                            {* #birthdate *}
                                            {* #phone *}
                                            {* #customerType *}
                                            {* #mainSpecialty *}
                                            {* #licenseNumber *}
                                            {* #brandedConsent *}
                                            <div class="capture_form_item">
                                                <span lang="en-US"><input value="Submit" type="submit" class="capture_btn capture_primary"></span>
                                                <span lang="nl-NL"><input value="Versturen" type="submit" class="capture_btn capture_primary"></span>
                                                {* #savedProfileMessage *}
                                            </div>
                                            {* /editProfileForm *}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Flow version:
                  This is a container for a debugging utility.  See showFlowVersion() and
                  the onCaptureRenderStart event handler in janrain-init.js.
                -->
                <div id="flow-version"></div>



                <div class="login__form clearfix">
                    <form name="loginform" id="loginform" action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
                        <div class="login__form-block">
                            <h1 class="login__caption">Inloggen <span>msd.nl</span></h1>
                        </div>
                        <div class="login__form-block">
                            <div class="login__form-row">
                                <div class="login__form-group login__form-group--wide">
                                    <label for="user_login" class="login__label">Gebruikersnaam *</label>
                                    <input type="text" id="user_login" name="log" value="<?php echo(isset($_POST['log']) ? $_POST['log'] : null); ?>" size="20" />
                                </div>
                            </div>
                            <div class="login__form-row">
                                <div class="login__form-group login__form-group--wide">
                                    <label for="user_pass" class="login__label">Wachtwoord *</label>
                                    <input id="user_pass" class="input" name="pwd" value="<?php echo(isset($_POST['pwd']) ? $_POST['pwd'] : null); ?>" size="20" type="password">
                                </div>
                            </div>
                            <?php $login = (isset($_GET['login']) ) ? $_GET['login'] : 0; ?>

                            <?php
                            if ($login === "failed") {
                                echo '<p class="is_error"><strong>ERROR:</strong> Invalid username and/or password.</p>';
                            } elseif ($login === "empty") {
                                echo '<p class="is_error"><strong>ERROR:</strong> Username and/or Password is empty.</p>';
                            }
                            ?>
                        </div>
                        <div class="login__form-block">
                            <?php $siteURL = get_site_url() ?>
                            <a class="login__link login__link--forgot-password" href="<?php echo $siteURL; ?>/lost-password">wachtwoord vergeten?</a>
                            <button type="submit" data-text="Inloggen" class="btn-style btn-style--light btn-style--small">
                                <span>Inloggen</span>
                                <?php /* <span>I</span><span>n</span><span>l</span><span>o</span><span>g</span><span>g</span><span>e</span><span>n</span> */ ?>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="login__text">
                    <?php while (have_posts()) : the_post(); ?> 

                        <?php the_content(); ?>

                        <?php
                    endwhile;
                    wp_reset_query();
                    ?>        
                </div>                
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
