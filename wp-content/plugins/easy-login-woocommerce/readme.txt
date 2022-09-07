=== Login/Signup Popup ( Inline Form + Woocommerce ) ===
Contributors: XootiX, xootixsupport
Donate link: https://www.paypal.me/xootix
Tags: woocommerce login popup, woocommerce signup popup, woocommerce login, woocommerce, login popup, signup, ajax login, ajax modal, login modal
Requires at least: 3.0.1
Tested up to: 5.4
Stable tag: 2.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allow users to login/signup anywhere from the site with the simple pop up.

== Description ==
[Live Demo](http://demo.xootix.com/easy-login-for-woocommerce/)
Login/Signup Popup is a simple & light weight plugin which allow users to login/signup anywhere from the site with the simple pop up without refreshing page.

### Features And Options:
* Supports Woocommerce
* Fully Ajaxed.
* Login , Sign up , Lost Password form.
* Login from anywere on the page using shortcode.
* Fully Customizable.
* WPML compatible

Try our OTP Login plugin [here](https://wordpress.org/plugins/mobile-login-woocommerce/)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/ directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Click on Login/Signup Popup on the dashboard.

== Frequently Asked Questions ==

= How to setup? =
1. Go to apperance->menus
2. Under Login Popup Tab , select the desired option.

= Shortcodes =
Use shortcode [xoo_el_action] to include it anywhere on the website.
To trigger particular form.
Login         - [xoo_el_action action="login"]
Registration  - [xoo_el_action action="register"]
Lost Password - [xoo_el_action action="lost-password"]

For Inline form
[xoo_el_inline_form active="register"]

You can also trigger popup using class.
Login         - xoo-el-login-tgr
Register      - xoo-el-reg-tgr
Lost Password - xoo-el-lostpw-tgr
For eg: <a class="xoo-el-login-tgr">Login</a>

= How to translate? =
1. Download PoEdit.
2. Open the easy-login-woocommerce.pot file in PoEdit. (/plugins/easy-login-woocommerce/languages/
   easy-login-woocommerce.pot)
3. Create new translation & translate the text.
4. Save the translated file with name "easy-login-woocommerce-Language_code". For eg: German(easy-login-woocommerce-de_DE)
   , French(easy-login-woocommerce-fr_FR). -- [Language code list](https://make.wordpress.org/polyglots/teams/)
5. Save Location: Your wordpress directory/wp-content/languages/


= How to override templates? =
Same way as you do for woocommerce.
Plugin template files are under easy-login-woocommerce/templates folder.
If you want to edit the template , say for login form. Template is xoo-el-login-section.php.
Create a woocommerce folder in your theme's directory & create a new file with name xoo-el-login-section.php , make the desired changes.


== Screenshots ==
1. Login Form.
2. Registration form with input validation
3. Lost password form.
4. Customize Fields
5. Settings
6. Settings


== Changelog ==
= 2.1 =
* New 	- Added option to replace woocommerce checkout login form
* Fix 	- Minor Bugs

= 2.0 =
*** MAJOR UPDATE ***
* New 	- WPML Compatible
* Tweak - Template Changes
* Tweak - Code Optimized
* Tweak - Fields Tab separated
* Fix 	- Inline Form always showing on the top
* Fix 	- Multiple IDs warning
* Fix 	- Popup Flashing on page load
* Fix 	- Minor Bugs

= 1.7 =
* Fix - Registration issue for non woocommerce users
* Fix - OTP login activate/deactivate issue

= 1.6 =
* New - Mailchimp integration
* New - Added attribute "display" & "change_to_text"in shortcode [xoo_el_action]
* Tweak - Generate username functionality more secured
* Minor improvements

= 1.5 =
* Fix - Security issue

= 1.4 =
* Added "Hello Firstname" for menu item
* Minor bug fixes

= 1.3 =
* Major Release.
* New - Form input icons.
* New - Remember me checkbox.
* New - Terms and conditions checkbox.
* Tweak - Template changes
* Tweak - Removed font awesome icons , added custom font icons.

= 1.2 =
* Fix - Not working on mobile devices.
* New - Sidebar Image.
* New - Popup animation.

= 1.1 =
* Fix - Not working on mobile devices.
* New - Extra input padding.

= 1.0.0 =
* Initial Public Release.