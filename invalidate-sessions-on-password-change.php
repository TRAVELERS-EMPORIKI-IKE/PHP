<?php

/**
 * Invalidate Sessions on Password Change Chatgpt
 */
function invalidate_old_sessions_on_password_change($user_id, $old_user_data) {
    $user = get_userdata($user_id);
    $old_pass = $old_user_data->user_pass;

    if ($user && $old_pass !== $user->user_pass) {
        wp_clear_auth_cookie(); // Clear cookies for the current session
        wp_set_auth_cookie($user_id); // Reset cookies for the current session
        wp_destroy_other_sessions(); // Destroy all other sessions for this user
    }
}
add_action('profile_update', 'invalidate_old_sessions_on_password_change', 10, 2);
