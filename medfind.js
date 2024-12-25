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
function verif1() {
    console.log("Fonction vis() appelée");
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
        alert("Vérifiez votre téléphone !");
        return false;
    }
    if (email === "" || email.indexOf("@") === -1 || email.indexOf(".") === -1) {
        alert("Vérifiez votre email !");
        return false;
    }
    if (pass === "" || pass.length !== 8 || !estNumeriqueAlphabetique(pass)) {
        alert("Vérifiez votre mot de passe !");
        return false;
    }
    if (nom === "" || nom.length < 2 || !estAlphabetique(nom)) {
        alert("Vérifiez votre nom !");
        return false;
    }
    if (pre === "" || pre.length < 2 || !estAlphabetique(pre)) {
        alert("Vérifiez votre prénom !");
        return false;
    }
    if (!gen[0].checked && !gen[1].checked) {
        alert("Vérifiez votre genre !");
        return false;
    }
    if (date === "") {
        alert("Vérifiez votre date de naissance !");
        return false;
    }
    if (add === "" || add.length < 7) {
        alert("Vérifiez votre adresse 1 !");
        return false;
    }
    if (add2 === "" || add2.length < 7) {
        alert("Vérifiez votre adresse 2 !");
        return false;
    }
    if (stat === 0) {
        alert("Vérifiez votre état !");
        return false;
    }
    if (zip === "" || !estNumerique(zip)) {
        alert("Vérifiez votre code postal !");
        return false;
    }
    if (!ver) {
        alert("Veuillez accepter les conditions !");
        return false;
    }
    return true;
}
function verif2(){
    tel=f.tel.value
    email=f.email.value
    pass=f.pass.value
    nom=f.nom.value
    pre=f.pre.value
    gen=f.check1
    date=f.date.value
    add=f.add.value
    add2=f.add2.value
    stat=f.stat.selectedIndex
    zip=f.zip.value
    ver=f.check3
    if(tel=="" || tel.length!=8 || estNumerique(tel)==false){
        alert("verfie votre telephone!")
        return false
    }
    if(email==""|| email.indexOf('@')==-1 || email.indexOf('.')==-1){
        alert("verfie votre email ! ");
        return false
    }
    if(pass=="" || pass.length!=8 || estNumeriqueAlphabetique(pass)==false){
        alert("verfie votre password ! ")
        return false
    }
    if(nom=="" || nom.length<2 || estAlphabetique(nom)==false){
        alert("verfie votre nom ! ")
        return false
    }
    if(pre=="" || pre.length<2 || estAlphabetique(pre)==false){
        alert("verfie votre prenom ! ")
        return false
    }
    if(!gen[0].checked && !gen[1].checked){
        alert("verfie votre gender ! ")
        return false
    }
    if(date==""){
        alert("verfie votre date de naissance ! ")
        return false
    }
    if(add=="" || add.length<7){
        alert("verfie votre address 1 !")
        return false
    }
    if(add2=="" || add2.length<7 ){
        alert("verfie votre address 2 !")
        return false
    }
    if(stat==0){
        alert("verfie votre state ! ")
        return false
    }
    if(zip=="" || estNumerique(zip)==false){
        alert("verfie votre zip ! ")
        return false
    }
    nomphar=f.nomphar.value;
    if(nomphar==""){
        alert("verfie votre Nom de Livraison! ")
        return false
    }
    if(!ver[0].checked){
        alert("verfie votre check me out ! ")
        return false
    }
}
function verif3(){
    tel=f.tel.value
    email=f.email.value
    pass=f.pass.value
    nom=f.nom.value
    pre=f.pre.value
    gen=f.check1
    date=f.date.value
    add=f.add.value
    add2=f.add2.value
    stat=f.stat.selectedIndex
    zip=f.zip.value
    type=f.check2
    ver=f.check3
    if(tel=="" || tel.length!=8 || estNumerique(tel)==false){
        alert("verfie votre telephone!")
        return false
    }
    if(email==""|| email.indexOf('@')==-1 || email.indexOf('.')==-1){
        alert("verfie votre email ! ");
        return false
    }
    if(pass=="" || pass.length!=8 || estNumeriqueAlphabetique(pass)==false){
        alert("verfie votre password ! ")
        return false
    }
    if(nom=="" || nom.length<2 || estAlphabetique(nom)==false){
        alert("verfie votre nom ! ")
        return false
    }
    if(pre=="" || pre.length<2 || estAlphabetique(pre)==false){
        alert("verfie votre prenom ! ")
        return false
    }
    if(!gen[0].checked && !gen[1].checked){
        alert("verfie votre gender ! ")
        return false
    }
    if(date==""){
        alert("verfie votre date de naissance ! ")
        return false
    }
    if(add=="" || add.length<7){
        alert("verfie votre address 1 !")
        return false
    }
    if(add2=="" || add2.length<7 ){
        alert("verfie votre address 2 !")
        return false
    }
    if(stat==0){
        alert("verfie votre state ! ")
        return false
    }
    if(zip=="" || estNumerique(zip)==false){
        alert("verfie votre zip ! ")
        return false
    }
    nomphar=f.nomphar.value;
    if(nomphar==""){
        alert("verfie votre Nom de Pharmacie! ")
        return false
    }
    if(ver[0]){
        alert("verfie votre check me out ! ")
        return false
    }
    
}
function verif4(){
    id=f.id.value;
    if(id==""){
        alert("verfie votre ID")
        return false
    }
}
function verif5(){
    tel=f.tel.value
    pass=f.pass.value
    if(tel=="" || tel.length!=8 || estNumerique(tel)==false){
        alert("verfie votre telephone!")
        return false
    }
    if(pass=="" || pass.length!=8 || estNumeriqueAlphabetique(pass)==false){
        alert("verfie votre password ! ")
        return false
    }
    return true
}
