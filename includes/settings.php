<?php 
/** Settings Page */

// Register the settings page
add_action('admin_menu', 'hostfully_booking_widget_add_settings_page');
function hostfully_booking_widget_add_settings_page() {
    add_options_page(
        'Hostfully Booking Widget Settings', // Page title
        'Hostfully Booking Widget', // Menu title
        'manage_options', // Capability
        'hostfully_booking_widget-settings', // Menu slug
        'hostfully_booking_widget_render_settings_page' // Callback to render the page
    );
}

// Render the settings page
function hostfully_booking_widget_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Hostfully Booking Widget Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('hostfully_booking_widget-settings'); // Use your settings group name
            do_settings_sections('hostfully_booking_widget-settings'); // Use your settings page slug
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings and fields
add_action('admin_init', 'hostfully_booking_widget_register_settings');
function hostfully_booking_widget_register_settings() {
    register_setting(
        'hostfully_booking_widget-settings', // Settings group name
        'hostfully_booking_widget_settings', // Option name
        'hostfully_booking_widget_sanitize_settings' // Sanitization callback
    );

    add_settings_section(
        'hostfully_booking_widget-general', // Section ID
        'General Settings', // Section title
        'hostfully_booking_widget_render_section', // Callback to render the section
        'hostfully_booking_widget-settings' // Page slug
    );

    add_settings_field(
        'hostfully-property-uid', // Field ID
        'Property UID', // Field label
        'hostfully_booking_widget_render_property_uid', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-general' // Section ID
    );

    add_settings_section(
        'hostfully_booking_widget-fields', // Section ID
        'Fields', // Section title
        'hostfully_booking_widget_render_fields_section', // Callback to render the section
        'hostfully_booking_widget-settings' // Page slug
    );

    // 'Phone' field
    add_settings_field(
        'hf-show-phone', // Field ID
        'Phone', // Field label
        'hostfully_booking_widget_render_phone', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-fields' // Section ID
    );

    // 'Notes' field
    add_settings_field(
        'hf-show-notes', // Field ID
        'Notes', // Field label
        'hostfully_booking_widget_render_notes', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-fields' // Section ID
    );

    // 'Options' section
    add_settings_section(
        'hostfully_booking_widget-options', // Section ID
        'Options', // Section title
        'hostfully_booking_widget_render_options_section', // Callback to render the section
        'hostfully_booking_widget-settings' // Page slug
    );
    
    // 'Price Details' field
    add_settings_field(
        'hf-show-price-details', // Field ID
        'Price Details', // Field label
        'hostfully_booking_widget_render_price_details', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-options' // Section ID
    );
    
    // 'Price' field
    add_settings_field(
        'hf-show-price', // Field ID
        'Dynamic Pricing', // Field label
        'hostfully_booking_widget_render_price', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-options' // Section ID
    );
    
    // 'MinStay' field
    add_settings_field(
        'hf-show-minStay', // Field ID
        'Minimun Stay', // Field label
        'hostfully_booking_widget_render_minStay', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-options' // Section ID
    );
    
    // 'MinStay' field
    add_settings_field(
        'hf-show-availability', // Field ID
        'Availability', // Field label
        'hostfully_booking_widget_render_availability', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-options' // Section ID
    );

    // 'Colors' section
    add_settings_section(
        'hostfully_booking_widget-colors', // Section ID
        'Colors', // Section title
        'hostfully_booking_widget_render_colors_section', // Callback to render the section
        'hostfully_booking_widget-settings' // Page slug
    );

    // 'widgetColor' field
    add_settings_field(
        'hf-widgetColor', // Field ID
        'Background color', // Field label
        'hostfully_booking_widget_render_widgetColor', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-colors' // Section ID
    );
    
    // 'textColor' field
    add_settings_field(
        'hf-textColor', // Field ID
        'Text color', // Field label
        'hostfully_booking_widget_render_textColor', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-colors' // Section ID
    );
    
    // 'buttonBackgroundColor' field
    add_settings_field(
        'hf-buttonBackgroundColor', // Field ID
        'Button Background color', // Field label
        'hostfully_booking_widget_render_buttonBackgroundColor', // Callback to render the field
        'hostfully_booking_widget-settings', // Page slug
        'hostfully_booking_widget-colors' // Section ID
    );


}

// Render settings section
function hostfully_booking_widget_render_section() {
    echo '<p>Please add your Property UID.</p>';
}

// Render fields section
function hostfully_booking_widget_render_fields_section() {
    echo '<p>Please select the fields you want to dislplay below.</p>';
}

// Render the 'Options' section
function hostfully_booking_widget_render_options_section() {
    echo '<p>Please select your options below.</p>';
}

// Render 'Colors' section
function hostfully_booking_widget_render_colors_section() {
    echo '<p>Please select your colors below.</p>';
}

// Render Property UID
function hostfully_booking_widget_render_property_uid() {
    $options = get_option('hostfully_booking_widget_settings');
    $value = isset($options['hostfully-property-uid']) ? $options['hostfully-property-uid'] : '';
    echo "<input type='text' name='hostfully_booking_widget_settings[hostfully-property-uid]' value='$value' style='width: 100%; max-width: 300px;'>";
    echo "<p style='font-size: 12px;'>If you have multiple properties, you can overwrite this field on each page or post.</p>";
}

