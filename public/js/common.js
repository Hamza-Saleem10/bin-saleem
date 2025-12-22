let _$ = $(document);

$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});  

_$.ajaxError(function (event, jqxhr, settings, thrownError) {
    if (jqxhr.status === 401) {
        console.log(401);
        document.location.href = route('login');
    } else if (jqxhr.status === 419) {
        console.log(419);
        errorMessage('Session expired');
    }
});

_$.ready(function(){ 
     
    if (typeof $(".datepicker") !== 'undefined' && $(".datepicker").datepicker) {
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+15"
        });
    }
    
    
    $('[data-toggle="tooltip"]').tooltip();

    if (typeof $(".select2") !== 'undefined' && $(".select2").select2) {
        $(".select2").select2({
            // placeholder: "Select Option",
            allowClear: false
        });    
    }

    $('.datatable').on('click', '.btn-status', function (e) {

        e.preventDefault();  
        $datatable = $(this).parents('.datatable');
        var url= $(this).attr('href');

        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure! You want to update status of this record?',
            type: 'red',
            typeAnimated: true,
            closeIcon: true,
            buttons: {
                confirm: function () {
                    $datatable.find("tbody").LoadingOverlay("show");
                    $.ajax({
                        type: "get",
                        url: url,
                        dataType: "json",
                        complete:function (res) {
                            $datatable.find("tbody").LoadingOverlay("hide");
                            var result = JSON.parse(res.responseText);
                            //var result = j.result;
                            if(res.status == 200){
                                reloadDatatable($datatable);
                                successMessage(result.message);
                            }else{
                                errorMessage(result.message);
                            }
                        },
                          error: function (request, status, error) {
                              $datatable.find("tbody").LoadingOverlay("hide");                     
                              var result = request.responseJSON.result;
                              var err = JSON.parse(request.responseText);
                              if(status == 401){
                                errorMessage(result.message);                  
                            }else{
                                errorMessage(err.message);
                            }                    
                          } 
                    });                                                                         
                },
                cancel: function () { },
            }
        });

        return false;

    });

    $('.datatable').on('click', '.btn-delete', function (e) 
    {
        e.preventDefault();  
        $datatable = $(this).parents('.datatable');
        var url= $(this).attr('href');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        $.confirm({
            title: 'Confirm!',
            content: 'Are you sure! You want to remove this record?',
            type: 'red',
            typeAnimated: true,
            closeIcon: true,
            buttons: {
                confirm: function () {
                    $datatable.find("tbody").LoadingOverlay("show");
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        dataType: "json",
                        complete:function (res) {
                            $datatable.find("tbody").LoadingOverlay("hide");
                            var result = JSON.parse(res.responseText);
                            //var result = j.result;
                            if(res.status == 200){
                                reloadDatatable($datatable);
                                successMessage(result.message);
                            }else{
                                errorMessage(result.message);
                            }
                        },
                          error: function (request, status, error) {
                              $datatable.find("tbody").LoadingOverlay("hide");                     
                              var result = request.responseJSON.result;
                              var err = JSON.parse(request.responseText);
                              if(status == 401){
                                errorMessage(result.message);                  
                            }else{
                                errorMessage(err.message);
                            }                    
                          } 
                    });                                                                         
                },
                cancel: function () { },
            }
        });

        return false;
    });    
    
});

/**
 * Create Ajax Datatables
 * @param url
 * @param columns
 * @param index_field
 * @param ordering
 * @param pageLength
 * @param permitOrder
 */
