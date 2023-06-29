

document.addEventListener("DOMContentLoaded", () => {
    // Documents
    const iconDocumentsSubnav = document.getElementById("iconDocumentsSubnav")
    const ulDocumentsSubnav = document.getElementById("ulDocumentsSubnav")

    if(ulDocumentsSubnav)
    {
        ulDocumentsSubnav.style.display = "none"
        if(window.location.pathname.startsWith("/documents"))
        {
            ulDocumentsSubnav.style.display = ""
            iconDocumentsSubnav.classList.add("rotate-180")
        }
        else
        {
            ulDocumentsSubnav.style.display = "none"
        }
    }

    if(iconDocumentsSubnav)
    {
        iconDocumentsSubnav.addEventListener("click", () => {
            if(iconDocumentsSubnav.classList.contains("rotate-180"))
            {
                iconDocumentsSubnav.classList.remove("rotate-180")
                ulDocumentsSubnav.style.display = "none"
            }
            else
            {
                iconDocumentsSubnav.classList.add("rotate-180")
                ulDocumentsSubnav.style.display = ""
            }
        })
    }

    // Settings
    const iconSettingsSubnav = document.getElementById("iconSettingsSubnav")
    const ulSettingsSubnav = document.getElementById("ulSettingsSubnav")

    if(iconSettingsSubnav && ulSettingsSubnav)
    {
        if(window.location.pathname.startsWith("/settings"))
        {
            ulSettingsSubnav.style.display = ""
            iconSettingsSubnav.classList.add("rotate-180")
        }
        else
        {
            ulSettingsSubnav.style.display = "none"
        }

        iconSettingsSubnav.addEventListener("click", () => {
            if(iconSettingsSubnav.classList.contains("rotate-180"))
            {
                iconSettingsSubnav.classList.remove("rotate-180")
                ulSettingsSubnav.style.display = "none"
            }
            else
            {
                iconSettingsSubnav.classList.add("rotate-180")
                ulSettingsSubnav.style.display = ""
            }
        })
    }
})