// Render Phone
function hostfully_booking_widget_render_phone() {
    $options = get_option('hostfully_booking_widget_settings');
    $checked = isset($options['hf-show-phone']) && $options['hf-show-phone'] === '1' ? 'checked' : '';
    echo "<input type='checkbox' name='hostfully_booking_widget_settings[hf-show-phone]' $checked> Show Phone Field";
}

// Render Notes
function hostfully_booking_widget_render_notes() {
    $options = get_option('hostfully_booking_widget_settings');
    $checked = isset($options['hf-show-notes']) && $options['hf-show-notes'] === '1' ? 'checked' : '';
    echo "<input type='checkbox' name='hostfully_booking_widget_settings[hf-show-notes]' $checked> Show Notes Field";
}

// Render Price Details
function hostfully_booking_widget_render_price_details() {
    $options = get_option('hostfully_booking_widget_settings');
    $checked = isset($options['hf-show-price-details']) && $options['hf-show-price-details'] === '1' ? 'checked' : '';
    echo "<input type='checkbox' name='hostfully_booking_widget_settings[hf-show-price-details]' $checked> Show Price Details";
}

// Render Price 
function hostfully_booking_widget_render_price() {
    $options = get_option('hostfully_booking_widget_settings');
    $checked = isset($options['hf-show-price']) && $options['hf-show-price'] === '1' ? 'checked' : '';
    echo "<input type='checkbox' name='hostfully_booking_widget_settings[hf-show-price]' $checked> Show Dynamic Pricing";
}

// Render minStay 
function hostfully_booking_widget_render_minStay() {
    $options = get_option('hostfully_booking_widget_settings');
    $checked = isset($options['hf-show-minStay']) && $options['hf-show-minStay'] === '1' ? 'checked' : '';
    echo "<input type='checkbox' name='hostfully_booking_widget_settings[hf-show-minStay]' $checked> Show Minimum Stay";
}

// Render availability 
function hostfully_booking_widget_render_availability() {
    $options = get_option('hostfully_booking_widget_settings');
    $checked = isset($options['hf-show-availability']) && $options['hf-show-availability'] === '1' ? 'checked' : '';
    echo "<input type='checkbox' name='hostfully_booking_widget_settings[hf-show-availability]' $checked> Prevent inquiries for already booked dates";
}

// Render widgetColor
function hostfully_booking_widget_render_widgetColor() {
    $options = get_option('hostfully_booking_widget_settings');
    $color = isset($options['hf-widgetColor']) ? $options['hf-widgetColor'] : '';
    echo "<input type='text' name='hostfully_booking_widget_settings[hf-widgetColor]' data-default-color='#ffffff' value='$color' class='open-c-picker' />";
}

// Render textColor
function hostfully_booking_widget_render_textColor() {
    $options = get_option('hostfully_booking_widget_settings');
    $color = isset($options['hf-textColor']) ? $options['hf-textColor'] : '';
    echo "<input type='text' name='hostfully_booking_widget_settings[hf-textColor]' data-default-color='#F8981B' value='$color' class='open-c-picker' />";
}

// Render buttonBackgroundColor
function hostfully_booking_widget_render_buttonBackgroundColor() {
    $options = get_option('hostfully_booking_widget_settings');
    $color = isset($options['hf-buttonBackgroundColor']) ? $options['hf-buttonBackgroundColor'] : '';
    echo "<input type='text' name='hostfully_booking_widget_settings[hf-buttonBackgroundColor]' data-default-color='#F8981B' value='$color' class='open-c-picker' />";
}

// Sanitize settings
function hostfully_booking_widget_sanitize_settings($input) {
    $sanitized_input = array();
    if (isset($input['hostfully-property-uid'])) {
        $sanitized_input['hostfully-property-uid'] = sanitize_text_field($input['hostfully-property-uid']);
    }
    if (isset($input['hf-show-phone'])) {
        $sanitized_input['hf-show-phone'] = $input['hf-show-phone'] === 'on' ? '1' : '0';
    }
    if (isset($input['hf-show-notes'])) {
        $sanitized_input['hf-show-notes'] = $input['hf-show-notes'] === 'on' ? '1' : '0';
    }
    if (isset($input['hf-show-price-details'])) {
        $sanitized_input['hf-show-price-details'] = $input['hf-show-price-details'] === 'on' ? '1' : '0';
    }
    if (isset($input['hf-show-price'])) {
        $sanitized_input['hf-show-price'] = $input['hf-show-price'] === 'on' ? '1' : '0';
    }
    if (isset($input['hf-show-minStay'])) {
        $sanitized_input['hf-show-minStay'] = $input['hf-show-minStay'] === 'on' ? '1' : '0';
    }
    if (isset($input['hf-show-availability'])) {
        $sanitized_input['hf-show-availability'] = $input['hf-show-availability'] === 'on' ? '1' : '0';
    }
    if (isset($input['hf-widgetColor'])) {
        $sanitized_input['hf-widgetColor'] = sanitize_hex_color($input['hf-widgetColor']);
    }
    if (isset($input['hf-textColor'])) {
        $sanitized_input['hf-textColor'] = sanitize_hex_color($input['hf-textColor']);
    }
    if (isset($input['hf-buttonBackgroundColor'])) {
        $sanitized_input['hf-buttonBackgroundColor'] = sanitize_hex_color($input['hf-buttonBackgroundColor']);
    }
    return $sanitized_input;
}