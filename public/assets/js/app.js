/**
 * Function for validate form
 * @returns {boolean}
 */
function validateJs()
{
    const name = document.forms["RegForm"]["username"];
    const email = document.forms["RegForm"]["mail"];
    const password = document.forms["RegForm"]["password"];
    const password_repeat = document.forms["RegForm"]["password-check"];

//================> Check username <==================
    if (name.value === "")
    {
        alert("Mettez votre nom.");
        name.focus();
        return false;
    }
    if (name.value <= 4)
    {
        alert("Votre nom doit contenir au minimum 5 caractère.");
        name.focus();
        return false;
    }
//================> Check Mail <==================
    if (email.value === "")
    {
        alert("Mettez une adresse email valide.");
        email.focus();
        return false;
    }

    if (email.value.indexOf("@", 0) < 0)
    {
        alert("Mettez une adresse email valide.");
        email.focus();
        return false;
    }

    if (email.value.indexOf(".", 0) < 0)
    {
        alert("Mettez une adresse email valide.");
        email.focus();
        return false;
    }
//================> Check Pass <==================
    if (password.value === "")
    {
        alert("Saisissez votre mot de passe");
        password.focus();
        return false;
    }
    if (password_repeat.value === "")
    {
        alert("Saisissez votre mot de passe");
        password.focus();
        return false;
    }
    if (password ===! password_repeat){
        alert("Les mot de passe ne corresponde pas !")
        password.focus();
        return false;
    }
    return true;
}