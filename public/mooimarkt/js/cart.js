(function ($) {
    var Cart = {
        init: function () {
            this.bind();
            // this.section_example = $(this.example_block).find(this.example_section);
            // this.lesson_example = $(this.example_block).find(this.example_lesson);
            // this.main_block = $(this.main_block_id);
            // this.sections_items_list = this.main_block.find(this.sections_items_list_class);
            // this.section_iter = this.main_block.data('iter');
        },
        bind: function () {
            $(document).on("click", ".addToCart", this.add);
        },
        add: function (e) {
            e.preventDefault();

        },
    };

    $(document).ready(function () {
        Cart.init();
    });
})(jQuery);