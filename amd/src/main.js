define(["jquery", "core/str", "core/modal_factory"], function($, Str, ModalFactory) {
    return {
        init: function() {
            Str.get_string('addresourceoractivity')
                .then(function(str) {
                    var buttonHtml = '' +
                        '<button class="alternative-modchooser btn link">' +
                        '<i class="icon fa fa-plus fa-fw "></i>' + str + '</button>';
                    $('.section-modchooser-link').parent().append(buttonHtml);

                    var title = 'Add activty or resource'; // TODO, localise.
                    var body = 'RESOURCES GO HERE';

                    return ModalFactory.create({
                        type: ModalFactory.types.DEFAULT,
                        title: title,
                        body: body,
                        large: true
                    });
                })
                .then(function(modal) {
                    $('.alternative-modchooser').click(function() {
                        modal.show();

                    });
                });
        }
    };
});