function create_datatables (url, columns, datatable_class = 'datatable', index_field = true, ordering = [], pageLength=10, permitOrder = true, exportData = false, exportButtons = ['csv', 'excel', 'pdf', 'print'])
{
    if (index_field) {
        $('.'+datatable_class+' thead tr').prepend("<th>#</th>");
        $('.'+datatable_class+' tfoot tr').prepend("<th>#</th>");

        columns.unshift({name:'index', data: 'index', width: '2%', className: 'text-center', orderable: false, searchable: false});
    }
    
    var options = {
        // search: {return: true},
        oLanguage: { sProcessing: '<img src="'+ Ziggy.url +'/images/bx_loader.gif">' },
        processing: true,
        serverSide: true,
        ordering: permitOrder,
        responsive: true,
        pageLength: pageLength,
        bLengthChange: (pageLength>0)?(pageLength==30?false:true):false,
        searching: (pageLength>0)?true:false,
        paging: (pageLength>0)?true:false,
        info: (pageLength>0)?(pageLength==30?false:true):false,
        ajax: {
            url: url,
            type:'POST',
        },
        columns: columns,
        order: ordering,
        drawCallback: function ( settings ) {
            var api = this.api();

            if (index_field) {
                api.column(0).nodes().each(function (cell, i) {
                    var index = (i+1) + (t.page.info().page * t.page.info().length);
                    cell.innerHTML = index;
                });
            }
        }
    };
    
    if (exportData) {
        options.dom = 'Bfrtip';
        options.buttons = exportButtons;
    }

    $('#'+datatable_class).DataTable().clear().destroy();
    var t = $('.'+datatable_class).DataTable(options);
    return t;
}

/**
 * Show Dropdown
 * @param el
 * @param show
 */
function loadDropdown(el, show = false, callback = false) {
    el = $(el);
    $url = el.attr('data-url');
    console.log(el);
    console.log(el.id);
    $ddName = el.attr('name');
    $placeholder = el.attr('data-placeholdertext');
    $selected = el.attr('data-selectedid');
    $otherIdName = (el.attr('data-otheridname')) ? el.attr('data-otheridname') : '';
    $otherIdValue = (el.attr('data-otheridvalue')) ? el.attr('data-otheridvalue') : '';
    // $designationIdValue = (el.attr('data-designationIdValue')) ? el.attr('data-designationIdValue') : '';
    // $gradeValue = (el.attr('data-gradeValue')) ? el.attr('data-gradeValue') : '';

    $id = $selected;
    $ddName = $ddName;

    var _self = $('#select2-' + $ddName + '-container');
    if (_self[0] == undefined){
        _self = $('#' + $ddName);
    }

    loadingOverlay(_self, show);
    $.ajax({
        type: "POST",
        url: $url,
        data: {
            'id': $id,
            'placeholder': $placeholder,
            'ddName': $ddName,
            'otherIdValue': $otherIdValue,
        },
        dataType: "json",
        success: function (data, textStatus, jqXHR) {
            console.log(data);
            $('select[name=' + data.request.ddName + ']').html(data.options);
            if ($id > 0) {
                $('select[name=' + data.request.ddName + ']').change();
            }

            if (callback) {
                callback(data);
            }
        },
        error: function (data, textStatus, jqXHR) {
            //process error msg
        },
        complete:function (res) {
            stopOverlay(_self, show);
        }
    });
}

/**
 * Show Ajax Error Message
 * @param response
 */
function showAjaxErrorMessage(response, form = false)
{
    let responseJson = JSON.parse(response.responseText);
    let errors = responseJson.errors;
    
    if (form) {
        if (errors !== undefined) {
            Object.keys(errors).forEach(function (item) {
                for (let value of errors[item]) {                    
                    $('[name=' + item + ']').parent('.form-group').find(".text-danger").text(value);
                    $('#' + item + '-error').text(value);
                    $('[name=' + item + ']').addClass('is-invalid');
                }
            });
        }
    } 
    if (errors !== undefined) {
        Object.keys(errors).forEach(function (item) {
            for (let value of errors[item]) {
                errorMessage(value);
            }
        });
    } else if (responseJson.message !== undefined) {
        errorMessage(responseJson.message);
    }
    
}

/**
 * Loading overlay js
 * @param _ele
 */
let loadingOverlay = (_ele, show = true) => {
    if (show) {
        _ele.LoadingOverlay('show');
    }    
}

/**
 * Stopping overlay js
 * @param _ele
 */
