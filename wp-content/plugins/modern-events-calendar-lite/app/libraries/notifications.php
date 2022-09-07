<?php
/** no direct access **/
defined('MECEXEC') or die();

/**
 * Webnus MEC notifications class
 * @author Webnus <info@webnus.biz>
 */
class MEC_notifications extends MEC_base
{
    public $main;
    public $PT;
    public $notif_settings;
    public $settings;
    public $book;

    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        // Import MEC Main
        $this->main = $this->getMain();

        // MEC Book Post Type Name
        $this->PT = $this->main->get_book_post_type();

        // MEC Notification Settings
        $this->notif_settings = $this->main->get_notifications();

        // MEC Settings
        $this->settings = $this->main->get_settings();

        // MEC Book
        $this->book = $this->getBook();
    }

    /**
     * Send email verification notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return boolean
     */
    public function email_verification($book_id)
    {
        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);

        if(!isset($booker->user_email)) return false;

        $price = get_post_meta($book_id, 'mec_price', true);

        // Auto verification for free bookings is enabled so don't send the verification email
        if($price <= 0 and isset($this->settings['booking_auto_verify_free']) and $this->settings['booking_auto_verify_free'] == 1) return false;

        // Auto verification for paid bookings is enabled so don't send the verification email
        if($price > 0 and isset($this->settings['booking_auto_verify_paid']) and $this->settings['booking_auto_verify_paid'] == 1) return false;

        $subject = isset($this->notif_settings['email_verification']['subject']) ? $this->content(__($this->notif_settings['email_verification']['subject'], 'modern-events-calendar-lite'), $book_id) : __('Please verify your email.', 'modern-events-calendar-lite');
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $recipients_str = isset($this->notif_settings['email_verification']['recipients']) ? $this->notif_settings['email_verification']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

        $users = isset($this->notif_settings['email_verification']['receiver_users']) ? $this->notif_settings['email_verification']['receiver_users'] : array();
        $users_down = $this->main->get_emails_by_users($users);
        $recipients = array_merge($users_down, $recipients);

        $roles = isset($this->notif_settings['email_verification']['receiver_roles']) ? $this->notif_settings['email_verification']['receiver_roles'] : array();
        $user_roles = $this->main->get_emails_by_roles($roles);
        $recipients = array_merge($user_roles, $recipients);

        // Unique Recipients
        $recipients = array_unique($recipients);

        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

            $headers[] = 'BCC: '.$recipient;
        }

        // Attendees
        $attendees = get_post_meta($book_id, 'mec_attendees', true);
        if(!is_array($attendees) or (is_array($attendees) and !count($attendees))) $attendees = array(get_post_meta($book_id, 'mec_attendee', true));

        // Do not send email twice!
        $done_emails = array();

        // Book Data
        $key = get_post_meta($book_id, 'mec_verification_key', true);
        $event_id = get_post_meta($book_id, 'mec_event_id', true);
        $link = trim(get_permalink($event_id), '/').'/verify/'.$key.'/';

        // Changing some sender email info.
        $this->mec_sender_email_notification_filter();

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the emails
        foreach($attendees as $attendee)
        {
            $to = isset($attendee['email']) ? $attendee['email'] : '';
            if(!trim($to) or in_array($to, $done_emails) or !filter_var($to, FILTER_VALIDATE_EMAIL)) continue;

            $message = isset($this->notif_settings['email_verification']['content']) ? $this->content($this->notif_settings['email_verification']['content'], $book_id, $attendee) : '';
            $message = str_replace('%%verification_link%%', $link, $message);
            $message = str_replace('%%link%%', $link, $message);

            $message = $this->add_template($message);

            // Filter the email
            $mail_arg = array(
                'to'            => $to,
                'subject'       => $subject,
                'message'       => $message,
                'headers'       => $headers,
                'attachments'   => array(),
            );

            $mail_arg = apply_filters('mec_before_send_email_verification', $mail_arg, $book_id, 'email_verification');

            // Send the mail
            wp_mail($mail_arg['to'], html_entity_decode(stripslashes($mail_arg['subject']), ENT_HTML5), wpautop(stripslashes($mail_arg['message'])), $mail_arg['headers'], $mail_arg['attachments']);

            // For prevention of email repeat send
            $done_emails[] = $to;
        }

        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }

    /**
     * Send booking notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return boolean
     */
    public function booking_notification($book_id)
    {
        $booking_notification = apply_filters('mec_booking_notification', true);
        if(!$booking_notification) return false;

        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);

        if(!isset($booker->user_email)) return false;

        // Booking Notification is disabled
        if(isset($this->notif_settings['booking_notification']['status']) and !$this->notif_settings['booking_notification']['status']) return false;

        $subject = isset($this->notif_settings['booking_notification']['subject']) ? $this->content(__($this->notif_settings['booking_notification']['subject'], 'modern-events-calendar-lite'), $book_id) : __('Your booking is received.', 'modern-events-calendar-lite');
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $recipients_str = isset($this->notif_settings['booking_notification']['recipients']) ? $this->notif_settings['booking_notification']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

        $users = isset($this->notif_settings['booking_notification']['receiver_users']) ? $this->notif_settings['booking_notification']['receiver_users'] : array();
        $users_down = $this->main->get_emails_by_users($users);
        $recipients = array_merge($users_down, $recipients);

        $roles = isset($this->notif_settings['booking_notification']['receiver_roles']) ? $this->notif_settings['booking_notification']['receiver_roles'] : array();
        $user_roles = $this->main->get_emails_by_roles($roles);
        $recipients = array_merge($user_roles, $recipients);

        // Unique Recipients
        $recipients = array_unique($recipients);

        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

            $headers[] = 'BCC: '.$recipient;
        }

        // Send the notification to event organizer
        if(isset($this->notif_settings['booking_notification']['send_to_organizer']) and $this->notif_settings['booking_notification']['send_to_organizer'] == 1)
        {
            $organizer_email = $this->get_booking_organizer_email($book_id);
            if($organizer_email !== false) $headers[] = 'BCC: '.trim($organizer_email);
        }

        // Attendees
        $attendees = get_post_meta($book_id, 'mec_attendees', true);
        if(!is_array($attendees) or (is_array($attendees) and !count($attendees))) $attendees = array(get_post_meta($book_id, 'mec_attendee', true));

        // Do not send email twice!
        $done_emails = array();

        // Changing some sender email info.
        $this->mec_sender_email_notification_filter();

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the emails
        foreach($attendees as $attendee)
        {
            $to = isset($attendee['email']) ? $attendee['email'] : '';
            if(!trim($to) or in_array($to, $done_emails) or !filter_var($to, FILTER_VALIDATE_EMAIL)) continue;

            $message = isset($this->notif_settings['booking_notification']['content']) ? $this->content($this->notif_settings['booking_notification']['content'], $book_id, $attendee) : '';
            $message = $this->add_template($message);

            // Filter the email
            $mail_arg = array(
                'to'            => $to,
                'subject'       => $subject,
                'message'       => $message,
                'headers'       => $headers,
                'attachments'   => array(),
            );

            $mail_arg = apply_filters( 'mec_before_send_booking_notification', $mail_arg, $book_id, 'booking_notification');

            // Send the mail
            wp_mail($mail_arg['to'], html_entity_decode(stripslashes($mail_arg['subject']), ENT_HTML5), wpautop(stripslashes($mail_arg['message'])), $mail_arg['headers'], $mail_arg['attachments']);

            // For prevention of email repeat send
            $done_emails[] = $to;
        }

        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }

    /**
     * Send booking confirmation notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @param string $mode
     * @return boolean
     */
    public function booking_confirmation($book_id, $mode = 'manually')
    {
        // Booking Confirmation is disabled
        if(isset($this->notif_settings['booking_confirmation']['status']) and !$this->notif_settings['booking_confirmation']['status']) return false;

        $confirmation_notification = apply_filters('mec_booking_confirmation', true);
        if(!$confirmation_notification) return false;

        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);

        if(!isset($booker->user_email)) return false;

        $send_email_state =  (isset($this->settings['booking_auto_confirm_send_email']) and $this->settings['booking_auto_confirm_send_email'] == '1') ? true : false;

        // Don't send the confirmation email
        if($mode == 'auto' and !$send_email_state) return false;

        $subject = isset($this->notif_settings['booking_confirmation']['subject']) ? $this->content(__($this->notif_settings['booking_confirmation']['subject'], 'modern-events-calendar-lite'), $book_id) : __('Your booking is confirmed.', 'modern-events-calendar-lite');
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $recipients_str = isset($this->notif_settings['booking_confirmation']['recipients']) ? $this->notif_settings['booking_confirmation']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

        $users = isset($this->notif_settings['booking_confirmation']['receiver_users']) ? $this->notif_settings['booking_confirmation']['receiver_users'] : array();
        $users_down = $this->main->get_emails_by_users($users);
        $recipients = array_merge($users_down, $recipients);

        $roles = isset($this->notif_settings['booking_confirmation']['receiver_roles']) ? $this->notif_settings['booking_confirmation']['receiver_roles'] : array();
        $user_roles = $this->main->get_emails_by_roles($roles);
        $recipients = array_merge($user_roles, $recipients);

        // Unique Recipients
        $recipients = array_unique($recipients);

        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

            $headers[] = 'BCC: '.$recipient;
        }

        // Attendees
        $attendees = get_post_meta($book_id, 'mec_attendees', true);
        if(!is_array($attendees) or (is_array($attendees) and !count($attendees))) $attendees = array(get_post_meta($book_id, 'mec_attendee', true));

        // Do not send email twice!
        $done_emails = array();

        // Changing some sender email info.
        $this->mec_sender_email_notification_filter();

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the emails
        foreach($attendees as $attendee)
        {
            $to = isset($attendee['email']) ? $attendee['email'] : '';
            if(!trim($to) or in_array($to, $done_emails) or !filter_var($to, FILTER_VALIDATE_EMAIL)) continue;

            $message = isset($this->notif_settings['booking_confirmation']['content']) ? $this->content($this->notif_settings['booking_confirmation']['content'], $book_id, $attendee) : '';
            $message = $this->add_template($message);

            // Filter the email
            $mail_arg = array(
                'to'            => $to,
                'subject'       => $subject,
                'message'       => $message,
                'headers'       => $headers,
                'attachments'   => array(),
            );

            $mail_arg = apply_filters( 'mec_before_send_booking_confirmation', $mail_arg, $book_id, 'booking_confirmation');

            // Send the mail
            wp_mail($mail_arg['to'], html_entity_decode(stripslashes($mail_arg['subject']), ENT_HTML5), wpautop(stripslashes($mail_arg['message'])), $mail_arg['headers'], $mail_arg['attachments']);

            // Send One Single Email Only To First Attendee
            if(isset($this->notif_settings['booking_confirmation']['send_single_one_email'])) break;

            // For prevention of email repeat send
            $done_emails[] = $to;
        }

        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }

      /**
     * Send booking cancellation
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return void
     */
    public function booking_cancellation($book_id)
    {
        $cancellation_notification = apply_filters('mec_booking_cancellation', true);
        if(!$cancellation_notification) return;

        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);

        // Cancelling Notification is disabled
        if(!isset($this->notif_settings['cancellation_notification']['status']) or isset($this->notif_settings['cancellation_notification']['status']) and !$this->notif_settings['cancellation_notification']['status']) return;

        $tos = array();

        // Send the notification to admin
        if(isset($this->notif_settings['cancellation_notification']['send_to_admin']) and $this->notif_settings['cancellation_notification']['send_to_admin'] == 1)
        {
            $tos[] = get_bloginfo('admin_email');
        }

        // Send the notification to event organizer
        if(isset($this->notif_settings['cancellation_notification']['send_to_organizer']) and $this->notif_settings['cancellation_notification']['send_to_organizer'] == 1)
        {
            $organizer_email = $this->get_booking_organizer_email($book_id);
            if($organizer_email !== false) $tos[] = trim($organizer_email);
        }

        // Send the notification to event user
        if(isset($this->notif_settings['cancellation_notification']['send_to_user']) and $this->notif_settings['cancellation_notification']['send_to_user'] == 1)
        {
            if(isset($booker->user_email) and $booker->user_email)
            {
                // Attendees
                $attendees = get_post_meta($book_id, 'mec_attendees', true);
                if(!is_array($attendees) or (is_array($attendees) and !count($attendees))) $attendees = array(get_post_meta($book_id, 'mec_attendee', true));

                // For When sended email time, And  prevention of email repeat send
                $done_emails = array();

                // Send the emails
                foreach($attendees as $attendee)
                {
                    if(isset($attendee['email']) and !in_array($attendee['email'], $done_emails))
                    {
                        $tos[] = $attendee;
                        $done_emails[] = $attendee['email'];
                    }
                }
            }
        }

        // No Recipient
        if(!count($tos)) return;

        $headers = array('Content-Type: text/html; charset=UTF-8');

        $recipients_str = isset($this->notif_settings['cancellation_notification']['recipients']) ? $this->notif_settings['cancellation_notification']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

        $users = isset($this->notif_settings['cancellation_notification']['receiver_users']) ? $this->notif_settings['cancellation_notification']['receiver_users'] : array();
        $users_down = $this->main->get_emails_by_users($users);
        $recipients = array_merge($users_down, $recipients);

        $roles = isset($this->notif_settings['cancellation_notification']['receiver_roles']) ? $this->notif_settings['cancellation_notification']['receiver_roles'] : array();
        $user_roles = $this->main->get_emails_by_roles($roles);
        $recipients = array_merge($user_roles, $recipients);

        // Unique Recipients
        $recipients = array_unique($recipients);

        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

            $headers[] = 'BCC: '.$recipient;
        }

        $subject = isset($this->notif_settings['cancellation_notification']['subject']) ? $this->content(__($this->notif_settings['cancellation_notification']['subject'], 'modern-events-calendar-lite'), $book_id) : __('booking canceled.', 'modern-events-calendar-lite');

        // Changing some sender email info.
        $this->mec_sender_email_notification_filter();

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the mail
        $i = 1;
        foreach($tos as $to)
        {
            $mailto = (is_array($to) and isset($to['email'])) ? $to['email'] : $to;

            if(!trim($mailto) or !filter_var($mailto, FILTER_VALIDATE_EMAIL)) continue;
            if($i > 1) $headers = array('Content-Type: text/html; charset=UTF-8');

            $message = isset($this->notif_settings['cancellation_notification']['content']) ? $this->content($this->notif_settings['cancellation_notification']['content'], $book_id, (is_array($to) ? $to : NULL)) : '';

            // Book Data
            $message = str_replace('%%admin_link%%', $this->link(array('post_type'=>$this->main->get_book_post_type()), $this->main->URL('admin').'edit.php'), $message);

            $message = $this->add_template($message);

            // Filter the email
            $mail_arg = array(
                'to'            => $mailto,
                'subject'       => $subject,
                'message'       => $message,
                'headers'       => $headers,
                'attachments'   => array(),
            );

            $mail_arg = apply_filters( 'mec_before_send_booking_cancellation', $mail_arg, $book_id, 'booking_cancellation');

            // Send the mail
            wp_mail($mail_arg['to'], html_entity_decode(stripslashes($mail_arg['subject']), ENT_HTML5), wpautop(stripslashes($mail_arg['message'])), $mail_arg['headers'], $mail_arg['attachments']);

            $i++;
        }

        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));
    }

    /**
     * Send admin notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return void
     */
    public function admin_notification($book_id)
    {
        // Admin Notification is disabled
        if(isset($this->notif_settings['admin_notification']['status']) and !$this->notif_settings['admin_notification']['status']) return;

        $to = get_bloginfo('admin_email');
        $subject = isset($this->notif_settings['admin_notification']['subject']) ? $this->content(__($this->notif_settings['admin_notification']['subject'], 'modern-events-calendar-lite'), $book_id) : __('A new booking is received.', 'modern-events-calendar-lite');
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $recipients_str = isset($this->notif_settings['admin_notification']['recipients']) ? $this->notif_settings['admin_notification']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

        $users = isset($this->notif_settings['admin_notification']['receiver_users']) ? $this->notif_settings['admin_notification']['receiver_users'] : array();
        $users_down = $this->main->get_emails_by_users($users);
        $recipients = array_merge($users_down, $recipients);

        $roles = isset($this->notif_settings['admin_notification']['receiver_roles']) ? $this->notif_settings['admin_notification']['receiver_roles'] : array();
        $user_roles = $this->main->get_emails_by_roles($roles);
        $recipients = array_merge($user_roles, $recipients);

        // Unique Recipients
        $recipients = array_unique($recipients);

        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

            $headers[] = 'CC: '.$recipient;
        }

        // Send the notification to event organizer
        if(isset($this->notif_settings['admin_notification']['send_to_organizer']) and $this->notif_settings['admin_notification']['send_to_organizer'] == 1)
        {
            $organizer_email = $this->get_booking_organizer_email($book_id);
            if($organizer_email !== false) $headers[] = 'CC: '.trim($organizer_email);
        }

        $message = isset($this->notif_settings['admin_notification']['content']) ? $this->content($this->notif_settings['admin_notification']['content'], $book_id) : '';

        // Book Data
        $message = str_replace('%%admin_link%%', $this->link(array('post_type'=>$this->main->get_book_post_type()), $this->main->URL('admin').'edit.php'), $message);

        // Changing some sender email info.
        $this->mec_sender_email_notification_filter();

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        $message = $this->add_template($message);

        // Filter the email
        $mail_arg = array(
            'to'            => $to,
            'subject'       => $subject,
            'message'       => $message,
            'headers'       => $headers,
            'attachments'   => array(),
        );
        $mail_arg = apply_filters( 'mec_before_send_admin_notification', $mail_arg, $book_id, 'admin_notification');

        // Send the mail
        wp_mail($mail_arg['to'], html_entity_decode(stripslashes($mail_arg['subject']), ENT_HTML5), wpautop(stripslashes($mail_arg['message'])), $mail_arg['headers'], $mail_arg['attachments']);

        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));
    }

    /**
     * Send booking reminder notification
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return boolean
     */
    public function booking_reminder($book_id)
    {
        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);

        if(!isset($booker->user_email)) return false;

        $subject = isset($this->notif_settings['booking_reminder']['subject']) ? $this->content(__($this->notif_settings['booking_reminder']['subject'], 'modern-events-calendar-lite'), $book_id) : __('Booking Reminder', 'modern-events-calendar-lite');
        $headers = array('Content-Type: text/html; charset=UTF-8');

        $recipients_str = isset($this->notif_settings['booking_reminder']['recipients']) ? $this->notif_settings['booking_reminder']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

        $users = isset($this->notif_settings['booking_reminder']['receiver_users']) ? $this->notif_settings['booking_reminder']['receiver_users'] : array();
        $users_down = $this->main->get_emails_by_users($users);
        $recipients = array_merge($users_down, $recipients);

        $roles = isset($this->notif_settings['booking_reminder']['receiver_roles']) ? $this->notif_settings['booking_reminder']['receiver_roles'] : array();
        $user_roles = $this->main->get_emails_by_roles($roles);
        $recipients = array_merge($user_roles, $recipients);

        // Unique Recipients
        $recipients = array_unique($recipients);

        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

            $headers[] = 'BCC: '.$recipient;
        }

        // Attendees
        $attendees = get_post_meta($book_id, 'mec_attendees', true);
        if(!is_array($attendees) or (is_array($attendees) and !count($attendees))) $attendees = array(get_post_meta($book_id, 'mec_attendee', true));

        // Changing some sender email info.
        $this->mec_sender_email_notification_filter();

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the emails
        foreach($attendees as $attendee)
        {
            if(isset($attendee[0]['MEC_TYPE_OF_DATA'])) continue;

            $to = $attendee['email'];
            $message = isset($this->notif_settings['booking_reminder']['content']) ? $this->content($this->notif_settings['booking_reminder']['content'], $book_id, $attendee) : '';

            if(!trim($to)) continue;

            $message = $this->add_template($message);

            // Filter the email
            $mail_arg = array(
                'to'            => $to,
                'subject'       => $subject,
                'message'       => $message,
                'headers'       => $headers,
                'attachments'   => array(),
            );

            $mail_arg = apply_filters('mec_before_send_booking_reminder', $mail_arg, $book_id, 'booking_reminder');

            // Send the mail
            wp_mail($mail_arg['to'], html_entity_decode(stripslashes($mail_arg['subject']), ENT_HTML5), wpautop(stripslashes($mail_arg['message'])), $mail_arg['headers'], $mail_arg['attachments']);
        }

        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }

    /**
     * Send new event notification
     * @author Webnus <info@webnus.biz>
     * @param int $event_id
     * @param boolean $update
     * @return boolean
     */
    public function new_event($event_id, $update = false)
    {
        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if(defined('DOING_AUTOSAVE') and DOING_AUTOSAVE) return false;

        // MEC Event Post Type
        $event_PT = $this->main->get_main_post_type();

        // If it's not a MEC Event
        if(get_post_type($event_id) != $event_PT) return false;

        // If it's an update request, then don't send any notification
        if($update) return false;

        // New event notification is disabled
        if(!isset($this->notif_settings['new_event']['status']) or (isset($this->notif_settings['new_event']['status']) and !$this->notif_settings['new_event']['status'])) return false;

        $status = get_post_status($event_id);

        // Don't send the email if it's auto draft post
        if($status == 'auto-draft') return false;

        $to = (!isset($this->notif_settings['new_event']['send_to_admin']) or (isset($this->notif_settings['new_event']['send_to_admin']) and $this->notif_settings['new_event']['send_to_admin'])) ? get_bloginfo('admin_email') : NULL;

        $recipients_str = isset($this->notif_settings['new_event']['recipients']) ? $this->notif_settings['new_event']['recipients'] : '';
        $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

        $users = isset($this->notif_settings['new_event']['receiver_users']) ? $this->notif_settings['new_event']['receiver_users'] : array();
        $users_down = $this->main->get_emails_by_users($users);
        $recipients = array_merge($users_down, $recipients);

        $roles = isset($this->notif_settings['new_event']['receiver_roles']) ? $this->notif_settings['new_event']['receiver_roles'] : array();
        $user_roles = $this->main->get_emails_by_roles($roles);
        $recipients = array_merge($user_roles, $recipients);

        // Unique Recipients
        $recipients = array_unique($recipients);

        if(is_null($to) and !count($recipients)) return false;
        else if(is_null($to))
        {
            $to = current($recipients);
            unset($recipients[0]);
        }

        $subject = (isset($this->notif_settings['new_event']['subject']) and trim($this->notif_settings['new_event']['subject'])) ? __($this->notif_settings['new_event']['subject'], 'modern-events-calendar-lite') : __('A new event is added.', 'modern-events-calendar-lite');
        $headers = array('Content-Type: text/html; charset=UTF-8');

        foreach($recipients as $recipient)
        {
            // Skip if it's not a valid email
            if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

            $headers[] = 'CC: '.$recipient;
        }

        $message = (isset($this->notif_settings['new_event']['content']) and trim($this->notif_settings['new_event']['content'])) ? $this->notif_settings['new_event']['content'] : '';

        // Site Data
        $message = str_replace('%%blog_name%%', get_bloginfo('name'), $message);
        $message = str_replace('%%blog_url%%', get_bloginfo('url'), $message);
        $message = str_replace('%%blog_description%%', get_bloginfo('description'), $message);

        // Event Data
        $message = str_replace('%%admin_link%%', $this->link(array('post_type'=>$event_PT), $this->main->URL('admin').'edit.php'), $message);
        $message = str_replace('%%event_title%%', get_the_title($event_id), $message);
        $message = str_replace('%%event_link%%', get_post_permalink($event_id), $message);
        $message = str_replace('%%event_start_date%%', $this->main->date_i18n(get_option('date_format'), strtotime(get_post_meta($event_id, 'mec_start_date', true))), $message);
        $message = str_replace('%%event_end_date%%', $this->main->date_i18n(get_option('date_format'), strtotime(get_post_meta($event_id, 'mec_end_date', true))), $message);
        $message = str_replace('%%event_status%%', $status, $message);
        $message = str_replace('%%event_note%%', get_post_meta($event_id, 'mec_note', true), $message);

        // Data Fields
        $event_fields = $this->main->get_event_fields();
        $event_fields_data = get_post_meta($event_id, 'mec_fields', true);
        if(!is_array($event_fields_data)) $event_fields_data = array();

        foreach($event_fields as $f => $event_field)
        {
            if(!is_numeric($f)) continue;

            $field_value = isset($event_fields_data[$f]) ? $event_fields_data[$f] : NULL;
            if(trim($field_value) === '') continue;

            $event_field_name = isset($event_field['label']) ? $event_field['label'] : '';
            if(is_array($field_value)) $field_value = implode(', ', $field_value);

            $message = str_replace('%%event_field_'.$f.'%%', trim($field_value, ', '), $message);
            $message = str_replace('%%event_field_'.$f.'_with_name%%', trim((trim($event_field_name) ? $event_field_name.': ' : '').trim($field_value, ', ')), $message);
        }

        // Notification Subject
        $subject = str_replace('%%event_title%%', get_the_title($event_id), $subject);

        // Changing some sender email info.
        $this->mec_sender_email_notification_filter();

        // Set Email Type to HTML
        add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        // Send the mail
        wp_mail($to, html_entity_decode(stripslashes($subject), ENT_HTML5), wpautop(stripslashes($message)), $headers);

        // Remove the HTML Email filter
        remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

        return true;
    }

    /**
    * Send new event published notification
    * @author Webnus <info@webnus.biz>
    * @param string $new
    * @param string $old
    * @param object $post
    * @return void
    */
    public function user_event_publishing($new, $old, $post)
    {
        // MEC Event Post Type
        $event_PT = $this->main->get_main_post_type();

        // User event publishing notification is disabled
        if(!isset($this->notif_settings['user_event_publishing']['status']) or (isset($this->notif_settings['user_event_publishing']['status']) and !$this->notif_settings['user_event_publishing']['status'])) return false;

        if(($new == 'publish') and ($old != 'publish') and ($post->post_type == $event_PT))
        {
            $guest_email = get_post_meta($post->ID, 'fes_guest_email', true);

            // Not Set Guest User Email
            if(!trim($guest_email) or !filter_var($guest_email, FILTER_VALIDATE_EMAIL)) return;

            $guest_name = get_post_meta($post->ID, 'fes_guest_name', true);
            $status = get_post_status($post->ID);

            $to = $guest_email;
            $subject = (isset($this->notif_settings['user_event_publishing']['subject']) and trim($this->notif_settings['user_event_publishing']['subject'])) ? __($this->notif_settings['user_event_publishing']['subject'], 'modern-events-calendar-lite') : __('Your event is published.', 'modern-events-calendar-lite');
            $headers = array('Content-Type: text/html; charset=UTF-8');

            $recipients_str = isset($this->notif_settings['user_event_publishing']['recipients']) ? $this->notif_settings['user_event_publishing']['recipients'] : '';
            $recipients = trim($recipients_str) ? explode(',', $recipients_str) : array();

            $users = isset($this->notif_settings['user_event_publishing']['receiver_users']) ? $this->notif_settings['user_event_publishing']['receiver_users'] : array();
            $users_down = $this->main->get_emails_by_users($users);
            $recipients = array_merge($users_down, $recipients);

            $roles = isset($this->notif_settings['user_event_publishing']['receiver_roles']) ? $this->notif_settings['user_event_publishing']['receiver_roles'] : array();
            $user_roles = $this->main->get_emails_by_roles($roles);
            $recipients = array_merge($user_roles, $recipients);

            // Unique Recipients
            $recipients = array_unique($recipients);

            foreach($recipients as $recipient)
            {
                // Skip if it's not a valid email
                if(trim($recipient) == '' or !filter_var($recipient, FILTER_VALIDATE_EMAIL)) continue;

                $headers[] = 'CC: '.$recipient;
            }

            $message = (isset($this->notif_settings['user_event_publishing']['content']) and trim($this->notif_settings['user_event_publishing']['content'])) ? $this->notif_settings['user_event_publishing']['content'] : '';

            // User Data
            $message = str_replace('%%name%%', $guest_name, $message);

            // Site Data
            $message = str_replace('%%blog_name%%', get_bloginfo('name'), $message);
            $message = str_replace('%%blog_url%%', get_bloginfo('url'), $message);
            $message = str_replace('%%blog_description%%', get_bloginfo('description'), $message);

            // Event Data
            $message = str_replace('%%admin_link%%', $this->link(array('post_type'=>$event_PT), $this->main->URL('admin').'edit.php'), $message);
            $message = str_replace('%%event_title%%', get_the_title($post->ID), $message);
            $message = str_replace('%%event_link%%', get_post_permalink($post->ID), $message);
            $message = str_replace('%%event_start_date%%', $this->main->date_i18n(get_option('date_format'), strtotime(get_post_meta($post->ID, 'mec_start_date', true))), $message);
            $message = str_replace('%%event_end_date%%', $this->main->date_i18n(get_option('date_format'), strtotime(get_post_meta($post->ID, 'mec_end_date', true))), $message);
            $message = str_replace('%%event_status%%', $status, $message);
            $message = str_replace('%%event_note%%', get_post_meta($post->ID, 'mec_note', true), $message);

            // Data Fields
            $event_fields = $this->main->get_event_fields();
            $event_fields_data = get_post_meta($post->ID, 'mec_fields', true);
            if(!is_array($event_fields_data)) $event_fields_data = array();

            foreach($event_fields as $f => $event_field)
            {
                if(!is_numeric($f)) continue;

                $field_value = isset($event_fields_data[$f]) ? $event_fields_data[$f] : NULL;
                if(trim($field_value) === '') continue;

                $event_field_name = isset($event_field['label']) ? $event_field['label'] : '';
                if(is_array($field_value)) $field_value = implode(', ', $field_value);

                $message = str_replace('%%event_field_'.$f.'%%', trim($field_value, ', '), $message);
                $message = str_replace('%%event_field_'.$f.'_with_name%%', trim((trim($event_field_name) ? $event_field_name.': ' : '').trim($field_value, ', ')), $message);
            }

            // Notification Subject
            $subject = str_replace('%%event_title%%', get_the_title($post->ID), $subject);

            // Changing some sender email info.
            $this->mec_sender_email_notification_filter();

            // Set Email Type to HTML
            add_filter('wp_mail_content_type', array($this->main, 'html_email_type'));

            // Send the mail
            wp_mail($to, html_entity_decode(stripslashes($subject), ENT_HTML5), wpautop(stripslashes($message)), $headers);

            // Remove the HTML Email filter
            remove_filter('wp_mail_content_type', array($this->main, 'html_email_type'));
        }
    }

    /**
     * Generate a link based on parameters
     * @author Webnus <info@webnus.biz>
     * @param array $vars
     * @param string $url
     * @return string
     */
    public function link($vars = array(), $url = NULL)
    {
        if(!trim($url)) $url = $this->main->URL('site').$this->main->get_main_slug().'/';
        foreach($vars as $key=>$value) $url = $this->main->add_qs_var($key, $value, $url);

        return $url;
    }

    /**
     * Generate content of email
     * @author Webnus <info@webnus.biz>
     * @param string $message
     * @param int $book_id
     * @param array $attendee
     * @return string
     */
    public function content($message, $book_id, $attendee = array())
    {
        $booker_id = get_post_field('post_author', $book_id);
        $booker = get_userdata($booker_id);

        $event_id = get_post_meta($book_id, 'mec_event_id', true);

        $first_name = (isset($booker->first_name) ? $booker->first_name : '');
        $last_name = (isset($booker->last_name) ? $booker->last_name : '');
        $name = (isset($booker->first_name) ? trim($booker->first_name.' '.(isset($booker->last_name) ? $booker->last_name : '')) : '');
        $email = (isset($booker->user_email) ? $booker->user_email : '');

        /**
         * Get the data from Attendee instead of main booker user
         */
        if(isset($attendee['name']) and trim($attendee['name']))
        {
            $name = $attendee['name'];
            $attendee_ex_name = explode(' ', $name);

            $first_name = isset($attendee_ex_name[0]) ? $attendee_ex_name[0] : '';
            $last_name = isset($attendee_ex_name[1]) ? $attendee_ex_name[1] : '';
            $email = isset($attendee['email']) ? $attendee['email'] : $email;
        }

        // Booker Data
        $message = str_replace('%%first_name%%', $first_name, $message);
        $message = str_replace('%%last_name%%', $last_name, $message);
        $message = str_replace('%%name%%', $name, $message);
        $message = str_replace('%%user_email%%', $email, $message);
        $message = str_replace('%%user_id%%', (isset($booker->ID) ? $booker->ID : ''), $message);

        // Site Data
        $message = str_replace('%%blog_name%%', get_bloginfo('name'), $message);
        $message = str_replace('%%blog_url%%', get_bloginfo('url'), $message);
        $message = str_replace('%%blog_description%%', get_bloginfo('description'), $message);

        // Book Data
        $transaction_id = get_post_meta($book_id, 'mec_transaction_id', true);
        $transaction = $this->book->get_transaction($transaction_id);

        $date_format = get_option('date_format');
        $time_format = get_option('time_format');

        $timestamps = get_post_meta($book_id, 'mec_date', true);
        list($start_timestamp, $end_timestamp) = explode(':', $timestamps);

        if(trim($timestamps) and strpos($timestamps, ':') !== false)
        {
            if(trim($start_timestamp) != trim($end_timestamp))
            {
                $book_date = sprintf(__('%s to %s', 'modern-events-calendar-lite'), $this->main->date_i18n($date_format.' '.$time_format, $start_timestamp), $this->main->date_i18n($date_format.' '.$time_format, $end_timestamp));
            }
            else $book_date = get_the_date($date_format.' '.$time_format, $book_id);
        }
        else $book_date = get_the_date($date_format.' '.$time_format, $book_id);

        $message = str_replace('%%book_date%%', $book_date, $message);

        // Order Time
        $order_time = get_post_meta($book_id, 'mec_booking_time', true);
        $message = str_replace('%%book_order_time%%', $this->main->date_i18n($date_format.' '.$time_format, strtotime($order_time)), $message);

        // Book Time
        $event_start_time = get_post_meta($event_id, 'mec_allday', true) ? $this->main->m('all_day', __('All Day' , 'modern-events-calendar-lite')) : $this->main->get_time($start_timestamp);

        // Condition for check some parameter simple hide event time
        if(!get_post_meta($event_id, 'mec_hide_time', true)) $message = str_replace('%%book_time%%', $event_start_time, $message);
        else $message = str_replace('%%book_time%%', '', $message);

        $message = str_replace('%%invoice_link%%', $this->book->get_invoice_link($transaction_id), $message);

        $cancellation_key = get_post_meta($book_id, 'mec_cancellation_key', true);
        $cancellation_link = trim(get_permalink($event_id), '/').'/cancel/'.$cancellation_key.'/';

        $message = str_replace('%%cancellation_link%%', $cancellation_link, $message);

        // Booking Price
        $price = get_post_meta($book_id, 'mec_price', true);
        $message = str_replace('%%book_price%%', $this->main->render_price(($price ? $price : 0)), $message);
        $message = str_replace('%%total_attendees%%', $this->book->get_total_attendees($book_id), $message);

        $event_id = get_post_meta($book_id, 'mec_event_id', true);
        $mec_date = explode(':', get_post_meta($book_id, 'mec_date', true));

        // Booked Tickets
        if(count($mec_date) == 2 and isset($mec_date[0])) $message = str_replace('%%amount_tickets%%', $this->book->get_tickets_availability($event_id, $mec_date[0], 'reservation'), $message);

        // Attendee Full Information
        if(strpos($message, '%%attendee_full_info%%') !== false or strpos($message, '%%attendees_full_info%%') !== false)
        {
            $attendees_full_info = $this->get_full_attendees_info($book_id);

            $message = str_replace('%%attendee_full_info%%', $attendees_full_info, $message);
            $message = str_replace('%%attendees_full_info%%', $attendees_full_info, $message);
        }

        // Booking IDs
        $message = str_replace('%%booking_id%%', $book_id, $message);
        $message = str_replace('%%booking_transaction_id%%', $transaction_id, $message);

        // Payment Gateway
        $message = str_replace('%%payment_gateway%%', get_post_meta($book_id, 'mec_gateway_label', true), $message);

        // Data Fields
        $bfixed_fields = $this->main->get_bfixed_fields($event_id);

        if(is_array($bfixed_fields) and count($bfixed_fields) and isset($transaction['fields']) and is_array($transaction['fields']) and count($transaction['fields']))
        {
            foreach($bfixed_fields as $b => $bfixed_field)
            {
                if(!is_numeric($b)) continue;

                $bfixed_field_name = isset($bfixed_field['label']) ? $bfixed_field['label'] : '';
                $bfixed_value = isset($transaction['fields'][$b]) ? $transaction['fields'][$b] : NULL;
                if(trim($bfixed_value) === '') continue;

                if(is_array($bfixed_value)) $bfixed_value = implode(', ', $bfixed_value);

                $message = str_replace('%%booking_field_'.$b.'%%', trim($bfixed_value, ', '), $message);
                $message = str_replace('%%booking_field_'.$b.'_with_name%%', trim((trim($bfixed_field_name) ? $bfixed_field_name.': ' : '').trim($bfixed_value, ', ')), $message);
            }
        }

        // Event Data
        $organizer_id = get_post_meta($event_id, 'mec_organizer_id', true);
        $location_id = get_post_meta($event_id, 'mec_location_id', true);
        $speaker_id = wp_get_post_terms( $event_id, 'mec_speaker', '');

        $organizer = get_term($organizer_id, 'mec_organizer');
        $location = get_term($location_id, 'mec_location');

        // Data Fields
        $event_fields = $this->main->get_event_fields();
        $event_fields_data = get_post_meta($event_id, 'mec_fields', true);
        if(!is_array($event_fields_data)) $event_fields_data = array();

        foreach($event_fields as $f => $event_field)
        {
            if(!is_numeric($f)) continue;

            $event_field_name = isset($event_field['label']) ? $event_field['label'] : '';
            $field_value = isset($event_fields_data[$f]) ? $event_fields_data[$f] : NULL;
            if(trim($field_value) === '') continue;

            if(is_array($field_value)) $field_value = implode(', ', $field_value);

            $message = str_replace('%%event_field_'.$f.'%%', trim($field_value, ', '), $message);
            $message = str_replace('%%event_field_'.$f.'_with_name%%', trim((trim($event_field_name) ? $event_field_name.': ' : '').trim($field_value, ', ')), $message);
        }

        $message = str_replace('%%event_title%%', get_the_title($event_id), $message);
        $message = str_replace('%%event_link%%', get_post_permalink($event_id), $message);
        $message = str_replace('%%event_start_date%%', $this->main->date_i18n(get_option('date_format'), strtotime(get_post_meta($event_id, 'mec_start_date', true))), $message);
        $message = str_replace('%%event_end_date%%', $this->main->date_i18n(get_option('date_format'), strtotime(get_post_meta($event_id, 'mec_end_date', true))), $message);

        $featured_image = '';
        $thumbnail_url = get_the_post_thumbnail_url($event_id, 'medium');
        if(trim($thumbnail_url)) $featured_image = '<img src="'.$thumbnail_url.'">';

        $message = str_replace('%%event_featured_image%%', $featured_image, $message);

        $message = str_replace('%%event_organizer_name%%', (isset($organizer->name) ? $organizer->name : ''), $message);
        $message = str_replace('%%event_organizer_tel%%', get_term_meta($organizer_id, 'tel', true), $message);
        $message = str_replace('%%event_organizer_email%%', get_term_meta($organizer_id, 'email', true), $message);

        $speaker_name = array();
        foreach($speaker_id as $speaker) $speaker_name[] = isset($speaker->name) ? $speaker->name : null;

        $message = str_replace('%%event_speaker_name%%', (isset($speaker_name) ? implode(', ', $speaker_name): ''), $message);
        $message = str_replace('%%event_location_name%%', (isset($location->name) ? $location->name : ''), $message);
        $message = str_replace('%%event_location_address%%', get_term_meta($location_id, 'address', true), $message);

        $additional_locations_name = '';
        $additional_locations_address = '';

        $additional_locations_ids = get_post_meta($event_id, 'mec_additional_location_ids', true);
        if(!is_array($additional_locations_ids)) $additional_locations_ids = array();

        foreach($additional_locations_ids as $additional_locations_id)
        {
            $additional_location = get_term($additional_locations_id, 'mec_location');
            if(isset($additional_location->name))
            {
                $additional_locations_name .= $additional_location->name.', ';
                $additional_locations_address .= get_term_meta($additional_locations_id, 'address', true).'<br>';
            }
        }

        $message = str_replace('%%event_other_locations_name%%', trim($additional_locations_name, ', '), $message);
        $message = str_replace('%%event_other_locations_address%%', trim($additional_locations_address, ', '), $message);

        $ticket_start_hour = $ticket_start_minute = $ticket_end_hour = $ticket_end_minute = $ticket_start_ampm = $ticket_end_ampm = '';
        $ticket_names = array();
        $ticket_times = array();

        $ticket_ids_str = get_post_meta($book_id, 'mec_ticket_id', true);
        $tickets = get_post_meta($event_id, 'mec_tickets', true);

        $ticket_ids = explode(',', $ticket_ids_str);
        $ticket_ids = array_filter($ticket_ids);

        if(!is_array($ticket_ids)) $ticket_ids = array();
        if(!is_array($tickets)) $tickets = array();

        foreach($ticket_ids as $get_ticket_id=>$value)
        {
            foreach($tickets as $ticket=>$ticket_info)
            {
                if($ticket != $value) continue;

                $ticket_names[] = $ticket_info['name'];
                $ticket_start_hour = $ticket_info['ticket_start_time_hour'];
                $ticket_start_minute = $ticket_info['ticket_start_time_minute'];
                $ticket_start_ampm = $ticket_info['ticket_start_time_ampm'];
                $ticket_end_hour = $ticket_info['ticket_end_time_hour'];
                $ticket_end_minute = $ticket_info['ticket_end_time_minute'];
                $ticket_end_ampm = $ticket_info['ticket_end_time_ampm'];

                $ticket_start_minute_s = $ticket_start_minute;
                $ticket_end_minute_s = $ticket_end_minute;

                if($ticket_start_minute == '0') $ticket_start_minute_s = '00';
                if($ticket_start_minute == '5') $ticket_start_minute_s = '05';
                if($ticket_end_minute == '0') $ticket_end_minute_s = '00';
                if($ticket_end_minute == '5') $ticket_end_minute_s = '05';

                $ticket_start_seconds = $this->main->time_to_seconds($this->main->to_24hours($ticket_start_hour, $ticket_start_ampm), $ticket_start_minute_s);
                $ticket_end_seconds = $this->main->time_to_seconds($this->main->to_24hours($ticket_end_hour, $ticket_end_ampm), $ticket_end_minute_s);

                $ticket_times[] = $this->main->get_time($ticket_start_seconds).' ' . esc_html__('to' , 'modern-events-calendar-lite') . ' ' .$this->main->get_time($ticket_end_seconds);
            }
        }

        $message = str_replace('%%ticket_name%%', implode(',', $ticket_names), $message);
        $message = str_replace('%%ticket_time%%', implode(',', $ticket_times), $message);

        $ticket_name_time = '';
        foreach($ticket_names as $t_i=>$ticket_name)
        {
            $ticket_name_time .= $ticket_name.' ('.$ticket_times[$t_i].'), ';
        }

        $message = str_replace('%%ticket_name_time%%', trim($ticket_name_time, ', '), $message);

        $gmt_offset_seconds = $this->main->get_gmt_offset_seconds($start_timestamp);
        $event_title = get_the_title($event_id);
        $event_info = get_post($event_id);
        $event_content = trim($event_info->post_content) ? strip_shortcodes(strip_tags($event_info->post_content)) : $event_title;

        $google_caneldar_location = get_term_meta($location_id, 'address', true);
        $google_caneldar_link = '<a class="mec-events-gcal mec-events-button mec-color mec-bg-color-hover mec-border-color" href="https://www.google.com/calendar/event?action=TEMPLATE&text=' . $event_title . '&dates='. gmdate('Ymd\\THi00\\Z', ($start_timestamp - $gmt_offset_seconds)) . '/' . gmdate('Ymd\\THi00\\Z', ($end_timestamp - $gmt_offset_seconds)) . '&details=' . urlencode($event_content) . (trim($google_caneldar_location) ? '&location=' . urlencode($google_caneldar_location) : ''). '" target="_blank">' . __('+ Add to Google Calendar', 'modern-events-calendar-lite') . '</a>';
        $ical_export_link  = '<a class="mec-events-gcal mec-events-button mec-color mec-bg-color-hover mec-border-color" href="' . $this->main->ical_URL_email($event_id, $book_id, get_the_date('Y-m-d', $book_id)) . '">'. __('+ iCal export', 'modern-events-calendar-lite') . '</a>';

        $message = str_replace('%%google_calendar_link%%', $google_caneldar_link, $message);
        $message = str_replace('%%ics_link%%', $ical_export_link, $message);

        return $message;
    }

    /**
     * Get Booking Organizer Email by Book ID
     * @author Webnus <info@webnus.biz>
     * @param int $book_id
     * @return string
     */
    public function get_booking_organizer_email($book_id)
    {
        $event_id = get_post_meta($book_id, 'mec_event_id', true);
        $organizer_id = get_post_meta($event_id, 'mec_organizer_id', true);
        $email = get_term_meta($organizer_id, 'email', true);

        return trim($email) ? $email : false;
    }

    /**
     * Get full attendees info
     * @param $book_id
     * @return string
     */
    public function get_full_attendees_info($book_id)
    {
        $attendees_full_info = '';

        $attendees = get_post_meta($book_id, 'mec_attendees', true);
        if(!is_array($attendees) or (is_array($attendees) and !count($attendees))) $attendees = array(get_post_meta($book_id, 'mec_attendee', true));

        $event_id = get_post_meta($book_id, 'mec_event_id', true);
        $reg_fields = $this->main->get_reg_fields($event_id);

        $attachments = (isset($attendees['attachments']) and is_array($attendees['attachments'])) ? $attendees['attachments'] : array();
        $attachment_field = array();
        if(count($attachments))
        {
            foreach($reg_fields as $reg_field_id => $reg_field)
            {
                if(!is_numeric($reg_field_id)) continue;
                if($reg_field['type'] !== 'file') continue;

                $attachment_field = $reg_field;
                break;
            }
        }

        foreach($attendees as $key=>$attendee)
        {
            if($key === 'attachments') continue;

            $reg_form = isset($attendee['reg']) ? $attendee['reg'] : array();

            $attendees_full_info .= __('Name', 'modern-events-calendar-lite').': '.((isset($attendee['name']) and trim($attendee['name'])) ? $attendee['name'] : '---')."\r\n";
            $attendees_full_info .= __('Email', 'modern-events-calendar-lite').': '.((isset($attendee['email']) and trim($attendee['email'])) ? $attendee['email'] : '---')."\r\n";

            if(is_array($reg_form) and count($reg_form))
            {
                foreach($reg_form as $field_id=>$value)
                {
                    // Placeholder Keys
                    if(!is_numeric($field_id)) continue;

                    $type = $reg_fields[$field_id]['type'];

                    $label = isset($reg_fields[$field_id]) ? $reg_fields[$field_id]['label'] : '';
                    if(trim($label) == '') continue;

                    if($type == 'agreement')
                    {
                        $label = sprintf(__($label, 'modern-events-calendar-lite'), '<a href="'.get_the_permalink($reg_fields[$field_id]['page']).'">'.get_the_title($reg_fields[$field_id]['page']).'</a>');
                        $attendees_full_info .= $label.': '.($value == '1' ? __('Yes', 'modern-events-calendar-lite') : __('No', 'modern-events-calendar-lite'))."\r\n";
                    }
                    else
                    {
                        $attendees_full_info .= __($label, 'modern-events-calendar-lite').': '.(is_string($value) ? $value : (is_array($value) ? implode(', ', $value) : '---'))."\r\n";
                    }
                }
            }

            $attendees_full_info .= "\r\n";
        }

        // Attachment
        if(count($attachments))
        {
            $attendees_full_info .= __($attachment_field['label'], 'modern-events-calendar-lite').': <a href="'.esc_url($attachments[0]['url']).'" target="_blank">'.esc_url($attachments[0]['url']).'</a>'."\r\n";
        }

        return $attendees_full_info;
    }

    /**
     * Add filters for sender name and sender email
     */
    public function mec_sender_email_notification_filter()
    {
        // MEC Notification Sender Email
        add_filter('wp_mail_from_name', array($this, 'notification_sender_name'));
        add_filter('wp_mail_from', array($this, 'notification_sender_email'));
    }
    
     /**
     * Change Notification Sender Name
     * @param string $sender_name
     * @return string
     */
    public function notification_sender_name($sender_name)
    {
        $sender_name = (isset($this->settings['booking_sender_name']) and trim($this->settings['booking_sender_name'])) ? trim($this->settings['booking_sender_name']) : $sender_name;
        return $sender_name;
    }

    /**
     * Change Notification Sender Email
     * @param string $sender_email
     * @return string
     */
    public function notification_sender_email($sender_email)
    {
        $sender_email = (isset($this->settings['booking_sender_email']) and trim($this->settings['booking_sender_email'])) ? trim($this->settings['booking_sender_email']) : $sender_email;
        return $sender_email;
    }

    /**
     * Add template to the email content
     * @param string $content
     * @return string
     */
    public function add_template($content)
    {
        return '<table border="0" cellpadding="0" cellspacing="0" class="wn-body" style="background-color: #f6f6f6; font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Oxygen,Open Sans, sans-serif;border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
            <tr>
                <td class="wn-container" style="display: block; margin: 0 auto !important; max-width: 680px; padding: 10px;font-family: sans-serif; font-size: 14px; vertical-align: top;">
                    <div class="wn-wrapper" style="box-sizing: border-box; padding: 38px 9% 50px; width: 100%; height: auto; background: #fff; background-size: contain; margin-bottom: 25px; margin-top: 30px; border-radius: 4px; box-shadow: 0 3px 55px -18px rgba(0,0,0,0.1);">
                        '.$content.'
                    </div>
                </td>
            </tr>
        </table>';
    }
}