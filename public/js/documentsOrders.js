const headers = [
    { text: "Definition", width: "10%", fieldName: "definition" },
    { text: "Document no.", width: "15%", fieldName: "number" },
    { text: "Contractor", width: "15%", fieldName: "contractor" },
    { text: "Date", width: "10%", fieldName: "date" },
    { text: "State", width: "10%", fieldName: "state" },
    { text: "Warehouse", width: "15%", fieldName: "warehouse" },
    { text: "Sum netto", width: "10%", fieldName: "valueNetto" },
    { text: "Sum brutto", width: "10%", fieldName: "valueGross" }
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
    const documents = await getDocuments()
    dataGrid = new DataGrid(headers, documents)

    dataGrid.setOnRowClick((dataRow) => {
        dataGrid.setOnlyRowChecked(dataRow)
    })

    dataGrid.setOnRowDoubleClick((dataRow) => {
        // const dataObject = dataRow.getDataObject()
        // dataForm.setDataObject(dataObject)
        // dataForm.setTitle(dataObject.name)
        // dataForm.setOnSave(async (formDataObject) => dataFormSaveUpdate(modal, dataForm, formDataObject))
        // dataForm.show()
    })

    //
    // Filters panel
    //
    filtersPanel = new FiltersPanel()
    filtersPanel.setOnChange(async (filters) => {
        const query = createDocumentsQuery(filters)
        const documents = await getDocuments(query)
        dataGrid.setDataArray(documents)
    })

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

    if(roleName == "Administrator" || roleName == "Trader")
    {
        filtersPanel.addItem(new FilterPanelItem("Contractor", ["contractor"], FilterPanelItem.types.SELECT_WITH_EMPTY, contractors))
        filtersPanel.addItem(new FilterPanelItem("Warehouse", ["warehouse"], FilterPanelItem.types.SELECT_WITH_EMPTY, warehouses))
    }

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
    const btnNew = document.getElementById("btnNew")
    if(btnNew)
    {
        btnNew.addEventListener("click", () => {

        })
    }

    const btnDelete = document.getElementById("btnDelete")
    if(btnDelete)
    {
        btnDelete.addEventListener("click", async () => {
            const idsToDelete = dataGrid.getCheckedData().map(x => x.iddocument)

            if(idsToDelete.length == 0)
            {
                modal.setModalType(Modal.modalTypes.WARNING)
                modal.setModalButtonsType(Modal.modalButtonsType.OK)
                modal.setTitle("Delete")
                modal.setText("No data selected")
                modal.show()
                return
            }

            modal.setModalType(Modal.modalTypes.WARNING)
            modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
            modal.setTitle("Delete")
            modal.setText("Are you sure you want to delete the selected items ?")
            modal.setOnAction(async (modalType, modalResult) => {
                if(!modalResult.result)
                {
                    return
                }

                const res = await ApiDocuments.deleteDocuments(idsToDelete)
                if(res.ok)
                {
                    const query = createDocumentsQuery(filtersPanel.getFilters())
                    const documents = await getDocuments(query)
                    dataGrid.setDataArray(documents)
                }
                else
                {
                    modal.setModalType(Modal.modalTypes.DANGER)
                    modal.setModalButtonsType(Modal.modalButtonsType.OK)
                    modal.setTitle("Delete")
                    modal.setText("Cannot delete this row!")
                    modal.show()
                }
            })
            modal.show()
        })
    }

    const btnOpenForm = document.getElementById("btnOpenForm")
    if(btnOpenForm)
    {
        btnOpenForm.addEventListener("click", async () => {
            const checkedData = dataGrid.getCheckedData()
            if(checkedData.length == 0)
            {
                modal.setModalType(Modal.modalTypes.WARNING)
                modal.setModalButtonsType(Modal.modalButtonsType.OK)
                modal.setTitle("Cannot select row")
                modal.setText("Cannot select row")
                modal.show()
                return
            }

            dataForm.setDataObject(checkedData[0])
            dataForm.setTitle(`${checkedData[0].name} ${checkedData[0].surname}`)
            dataForm.setOnSave(async (formDataObject) => dataFormSaveUpdate(modal, dataForm, formDataObject))
            dataForm.show()
        })
    }

    //
    // Apend components to html
    //
    const filtersPanelContainer = document.getElementById("filtersPanelContainer")
    filtersPanelContainer.appendChild(filtersPanel.getHtml())

    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())

    document.body.appendChild(modal.getHtml())
    // document.body.appendChild(dataForm.getHtml())
})

function createDocumentsQuery(filters) {
    let query = { }
    for(let filter of filters)
    {
        query = { ...query, ...filter }
    }
    return query
}

async function getDocuments(query = {}) {
    const documentsRes = await ApiDocuments.getDocuments({ ...query, type: 4 })
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