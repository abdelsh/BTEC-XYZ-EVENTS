var counter = 1;

setInterval(function(){
  document.getElementById('radio' + counter).checked = true;
  counter++

  if (counter > 3) {
    counter = 1;
  }
}, 5000);



function showLogin() {

    var login = document.getElementById("login");
    var register = document.getElementById("register");

    var showLogin = document.getElementById("showLogin");
    var showRegister = document.getElementById("showRegister");

    register.style.display = "none";
    login.style.display = "block";


    showLogin.style.borderBottom = "none";
    showLogin.style.borderRight = "none";
    showLogin.style.backgroundColor = "#003049";
    showLogin.style.borderBottomRightRadius = "0px";
    showLogin.style.width = "49%"

    showRegister.style.borderBottom = "1px white solid";
    showRegister.style.borderLeft = "1px white solid";
    showRegister.style.borderBottomLeftRadius = "20px";
    showRegister.style.marginLeft = "-1px";
    showRegister.style.backgroundColor = "#0f4c5c";

}

function showRegister() {

    var login = document.getElementById("login");
    var register = document.getElementById("register");

    var showLogin = document.getElementById("showLogin");
    var showRegister = document.getElementById("showRegister");

    
    
    login.style.display = "none";
    register.style.display = "block";

    showLogin.style.borderBottom = "1px white solid";
    showLogin.style.borderRight = "1px white solid";
    showLogin.style.backgroundColor = "#0f4c5c";
    showLogin.style.borderBottomRightRadius = "20px";
    showLogin.style.width = "49%"

    showRegister.style.borderBottom = "none";
    showRegister.style.borderLeft = "none";
    showRegister.style.borderBottomLeftRadius = "0px";
    showRegister.style.marginLeft = "0px";
    showRegister.style.backgroundColor = "#003049";
} 