let stopOverlay = (_ele, hide = true) => {
    if (hide) {
        _ele.LoadingOverlay('hide');
    }
}

$.fn.serializeFiles = function () {
    let form = $(this),
        formData = new FormData(),
        formParams = form.serializeArray();

    $.each(form.find('input[type="file"]'), function (i, tag) {
        $.each($(tag)[0].files, function (i, file) {
            formData.append(tag.name, file);
        });
    });

    $.each(formParams, function (i, val) {
        formData.append(val.name, val.value);
    });

    return formData;
};

/**
 * Reload Datatable
 * @param _ele
 */
function reloadDatatable (tableId = '#datatable') {
    let _datatable = $(tableId);
    let reloadDatatable = _datatable.dataTable({ bRetrieve : true });
    if(reloadDatatable != ""){
        reloadDatatable.fnDraw(); 
    }
}

/**
 * Generate Random Number
 * @param length
 */
function generateRandomNumber (length) {
    if(!length) { length = 16; }
    //var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var chars = "1234567890";
    var result="";

    for (var i = length; i > 0; --i)
        result += chars[Math.round(Math.random() * (chars.length - 1))]
    return result
}

_$.ready(function(){               
    $('.tooltips').tooltip();
    $('[data-toggle="tooltip"]').tooltip();
});

 
/**
 * Show Success Message
 * @param message
 * @param title
 */
function successMessage(message, title)
{
    if (!title) title = "Success!";
    toastr.remove();
    toastr.success(message, title, {
        closeButton: true,
        timeOut: 4000,
        progressBar: true,
        newestOnTop: true
    }); 
}

/**
 * Show Error Message
 * @param message
 * @param title
 */
function errorMessage(message, title)
{
    if (!title) title = "Error!";
    toastr.remove();
    toastr.error(message, title, {
        closeButton: true,
        timeOut: 4000,
        progressBar: true,
        newestOnTop: true
    }); 
}

/**
 * Validate Phone Number
 * @param $number
 */
function validatePhoneNumber(number)
{
    regex = /^03[0-9]{9}$/;
    return regex.test(number);
}

/**
 * Validate Cnic Number
 * @param $number
 */
function validateCnicNumber(number)
{
    regex = /^[1-9]{1}[0-9]{12}$/;
    $format = regex.test(number);
    $repeat0 = /^[0-9]*[0]{6}[0-9]*$/.test(number);
    $repeat1 = /^[0-9]*[1]{6}[0-9]*$/.test(number);
    $repeat2 = /^[0-9]*[2]{6}[0-9]*$/.test(number);
    $repeat3 = /^[0-9]*[3]{6}[0-9]*$/.test(number);
    $repeat4 = /^[0-9]*[4]{6}[0-9]*$/.test(number);
    $repeat5 = /^[0-9]*[5]{6}[0-9]*$/.test(number);
    $repeat6 = /^[0-9]*[6]{6}[0-9]*$/.test(number);
    $repeat7 = /^[0-9]*[7]{6}[0-9]*$/.test(number);
    $repeat8 = /^[0-9]*[8]{6}[0-9]*$/.test(number);
    $repeat9 = /^[0-9]*[9]{6}[0-9]*$/.test(number);

    if ($format && !$repeat0 && !$repeat1 && !$repeat2 && !$repeat3 && !$repeat4 && !$repeat5 && !$repeat6 && !$repeat7 && !$repeat8 && !$repeat9) {
        return true;
    }
    return false;
}

function generalMessage(response = false) {
    if (response.success) {
        toastr.success(response.message, "Successful");
    }
    else {
        toastr.warning(response.message, "Error");
    }
}

