const headers = [
    { text: "Table number", width: "20%", fieldName: "tablenumber" },
    { text: "Date of publication", width: "15%", fieldName: "dateofpublication" },
    { text: "Announcement date", width: "15%", fieldName: "announcementdate" },
    { text: "Name", width: "10%", fieldName: "name" },
    { text: "Code", width: "10%", fieldName: "symbol" },
    { text: "Factor", width: "15%", fieldName: "factor" },
    { text: "Rate", width: "10%", fieldName: "rate" },
]

let dataGrid
let filtersPanel

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {
    // Filter panel
    filtersPanel = new FiltersPanel()
    filtersPanel.addItem(new FilterPanelItem("Period", ["periodFrom", "periodTo"], FilterPanelItem.types.DATE_PERIOD))

    const divFiltersPanelContainer = document.getElementById("filtersPanelContainer")
    divFiltersPanelContainer.appendChild(filtersPanel.getHtml())

    // Grid
    const exchanges = await getExchangesAll()
    dataGrid = new DataGrid(headers, exchanges)

    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())

    // Search input
    const inputSearch = document.getElementById("inputSearch")
    inputSearch.addEventListener("keydown", (e) => {
        if(e.key === "Enter")
        {
            console.log("ENTER")
        }
    })

    // Action buttons
    const btnImportExchanges = document.getElementById("btnImportExchanges")
    btnImportExchanges.addEventListener("click", async () => {
        const days = 7
        await ApiExchanges.importExchanges(days)
        const exchanges = await getExchangesAll()
        dataGrid.setDataArray(exchanges)
    })
})

async function getExchangesAll()
{
    const result = await ApiExchanges.getExchangesAll()
    return result.data.exchanges.map(x => ({
        tablenumber: x.tablenumber,
        dateofpublication: x.dateofpublication,
        announcementdate: x.announcementdate,
        name: x.currency.name,
        symbol: x.currency.symbol,
        factor: x.factor,
        rate: x.rate
    }))
}
