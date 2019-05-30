$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    $('[data-toggle="tooltip"]').tooltip(); 

    $(window).scroll(function() {
        var height = $(window).scrollTop();
        if (height > 400) {
            $('#backToTop').fadeIn();
        } else {
            $('#backToTop').fadeOut();
        }
    });

    $("#backToTop").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 1 }, "slow");
        return false;
    });

    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });
    
    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
    

});

function setIndexRemove(x) {
    x.href = "index.php?p=remove&id=" + x.closest('tr').rowIndex;
}

function setIndexModify(x) {
    x.href = "index.php?p=modify&id=" + x.closest('tr').rowIndex;
}

function setIndexInsertA(x) {
    x.href = "index.php?p=insert&insert=a&id=" + x.closest('tr').rowIndex;
}

function setIndexInsertB(x) {
    x.href = "index.php?p=insert&insert=b&id=" + x.closest('tr').rowIndex;
}

function confirmationRemoval() {
    return confirm('Are you sure you want to delete?');
}

function goBack() {
    window.history.back();
}

function addAutoResize() {
    document.querySelectorAll('[data-autoresize]').forEach(function (element) {
        element.style.boxSizing = 'border-box';
        var offset = element.offsetHeight - element.clientHeight;
        document.addEventListener('input', function (event) {
        event.target.style.height = 'auto';
        event.target.style.height = event.target.scrollHeight + offset + 'px';
    });
        element.removeAttribute('data-autoresize');
    });
}

addAutoResize();

$('tbody').sortable({
    handle: ".handle",
    placeholder: "highlight",
    start: function(event, ui){ $(ui.item).data('startindex', ui.item.index()); },
    update: function(event, ui){ $(ui.item).data('updateindex', ui.item.index()); },
    deactivate: function( event, ui ) {
        location.href='index.php?p=sort&o=' +  $(ui.item).data().startindex + '&n=' +  $(ui.item).data().updateindex;
    }
});

// Forms dependent hide and show

var all_options = document.querySelectorAll("[id^='frm-options']");
var all_languages = document.querySelectorAll("[id^='frm-language']");
var all_files = document.querySelectorAll("[id^='frm-file']");
var all_option_content = document.querySelectorAll("[id^='frm-option_content']");
var all_name = document.querySelectorAll("[id^='frm-names']");
var all_trg = document.querySelectorAll("[id^='frm-trgs']");

var labels = document.getElementsByTagName('LABEL');
for (var i = 0; i < labels.length; i++) {
    if (labels[i].htmlFor !== '') {
         var elem = document.getElementById(labels[i].htmlFor);
         if (elem)
            elem.label = labels[i];         
    }
}


for (var i = 0; i < all_options.length; i++) {
    if (all_options[i].value == "codeInline") {
        all_option_content[i].label.innerHTML = 'Code:';
        all_languages[i].parentNode.parentNode.style.display = "block"; 
        all_files[i].parentNode.parentNode.style.display = "none";
        all_option_content[i].parentNode.parentNode.style.display = "block"; 
        all_name[i].parentNode.parentNode.style.display = "none";
        all_trg[i].parentNode.parentNode.style.display = "none"; 
    } else if (all_options[i].value == "codeFile") {
        all_languages[i].parentNode.parentNode.style.display = "block";
        all_files[i].parentNode.parentNode.style.display = "block"; 
        all_option_content[i].parentNode.parentNode.style.display = "none"; 
        all_name[i].parentNode.parentNode.style.display = "none";
        all_trg[i].parentNode.parentNode.style.display = "none"; 
    } else if (all_options[i].value == "image") {
        all_option_content[i].label.innerHTML = 'Image Name';
        all_languages[i].parentNode.parentNode.style.display = "none";
        all_files[i].parentNode.parentNode.style.display = "block"; 
        all_option_content[i].parentNode.parentNode.style.display = "block"; 
        all_name[i].parentNode.parentNode.style.display = "none";
        all_trg[i].parentNode.parentNode.style.display = "none"; 
    } else if (all_options[i].value == "imageURL") {
        all_option_content[i].label.innerHTML = 'Image URL Link:';
        all_languages[i].parentNode.parentNode.style.display = "none";
        all_files[i].parentNode.parentNode.style.display = "none"; 
        all_option_content[i].parentNode.parentNode.style.display = "block"; 
        all_name[i].parentNode.parentNode.style.display = "block";
        all_trg[i].parentNode.parentNode.style.display = "none"; 
    } else if (all_options[i].value == "linkButton") {
        all_option_content[i].label.innerHTML = 'URL Link:';
        all_languages[i].parentNode.parentNode.style.display = "none";
        all_files[i].parentNode.parentNode.style.display = "none"; 
        all_option_content[i].parentNode.parentNode.style.display = "block"; 
        all_name[i].parentNode.parentNode.style.display = "block";
        all_trg[i].parentNode.parentNode.style.display = "block"; 
    } else {
            switch(all_options[i].value) {
                  case "title":
                    all_option_content[i].label.innerHTML = 'Title:';
                    break;
                  case "description":
                    all_option_content[i].label.innerHTML = 'Description:';
                    break;
                  case "pathAdd":
                    all_option_content[i].label.innerHTML = 'Path:';
                    break;
                  case "path":
                    all_option_content[i].label.innerHTML = 'Path:';
                    break;
                  case "blockquote":
                    all_option_content[i].label.innerHTML = 'Block Quote:';
                    break;
                  default:
                    all_option_content[i].label.innerHTML = 'Content:';
            }
        all_languages[i].parentNode.parentNode.style.display = "none";
        all_files[i].parentNode.parentNode.style.display = "none"; 
        all_option_content[i].parentNode.parentNode.style.display = "block"; 
        all_name[i].parentNode.parentNode.style.display = "none";
        all_trg[i].parentNode.parentNode.style.display = "none"; 
    }
    
}

