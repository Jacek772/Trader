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

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", () => {
    dataGrid = new DataGrid(headers, dataArray)

    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())
})
