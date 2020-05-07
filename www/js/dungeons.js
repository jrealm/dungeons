/*global $,Blob,atob,btoa,toastr*/
/*jslint browser,long*/

(function () {

    "use strict";

    var backward = function () {
        $(".breadcrumb-item a").last().click();
    };

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

    var destroy = function (target) {
        target.find("div[data-format=color]").each(function (ignore, element) {
            $(element).data("colorpicker").destroy();
        });

        target.find("input[data-format=date],input[data-format=datetime]").each(function (ignore, element) {
            $(element).data("daterangepicker").remove();
        });

        if ($.fn.select2) {
            target.find("select.select2bs4").select2("destroy");
        }

        if ($.fn.summernote) {
            target.find("textarea[data-format=html]").summernote("destroy");
        }

        target.hide().empty();
    };

    var download = function (response) {
        var anchor;
        var file;
        var raw = atob(response.content);
        var size = raw.length;
        var data = new Array(size);

        while (size) {
            size -= 1;
            data[size] = raw.charCodeAt(size);
        }

        file = new Blob([new Uint8Array(data)], {type: response.contentType});

        anchor = document.getElementById("download-anchor");
        anchor.download = response.filename;
        anchor.href = URL.createObjectURL(file);
        anchor.click();

        URL.revokeObjectURL(anchor.href);
    };

    var empty = function (value) {
        if (value) {
            return false;
        }

        return value === "" || value === null || value === undefined;
    };

    var encode = function (text) {
        return btoa(text).replace(/\+/g, "-").replace(/\//g, "_").replace(/\=/g, "");
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
        var parameters;
        var target;

        switch (response.type) {
        case "backward":
            backward();
            break;
        case "download":
            download(response);
            break;
        case "location":
            location.href = response.path;
            break;
        case "redirect":
            if (response.message) {
                toastr.info(response.message);
            }
            redirect({path: response.path});
            break;
        case "refresh":
            if (response.message) {
                toastr.info(response.message);
            }
            if (response.modal) {
                $(".modal-wrapper .modal").modal("hide");
                parameters = {d: encode(encodeURIComponent(JSON.stringify(serialize(".form-wrapper"))))};
            }
            perform(history.state.path, parameters || {});
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
                destroy(target);

                target.html(data.children("html").text().trim()).show();
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

    var toggleControls = function (checked) {
        var list = [];

        checked.each(function (ignore, input) {
            list.push($(input).data("id"));
        });

        $("button[data-least]").data("args", list).each(function (ignore, element) {
            var button = $(element);

            button.prop("disabled", list.length < button.data("least"));
        });
    };

    window.initForm = function (form) {
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

        form.find("input[data-format=date],input[data-format=datetime]").each(function (ignore, element) {
            var input = $(element);

            input.daterangepicker({
                autoUpdateInput: false,
                locale: {format: input.data("pattern")},
                showDropdowns: true,
                singleDatePicker: true,
                timePicker: input.data("format").indexOf("time") >= 0,
                timePicker24Hour: true,
                timePickerSeconds: true
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
            }).filter("[data-search]").on("change", function (event) {
                var select = $(event.currentTarget);
                var inputs = select.closest("[id]").find("[data-name]");

                inputs.filter(":visible").addClass("d-none").find("input,select").val("").filter("select").trigger("change");
                inputs.filter("[data-name='" + select.val() + "']").removeClass("d-none");
            });
        }

        if ($.fn.summernote) {
            form.find("textarea[data-format=html]").summernote().filter("[data-disabled]").summernote("disable");
        }
    };

    window.onpopstate = function (event) {
        $(".ekko-lightbox, .modal-wrapper .modal").modal("hide");

        perform(event.state.path, {});
    };

    window.perform = perform;

    window.toggleMenu = function () {
        var menu = $("a[data-leaf][href='" + $(".breadcrumb-item[data-menu]").first().data("menu") + "']").blur();

        $("a.active[data-leaf]").removeClass("active");

        menu.addClass("active").parents(".has-treeview").addClass("menu-open").children("ul").css("display", "block");

        saveMenu();

        $("body.sidebar-open").toggleClass("sidebar-collapse sidebar-open");
    };

    $("button[data-language]").click(function (event) {
        location.href = $(event.currentTarget).data("path") + location.href.substring(document.baseURI.length);
    });

    $(document).delegate("a[data-ajax]", "click", function (event) {
        var anchor = $(event.currentTarget);
        var modal = anchor.closest(".modal");
        var path = anchor.attr("href");

        if (modal.length) {
            modal.one("hidden.bs.modal", function () {
                redirect({path});
            }).modal("hide");
        } else if (path === history.state.path) {
            perform(path, {});
        } else {
            redirect({path});
        }

        return false;
    }).delegate("a[data-toggle=lightbox]", "click", function (event) {
        $(event.currentTarget).ekkoLightbox();

        return false;
    }).delegate("button[data-ajax]", "click", function (event) {
        var button = $(event.currentTarget);
        var form = button.data("form");
        var options;

        if (form) {
            $(".invalid-feedback", form).hide().empty();
            options = {parameters: {"form-id": form}};
        } else {
            form = {args: button.data("args")};
        }

        perform(button.data("ajax"), form, options);
    }).delegate("button[data-backward]", "click", function () {
        backward();
    }).delegate("button[data-search]", "click", function (event) {
        var form = serialize($(event.currentTarget).data("form"));
        var path = history.state.path.replace(/(\?.*)/, "");
        var search = {};

        $.each(Object.keys(form), function (ignore, name) {
            var value = $.trim(form[name]);

            if (value) {
                search[name] = encodeURIComponent(value);
            }
        });

        if (Object.keys(search).length) {
            path += "?q=" + encode(JSON.stringify(search));
        }

        redirect({path});
    }).delegate("input[data-all][type=checkbox]", "change", function (event) {
        var list = $("input[data-id][type=checkbox]");

        list.prop("checked", $(event.currentTarget).prop("checked"));

        toggleControls(list.filter(":checked"));
    }).delegate("input[data-id][type=checkbox]", "change", function () {
        var list = $("input[data-id][type=checkbox]");
        var checked = list.filter(":checked");

        $("input[data-all][type=checkbox]").prop("checked", list.length === checked.length);

        toggleControls(checked);
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
