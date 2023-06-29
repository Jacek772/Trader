const headers = [
    { text: "Table number", width: "20%", fieldName: "tablenumber" },
    { text: "Date of publication", width: "15%", fieldName: "dateofpublication" },
    { text: "Announcement date", width: "15%", fieldName: "announcementdate" },
    { text: "Name", width: "10%", fieldName: "name" },
    { text: "Code", width: "10%", fieldName: "symbol" },
    { text: "Factor", width: "15%", fieldName: "factor" },
    { text: "Rate", width: "10%", fieldName: "rate" },
]

let modal
let dataGrid
let filtersPanel

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {
    //
    // Modal
    //
    modal = new Modal()

    //
    // Grid
    //
    const exchanges = await getExchanges()
    dataGrid = new DataGrid(headers, exchanges)

    //
    // Filters panel
    //
    filtersPanel = new FiltersPanel()
    filtersPanel.setOnChange(async (filters) => {
        const query = createExchangesQuery(filters)
        const exchanges = await getExchanges(query)
        dataGrid.setDataArray(exchanges)
    })


    const currenciesRes = await ApiCurrencies.getAllCurrencies()
    const currencies = currenciesRes.data.currencies.map(x => ({
        text: x.symbol,
        value: x.idcurrency
    }))

    filtersPanel.addItem(new FilterPanelItem("Period", ["periodFrom", "periodTo"], FilterPanelItem.types.DATE_PERIOD))
    filtersPanel.addItem(new FilterPanelItem("Currency", ["idCurrency"], FilterPanelItem.types.SELECT_WITH_EMPTY, currencies))

    const divFiltersPanelContainer = document.getElementById("filtersPanelContainer")
    divFiltersPanelContainer.appendChild(filtersPanel.getHtml())

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
    // Action buttons
    //
    const btnImportExchanges = document.getElementById("btnImportExchanges")
    btnImportExchanges.addEventListener("click", async () => {

        modal.setModalType(Modal.modalTypes.INFO)
        modal.setModalButtonsType(Modal.modalButtonsType.EMPTY)
        modal.setTitle("Import of exchange rates")
        modal.setText("Import of exchange rates. Please wait...")
        modal.setBlockClosing(true)
        modal.show()

        const days = 7
        await ApiExchanges.importExchanges(days)
        modal.close()

        const query = createExchangesQuery(filtersPanel.getFilters())
        const exchanges = await getExchanges(query)
        dataGrid.setDataArray(exchanges)
    })

    //
    // Apend components to html
    //
    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())

    document.body.appendChild(modal.getHtml())
})

const createExchangesQuery = (filters) => {
    let query = { }
    for(let filter of filters)
    {
        query = { ...query, ...filter }
    }
    return query
}

async function getExchanges(query = {})
{
    const result = await ApiExchanges.getExchanges(query)
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
