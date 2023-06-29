
// DOMContentLoaded
document.addEventListener("DOMContentLoaded", () => {
    const formLogin = document.getElementById("formLogin")
    const inputLogin = document.getElementById("inputLogin")
    const inputPassword = document.getElementById("inputPassword")
    const inputRemember = document.getElementById("inputRemember")

    const login = localStorage.getItem("login")
    const password = localStorage.getItem("password")
    if(login && password)
    {
        inputRemember.checked = true
        inputLogin.value = login
        inputPassword.value = password
    }

    formLogin.addEventListener("submit", e => {
        if(inputRemember.checked)
        {
            localStorage.setItem("login", inputLogin.value)
            localStorage.setItem("password", inputPassword.value)
        }
        else
        {
            localStorage.removeItem("login")
            localStorage.removeItem("password")
        }
    })
})
