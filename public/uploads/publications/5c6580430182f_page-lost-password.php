<?php
/*
  Template Name: Lost Password Page
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['user_login'])) {
        sendResetPasswordLinkByEmail($_POST['user_login']);
        // exit;   
    }elseif(isset($_POST['username'])){
        sendResetPasswordLinkByUser($_POST['username'], $_POST['user_multi_email']);
        // exit;
    }

    
}else{
    echoResetPasswordForm();
}

function reset_password_message($user_data) {
        // if (!empty($_POST['user_login'])) {
        //     $user_data = get_user_by('email', trim($_POST['user_login']));
        // } else {
        //     $login = trim($_POST['user_login']);
        //     $user_data = get_user_by('login', $login);
        // }
        
        $user_login = $user_data->user_login;

        $key = get_password_reset_key($user_data);
        update_user_meta($user_data->ID, 'reset_pass_time', time(), $prev_value = '');

        $msg = __('The password for the following account has been requested to be reset:') . "\r\n\r\n";
        $msg .= network_site_url() . "\r\n\r\n";
        $msg .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $msg .= __('If this message was sent in error, please ignore this email.') . "\r\n\r\n";
        $msg .= __('To reset your password, visit the following address:');
        $msg .= network_site_url("reset-password?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";
        $msg .= __('Please be aware that the link will be valid for 30 minutes after which you will need to send another link.');

        return $msg;
    }

function sendResetPasswordLinkByEmail($email){
    $allowedEmails = get_option('c2c_allow_multiple_accounts')['emails'];
    
    if (in_array($email, $allowedEmails)) {
        $user = c2c_get_users_by_email($email);
        // $user_data = get_users(array('search' => $_POST['user_login']));
        // echo '<pre>'; var_dump($user); exit;
    }else{
        $user = get_user_by('email', $email);
    }

    if (is_array($user)) {
        echoResetPasswordForm(true, $email);
        exit;
    }


    $resetPasswordTimer = get_user_meta($user->ID, 'reset_pass_time')[0];
    
    if (empty($_POST['user_login'])) {
        $error = 'Email is required';
        echoResetPasswordForm(false, '', $error);
    } else if (empty($user)) {
        $error = 'No user with given email';
        echoResetPasswordForm(false, '', $error);
    } else if (!empty($user) && !(time() - $resetPasswordTimer > 10)) {
//    } else if (!empty($user) && !empty($user->user_activation_key)) {
        $error = 'You\'ve already sent a request for new password.';
        echoResetPasswordForm(false, '', $error);
    } else {
        wp_mail($_POST['user_login'], '[msd] Password Reset', reset_password_message($user));
        wp_safe_redirect(get_option('home') . '/wp-login.php?action=lostpassword');
        exit;
    }
}

function sendResetPasswordLinkByUser($username, $email){
    $allowedEmails = c2c_get_users_by_email($email);
    foreach ($allowedEmails as $user) {
        if(strtolower($user->user_login) == strtolower($username)){
            wp_mail($email, '[msd] Password Reset', reset_password_message($user));
            wp_safe_redirect(get_option('home') . '/wp-login.php?action=lostpassword');
            exit;
        }
    }
    $error = 'User doesn\'t exist';
    echoResetPasswordForm(true, $email, $error);
}

$users = get_users();
global $wpdb;
foreach ($users as $user) {
    if ($user->ID != 0) {
        $resetPasswordTimer = get_user_meta($user->ID, 'reset_pass_time')[0];
        $date = new DateTime();
        if ($resetPasswordTimer == "") {
            update_user_meta($user->ID, 'reset_pass_time', strtotime($date->setTimestamp(0)->format('d-m-Y H:i:s')));
        }

        if (isset($resetPasswordTimer) && !empty($resetPasswordTimer) && (time() - $resetPasswordTimer > 1800)) {
            update_user_meta($user->ID, 'reset_pass_time', strtotime($date->setTimestamp(0)->format('d-m-Y H:i:s')));
            $resetQuery = $wpdb->query(
                    $wpdb->prepare(
                            "UPDATE wp_users SET user_activation_key = '' WHERE user_login = %s AND user_activation_key = %s", $user->user_login, $user->user_activation_key
                    )
            );
        }
    }
}
?>

<?php function echoResetPasswordForm($multipleUsers = false, $email = '', $error = null){ ?>
    <?php if ($multipleUsers) {
        $emailInput = '<input type="hidden" name="user_multi_email" value="' . esc_attr($email)  . '"/>';
        $userInput =  '<p>Multiple users detected on this email, please enter your username below</p><label for="username" class="login__label"></label>Username *<input type="text" name="username"/>';
    }else{
        $emailInput = '<label for="user_login" class="login__label">Email *</label><input type="text" name="user_login" value="' . esc_attr($email)  . '"/>';
    }
    
    ?>
    <?php get_header('no-submeni'); ?>

<?php $invalidKey = (isset($_GET['errors']) ? $_GET['errors'] : 0) ?>
<?php if ($invalidKey === 'invalidkey') { ?>
    <div class="note open alert alert-info">
        <?php echo 'Invalid reset password key.' ?>
    </div>
<?php } ?>
<?php if ($invalidKey === 'expiredkey') { ?>
    <div class="note open alert alert-info">
        <?php echo 'Your password reset link has expired.' ?>
    </div>
<?php } ?>
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
                <div class="login__form clearfix">
                    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
                        <div class="login__form-block">
                            <h1 class="login__caption">Wachtwoord vergeten <span>msdoncology.nl</span></h1>
                        </div>

                        <div class="login__form-block">
                            <div class="login__form-row">
                                <div class="login__form-group login__form-group--wide">
                                    <?php 
                                    echo $emailInput; 
                                    echo isset($userInput) ? $userInput : '';
                                    ?>
                                    <p class="is_error"><?php echo $error ?></p>
                                </div>
                            </div>
                            <div class="login__form-block">
                                <button type="submit" name="submit" data-text="Nieuw wachtwoord aanmaken" value="reset" class="btn-style btn-style--light btn-style--small">
                                    <span>Nieuw wachtwoord aanmaken</span>
                                    <?php /* <span>N</span><span>i</span><span>e</span><span>u</span><span>w</span><span>&nbsp;</span><span>w</span><span>a</span><span>c</span><span>h</span><span>t</span><span>w</span><span>o</span><span>o</span><span>r</span><span>d</span><span>&nbsp;</span><span>a</span><span>a</span><span>n</span><span>m</span><span>a</span><span>k</span><span>e</span><span>n</span> */ ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="login__text">
                    <a class="login__link" href="<?php get_site_url() ?>/registratie">Account aanmaken</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer() ?>
<?php } ?>

