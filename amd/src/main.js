define(["jquery", "core/str", "core/modal_factory", "core/templates"], function($, Str, ModalFactory, Template) {
    return {
        init: function() {

            Str.get_string('addresourceoractivity')
                .then(function(str) {
                    var buttonHtml = '' +
                        '<button class="alternative-modchooser btn link">' +
                        '<i class="icon fa fa-plus fa-fw "></i>' + str + '</button>';
                    $('.section-modchooser-link').parent().append(buttonHtml);

                    var title = 'Add activty or resource'; // TODO, localise.
                    var body = '<div></div>';

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
                        var context = {};
                        var modalBodyPromise = Template.render('local_activitychooser/modulechooser', context);
                        modal.setBody(modalBodyPromise);
                    });
                });
        }
    };
});