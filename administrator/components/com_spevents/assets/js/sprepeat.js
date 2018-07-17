(function ($) {
    $.fn.spRepeat = function(options){
        var options = $.extend({
            base_url = '',
            common_name = ''
        }, options);

        const base_url = options.base_url;
        const common_name = options.common_name;

        $(document).on("click", "#spevents-add-new-section", function (e) {
            e.preventDefault();

            console.log(base_url);

            $(this).css({
                "border": "none"
            });
            var clone = $(".spevents-clonable:first-child").clone();

            clone.find("input, textarea").each(function () {
                $(this).val("");
            });
            clone.find(".sp-media-preview").each(function () {
                $(this).attr("src", base_url + "images/no-preview.jpg");
            });
            $(".spevents-section-container").append(clone);


            var count = 0;
            $(".spevents-clonable").each(function () {

                $(this).find("input, textarea").each(function () {
                    var name = $(this).attr("name").split("][");
                    name[1] = common_name + count;
                    name = name.join("][");
                    $(this).attr("name", name);
                });

                $(this).find(".sp-btn-media-manager").each(function () {
                    let id = $(this).attr("data-id").split("-");
                    id[2] = common_name + count;
                    id = id.join("-");
                    $(this).attr("data-id", id);
                });

                $(this).find(".sp-media-input").each(function () {
                    let id = $(this).attr("id").split("-");
                    id[2] = common_name + count;
                    id = id.join("-");
                    $(this).attr("id", id);
                });
                count++;
            });
        });

        $(document).on("click", ".spevents-close", function (e) {
            e.preventDefault();
            var parent = $(this).parent();
            var clonables = $(".spevents-clonable");
            if (clonables.length > 1)
                parent.remove();

            var count = 0;
            $(".spevents-clonable").each(function () {

                $(this).find("input, textarea").each(function () {
                    var name = $(this).attr("name").split("][");
                    name[1] = common_name + count;
                    name = name.join("][");
                    $(this).attr("name", name);
                });

                $(this).find(".sp-btn-media-manager").each(function () {
                    let id = $(this).attr("data-id").split("-");
                    id[2] = common_name + count;
                    id = id.join("-");
                    $(this).attr("data-id", id);

                });

                $(this).find(".sp-media-input").each(function () {
                    let id = $(this).attr("id").split("-");
                    id[2] = common_name + count;
                    id = id.join("-");
                    $(this).attr("id", id);
                });

                count++;
            });
        });

        function readURL(input, preview) {
            var link = "";
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    link = e.target.result;
                    preview.attr("src", link);
                }
                reader.readAsDataURL(input.files[0]);
            }
            return link;
        }
        $(document).on("change", ".image", function (e) {
            var preview = $(this).parent().find(".spevents-preview");
            //console.log(preview);
            readURL(this, preview);
        });

    }
})(jQuery);
