let formPost = document.querySelector('#formPost');

function checkForm() {
    if (formPost.messageTitle.value == "") {
        alert("Title required!");
        formPost.messageTitle.focus();
        return false;
    }
    if (formPost.authorName.value == "") {
        alert("Name required!");
        formPost.authorName.focus();
        return false;
    }
    if (formPost.authorMail.value != "") {
        if (!checkmail(formPost.authorMail)) {
            formPost.authorMail.focus();
            return false;
        }
    }
    if (formPost.messageContent.value == "") {
        alert("Content required!");
        formPost.messageContent.focus();
        return false;
    }
    return confirm('Ready to send?');
}

function checkmail(myEmail) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (filter.test(myEmail.value)) {
        return true;
    }
    alert("The format of mail is not correct!");
    return false;
}

console.log(1234);