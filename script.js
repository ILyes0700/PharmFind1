// script.js
document.getElementById('submitButton').addEventListener('click', () => {
    const nom = document.getElementById('nom').value;
    const image = document.getElementById('image').files[0];
    const prix = document.getElementById('prix').value;
    const description = document.getElementById('description').value;

    if (nom && image && prix && description) {
        const output = document.getElementById('output');

        // Create a preview of the added medication
        const reader = new FileReader();
        reader.onload = function(e) {
            output.innerHTML = `
                <h3>Médicament ajouté :</h3>
                <p><strong>Nom :</strong> ${nom}</p>
                <p><strong>Prix :</strong> ${prix} €</p>
                <p><strong>Description :</strong> ${description}</p>
                <img src="${e.target.result}" alt="Image du médicament" style="max-width: 100%; height: auto; margin-top: 10px;">
            `;
        };
        reader.readAsDataURL(image);
    } else {
        alert("Veuillez remplir tous les champs.");
    }
});
