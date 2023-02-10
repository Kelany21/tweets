/*
Copyright 2017 Ziadin Givan

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

https://github.com/givanz/VvvebJs
*/

var models = [];
var columns = [];
var slider = ['https://source.unsplash.com/WEQbe2jBg40/600x1200'];

Vvveb.ComponentsGroup['Server Components'] = ["components/products", "components/product", "components/categories", "components/manufacturers", "components/search", "components/user", "components/product_gallery", "components/cart", "components/checkout", "components/filters", "components/product", "components/slider"];


Vvveb.Components.add("components/product", {
    name: "Product",
    attributes: ["data-component-product"],

    image: "icons/map.svg",
    html: '<iframe frameborder="0" src="https://maps.google.com/maps?&z=1&t=q&output=embed"></iframe>',

    properties: [
        {
            name: "Id",
            key: "id",
            htmlAttr: "id",
            inputtype: TextInput
        },
        {
            name: "Select",
            key: "id",
            htmlAttr: "id",
            inputtype: SelectInput,
            data: {
                options: [{
                    value: "",
                    text: "None"
                }, {
                    value: "pull-left",
                    text: "Left"
                }, {
                    value: "pull-right",
                    text: "Right"
                }]
            },
        },
        {
            name: "Select 2",
            key: "id",
            htmlAttr: "id",
            inputtype: SelectInput,
            data: {
                options: [{
                    value: "",
                    text: "nimic"
                }, {
                    value: "pull-left",
                    text: "gigi"
                }, {
                    value: "pull-right",
                    text: "vasile"
                }, {
                    value: "pull-right",
                    text: "sad34"
                }]
            },
        }]
});
Vvveb.Components.add("components/products", {
    name: "Products",
    attributes: ["data-component-products"],

    image: "icons/products.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',

    init: function (node) {
        $('.form-group[data-group]').hide();
        if (node.dataset.type != undefined) {
            $('.form-group[data-group="' + node.dataset.type + '"]').show();
        } else {
            $('.form-group[data-group]:first').show();
        }
    },
    properties: [{
        name: false,
        key: "type",
        inputtype: RadioButtonInput,
        htmlAttr: "data-type",
        data: {
            inline: true,
            extraclass: "btn-group-fullwidth",
            options: [{
                value: "autocomplete",
                text: "Autocomplete",
                title: "Autocomplete",
                icon: "la la-search",
                checked: true,
            }, {
                value: "automatic",
                icon: "la la-cog",
                text: "Configuration",
                title: "Configuration",
            }],
        },
        onChange: function (element, value, input) {

            $('.form-group[data-group]').hide();
            $('.form-group[data-group="' + input.value + '"]').show();

            return element;
        },
        init: function (node) {
            return node.dataset.type;
        },
    }, {
        name: "Products",
        key: "products",
        group: "autocomplete",
        htmlAttr: "data-products",
        inline: true,
        col: 12,
        inputtype: AutocompleteList,
        data: {
            url: "/admin/?module=editor&action=productsAutocomplete",
        },
    }, {
        name: "Number of products",
        group: "automatic",
        key: "limit",
        htmlAttr: "data-limit",
        inputtype: NumberInput,
        data: {
            value: "8",//default
            min: "1",
            max: "1024",
            step: "1"
        },
        getFromNode: function (node) {
            return 10
        },
    }, {
        name: "Start from page",
        group: "automatic",
        key: "page",
        htmlAttr: "data-page",
        data: {
            value: "1",//default
            min: "1",
            max: "1024",
            step: "1"
        },
        inputtype: NumberInput,
        getFromNode: function (node) {
            return 0
        },
    }, {
        name: "Order by",
        group: "automatic",
        key: "order",
        htmlAttr: "data-order",
        inputtype: SelectInput,
        data: {
            options: [{
                value: "price_asc",
                text: "Price Ascending"
            }, {
                value: "price_desc",
                text: "Price Descending"
            }, {
                value: "date_asc",
                text: "Date Ascending"
            }, {
                value: "date_desc",
                text: "Date Descending"
            }, {
                value: "sales_asc",
                text: "Sales Ascending"
            }, {
                value: "sales_desc",
                text: "Sales Descending"
            }]
        }
    }, {
        name: "Category",
        group: "automatic",
        key: "category",
        htmlAttr: "data-category",
        inline: true,
        col: 12,
        inputtype: AutocompleteList,
        data: {
            url: "/admin/?module=editor&action=productsAutocomplete",
        },

    }, {
        name: "Manufacturer",
        group: "automatic",
        key: "manufacturer",
        htmlAttr: "data-manufacturer",
        inline: true,
        col: 12,
        inputtype: AutocompleteList,
        data: {
            url: "/admin/?module=editor&action=productsAutocomplete",
        }
    }, {
        name: "Manufacturer 2",
        group: "automatic",
        key: "manufacturer 2",
        htmlAttr: "data-manufacturer2",
        inline: true,
        col: 12,
        inputtype: AutocompleteList,
        data: {
            url: "/admin/?module=editor&action=productsAutocomplete",
        },
    }]
});
Vvveb.Components.add("components/manufacturers", {
    name: "Manufacturers",
    classes: ["component_manufacturers"],
    image: "icons/categories.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        nolabel: false,
        inputtype: TextInput,
        data: {text: "Fields"}
    }, {
        name: "Name",
        key: "category",
        inputtype: TextInput
    }, {
        name: "Image",
        key: "category",
        inputtype: TextInput
    }
    ]
});
Vvveb.Components.add("components/categories", {
    name: "Categories",
    classes: ["component_categories"],
    image: "icons/categories.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        name: "Name",
        key: "name",
        htmlAttr: "src",
        inputtype: FileUploadInput
    }]
});
Vvveb.Components.add("components/search", {
    name: "Search",
    classes: ["component_search"],
    image: "icons/search.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        name: "asdasdad",
        key: "src",
        htmlAttr: "src",
        inputtype: FileUploadInput
    }, {
        name: "34234234",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "d32d23",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    }]
});
Vvveb.Components.add("components/user", {
    name: "User",
    classes: ["component_user"],
    image: "icons/user.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        name: "asdasdad",
        key: "src",
        htmlAttr: "src",
        inputtype: FileUploadInput
    }, {
        name: "34234234",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "d32d23",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    }]
});
Vvveb.Components.add("components/product_gallery", {
    name: "Product gallery",
    classes: ["component_product_gallery"],
    image: "icons/product_gallery.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        name: "asdasdad",
        key: "src",
        htmlAttr: "src",
        inputtype: FileUploadInput
    }, {
        name: "34234234",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "d32d23",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    }]
});
Vvveb.Components.add("components/cart", {
    name: "Cart",
    classes: ["component_cart"],
    image: "icons/cart.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        name: "asdasdad",
        key: "src",
        htmlAttr: "src",
        inputtype: FileUploadInput
    }, {
        name: "34234234",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "d32d23",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    }]
});
Vvveb.Components.add("components/checkout", {
    name: "Checkout",
    classes: ["component_checkout"],
    image: "icons/checkout.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        name: "asdasdad",
        key: "src",
        htmlAttr: "src",
        inputtype: FileUploadInput
    }, {
        name: "34234234",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "d32d23",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    }]
});
Vvveb.Components.add("components/filters", {
    name: "Filters",
    classes: ["component_filters"],
    image: "icons/filters.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        name: "asdasdad",
        key: "src",
        htmlAttr: "src",
        inputtype: FileUploadInput
    }, {
        name: "34234234",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "d32d23",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    }]
});
Vvveb.Components.add("components/product", {
    name: "Product",
    classes: ["component_product"],
    image: "icons/product.svg",
    html: '<div class="form-group"><label>Your response:</label><textarea class="form-control"></textarea></div>',
    properties: [{
        name: "asdasdad",
        key: "src",
        htmlAttr: "src",
        inputtype: FileUploadInput
    }, {
        name: "34234234",
        key: "width",
        htmlAttr: "width",
        inputtype: TextInput
    }, {
        name: "d32d23",
        key: "height",
        htmlAttr: "height",
        inputtype: TextInput
    }]
});
Vvveb.Components.add("components/slider", {

    name: "Slider",
    attributes: ["data-component-slider"],
    image: "icons/slider.svg",
    html: '<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-component-slider>\n' +
        '  <ol class="carousel-indicators">\n' +
        sliderDots() +
        '  </ol>\n' +
        '  <div class="carousel-inner">\n' +
        '    <div class="carousel-item active">\n' +
        sliderImages() +
        '    </div>\n' +
        '  </div>\n' +
        '  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">\n' +
        '    <span class="carousel-control-prev-icon" aria-hidden="true"></span>\n' +
        '    <span class="sr-only">Previous</span>\n' +
        '  </a>\n' +
        '  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">\n' +
        '    <span class="carousel-control-next-icon" aria-hidden="true"></span>\n' +
        '    <span class="sr-only">Next</span>\n' +
        '  </a>\n' +
        '</div>',
    afterDrop: function (node) {
        if (models.length === 0) {
            $.get('http://127.0.0.1:8000/en/dashboard/page-template/get-models', function (res) {
                res.models.forEach(function (item, index) {
                    models.push({
                        value: item,
                        text: item
                    })
                })

            })
        }

    },
    init: function (node) {

    },
    beforeInit: function (node) {

    },
    onChange: function (node, property, value) {
        console.log(property.key)
        if (property.key === 'model') {
            $.get('http://127.0.0.1:8000/en/dashboard/page-template/get-model-data?model=' + value, function (res) {
                columns = [];
                res.columns.forEach(function (item, index) {
                    columns.push({
                        value: item,
                        text: item
                    })
                })
                console.log(columns)
            })
        }
    },
    properties: [
        {
            name: "Model",
            key: "model",
            inputtype: SelectInput,
            data: {
                options: models
            }
        },
        {
            name: "Column",
            key: "column",
            inputtype: SelectInput,
            data: {
                options: columns
            }
        },
        {
            name: "Limit",
            key: "limit",
            inputtype: NumberInput,
            onChange: function (node, property, value) {
                if (slider.length < property) {
                    for (var i = 0; i < (property - slider.length); i++) {
                        slider.push('https://source.unsplash.com/WEQbe2jBg40/600x1200')
                    }
                }
            }
        }],

});


function sliderDots() {
    var out = '';
    for (var i = 0; i < slider.length; i++) {
        out += '<li data-target="#carouselExampleIndicators" data-slide-to="0" class="' + (i === 0 ? 'active' : '') + '"></li>\n';
    }
    return out;
}

function sliderImages() {
    var out = '';
    for (var i = 0; i < slider.length; i++) {
        out += '      <img class="d-block w-100" src="https://source.unsplash.com/WEQbe2jBg40/600x1200" alt="First slide">\n';
    }
    return out;
}




