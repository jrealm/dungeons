/*global $*/
/*jslint browser,long*/

(function () {

    "use strict";

    var active = false;

    var count = 0;

    var edit = function (event) {
        window.editLabel($(event.currentTarget).data("edit"));

        return false;
    };

    var toggle = function () {
        var elements = $("[data-edit]");

        active = !active;

        if (active) {
            elements.addClass("editable-label").on("click", edit);
        } else {
            elements.removeClass("editable-label").off("click", edit);
        }
    };

    $(document).on("keyup", function (event) {
        if (event.which === 17) {
            count += 1;

            if (count !== 5) {
                return;
            }

            toggle();
        }

        count = 0;
    });

}());