document.addEventListener("change", function(){
    var all_options = document.querySelectorAll("[id^='frm-options']");
    var all_languages = document.querySelectorAll("[id^='frm-language']");
    var all_files = document.querySelectorAll("[id^='frm-file']");
    var all_option_content = document.querySelectorAll("[id^='frm-option_content']");
    var all_name = document.querySelectorAll("[id^='frm-names']");
    var all_trg = document.querySelectorAll("[id^='frm-trgs']");
    
    for (var i = 0; i < all_options.length; i++) {
        if (all_options[i].value == "codeInline") {
            all_option_content[i].label.innerHTML = 'Code:';
            all_languages[i].parentNode.parentNode.parentNode.style.display = "block"; 
            all_files[i].parentNode.parentNode.style.display = "none";
            all_option_content[i].parentNode.parentNode.style.display = "block"; 
            all_name[i].parentNode.parentNode.style.display = "none";
            all_trg[i].parentNode.parentNode.style.display = "none";
        } else if (all_options[i].value == "codeFile") {
            all_languages[i].parentNode.parentNode.parentNode.style.display = "block";
            all_files[i].parentNode.parentNode.style.display = "block"; 
            all_option_content[i].parentNode.parentNode.style.display = "none"; 
            all_name[i].parentNode.parentNode.style.display = "none";
            all_trg[i].parentNode.parentNode.style.display = "none";
        } else if (all_options[i].value == "image") {
            all_option_content[i].label.innerHTML = 'Image Name:';
            all_languages[i].parentNode.parentNode.parentNode.style.display = "none";
            all_files[i].parentNode.parentNode.style.display = "block"; 
            all_option_content[i].parentNode.parentNode.style.display = "block"; 
            all_name[i].parentNode.parentNode.style.display = "none";
            all_trg[i].parentNode.parentNode.style.display = "none";
        } else if (all_options[i].value == "imageURL") {
            all_option_content[i].label.innerHTML = 'Image URL Link:';
            all_languages[i].parentNode.parentNode.parentNode.style.display = "none";
            all_files[i].parentNode.parentNode.style.display = "none"; 
            all_option_content[i].parentNode.parentNode.style.display = "block"; 
            all_name[i].parentNode.parentNode.style.display = "block";
            all_trg[i].parentNode.parentNode.style.display = "none";
        } else if (all_options[i].value == "linkButton") {
            all_option_content[i].label.innerHTML = 'URL Link:';
            all_languages[i].parentNode.parentNode.parentNode.style.display = "none";
            all_files[i].parentNode.parentNode.style.display = "none"; 
            all_option_content[i].parentNode.parentNode.style.display = "block"; 
            all_name[i].parentNode.parentNode.style.display = "block";
            all_trg[i].parentNode.parentNode.style.display = "block";
        } else {
                switch(all_options[i].value) {
                  case "title":
                    all_option_content[i].label.innerHTML = 'Title:';
                    break;
                  case "description":
                    all_option_content[i].label.innerHTML = 'Description:';
                    break;
                  case "pathAdd":
                    all_option_content[i].label.innerHTML = 'Path:';
                    break;
                  case "path":
                    all_option_content[i].label.innerHTML = 'Path:';
                    break;
                  case "blockquote":
                    all_option_content[i].label.innerHTML = 'Block Quote:';
                    break;
                  default:
                    all_option_content[i].label.innerHTML = 'Content:';
                }
            all_languages[i].parentNode.parentNode.parentNode.style.display = "none";
            all_files[i].parentNode.parentNode.style.display = "none"; 
            all_option_content[i].parentNode.parentNode.style.display = "block"; 
            all_name[i].parentNode.parentNode.style.display = "none";
            all_trg[i].parentNode.parentNode.style.display = "none";
        }
    }
});

if (document.getElementById('rvselect')) {
    
    document.getElementById('ivhidden').value = document.getElementById('rvselect').value;
    document.getElementById('evhidden').value = document.getElementById('rvselect').value;  
    document.getElementById('dvhidden').value = document.getElementById('rvselect').value;  
    
    document.getElementById('rvselect').onchange = function() {
        document.getElementById('ivhidden').value = document.getElementById('rvselect').value;
        document.getElementById('evhidden').value = document.getElementById('rvselect').value;    
        document.getElementById('dvhidden').value = document.getElementById('rvselect').value;    
    };  

}