function validationErrors(formId, response) {
    $('.error-message').remove();
    $('.error').next('div').remove();
    $('.valid').next('div').remove();
    $('.error').removeClass('error');

    var errorString = '';
    var index = 0;

    $.each( response.data, function( key, value) {

        if (index === 0) {
            toastr.error(value, "Error");
            index++;
        }
        
        // if($.isArray(value)) {
        //     value = value[0];
            
        //     errorString += value + '<br>';
        //     // debugger;
        //     $("#"+formId+" name=" + key + "[]").addClass('error');
        //     $("#"+formId+" name=" + key + "[]").next('div').remove();
        //     $("#"+formId+" name=" + key + "[]").after('<div class="error-message">'+value+'</div>');
        // }

        errorString += value + '<br>';
        // debugger;
        $("#"+formId+" #" + key).addClass('error');
        $("#"+formId+" #" + key).next('div').remove();
        $("#"+formId+" #" + key).after('<div class="error-message">'+value+'</div>');
        
    });
    toastr.warning(response.message, "Error");
    $(".btn-submit").attr("disabled", false);
}

function ajaxCall(formId = false, url, method = "GET", data = null, dataType = 'json', onSuccessCallback = false, onErrorCallback = false) {
    
    $('.error-message').remove();
    $('.error').next('div').remove();
    $('.valid').next('div').remove();
    $('.error').removeClass('error');

    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: dataType,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            
            if (response.code == 422) {
                validationErrors(formId, response);
                return false;
            }

            if (onSuccessCallback) {
                onSuccessCallback(response);
                return false;
            } else {
                generalMessage(response);
            }            
        },
        error: function (xhr, status, error) {
            if (onErrorCallback) {
                onErrorCallback(error);
            } else {
                generalMessage(error);
            }
        }
    });
}


function simpleAjaxCall(
    url,
    method = "GET",
    data = null,
    dataType = "json",
    onSuccessCallback = false,
    onErrorCallback = false
) {
    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: dataType,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.code == 422) {
                validationErrors(formId, response);
                return false;
            }

            if (response.token != undefined) {
                $('meta[name="csrf-token"]').attr("content", response.token);
            }

            if (onSuccessCallback) {
                onSuccessCallback(response);
                return false;
            } else {
                generalMessage(response);
            }
        },
        error: function (xhr, status, error) {
            if (onErrorCallback) {
                onErrorCallback(xhr);
            } else {
                generalMessage(error);
            }
        },
    });
}

/**
 * Accepts either a URL or querystring and returns an object associating 
 * each querystring parameter to its value. 
 *
 * Returns an empty object if no querystring parameters found.
 */
function getUrlParams(urlOrQueryString) {
    if ((i = urlOrQueryString.indexOf('?')) >= 0) {
      const queryString = urlOrQueryString.substring(i+1);
      if (queryString) {
        return _mapUrlParams(queryString);
      } 
    }
    
    return {};
  }
  
  /**
   * Helper function for `getUrlParams()`
   * Builds the querystring parameter to value object map.
   *
   * @param queryString {string} - The full querystring, without the leading '?'.
   */
  function _mapUrlParams(queryString) {
    return queryString    
      .split('&') 
      .map(function(keyValueString) { return keyValueString.split('=') })
      .reduce(function(urlParams, [key, value]) {
        if (Number.isInteger(parseInt(value)) && parseInt(value) == value) {
          urlParams[key] = parseInt(value);
        } else {
          urlParams[key] = decodeURI(value);
        }
        return urlParams;
      }, {});
  }

  /**
 * Format date to dd-mm-yyyy HH:MM:SS
 * @param {string|Date} data - Date string or Date object
 * @returns {string} Formatted date string
 */
function formatDate(data) {
    if (!data) return "";
    
    try {
        const date = new Date(data);
        if (isNaN(date.getTime())) return "";
        
        return date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        }).replace(',', '');
    } catch (e) {
        console.error('Error formatting date:', e);
        return "";
    }
}

// Alternative: Add it to jQuery as a utility function
if (typeof jQuery !== 'undefined') {
    $.formatDate = formatDate;
    
    // Also as a jQuery plugin for elements
    $.fn.formatDateText = function() {
        return this.each(function() {
            var $this = $(this);
            var formatted = formatDate($this.text());
            if (formatted) {
                $this.text(formatted);
            }
        });
    };
}



