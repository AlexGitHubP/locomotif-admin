
function goUp(input){
    var label = $(input).parent().find('.login-label');
    $(label).animate({
        top: 0,
        fontSize: 14,
        opacity: 1
    });
}

function pxToVw(px) {
    const viewport = window.innerWidth;
    const vw = px / (viewport / 100);
    return vw;
}

function checkInput(){
    var tt = $('.login-input-holder');
    $.each(tt, function(_index, value){
        var cc = $(value).val();
        (cc.length === 0) ? goUp(value) : goDown();
    })
}
function mapCharacters(inputString){
    var mapping = {
        'ș': 's',
        'ț': 't',
        'ă': 'a',
        'î': 'i',
        'â': 'a',
        'Ș': 'S',
        'Ț': 'T',
        'Ă': 'A',
        'Î': 'I',
        'Â': 'A'
    };
    
    var returnClean = inputString.replace(/[^\x00-\x7F]/g, function(char) {
        return mapping[char] || char;
    });

    return returnClean;
}
function processAttribute(response){
    console.log(response)
    let attrInfos = response.infos;
    let metaName = attrInfos.meta_attribute.charAt(0).toUpperCase() + attrInfos.meta_attribute.slice(1);
    let parentExists = $('.gID'+attrInfos.meta_key).length;
        if(parentExists==1){
            $('.gID'+attrInfos.meta_key).append(
                `<div class="attr_group">
                    <p>${metaName}:</p>
                    <ul class="attr_meta">
                        <li data-id="${attrInfos.id}">${attrInfos.meta_value}<span>X</span></li>
                    </ul>
                </div>`
            )
        }else{
            $('.dynamicParent').append(
                `
                <div class="attr_values_group gID${attrInfos.meta_key}">
                    <p class="displayBlock">${attrInfos.meta_name}</p>
                    <div class="attr_group">
                        <p>${metaName}:</p>
                        <ul class="attr_meta">
                            <li data-id="${attrInfos.id}">${attrInfos.meta_value}<span>X</span></li>
                        </ul>
                    </div>
                </div>`
            )
        }
    
    showSnackbar(response.success, response.message, 1000)
}

function processRequest(response){
    if(typeof response.type !== 'undefined' && response.type !== ''){
        switch (response.type) {
            case 'product':
                console.log(response)
            break;
            case 'category':
                showSnackbar(response.success, response.message, 1000)
            break;
            case 'productMeta':
                processAttribute(response)
            break;
            case 'mediaDelete':
                showSnackbar(response.success, response.message, 1000)
                nodeReference.fadeOut('400', function(){
                    nodeReference.remove()
                    $(".media-element[data-id='" + response.id +"']").fadeOut('400', function(){
                        $(this).remove()
                    });
                })
            break;
            
        
            default:
                alert('Nu exista tipul acesta de atribut alocat.')
            break;
        }
    }
}

function generalAjaxSubmit(tableName, formID, submitUrl){
    let form = document.getElementById(formID);
    let formData = new FormData(form);
    
    $.ajax({
        method:'POST',
        dataType:'json',
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        data:formData,
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:submitUrl,
    }).done(function(response){
        if(response.success==true){
            processRequest(response)
        }else{
            alert('A intervenit o eroare la salvarea elementului. Va rugam incercati din nou.')
        }
    }).fail(function(response){
        alert('A intervenit o eroare. Va rugam incercati din nou.')
    })
}
function checkIfAttrValueAlreadyExists(meta_attribute, meta_key, pid, attr_identifier){
    let formData = new FormData();
        formData.append('meta_attribute', meta_attribute);
        formData.append('pid', pid);
        formData.append('meta_key', meta_key);
        
    $.ajax({
        method:'POST',
        dataType:'json',
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        data:formData,
        cache: false,
        custom: {attr_identifier:attr_identifier},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/admin/productsMeta/checkMetaExists',
    }).done(function(response){
        if(response.exists==true){
            showSnackbar('error', 'Exista deja asociată această proprietate pentru produs.', 2000)
        }else{
            getGroupedAttributeValues(attr_identifier)
        }
    })
}
function getGroupedAttributeValues(attr_identifier){
    let formData = new FormData();
        formData.append('attr_identifier', attr_identifier);
    $.ajax({
        method:'POST',
        dataType:'json',
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        data:formData,
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/admin/productsAttributesValues/getGroupedAssocValues',
    }).done(function(response){
        let html =`<div class="input-element">
                    <label for="value_elements">Adaugă valori</label>
                        <select name='meta_value[]' id='meta_value' value='' multiplename="value_elements">
                        ${Object.keys(response).map(key => (
                            `<option value="${response[key]['attr_value']}">${response[key]['attr_value']}</option>`
                        )).join('')}
                        </select>
                    </div>`;
    
        $('.attrSelectors').html(html)
        // setTimeout(function(){
        //     const value_elements = $('#meta_value').filterMultiSelect({
        //         selectAllText:"Alege toate",
        //         filterText:"Caută după"
        //     });
        // }, 10)
    })
}

