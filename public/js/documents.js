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

let modal
let dataGrid
let filtersPanel

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {
    const documents = await getDocuments()

    // dataGrid = new DataGrid(headers, dataArray)
    dataGrid = new DataGrid(headers, documents)
    filtersPanel = new FiltersPanel()

    filtersPanel.onChange = async (filters) => {
        const query = createDocumentsQuery(filters)
        const documents = await getDocuments(query)
        dataGrid.setDataArray(documents)
    }

    // Grid
    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())

    // Filter panel
    const documentsdefinitionsRes = await ApiDocumentsdefinitions.getAllDocumentsdefinitions()
    const documentsdefinitions = documentsdefinitionsRes.data.documentsdefinitions.map(x => ({
        text: x.symbol,
        value: x.idDocumentdefinition
    }))

    const contractorsRes = await ApiContractors.getAllContractors()
    const contractors = contractorsRes.data.contractors.map(x => ({
        text: x.companyname,
        value: x.idcontractor
    }))

    const warehousesRes = await ApiWarehouses.getAllWarehouses()
    const warehouses = warehousesRes.data.warehouses.map(x => ({
        text: `(${x.symbol}) ${x.name}`,
        value: x.idwarehouse
    }))

    filtersPanel.addItem(new FilterPanelItem("Period", ["periodFrom", "periodTo"], FilterPanelItem.types.DATE_PERIOD))
    filtersPanel.addItem(new FilterPanelItem("Definition", ["definition"], FilterPanelItem.types.SELECT_WITH_EMPTY, documentsdefinitions))
    filtersPanel.addItem(new FilterPanelItem("Contractor", ["contractor"], FilterPanelItem.types.SELECT_WITH_EMPTY, contractors))
    filtersPanel.addItem(new FilterPanelItem("Warehouse", ["warehouse"], FilterPanelItem.types.SELECT_WITH_EMPTY, warehouses))

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
    btnDelete.addEventListener("click", async () => {
        const idsToDelete = dataGrid.getCheckedData().map(x => x.idDocument)

        if(idsToDelete.length == 0)
        {
            modal.setModalType(Modal.modalTypes.WARNING)
            modal.setModalButtonsType(Modal.modalButtonsType.OK)
            modal.setTitle("Nie wybrano dokumentu")
            modal.setText("Nie wybrano dokumentu do usunięcia")
            modal.show()
            return
        }

        modal.setModalType(Modal.modalTypes.WARNING)
        modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
        modal.setTitle("Usuwanie dokumentów")
        modal.setText("Czy na pewno chcesz usunąć wybrane dokumenty ?")
        modal.setOnAction(async (modalType, modalResult) => {
            if(!modalResult.result)
            {
                return
            }

            await ApiDocuments.deleteDocuments(idsToDelete)

            const query = createDocumentsQuery(filtersPanel.getFilters())
            const documents = await getDocuments(query)
            dataGrid.setDataArray(documents)
        })
        modal.show()
    })

    // const dataGridTest = document.getElementById("dataGridTest")
    // dataGridTest.appendChild(dataGrid.getHtml())

    // Modal

    modal = new Modal()
    modal.setTitle("Title")
    modal.setText("Text modala")
    modal.setModalType(Modal.modalTypes.INFO)
    modal.setModalButtonsType(Modal.modalButtonsType.OK)
    modal.setBlockClosing(false)
    modal.setOnAction((result) => {
        console.log(result)
    })

    document.body.appendChild(modal.getHtml())
    // modal.show()
})

const createDocumentsQuery = (filters) => {
    let query = { }
    for(let filter of filters)
    {
        query = { ...query, ...filter }
    }
    return query
}

const getDocuments = async (query = {}) => {
    const documentsRes = await ApiDocuments.getDocuments(query)
    return documentsRes.data.documents.map(x => ({
        idDocument: x.idDocument,
        definition: x.definition.symbol,
        number: x.number,
        contractor: x.contractor.companyname,
        date: x.date,
        state: x.state,
        warehouse: x.warehouse.name,
        sunNetto: 0,
        sumBrutto: 0
    }))
}



