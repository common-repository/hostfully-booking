jQuery(document).ready(function (jQuery) {

  function handle_widget_loading() {
    var options = {
      // a callback to fire whenever the color changes to a valid color
      change: function (event, ui) {
        update_value(event, ui);
      },
      // a callback to fire when the input is emptied or an invalid color
      clear: function () {},
      // hide the color picker controls on load
      hide: true,
      // show a group of common colors beneath the square
      // or, supply an array of colors to customize further
      palettes: true,
    };
    jQuery(".open-c-picker").wpColorPicker(options);
  }

  // Update Value after update
  function update_value(event,ui) {
    jQuery(event.target.id).attr('value', ui.color.toString());
  }

  jQuery(document).ready(handle_widget_loading);
  jQuery(document).on("widget-updated widget-added sidebar-updated partial-content-moved", handle_widget_loading);
  jQuery(document).on("widget-loaded", handle_widget_loading);

});
