document.addEventListener("DOMContentLoaded", () => {
    const nav = document.querySelector("nav")
    const iconHamburger = document.getElementById("iconHamburger")
    iconHamburger.addEventListener("click", () => {
        if(nav.style.display == "" || nav.style.display == "none")
        {
            nav.style.display = "block"
        }
        else
        {
            nav.style.display = "none"
        }
    })
})