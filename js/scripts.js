function comparePasswords() {
    // get 2 password values from form
    let pw1 = document.getElementById('password').value
    let pw2 = document.getElementById('confirm').value
    let message = document.getElementById('message')

    // compare
    if (pw1 != pw2) {
        // message.innerText = "Passwords must match"
        // message.className = "alert alert-info"
        return false
    }
    else {
        // message.innerText = "Passwords must be a minimum of 8 characters, including 1 digit, 1 upper-case letter, and 1 lower-case letter."
        // message.className = "alert alert-secondary"
        return true
    }
}