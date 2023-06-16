const headers = [
    { text: "Company name", width: "50%", fieldName: "companyname" },
    { text: "Pesel", width: "20%", fieldName: "pesel" },
    { text: "Nip", width: "20%", fieldName: "nip" },
]

let dataGrid
let filtersPanel
// DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {

    // Grid
    const contractors = await getAllContractors()
    dataGrid = new DataGrid(headers, contractors)

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
    const btnNew = document.getElementById("btnNew")
    btnNew.addEventListener("click", () => {
        console.log(filtersPanel.getFilters())
    })

    const btnDelete = document.getElementById("btnDelete")
    btnDelete.addEventListener("click", async () => {
        const idsToDelete = dataGrid.getCheckedData().map(x => x.idcontractor)
    })
})

async function getAllContractors()
{
    const contractorsRes = await ApiContractors.getAllContractors()
    return contractorsRes.data.contractors.map(x => ({
        companyname: x.companyname,
        pesel: x.pesel,
        nip: x.nip
    }))
}