module.exports = {

    template: '<textarea :name="name"></textarea>',

    props: {
        model: {
            required: true,
        },

        name: {
            type: String,
            required: true,
        },

        height: {
            type: String,
            default: '150'
        }
    },

    mounted:function () {
        {
            (function($,_this){
                let config = {
                    height: _this.height,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                    ],
                };

                let vm = _this;

                config.callbacks = {

                    onInit: function () {
                        $(vm.$el).summernote("code", vm.model);
                    },

                    onChange: function () {
                        vm.$emit('change', $(vm.$el).summernote('code'));
                    },

                    onBlur: function () {
                        vm.$emit('change', $(vm.$el).summernote('code'));
                    }
                };

                $(_this.$el).summernote(config);
            })(jQuery,this)
        }
    },

}
