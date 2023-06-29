
// Global variables
let pageform

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {
    //
    // Data
    //
    const resCurrencies = await ApiCurrencies.getAllCurrencies()
    console.log(resCurrencies.data.currencies)

    const currencies = resCurrencies.data.currencies.map(x => ({
        text: `(${x.symbol}) ${x.name}`,
        value: x.idcurrency
    }))

    //
    // Pageform
    //
    const fields = [
        {
            caption: "Regional",
            section: true,
            dataFields: [
                new PageformField("Default currency", "idcurrency", 150, 300, PageformField.types.SELECT, [...currencies])
            ]
        }
    ]

    const dataObject = {
        idcurrency: 2
    }

    pageform = new Pageform(fields)
    pageform.setDataObject(dataObject)
    pageform.setOnSave(dataObject => {
        console.log(dataObject)
    })

    //
    // Search input
    //
    const inputSearch = document.getElementById("inputSearch")
    inputSearch.addEventListener("keydown", (e) => {
        if(e.key === "Enter")
        {
            console.log("ENTER")
        }
    })


    //
    // Apend components to html
    //
    const divPageformContainer = document.getElementById("pageformContainer")
    divPageformContainer.appendChild(pageform.getHtml())
})