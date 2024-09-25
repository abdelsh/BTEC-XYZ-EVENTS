// document.addEventListener("DOMContentLoaded", function() {
//     // Check and truncate description
//     let shortDesc = document.getElementById('shortDesc'); 
//     let shortDescMaxLength = 250; 

//     if (shortDesc && shortDesc.textContent.length > shortDescMaxLength) {
//         console.log("Truncating description...");
//         shortDesc.textContent = shortDesc.textContent.substring(0, shortDescMaxLength) + '...';
//     }

//     // Check and truncate title
//     let shortTitle = document.getElementById('shortTitle'); 
//     let shortTitleMaxLength = 50;

//     if (shortTitle && shortTitle.textContent.length > shortTitleMaxLength) {
//         console.log("Truncating title...");
//         shortTitle.textContent = shortTitle.textContent.substring(0, shortTitleMaxLength) + '...';
//     }
// });


function limitText(elementId, maxLength) {
    var elements = document.getElementsByClassName(elementId);
    

    for (var i = 0, length = elements.length; i < length; i++) {
        var text = elements[i].innerText;
        if (text.length > maxLength) {
            elements[i].innerText = text.slice(0, maxLength) + '...';
        }
    }
}

// Call the function with the ID of the h4 element and the desired maximum length
limitText('shortTitle', 30);
limitText('shortDesc', 250);