define(["jquery"], function ($) {
    return {
        init: function () {
            $("#activitychooser_recommended_add").click(function () {
                $('.localactivitychoosermoduleslist option:selected').remove().appendTo('.localactivitychoosermodulesselected');
            });
            $("#activitychooser_recommended_remove").click(function () {
                    $('.localactivitychoosermodulesselected option:selected').remove().appendTo('.localactivitychoosermoduleslist');
            });
        }
    };
});