function getAttributeValues(attr_id, text){
    var formData = new FormData();
        formData.append('attr_id', attr_id);
    $.ajax({
        method:'POST',
        dataType:'json',
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        data:formData,
        cache: false,
        custom:{text:text},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/admin/productsAttributesValues/getAssocValues',
      }).done(function(response){
        let html =`<div class="input-element">
                    <label for="attr_value_type">Adaugă proprietate pentru ${text}:</label>
                        <select name='meta_combined_key' id='meta_combined_key' value=''>
                            <option value="">Alege</option>
                        ${Object.keys(response).map(key => (
                            `<option value="${response[key]['attr_value_identifier']}">${response[key]['attr_value_name']}</option>`
                        )).join('')}
                        </select>
                    </div>`;
       
        $('.constructAttrSelectors').html(html)
    })
}

function buildAttributeIdentifier(){
    let listenToInput = $('.buildAttributeIdentifier');
    let target = $(listenToInput).attr('data-target');
    let parentIdentifier = $('#attr_identifier').val()
    
    $(listenToInput).on('input', function(event) {
        var inputValue = $(this).val();    
            //remove empty spaces
            inputValue = inputValue.replace(/\s+/g, '_');
            //all lowercase
            inputValue = inputValue.toLowerCase();
            //all latin characters replaced
            inputValue = mapCharacters(inputValue);
            //replace all unwanted characters, and numbers and leave only alphabet and lowerscore
            inputValue = inputValue.replace(/[^a-zA-Z_]/g, ''); 
        $('#'+target).val(parentIdentifier+'_'+inputValue)
      });
}

function buildNiceUrl(){
    let listenToInput = $('.builNiceUrl');
    let target = $(listenToInput).attr('data-target');
    
    $(listenToInput).on('input', function(event) {
        var inputValue = $(this).val();    
            //remove empty spaces
            inputValue = inputValue.replace(/\s+/g, '-');
            //all lowercase
            inputValue = inputValue.toLowerCase();
            //all latin characters replaced
            inputValue = mapCharacters(inputValue);
            //replace all unwanted characters, and numbers and leave only alphabet and lowerscore
            inputValue = inputValue.replace(/[^a-zA-Z0-9-]/g, ''); 
        $('#'+target).val(inputValue)
      });
}

function buildTags() {
    let element = $('.tagElement');
    $(element).tagComplete({
        data: [],
        keyLimit:2000,
        freeInput :true,
        freeEdit :true,
        hide:false,
    });
    
}

function deleteAttributeMeta(element, attr_value_id){
    var formData = new FormData();
        formData.append('attr_value_id', attr_value_id);
    $.ajax({
        method:'POST',
        dataType:'json',
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        data:formData,
        cache: false,
        custom:{element:element},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/admin/productsMeta/ajaxDelete',
    }).done(function(response){
        $(element).parent().parent().fadeOut('400', function(){
            $(this).remove()
        })
        $(element).parent().parent().parent().fadeOut('400', function(){
            $(this).remove()
        })
        showSnackbar(response.type, response.message, 600)
    })
}

