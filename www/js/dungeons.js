/*global $,toastr*/
/*jslint browser,long*/

(function () {

    "use strict";

    var combine = function (data, name, value) {
        if (empty(value)) {
            value = null;
        }

        if (data.hasOwnProperty(name)) {
            var current = data[name];

            if (Array.isArray(current)) {
                current.push(value);
            } else {
                data[name] = [current, value];
            }
        } else {
            data[name] = value;
        }
    };

    var empty = function (value) {
        if (value) {
            return false;
        }

        return value === "" || value === null || value === undefined;
    };

    var error = function (response) {
        overlay.hide();

        switch (response.status) {
        case 401:
            location.reload();
            break;
        default:
            toastr.error(response.statusText);
        }
    };

    var execute = function (script) {
        $.globalEval("(function () {" + script + "}());");
    };

    var overlay = (function () {
        var overlays = 0;
        var wrapper = $(".overlay-wrapper");

        return {
            hide: function () {
                overlays -= 1;

                if (!overlays) {
                    wrapper.hide();
                }
            },
            show: function () {
                if (!overlays) {
                    wrapper.show();
                }

                overlays += 1;
            }
        };
    }());

    var perform = function (path, parameters, options) {
        overlay.show();

        if (empty(path)) {
            path = settings.overview;
        }

        if (!$.isPlainObject(parameters)) {
            parameters = serialize(parameters);
        }

        if (options && options.parameters) {
            $.extend(parameters, options.parameters);
        }

        $.ajax({
            contentType: "application/json",
            data: JSON.stringify(parameters),
            error,
            success,
            type: "POST",
            url: path
        });
    };

    var processJson = function (response) {
        var target;

        switch (response.type) {
        case "delete-success":
            perform(history.state.path, {});
            break;
        case "redirect":
            redirect({path: response.path});
            break;
        case "reload":
            location.reload();
            break;
        case "validation":
            target = $(response.target);
            $.each(response.errors, function (ignore, error) {
                $(".invalid-feedback[data-name='" + error.name + "']", target).text(error.message).show();
            });
            break;
        default:
            if (response.error) {
                toastr.error(response.message || response.error);
            }
        }
    };

    var processXml = function (ignore, response) {
        var data = $(response);
        var expression = data.children("target").text().trim();
        var target;

        if (expression) {
            target = $(expression);
        }

        if (!expression || target.length === 1) {
            execute(data.children("preprocess").text());

            if (target) {
                target.hide().empty().html(data.children("html").text().trim()).show();
            }

            execute(data.children("postprocess").text());
        }
    };

    var redirect = function (state, replace) {
        if (replace) {
            history.replaceState(state, "", state.path);
        } else {
            history.pushState(state, "", state.path);
        }

        perform(state.path, {});
    };

    var saveMenu = function () {
        var menus = [];

        $("a[data-branch]").each(function (ignore, element) {
            var node = $(element);

            if (node.parent().hasClass("menu-open")) {
                menus.push(node.data("branch"));
            }
        });

        localStorage.EXPANDED_MENUS = JSON.stringify(menus);
    };

    var serialize = function (expression) {
        var data = {};

        $(expression).find("input,select,textarea").each(function (ignore, element) {
            if (element.name) {
                switch (element.type) {
                case "checkbox":
                    if (!element.checked) {
                        combine(data, element.name, null);
                        return;
                    }
                    break;

                case "radio":
                    if (!element.checked) {
                        return;
                    }
                    break;

                case "select-multiple":
                case "textarea":
                    combine(data, element.name, $(element).val());
                    return;
                }

                combine(data, element.name, element.value);
            }
        });

        return data;
    };

    var settings = $.extend({overview: "overview"}, $("script:last").data());

    var success = function (data) {
        overlay.hide();

        if ($.isPlainObject(data)) {
            processJson(data);
        } else {
            $("response", data).each(processXml);
        }
    };

    window.initForm = function (form) {
        if (window.bsCustomFileInput) {
            window.bsCustomFileInput.init();
        }

        form.find("div[data-format=color]").each(function (ignore, element) {
            var target = $(element);
            var input = target.find("input");
            var output = target.find(".input-group-text");

            target.colorpicker().on("colorpickerChange", function (event) {
                var color = "";

                if (event.color) {
                    color = event.color.toString();
                }

                output.css("background-color", color);
            });

            output.css("background-color", input.val());
        });

        form.find("input[data-format=date]").each(function (ignore, element) {
            var input = $(element);

            input.daterangepicker({
                autoUpdateInput: false,
                locale: {format: input.data("pattern")},
                showDropdowns: true,
                singleDatePicker: true
            }).on("apply.daterangepicker", function (event, picker) {
                $(event.currentTarget).val(picker.startDate.format(input.data("pattern")));
            });
        });

        form.find("input[data-format=image]").on("change", function (event) {
            var file = event.currentTarget.files && event.currentTarget.files[0];
            var input = $(event.currentTarget).siblings("input[data-image]");
            var feedback = input.closest("div").siblings(".invalid-feedback").hide().empty();

            if (file) {
                if (file.type.startsWith("image/")) {
                    var reader = new FileReader();

                    reader.onload = function () {
                        input.val(reader.result);
                        input.siblings("input[data-filename]").val(file.name);
                        input.closest("div").find(".image-preview").html("<img class=\"border shadow\" src=\"" + reader.result + "\">");
                    };

                    reader.readAsDataURL(file);

                    return;
                }

                feedback.text(input.data("error")).show();
            }
        });

        if ($.fn.select2) {
            form.find("select.select2bs4").select2({
                theme: "bootstrap4"
            });
        }

        if ($.fn.summernote) {
            form.find("textarea[data-format=html]").summernote();
        }
    };

    window.onpopstate = function (event) {
        perform(event.state.path, {});
    };

    window.perform = perform;

    window.toggleMenu = function (path) {
        var menu = $("a[data-leaf][href='" + path + "']").blur();

        $("a.active[data-leaf]").removeClass("active");

        menu.addClass("active").parents(".has-treeview").addClass("menu-open").children("ul").css("display", "block");

        saveMenu();

        $("body.sidebar-open").toggleClass("sidebar-collapse sidebar-open");
    };

    $("button[data-language]").click(function (event) {
        location.href = $(event.currentTarget).data("path") + location.href.substring(document.baseURI.length);
    });

    $(document).delegate("a[data-ajax]", "click", function (event) {
        var path = $(event.currentTarget).attr("href");

        if (path === history.state.path) {
            perform(path, {});
        } else {
            redirect({path});
        }

        return false;
    }).delegate("button[data-ajax]", "click", function (event) {
        var button = $(event.currentTarget);
        var form = button.data("form");
        var options;

        if (form) {
            $(".invalid-feedback", form).hide().empty();
            options = {parameters: {"form-id": form}};
        } else {
            form = {};
        }

        perform(button.data("ajax"), form, options);
    }).ready(function () {
        $("ul[data-widget=treeview]").on("collapsed.lte.treeview expanded.lte.treeview", saveMenu);

        if (localStorage.EXPANDED_MENUS) {
            $.each(JSON.parse(localStorage.EXPANDED_MENUS), function (ignore, menu) {
                $("a[data-branch='" + menu + "']").parent().addClass("menu-open").children("ul").css("display", "block");
            });
        }

        if (history.state) {
            perform(history.state.path, {});
        } else {
            redirect({path: settings.landingPath + location.search}, true);
        }
    });

}());
