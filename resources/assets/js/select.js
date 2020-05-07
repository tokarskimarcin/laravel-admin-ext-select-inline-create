$('.select-inline-button:not([data-has-event])').each((key, element)=>{
    var $modalButton = $(element);
    $modalButton.attr('data-has-event', true);
}).on('modelCreated', function (e) {
    var $modalButton = $(e.target);
    var $select = $modalButton.closest('.form-group').find('.select-inline-create');
    var searchUrl = $select.data('model-search-url');
    var createdModelId = $modalButton.data('model-id');
    console.log(createdModelId, searchUrl);
    if(createdModelId && searchUrl){
        disable($modalButton);
        $.ajax({
            'url': searchUrl,
            'method': 'GET',
            'data': {
                'id': createdModelId
            }
        }).error((jqXHR, textStatus, errorThrown)=>{
            swal(jqXHR.status.toString(), errorThrown, 'error');})
            .success((result)=>{
                if(result.success){
                    var option = result.option;
                    // Set the value, creating a new option if necessary
                    if ($select.find("option[value='" + option.id + "']").length) {
                        $select.val(option.id).trigger('change');
                    } else {
                        // Create a DOM Option and pre-select by default
                        var newOption = new Option(option.text, option.id, true, true);
                        // Append it to the select
                        $select.append(newOption).trigger('change');
                    }
                }else{
                    toastr.error(result.message);
                }
            })
            .always(() => {
                enable($modalButton);
            })
    }else{
        console.warn("There is no model id in form response or there is no url of model searching.");
    }
});


function disable($button){
    switch ($button.prop('tagName')) {
        case 'A':
            $button.data('data-href', $button.attr('href'));
            $button.attr('href', 'javascript:void(0)');
        //intentional break statement missing
        case 'BUTTON':
            $button.attr('disabled', true);
            break;
    }
}

function enable($button) {
    switch ($button.prop('tagName')) {
        case 'A':
            $button.attr('href', $button.data('data-href'));
            $button.removeAttr('data-href');
        //intentional break statement missing
        case 'BUTTON':
            $button.removeAttr('disabled');
            break;
    }
}
