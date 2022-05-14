// ------------------- Method -------------------
// Attach files
const onAttachFilesClick = (key) => {
    $('.forms #' + key).trigger('click');
}

const onFileRemoveClick = (key) => {
    $('.forms #' + key).val('');
    onFileInputChange(key);
}

const onFileInputChange = (key) => {
    let files = $('.forms #' + key)[0].files;
    if (files.length > 0) {
        $('#dropzone-' + key + ' .dropzone-item').css('display', '');
        $('#dropzone-' + key + '-filename')[0].innerText = files[0].name;
        $('#dropzone-' + key + '-filesize')[0].innerText = formatSize(files[0].size);
    } else {
        $('#dropzone-' + key + ' .dropzone-item').css('display', 'none');
    }
}

// ------------------- Initialize Forms -------------------
// Tagify
const initTagifyForm = (selector, key, form, value) => {
    new Tagify($(selector)[0], {});
}

// Select
const initSelectForm = (selector, key, form, value) => {
    $(selector).select2();
}

// Map
const initMapForm = (selector, key, form, value) => {
    var map;
    var marker;
    var centerLocation;
    var markerLocation;

    var idLatitude = '.forms #' + key + '-latitude';
    var idLongitude = '.forms #' + key + '-longitude';
    var idUseMyLocation = '.forms #' + key + '-use-my-location';
    var latitudeInput = $(idLatitude);
    var longitudeInput = $(idLongitude);

    if ($(latitudeInput).val() != 0 && $(longitudeInput).val() != 0) {
        centerLocation = { lat: parseFloat($(latitudeInput).val()), lng: parseFloat($(longitudeInput).val()) }
        markerLocation = centerLocation;
    } else {
        centerLocation = { lat: 33.554, lng: 35.375 };
        markerLocation = { lat: 0, lng: 0 };
    }

    var idMap = '.forms #' + key + '-map';
    map = new google.maps.Map($(idMap)[0], {
        center: centerLocation,
        zoom: 12,
    });

    marker = new google.maps.Marker({
        position: markerLocation,
        draggable: true,
        map: markerLocation.lat != 0 || markerLocation.lng != 0 ? map : null,
    });

    map.addListener('click', (event) => {
        if (!marker.map) {
            marker.setMap(map);
        }
        marker.setPosition(event.latLng.toJSON());
        updateLocationInput(event.latLng.toJSON());
    });
    marker.addListener('drag', (event) => {
        updateLocationInput(event.latLng.toJSON());
    });
    marker.addListener('dragend', (event) => {
        updateLocationInput(event.latLng.toJSON());
    });

    function updateLocationInput(markerLocation) {
        $(latitudeInput).val(markerLocation.lat && markerLocation.lng ? markerLocation.lat : '');
        $(longitudeInput).val(markerLocation.lat && markerLocation.lng ? markerLocation.lng : '');
    }

    updateLocationInput(markerLocation);

    function handleInputChange() {
        if (!marker.map) {
            marker.setMap(map);
        }
        var latLng = new google.maps.LatLng(parseFloat($(latitudeInput).val()), parseFloat($(longitudeInput).val()));
        marker.setPosition(latLng);
    }

    const useMyLocation = () => {
        var options = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    moveCamera(latLng, 12);
                    updateLocationInput(latLng, 12);
                    handleInputChange();
                },
                (e) => {
                    handleLocationError(true);
                }, options);
        } else {
            handleLocationError(false);
        }
    }

    const handleLocationError = (browserHasGeolocation) => {
        browserHasGeolocation ? alert('Error: Please check your location permission and try again.') : alert('Error: Your browser doesn\'t support geolocation.');
    }

    const moveCamera = (location, zoom) => {
        map.setCenter({
            lat: location.lat(),
            lng: location.lng(),
        });
        map.setZoom(zoom);
    }

    $(latitudeInput).on('input', handleInputChange);
    $(longitudeInput).on('input', handleInputChange);
    $(idUseMyLocation).on('click', useMyLocation);
}

const initMultiSelectForm = (selector, key, form, value) => {
    $(selector).multiSelect({
        selectableHeader: "<input type='text' class='form-control search-input mb-3' autocomplete='off' placeholder='type to filter'>",
        selectionHeader: "<input type='text' class='form-control search-input mb-3' autocomplete='off' placeholder='type to filter'>",
        afterInit: function (ms) {
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                .on('keydown', function (e) {
                    if (e.which === 40) {
                        that.$selectableUl.focus();
                        return false;
                    }
                });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                .on('keydown', function (e) {
                    if (e.which == 40) {
                        that.$selectionUl.focus();
                        return false;
                    }
                });
        },
        afterSelect: function () {
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function () {
            this.qs1.cache();
            this.qs2.cache();
        }
    });
}

const initTextAreaForm = (selector, key, form, value) => {
    $(selector).text(value);
};

const initDatePickerForm = (selector, key, form, value) => {
    let arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }

    $(selector).datepicker({
        rtl: KTUtil.isRTL(),
        todayHighlight: true,
        orientation: 'bottom left',
        templates: arrows,
        format: 'yyyy-mm-dd',
    });
}

const initTimePickerForm = (selector, key, form, value) => {
    $(selector).timepicker({
        defaultTime: '',
        minuteStep: 1,
        showSeconds: false,
        showMeridian: true
    });
}

const initSwitchForm = (selector, key, form, value) => {
    $(selector + '[data-switch=true]').bootstrapSwitch();
}

const initForms = () => {
    Object.keys(formFields.forms).forEach((key) => {
        const form = formFields.forms[key];
        form.translatables.forEach(translatable => {
            let selector, value;
            if (translatable) {
                selector = ".forms [id='" + key + "[" + translatable + "]" + "']";
            } else {
                selector = ".forms [id='" + key + "']";
            }

            if (item) {
                if (translatable) {
                    value = item[key][translatable];
                } else {
                    value = item[key];
                }
            } else {
                if (translatable) {
                    value = old[key][translatable];
                } else {
                    value = old[key];
                }
            }

            console.log({ selector, value });

            switch (form.type) {
                case 'map':
                    initMapForm(selector, key, form, value);
                    break;
                case 'tagify':
                    initTagifyForm(selector, key, form, value);
                    break;
                case 'select':
                    // initSelectForm(selector, key, form, value);
                    break;
                case 'multiselect':
                    initMultiSelectForm(selector, key, form, value);
                    break;
                case 'textarea':
                    initTextAreaForm(selector, key, form, value);
                    break;
                case 'date':
                    initDatePickerForm(selector, key, form, value);
                    break;
                case 'time':
                    initTimePickerForm(selector, key, form, value);
                    break;
                case 'switch':
                    initSwitchForm(selector, key, form, value);
                    break;
            }
        });
    });
}

$(function () {
    initForms();
});

const initWidgets = () => {
    $('.select2').select2();
    $('.selectpicker').selectpicker();
}
initWidgets();
