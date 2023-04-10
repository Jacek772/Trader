const headers = [
    { text: "Definition", width: "10%", fieldName: "definition" },
    { text: "Document no.", width: "15%", fieldName: "number" },
    { text: "Contractor", width: "15%", fieldName: "contractor" },
    { text: "Date", width: "10%", fieldName: "date" },
    { text: "State", width: "10%", fieldName: "state" },
    { text: "Warehouse", width: "15%", fieldName: "warehouse" },
    { text: "Sum netto", width: "10%", fieldName: "sunNetto" },
    { text: "Sum brutto", width: "10%", fieldName: "sumBrutto" }
]

const dataArray = [
    { definition: "FS", number: "FS/000001/05/2023", contractor: "Januszex", date: "2023-01-06", state: "Approved", warehouse: "Główny", sunNetto: 1000, sumBrutto: 1230 },
    { definition: "FS", number: "FS/000002/05/2023", contractor: "Anna", date: "2023-01-06", state: "Approved", warehouse: "Główny", sunNetto: 2000, sumBrutto: 2460 },
]

let dataGrid
let filtersPanel

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", () => {
    dataGrid = new DataGrid(headers, dataArray)
    filtersPanel = new FiltersPanel()

    // Grid
    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())

    // Filter panel
    filtersPanel.addItem(new FilterPanelItem("Period", ["periodFrom", "periodTo"], FilterPanelItem.types.DATE_PERIOD))
    filtersPanel.addItem(new FilterPanelItem("Definition", ["definition"], FilterPanelItem.types.SELECT, [
        {text:"fs", value: 1},
        {text:"zo", value: 2},
        {text:"wz", value: 3 },
        {text:"zd", value: 4},
    ]))
    filtersPanel.addItem(new FilterPanelItem("Contractor", ["contractor"], FilterPanelItem.types.SELECT, []))
    filtersPanel.addItem(new FilterPanelItem("Warehouse", ["warehouse"], FilterPanelItem.types.SELECT, []))

    const divFiltersPanelContainer = document.getElementById("filtersPanelContainer")
    divFiltersPanelContainer.appendChild(filtersPanel.getHtml())


    // Search input
    const inputSearch = document.getElementById("inputSearch")
    inputSearch.addEventListener("keydown", (e) => {
        if(e.key === "Enter")
        {
            console.log("ENTER")
        }
    })

    // Action buttons
    const btnNew = document.getElementById("btnNew")
    btnNew.addEventListener("click", () => {
        console.log(filtersPanel.getFilters())
    })

    const btnDelete = document.getElementById("btnDelete")
    btnDelete.addEventListener("click", () => {

    })

    // const dataGridTest = document.getElementById("dataGridTest")
    // dataGridTest.appendChild(dataGrid.getHtml())

    
})
