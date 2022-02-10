var table_select_data = [];

// Tagify
const initTagify = () => {
    let inputs = $("input.tagify");
    let options = {};
    $.each(inputs, (index, input) => {
        tagify = new Tagify(input, options);
    });
}

// Attach files
const onAttachFilesClick = (key) => {
    $("#" + key).click();
}

const onFileInputChange = (key) => {
    let files = $("#" + key)[0].files;
    if (files.length > 0) {
        $("#dropzone-" + key + ' .dropzone-item').css('display', '');
        $("#dropzone-" + key + '-filename')[0].innerText = files[0].name;
        $("#dropzone-" + key + '-filesize')[0].innerText = formatSize(files[0].size);
    } else {
        $("#dropzone-" + key + ' .dropzone-item').css('display', 'none');
    }
}

const onFileRemoveClick = (key) => {
    $("#file-" + key).val('');
    onFileInputChange(key);
}

const formatSize = (bytes, decimalPoint) => {
    if (bytes == 0) return '0 Bytes';
    var k = 1000,
        dm = decimalPoint || 2,
        sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

// Map
const initMap = () => {
    Object.keys(formFields).forEach(key => {
        var form = formFields[key];
        if (form.type == "map") {
            var map;
            var marker;
            var centerLocation;
            var markerLocation;

            var idLatitude = "#" + key + "-latitude";
            var idLongitude = "#" + key + "-longitude";
            var idUseMyLocation = "#" + key + "-use-my-location";
            var latitudeInput = $(idLatitude);
            var longitudeInput = $(idLongitude);

            if ($(latitudeInput).val() != 0 && $(longitudeInput).val() != 0) {
                centerLocation = { lat: parseFloat($(latitudeInput).val()), lng: parseFloat($(longitudeInput).val()) }
                markerLocation = centerLocation;
            } else {
                centerLocation = { lat: 33.554, lng: 35.375 };
                markerLocation = { lat: 0, lng: 0 };
            }

            var idMap = "#" + key + "-map";
            map = new google.maps.Map($(idMap)[0], {
                center: centerLocation,
                zoom: 12,
            });

            marker = new google.maps.Marker({
                position: markerLocation,
                draggable: true,
                map: markerLocation.lat != 0 || markerLocation.lng != 0 ? map : null,
            });

            map.addListener("click", (event) => {
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
                $(latitudeInput).val(markerLocation.lat && markerLocation.lng ? markerLocation.lat : "");
                $(longitudeInput).val(markerLocation.lat && markerLocation.lng ? markerLocation.lng : "");
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
                browserHasGeolocation ? alert("Error: Please check your location permission and try again.") : alert("Error: Your browser doesn't support geolocation.");
            }

            const moveCamera = (location, zoom) => {
                map.setCenter({
                    lat: location.lat(),
                    lng: location.lng(),
                });
                map.setZoom(zoom);
            }

            $(latitudeInput).on("input", handleInputChange);
            $(longitudeInput).on("input", handleInputChange);
            $(idUseMyLocation).on("click", useMyLocation);
        }
    });
}

const initMultiSelect = () => {
    $(".searchable").multiSelect({
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

const initTextAreas = () => {
    Object.keys(formFields).forEach((key) => {
        let form = formFields[key];
        let el = $(`#${key}`);
        if (form.type == "textarea") {
            if (item && item[key]) {
                $(el).text(item[key]);
            } else if (old) {
                $(el).text(old[key]);
            }
        }
    });
}

const initDatePickers = () => {
    Object.keys(formFields).forEach((key) => {
        const form = formFields[key];

        if (form.type == 'date') {
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

            $("#" + key).datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                templates: arrows,
                format: "yyyy-mm-dd",
            });
        }
    });
}

const initTimePicker = () => {
    $(".timepicker").timepicker({
        defaultTime: "",
        minuteStep: 1,
        showSeconds: false,
        showMeridian: true
    });
}

const initSwitches = () => {
    $('[data-switch=true]').bootstrapSwitch();
}

const initTableSelects = () => {
    Object.keys(formFields).forEach((key) => {
        const form = formFields[key];
        if (form.type != 'table_select') {
            return;
        }

        const table_select = tableSelects[key];
        if (!table_select) {
            return;
        }

        table_select_data[key] = [];
        let old_data = old[key] ? JSON.parse(old[key]) : [];
        if (old_data && old_data.length > 0) {
            getTableUsersData(key, old_data);
        }

        const table = $(`#table_select_${key}`).DataTable({
            dom: `<'d-flex justify-content-between'<l><f>><'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 mt-0 justify-content-md-end dataTables_pager'p>>`,
            lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            pageLength: 5,
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            columns: table_select.columns,
            ajax: {
                url: table_select.url,
                type: 'GET',
            },
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            columnDefs: [{
                targets: 0,
                orderable: false,
                render: function (data, type, full, meta) {
                    const checked = arrayIncludes(table_select_data[key], 'id', full._id);
                    return `
            <label class="checkbox checkbox-single checkbox-primary mb-0 w-100 d-flex justify-content-center">
                <input type="checkbox" value="" class="checkable" ${checked ? 'checked' : null}/>
                <span></span>
            </label>`;
                },
            }],
            select: {
                style: 'multi',
                selector: 'td:first-child .checkable',
            },
            order: [[1, 'desc']],
        });

        table.getTableRowData = function (obj) {
            let tr = $(obj.closest('tr'));
            let table = $(obj.closest('table'));
            let data = table.DataTable().row(tr).data();
            return data;
        }

        table.on('change', '.checkable', function (e) {
            const checked = $(this).is(':checked');
            const raw = table.getTableRowData(e.target);

            if (checked) {
                table_select_data[key].push(raw);
            } else {
                removeTableSelectRaw(key, raw._id, false);
            }

            reloadTable(`#table_select_results_${key}`, table_select_data[key]);
        });

        const table_select_results = $(`#table_select_results_${key}`).DataTable({
            data: table_select_data[key],
            dom: `<'d-flex justify-content-between'<l><f>><'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 mt-0 justify-content-md-end dataTables_pager'p>>`,
            lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            pageLength: 5,
            responsive: true,
            orderCellsTop: true,
            columns: table_select.columns_result,
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            columnDefs: [{
                targets: 0,
                orderable: false,
                render: function (data, type, full, meta) {
                    return `
            <div class="w-100 d-flex justify-content-center" onclick="removeTableSelectRaw('${key}', '${full._id}', '1')">
              <div class="fas fa-ban pointer text-danger text-hover-secondary" style="font-size: 16px;"></div>
            </div>
          `;
                },
            }],
            order: [[1, 'desc']],
        });
    });

    const getTableUsersData = async (key, ids) => {
        const users = await getUsers(ids);
        table_select_data[key] = users;
        reloadTable(`#table_select_results_${key}`, table_select_data[key]);
        reloadTableAjax(`#table_select_${key}`);
    }

    const getUsers = async (ids) => {
        const response = await sendRequest(urls.getUsers, { users_ids: ids }, 'GET');
        return response.data.users;
    }

    const removeTableSelectRaw = (key, rawId, reloadMain) => {
        if (!table_select_data[key]) {
            return;
        }

        table_select_data[key] = table_select_data[key].filter((item) => {
            return item._id != rawId;
        });

        reloadTable(`#table_select_results_${key}`, table_select_data[key]);
        if (reloadMain) {
            reloadTableAjax(`#table_select_${key}`);
        }
    }

    const reloadTable = (tableKey, data) => {
        const table = $(tableKey).DataTable().clear();
        for (var k = 0; k < data.length; k++) {
            table.row.add(data[k]);
        }
        table.draw();
    }

    const reloadTableAjax = (tableKey) => {
        const table = $(tableKey).DataTable().ajax.reload();
    }

    $('#form').on('submit', (e) => {
        if (tableSelects) {
            Object.keys(tableSelects).forEach((key) => {
                $('<input>').attr({
                    type: 'hidden',
                    id: key,
                    name: key,
                    value: JSON.stringify(getArrayValues(table_select_data[key], 'id')),
                }).appendTo('#form');
            });
        }
    });
}

$(function () {
    initMap();
    initTagify();
    initMultiSelect();
    initTextAreas();
    initDatePickers();
    initTimePicker();
    initSwitches();
    initTableSelects();
});

// Livewire
document.addEventListener("DOMContentLoaded", () => {
    Livewire.hook('message.received', (message, component) => {
        $(component.el).find('.selectpicker').selectpicker('destroy');
    });
});

window.addEventListener('contentChanged', event => {
    if (event.detail.type == 'selectpicker') {
        $('#' + event.detail.key).selectpicker();
    }
});
