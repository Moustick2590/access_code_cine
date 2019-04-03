var errorMsgPseudoLogin = document.getElementById('errorMsgPseudoLogin');
var errorMsgPassOne = document.getElementById('errorMsgPassOne');
var errorMsgPassTwo = document.getElementById('errorMsgPassTwo');
var errorMsgEmail = document.getElementById('errorMsgEmail');

const formRegistration = document.getElementById('form_registration');
formRegistration.addEventListener('submit', async function (e) {

    e.preventDefault();

    var data = new FormData(formRegistration);

    // fetch en attente
    var response = await fetch('http://localhost/access_code_cine/controllers/testForm.php', {
        method: 'post',
        body: data
    })

    let dataResponse = await response.json();

    if (dataResponse.code == '404') {

        if (dataResponse.errorMsgPseudoLogin) {
            errorMsgPseudoLogin.textContent = dataResponse.errorMsgPseudoLogin;
        } else {
            errorMsgPseudoLogin.textContent = "";
        }
        if (dataResponse.errorMsgPassOne) {
            errorMsgPassOne.textContent = dataResponse.errorMsgPassOne;
        } else {
            errorMsgPassOne.textContent = "";
        }
        if (dataResponse.errorMsgPassTwo) {
            errorMsgPassTwo.textContent = dataResponse.errorMsgPassTwo;
        } else {
            errorMsgPassTwo.textContent = "";
        }
        if (dataResponse.errorMsgEmail) {
            errorMsgEmail.textContent = dataResponse.errorMsgEmail;
        } else {
            errorMsgEmail.textContent = "";
        }

    } else {       
        formRegistration.style.display ="none";
        var validation = document.createElement("p");
        validation.textContent ="vous pouvez vous connecter";
        document.getElementById('inscription').appendChild(validation);
    }
})

