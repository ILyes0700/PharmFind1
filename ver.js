function showAlert(message) {
    const alertBox = document.getElementById('alertBox');
    alertBox.textContent = message;  // Set the alert message
    alertBox.classList.add('show');  // Show the alert
    setTimeout(() => {
        alertBox.classList.remove('show');  // Hide the alert after 3 seconds
    }, 3000);
}
function estAlphabetique(chaine) {
    // Utiliser une expression régulière pour vérifier les lettres et espaces
    const regex = /^[a-zA-Z\s]+$/;
    return regex.test(chaine);
}
function estNumerique(chaine) {
    // Utiliser une expression régulière pour vérifier uniquement les chiffres
    const regex = /^[0-9]+$/;
    return regex.test(chaine);
}
function estNumeriqueAlphabetique(chaine) {
    // Utiliser une expression régulière pour vérifier les lettres, chiffres et espaces
    const regex = /^[a-zA-Z0-9\s]+$/;
    return regex.test(chaine);
}

function verif2() {
    const form = document.forms["f"]; // Récupère le formulaire par son nom
    const tel = form.tel.value;
    const email = form.email.value;
    const pass = form.pass.value;
    const nom = form.nom.value;
    const pre = form.pre.value;
    const gen = form.check1; // Collection des boutons radio
    const date = form.date.value;
    const add = form.add.value;
    const add2 = form.add2.value;
    const stat = form.stat.selectedIndex;
    const zip = form.zip.value;
    const ver = form.check3.checked;

    if (tel === "" || tel.length !== 8 || !estNumerique(tel)) {
        showAlert("Vérifiez votre téléphone !");
        return false;
    }
    if (email === "" || email.indexOf("@") === -1 || email.indexOf(".") === -1) {
        showAlert("Vérifiez votre email !");
        return false;
    }
    if (pass === "" || pass.length !== 8 || !estNumeriqueAlphabetique(pass)) {
        showAlert("Vérifiez votre mot de passe !");
        return false;
    }
    if (nom === "" || nom.length < 2 || !estAlphabetique(nom)) {
        showAlert("Vérifiez votre nom !");
        return false;
    }
    if (pre === "" || pre.length < 2 || !estAlphabetique(pre)) {
        showAlert("Vérifiez votre prénom !");
        return false;
    }
    if (!gen[0].checked && !gen[1].checked) {
        showAlert("Vérifiez votre genre !");
        return false;
    }
    if (date === "") {
        showAlert("Vérifiez votre date de naissance !");
        return false;
    }
    if (add === "" || add.length < 7) {
        showAlert("Vérifiez votre adresse 1 !");
        return false;
    }
    if (add2 === "" || add2.length < 7) {
        showAlert("Vérifiez votre adresse 2 !");
        return false;
    }
    if (stat === 0) {
        showAlert("Vérifiez votre état !");
        return false;
    }
    if (zip === "" || !estNumerique(zip)) {
        showAlert("Vérifiez votre code postal !");
        return false;
    }
    if (!ver) {
        showAlert("Veuillez accepter les conditions !");
        return false;
    }
    return true;
}
