<?php
/*
  Plugin Name: Volunteer Registration
  Plugin URI: 
  Description: Volunteer Registration
  Version: 1.1
  Author: Ajit Prabhakar
  Author URI: https://apbhkr.wordpress.com
*/

class Volunteer_registration_form
{
    private $username;
    private $email;
    private $phone;
    private $password;
    private $website;
    private $first_name;
    private $last_name;
    private $nickname;
    private $bio;

    function __construct()
    {
       add_shortcode('volunteer_registration_form', array($this, 'shortcode'));
    }

    public function registration_form()
    {
        ?>

        <form method="post" action="<?php echo esc_url_raw($_SERVER['REQUEST_URI']); ?>">
            <div class="login-form">
                <div class="form-group">
                    <input name="reg_name" type="text" class="form-control login-field"
                           value="<?php echo esc_html(isset($_POST['reg_name']) ? $_POST['reg_name'] : null); ?>"
                           placeholder="Username" id="reg-name" required/>
                    <label class="login-field-icon fui-user" for="reg-name"></label>
                </div>

                <div class="form-group">
                    <input name="reg_email" type="email" class="form-control login-field"
                           value="<?php echo esc_attr(isset($_POST['reg_email']) ? $_POST['reg_email'] : null); ?>"
                           placeholder="Email" id="reg-email" required/>
                    <label class="login-field-icon fui-mail" for="reg-email"></label>
                </div>
			<?php //$ph = intval($_POST['phone']); ?>
                <div class="form-group">
                    <input name="phone" type="number" class="form-control login-field"
                           value="<?php echo esc_attr(isset($_POST['phone']) ? $_POST['phone'] : null); ?>"
                           placeholder="Phone Number" id="reg-phone" required/>
                    <label class="login-field-icon fui-lock" for="reg-phone"></label>
                </div>

                <div class="form-group">
                    <input name="reg_password" type="password" class="form-control login-field"
                           value="<?php echo esc_attr(isset($_POST['reg_password']) ? $_POST['reg_password'] : null); ?>"
                           placeholder="Password" id="reg-pass" required/>
                    <label class="login-field-icon fui-lock" for="reg-pass"></label>
                </div>
                
                <div class="form-group">
                    <input name="reg_website" type="text" class="form-control login-field"
                           value="<?php echo esc_url_raw(isset($_POST['reg_website']) ? $_POST['reg_website'] : null); ?>"
                           placeholder="Website" id="reg-website"/>
                    <label class="login-field-icon fui-chat" for="reg-website"></label>
                </div>

                <div class="form-group">
                    <input name="reg_fname" type="text" class="form-control login-field"
                           value="<?php echo esc_attr(isset($_POST['reg_fname']) ? $_POST['reg_fname'] : null); ?>"
                           placeholder="First Name" id="reg-fname"/>
                    <label class="login-field-icon fui-user" for="reg-fname"></label>
                </div>

                <div class="form-group">
                    <input name="reg_lname" type="text" class="form-control login-field"
                           value="<?php echo esc_attr(isset($_POST['reg_lname']) ? $_POST['reg_lname'] : null); ?>"
                           placeholder="Last Name" id="reg-lname"/>
                    <label class="login-field-icon fui-user" for="reg-lname"></label>
                </div>

                <div class="form-group">
                    <input name="reg_nickname" type="text" class="form-control login-field"
                           value="<?php echo esc_html(isset($_POST['reg_nickname']) ? $_POST['reg_nickname'] : null); ?>"
                           placeholder="Nickname" id="reg-nickname"/>
                    <label class="login-field-icon fui-user" for="reg-nickname"></label>
                </div>

                <div class="form-group">
                    <input name="reg_bio" type="text" class="form-control login-field"
                           value="<?php echo esc_html(isset($_POST['reg_bio']) ? $_POST['reg_bio'] : null); ?>"
                           placeholder="About / Bio" id="reg-bio"/>
                    <label class="login-field-icon fui-new" for="reg-bio"></label>
                </div>

                <input class="btn btn-primary btn-lg btn-block" type="submit" name="reg_submit" value="Register"/>
        </form>
        </div>
    <?php
    }

    function validation()
    {

        if (empty($this->username) || empty($this->password) || empty($this->email) || empty($this->phone)) {
            return new WP_Error('field', 'Required form field is missing');
        }

        if (strlen($this->username) < 4) {
            return new WP_Error('username_length', 'Username too short. At least 4 characters is required');
        }

        if (strlen($this->password) < 5) {
            return new WP_Error('password', 'Password length must be greater than 5');
        }

        if (!is_email($this->email)) {
            return new WP_Error('email_invalid', 'Email is not valid');
        }

        if (email_exists($this->email)) {
            return new WP_Error('email', 'Email Already in use');
        }

        if (!empty($website)) {
            if (!filter_var($this->website, FILTER_VALIDATE_URL)) {
                return new WP_Error('website', 'Website is not a valid URL');
            }
        }

        $details = array('Username' => $this->username,
            'First Name' => $this->first_name,
            'Last Name' => $this->last_name,
            'Nickname' => $this->nickname,
            'bio' => $this->bio
        );

        foreach ($details as $field => $detail) {
            if (!validate_username($detail)) {
                return new WP_Error('name_invalid', 'Sorry, the "' . $field . '" you entered is not valid');
            }
        }

    }

    function registration()
    {

        $userdata = array(
            'user_login' => sanitize_user($this->username),
            'user_email' => sanitize_email($this->email),
            'phone' => intval($this->phone),
            'user_pass' => sanitize_text_field($this->password),
            'user_url' => esc_url_raw($this->website),
            'first_name' => sanitize_text_field($this->first_name),
            'last_name' => sanitize_text_field($this->last_name),
            'nickname' => sanitize_text_field($this->nickname),
            'description' => sanitize_text_field($this->bio),
        );

        if (is_wp_error($this->validation())) {
            echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger">';
            echo '<strong>' . $this->validation()->get_error_message() . '</strong>';
            echo '</div>';
        } else {
            $register_user = wp_insert_user($userdata);
            if (!is_wp_error($register_user)) {

                echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger">';
                echo '<strong>Registration complete. Goto <a href="' . wp_login_url() . '">login page</a></strong>';
                echo '</div>';
            } else {
                echo '<div style="margin-bottom: 6px" class="btn btn-block btn-lg btn-danger">';
                echo '<strong>' . $register_user->get_error_message() . '</strong>';
                echo '</div>';
            }
        }

    }

    function shortcode()
    {
        ob_start();

        if ($_POST['reg_submit']) {
            $this->username = sanitize_user($_POST['reg_name']);
            $this->email = sanitize_email($_POST['reg_email']);
            $this->phone = intval($_POST['phone']);
            $this->password = sanitize_text_field($_POST['reg_password']);
            $this->website = esc_url_raw($_POST['reg_website']);
            $this->first_name = sanitize_text_field($_POST['reg_fname']);
            $this->last_name = sanitize_text_field($_POST['reg_lname']);
            $this->nickname = sanitize_text_field($_POST['reg_nickname']);
            $this->bio = sanitize_text_field($_POST['reg_bio']);

            $this->validation();
            $this->registration();
        }

        $this->registration_form();
        return ob_get_clean();
    }

}

new Volunteer_registration_form;
