const imgName = document.getElementById("img-name");
const imgNameSpan = document.getElementById("img-name-span");

imgName.addEventListener('change', function() {
    console.log(imgName.value);
    imgNameSpan.textContent = this.value.replace(/^C:\\fakepath\\/, "");
    imgNameSpan.style.color = "white";
});
