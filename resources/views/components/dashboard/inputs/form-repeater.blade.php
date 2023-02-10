<div id="kt_repeater_1">
    <div class="form-group row" id="kt_repeater_1">
        <label class="col-lg-2 col-form-label text-right">Contacts:</label>
        <div data-repeater-list="" class="col-lg-10">
            <div data-repeater-item class="form-group row align-items-center">
                <div class="col-md-3">
                    <label>Name:</label>
                    <input type="email" class="form-control" placeholder="Enter full name"/>
                    <div class="d-md-none mb-2"></div>
                </div>
                <div class="col-md-3">
                    <label>Number:</label>
                    <input type="email" class="form-control" placeholder="Enter contact number"/>
                    <div class="d-md-none mb-2"></div>
                </div>
                <div class="col-md-2">
                    <div class="radio-inline">
                        <label class="checkbox checkbox-success">
                            <input type="checkbox"/> Primary
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                        <i class="la la-trash-o"></i>Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-form-label text-right"></label>
        <div class="col-lg-4">
            <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                <i class="la la-plus"></i>Add
            </a>
        </div>
    </div>
</div>

<script>
    // Class definition
var KTFormRepeater = function() {

// Private functions
var demo1 = function() {
    $('#kt_repeater_1').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function () {
            $(this).slideDown();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });
}

return {
    // public functions
    init: function() {
        demo1();
    }
};
}();

jQuery(document).ready(function() {
KTFormRepeater.init();
});
</script>