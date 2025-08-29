function promptThis(position, icon, heading, text) {
    'use strict';
    resetToastPosition();
    $.toast({
        heading: heading,
        text: text,
        position: String(position),
        icon: icon,
        stack: false,
        loaderBg: '#f96868'
    })
}


function promptError(heading, text) {
    'use strict';
    resetToastPosition();
    $.toast({
        heading: heading,
        text: text,
        position: 'top-right',
        icon: 'error',
        stack: false,
        loaderBg: '#f96868'
    })
}

function promptSuccess(heading, text) {
    'use strict';
    resetToastPosition();
    $.toast({
        heading: heading,
        text: text,
        position: 'top-right',
        icon: 'success',
        stack: false,
        loaderBg: '#f96868'
    })
}

function promptSuccessReload(heading, text) {
    'use strict';
    resetToastPosition();
    $.toast({
        heading: heading,
        text: text,
        position: 'top-right',
        icon: 'success',
        stack: false,
        loaderBg: '#f96868'
    })

    setTimeout(function () {
        location.reload();
    }, 2000);
}

function promptSuccessRedirect(heading, text, redirect) {
    'use strict';
    resetToastPosition();
    $.toast({
        heading: heading,
        text: text,
        position: 'top-right',
        icon: 'success',
        stack: false,
        loaderBg: '#f96868'
    })

    setTimeout(function () {
        window.location.href = redirect;
    }, 2000);
}

function promptWarning(heading, text) {
    'use strict';
    resetToastPosition();
    $.toast({
        heading: heading,
        text: text,
        position: 'top-right',
        icon: 'warning',
        stack: false,
        loaderBg: '#f96868'
    })
}

function resetToastPosition() {
    $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
    $(".jq-toast-wrap").css({
        "top": "",
        "left": "",
        "bottom": "",
        "right": ""
    }); //to remove previous position style
}