function deleteAttributeValue(element, attr_value_id, attr_id){
    var formData = new FormData();
        formData.append('attr_value_id', attr_value_id);
    $.ajax({
        method:'POST',
        dataType:'json',
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        data:formData,
        cache: false,
        custom:{
            attr_id:attr_id,
            element:element
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/admin/productsAttributesValues/ajaxDelete',
    }).done(function(response){
        $(element).parent().fadeOut('400', function(){
            $(this).remove()
        })
        let attrValuesList = $(element).parent().parent().find('li').length - 1;
        if(attrValuesList <= 0 ){
            $(element).parent().parent().parent().fadeOut('400', function(){
                $(this).remove()
            })
        }
        showSnackbar(response.type, response.message, 600)
    })
}

//functionalitati snackbar
{
    let newPosition = 0;
    let currentPosition = 0;
    let item = 1;
    
    var showSnackbar = function(type, message, timeout=600){
        let snackbarElement = `<div class='snackbar-element ${type}-snackbar snack-${item}'>
                                    <div class='close-snackbar'><img src="/backend/locomotif/img/close.svg"></div>
                                    <div class='snackbar-message'>
                                        <p>${message}</p>
                                    </div>
                                </div>`
        $('.snackbar').append(snackbarElement)
        let targetSnackbar = $('.snack-'+item);
        gsap.fromTo(targetSnackbar, {y: '-'+newPosition+'vw'}, {y:'-'+newPosition+'vw', autoAlpha:1, duration:0.3, ease: "power1.easeOut"})
        item = item + 1;
        setTimeout(function(){
            let disappear = newPosition + 4;
            gsap.to(targetSnackbar, {y:'-'+disappear+'vw', autoAlpha:0, duration:0.3, ease: "power1.easeOut", onComplete:function(){
                $(targetSnackbar).remove()
            }})
        }, timeout)
    }

    var deleteSnackbar = function(snackbarElement, theRest){
        let height = $(snackbarElement).outerHeight();
        let heightInVw = pxToVw(height)
            heightInVw = heightInVw + 0.8234987; //height in vw + margin-bottom
            newPosition = newPosition + heightInVw;
        let t = gsap.timeline();
            t.to(snackbarElement, {y:'-'+newPosition+'vw', autoAlpha:0, duration:0.3, ease: "power1.easeOut"})
            t.fromTo(theRest, {y: '-'+currentPosition+'vw'}, { y:'-'+newPosition+'vw', stagger: {each: 0.1, ease: "power1.easeOut"}}, '-=0.3');
            currentPosition = newPosition;
    }   
}
//functionalitati snackbar


function setupNavtabs(navtab) {
    var tabs = navtab.querySelectorAll("*[data-target]");
    
    for (var i=0; i < tabs.length; i++) {
      var tab = tabs[i];
  
      tab.addEventListener("click", function(e) {
        e.preventDefault();
        var id = e.target.dataset.target;
        var pane = document.getElementById(id);
        pane.classList.add("active");
        $.each(tabs, function(i, v){
            $(v).parent().removeClass('detail-selected')
        })
        $(e.target).parent().addClass("detail-selected");
  
        // remove .active class of all sibling elements
        var el = pane.nextElementSibling;
        while (el) {
          el.classList.remove("active");
          el = el.nextElementSibling;
        }
        el = pane.previousElementSibling;
        while (el) {
          el.classList.remove("active");
          el = el.previousElementSibling;
        }
      });
    }
}
function truncate(str, maxLength) {
    if (str.length <= maxLength) {
      return str;
    }
    
    return str.substr(0, maxLength - 3) + "...";
}
function initDropzone(dropzoneElement){
    let postUrl = $(dropzoneElement).attr('data-postUrl');
    // let previewElement = document.querySelector("#mediaTemplate");
    
    var previewNode = document.querySelector("#mediaTemplate");
        previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

    let customOptions  = {
        method:'POST',
        url:postUrl,
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        maxFilesize:3, //3mb
        paramName:'media',
        uploadMultiple:true,
        maxFiles:200,
        parallelUploads:100,
        clickable:true,
        autoProcessQueue:false,
        acceptedFiles:'image/*,application/pdf',
        previewsContainer:'.dropzonePreview',
        previewTemplate: previewTemplate,
        addRemoveLinks:false,
        createImageThumbnails:true,
        thumbnailMethod:'contain',
        dictDefaultMessage: "Adaugă imagini aici",
        dictFileTooBig: "Fisierul este prea mare ({{filesize}}MiB). Dimensiunea maxima est de: {{maxFilesize}}MiB.",
        dictInvalidFileType: "Acest tip de imagine/fisier nu este suportat.",
        dictResponseError: "A intervenit o eroare la incarcarea imaginilor: eroare {{statusCode}}.",
        dictCancelUpload: "Oprește încărcarea.",
        dictUploadCanceled: "Oprește încărcarea.",
        dictCancelUploadConfirmation: "Ești sigur că vrei să oprești?",
        dictRemoveFile: "Șterge",
        dictRemoveFileConfirmation: false,
        dictMaxFilesExceeded: "Nu ai voie să urci mai multe fișiere.",
    }
    let dropzone = new Dropzone(dropzoneElement, customOptions)
        dropzone.on("addedfile", file => {
            $(file.previewElement).find('.media-content .mediaName').html(truncate(file.name, 10))
        });
        dropzone.on("complete", function(file) {
            let statusItem = $(file.previewElement).find('.uploadStatus');
            if(file.status=='success'){
                setTimeout(function(){
                    gsap.to('.progress', {autoAlpha:0, duration:0.4})
                    gsap.to(statusItem,  {autoAlpha:1, duration:0.4})
                }, 500)
            }
        });
        dropzone.on("queuecomplete", function(progress) {
           
        });
        dropzone.on("sending", function(file, xhr, formData) {
            let owner    = ($('#owner').length > 0)    ? $('#owner').val()    : 'media';
            let owner_id = ($('#owner_id').length > 0) ? $('#owner_id').val() : 0;
            formData.append('owner', owner)
            formData.append('owner_id', owner_id)
        });
        dropzone.on("error", function(file, message) {
            if (file.previewElement) {
                file.previewElement.classList.add("dz-error");
                if (typeof message !== "string" && message.message) {
                  message = message.message;
                }
                for (let node of file.previewElement.querySelectorAll(
                  "[data-dz-errormessage]"
                )) {
                  node.textContent = message;
                }
              }
        });

    document.querySelector(".mediaUpload").onclick = function(e) {
        e.preventDefault();
        dropzone.processQueue();
    };
    //myDropzone.processQueue() to process images
}

var nodeReference;
var modalNode;
function getMediaEdit(mediaID){
    $.ajax({
        method:'POST',
        dataType:'html',
        data:{mediaID, mediaID},
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/admin/media/ajaxEdit',
    }).done(function(response){
        modalNode = $('<div>').attr('id', 'modalReference').addClass('mediaModalHolder').html(response);
        $('body').append(modalNode);
        setTimeout(function(){
            $('.mediaModalHolder').fadeIn()
        }, 150)
        nodeReference = $('#modalReference');
        $('body').on('click', '.closeModal', function(e){
            e.preventDefault();
            $(this).parent().parent().fadeOut()
            setTimeout(function(){
                nodeReference.remove()
            }, 400)
            
        })

    }).fail(function(response){
        alert('A intervenit o eroare. Va rugam incercati din nou.')
    })
}

function deleteMedia(mediaID){
    $.ajax({
        method:'POST',
        dataType:'json',
        data:{mediaID: mediaID},
        custom:{mediaID: mediaID},
        cache: false,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/admin/media/ajaxDelete',
    }).done(function(response){
        response.id = mediaID;
        processRequest(response)
    }).fail(function(response){
        showSnackbar(response.type, response.message, 2000)
    })
}

{
    let menuToggle = false;
    let submenuAnimation = new TimelineMax({ paused: true });

    $('body').on('click', '.hasChildren > a', function(e){
        e.preventDefault();

        var submenu     = $(this).parent().find('ul')
        var menuChevron = $(this).parent().find('.menuChevron')
            menuToggle = !menuToggle
            
        if(menuToggle){
            submenuAnimation.clear(); // clear the previous animation
            submenuAnimation.to(submenu, { height: 'auto', duration: 0.4 });
            submenuAnimation.to(menuChevron, { rotate: '90deg', duration: 0.2 }, '-=0.4');
            submenuAnimation.play();
        }else{
            submenuAnimation.reverse();
        }   
    })
}
{
    let moreActionsToggle = false;
    $('body').on('click', '.more-actions-tab svg', function(e){
        e.preventDefault();
        let moreList = $(this).parent().find('.more-list');
        moreActionsToggle = !moreActionsToggle
        if(moreActionsToggle){
            gsap.to(moreList, {autoAlpha:1, duration:0.3})
        }else{
            gsap.to(moreList, {autoAlpha:0, duration:0.3})
        }
    })
    $('body').on('mouseleave', '.more-actions-tab', function(e){
        console.log('leaving')
    })
}

//block scope
{
    let toggleMenu = false;
    let leftMenu = new TimelineMax({ paused: true });
        leftMenu.addLabel('concurrent')
        leftMenu.fromTo('.flex-dashboard-left', 0.4, {width:'12%'}, {width:'0'}, 'concurrent')
        leftMenu.fromTo('.flex-dashboard-right', 0.4, {width:'88%'}, {width:'99%'}, 'concurrent') //left side has a border of 1px

        $('body').on('click', '.cms-menu-hold-trigger', function(e){
            e.preventDefault();
            toggleMenu = !toggleMenu
            if(toggleMenu){
                leftMenu.play();
            }else{
                leftMenu.reverse();
            }
        })
}
function sortableImages(){
    var sortableImages = document.getElementById('sortableImages');
    var sortable = Sortable.create(sortableImages, {
        animation: 150,
        dataIdAttr: 'data-order',
        easing: "cubic-bezier(1, 0, 0, 1)",
        handler: '.handler',
        onEnd: (evt) => {
            const items = Array.from(sortableImages.children);
            items.forEach((item, index) => {
                item.setAttribute('data-order', index + 1);
            });

            items.forEach(item => {
                let mediaID = $(item).attr('data-id');
                let ordering = $(item).attr('data-order');
                let formData = new FormData();
                    formData.append('mediaID', mediaID)
                    formData.append('ordering', ordering)

                $.ajax({
                    method:'POST',
                    dataType:'json',
                    enctype: 'multipart/form-data',
                    contentType: false,
                    processData: false,
                    data:formData,
                    cache: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:'/admin/media/ajaxReorder',
                }).done(function(response){
                    console.log(response)
                    if(response.success==true){
                        
                    }else{
                        //alert('A intervenit o eroare la reordonarea imaginilor. Va rugam incercati din nou.')
                    }
                }).fail(function(response){
                    alert('A intervenit o eroare. Va rugam incercati din nou.')
                })
            });
        }
    });
}

function initTinyMce(){
    
    tinymce.init({
        selector: 'textarea.tinymce',
        keep_styles: false
    });
}

$(document).ready(function(){
    ($('.buildAttributeIdentifier').length>0) ? buildAttributeIdentifier() : '';
    ($('.builNiceUrl').length>0) ? buildNiceUrl() : '';
    ($('.tagElement').length>0) ? buildTags() : '';
    ($('.dropzoneArea').length>0) ? initDropzone('.dropzoneArea') : '';
    ($('.sortableImages').length>0) ? sortableImages() : '';
    ($('.tinymce').length>0) ? initTinyMce() : '';
    

    setTimeout(function(){
      checkInput();
    }, 500)

   
    var navtabs = document.querySelectorAll(".nav-tabs");
    for (var i=0; i < navtabs.length; i++) {  
        setupNavtabs(navtabs[i]);
    }

    $('body').on('click', '.errors-mask-holder-close', function(e){
        e.preventDefault();
        $(this).parent().parent().fadeOut()
    })

    $('body').on('click', '.modal-media-delete', function(e){
        e.preventDefault();
        let mediaID = $(this).attr('data-id');
        deleteMedia(mediaID)
    })
    
    $('body').on('click', '.media-element.editable', function(e){
        e.preventDefault();
        let mediaID = $(this).attr('data-id')
        getMediaEdit(mediaID)
    })
    
    
    $('body').on('change', '#attr_type_select', function(e){
        e.preventDefault();
        let attr_id = $(this).val()
        let attr_identifier = $(this).find("option:selected").attr('data-id');
        let text = $(this).find("option:selected").text()
        $('#meta_name').val(text)
        $('#meta_key').val(attr_identifier)
        
        getAttributeValues(attr_id, text)
    })
    $('body').on('change', '#meta_combined_key', function(e){
        e.preventDefault();
        let attr_identifier = $(this).val()
        let pid = $('#pid').val();
        let meta_key = $('#attr_type_select').find("option:selected").attr('data-id');
        let meta_attribute  = attr_identifier.split('_');
            meta_attribute  = (typeof meta_attribute[1] !== 'undefined' && meta_attribute[1] !== '') ? meta_attribute[1] : 'N/A';
        $('#meta_attribute').val(meta_attribute);
        checkIfAttrValueAlreadyExists(meta_attribute, meta_key, pid, attr_identifier)
    })
    $('body').on('click', '.attr_list li span', function(e){
        e.preventDefault();
        let attr_value_id = $(this).parent().attr('data-id')
        let attr_id       = $('#attr_id').val();
        let element       = $(this);
        deleteAttributeValue(element, attr_value_id, attr_id);
    })
    $('body').on('click', '.attr_meta li span', function(e){
        e.preventDefault();
        let attr_value_id = $(this).parent().attr('data-id')
        let element       = $(this);
        deleteAttributeMeta(element, attr_value_id);
    })
    
    $('body').on('click', '.close-snackbar', function(e){
        e.preventDefault();
        let snackbarElement = $(this).parent();
        let theRest = gsap.utils.toArray(snackbarElement.nextAll())
        deleteSnackbar(snackbarElement, theRest);
    })
    $('body').on('click', '.ajaxSubmit', function(e){
        e.preventDefault();
        let tableName = $(this).attr('data-tableName');
        let formID = $(this).attr('data-formID');
        let submitUrl = $(this).attr('data-submitUrl');
        generalAjaxSubmit(tableName, formID, submitUrl);
    })
    
    $('body').on('change', '.isSubcategory input', function(e){
        e.preventDefault();
        
        if ($(this).is(':checked')) {
            let parentCategory = $(this).attr('data-parent')
            $("#"+parentCategory).prop( "checked", true );
        }else{
            let parentCategory = $(this).attr('data-parent')
                parentHolder = $("#"+parentCategory).parent().parent();
            let subcategories = $(parentHolder).find("input[name='subcategories[]']")
            let uncheck = true;
            $.each(subcategories, function(index, value){
                if(value.checked){
                    uncheck = false;
                    return;
                }
            })
            if(uncheck){
                $("#"+parentCategory).prop( "checked", false );
            }
        }
    })

    $('input[type="radio"][name="main_subcategory"]').change(function() {
        if ($(this).is(':checked')) {
          // The radio input is checked
          var subcategID = $(this).val();
              subcategID = parseInt(subcategID);
          var pid = $('#pid').val();
              pid = parseInt(pid);

          $.ajax({
                method:'POST',
                dataType:'json',
                data:{
                    subcategID:subcategID,
                    pid:pid
                },
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'/admin/productsSubcategories/setMain',
            }).done(function(response){
                showSnackbar(response.type, response.message, 2000)
            }).fail(function(response){
                showSnackbar(response.type, response.message, 4000)
            })
          
          // Perform any additional actions or logic here
          
        } else {
          // The radio input is unchecked
        }
      });
    
    
})
