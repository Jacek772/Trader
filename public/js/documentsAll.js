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

// Global variables
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
    // Data form
    //
    const contractorsRes = await ApiContractors.getAllContractors()
    const contractorsOptionsData = contractorsRes.data.contractors.map(x => ({
        text: x.companyname,
        value: x.idcontractor
    }))

    const warehousesRes = await ApiWarehouses.getAllWarehouses()
    const warehousesOptionsData = warehousesRes.data.warehouses.map(x => ({
        text: `(${x.symbol}) ${x.name}`,
        value: x.idwarehouse
    }))

    const currenciesRes = await ApiCurrencies.getAllCurrencies()
    const currenciesOptionsData = currenciesRes.data.currencies.map(x => ({
        text: x.symbol ,
        value: x.idcurrency
    }))

    const fields = [
        {
            caption: "",
            section: false,
            dataFields: [
                new DataFormField("State", "state", 100, 200, DataFormField.types.SELECT, [
                    { text: "editied", value: 1 },
                    { text: "approved", value: 2 },
                    { text: "annulled", value: 3 }
                ]),
                new DataFormField("Date", "date", 100, 200, DataFormField.types.TEXT),
                new DataFormField("Warehouse", "idwarehouse", 100, 250, DataFormField.types.SELECT, warehousesOptionsData),
                new DataFormField("Currency", "idcurrency", 100, 200, DataFormField.types.SELECT, currenciesOptionsData),
            ]
        },
        {
            caption: "",
            section: false,
            dataFields: [
                new DataFormField("Contractor", "idcontractor", 100, 400, DataFormField.types.SELECT, contractorsOptionsData),
            ]
        },
        {
            caption: "",
            section: false,
            dataFields: [
                new DataFormField("Description", "description", 100, 800, DataFormField.types.TEXT),
            ]
        }
    ]

    dataForm = new DocumentDataForm(fields, 70, 90)
    dataForm.setOnSave(async (formDataObject) => dataFormSaveUpdate(modal, dataForm, formDataObject))
    dataForm.setOnClose(() => {
        modal.clear()
        modal.setModalType(Modal.modalTypes.WARNING)
        modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
        modal.setTitle("Closing the form")
        modal.setText("Do you want to abandon changes ?")
        modal.setOnAction((buttonsType, resultData) => {
            if(resultData.result)
            {
                dataForm.close()

                const checkedData = dataGrid.getCheckedData()
                if(checkedData && checkedData.length > 0)
                {
                    dataForm.setDataObject(checkedData[0])
                }
            }
        })

        modal.show()
    })

    //
    // Grid
    //
    const documents = await getDocuments()
    dataGrid = new DataGrid(headers, documents)

    dataGrid.setOnRowClick((dataRow) => {
        dataGrid.setOnlyRowChecked(dataRow)
    })

    dataGrid.setOnRowDoubleClick((dataRow) => {
        const dataObject = dataRow.getDataObject()
        dataForm.setDataObject(dataObject)
        console.log(dataObject)
        dataForm.setTitle(dataObject.number)
        // dataForm.setOnSave(async (formDataObject) => dataFormSaveUpdate(modal, dataForm, formDataObject))
        dataForm.show()
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

    filtersPanel.addItem(new FilterPanelItem("Period", ["periodFrom", "periodTo"], FilterPanelItem.types.DATE_PERIOD))
    filtersPanel.addItem(new FilterPanelItem("Contractor", ["contractor"], FilterPanelItem.types.SELECT_WITH_EMPTY, contractorsOptionsData))
    filtersPanel.addItem(new FilterPanelItem("Warehouse", ["warehouse"], FilterPanelItem.types.SELECT_WITH_EMPTY, warehousesOptionsData))

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
    btnNew.addEventListener("click", () => {
        dataForm.setDataObject({ positions: [] })
        dataForm.setOnSave(async (formDataObject) => dataFormSaveCreate(modal, dataForm, formDataObject))
        dataForm.setTitle("???")
        dataForm.show()
    })

    const btnDelete = document.getElementById("btnDelete")
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

    const btnOpenForm = document.getElementById("btnOpenForm")
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

    //
    // Apend components to html
    //
    const filtersPanelContainer = document.getElementById("filtersPanelContainer")
    filtersPanelContainer.appendChild(filtersPanel.getHtml())

    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())

    document.body.appendChild(dataForm.getHtml())
    document.body.appendChild(modal.getHtml())
})

async function dataFormSaveCreate(modal, dataForm, formDataObject) {
    try
    {
        const query = createDocumentsQuery(filtersPanel.getFilters())
        const documents = await getDocuments(query)
        dataGrid.setDataArray(documents)

        modal.clear()
        modal.setModalType(Modal.modalTypes.SUCCESS)
        modal.setModalButtonsType(Modal.modalButtonsType.OK)
        modal.setTitle("Success")
        modal.setText("Changes saved successfully!")
        modal.show()
    }
    catch (error)
    {
        modal.setModalType(Modal.modalTypes.DANGER)
        modal.setModalButtonsType(Modal.modalButtonsType.OK)
        modal.setTitle("Error")
        modal.setText(error.toString())
        modal.show()
    }

    dataForm.close()
}


async function dataFormSaveUpdate(modal, dataForm, formDataObject) {
    try
    {
        // Update document
        await ApiDocuments.updateDocument(formDataObject)

        // Delete positions
        const idsPositionsToDelete = formDataObject.positionsEditData
            .filter(x => x.deleted)
            .map(x => x.iddocumentposition)

        if(idsPositionsToDelete && idsPositionsToDelete.length > 0)
        {
            await ApiDocumentpositions.deleteDocumentpositions(idsPositionsToDelete)
        }

        // Create positions
        const newPositions = formDataObject.positionsEditData
            .filter(x => x.new)

        if(newPositions && newPositions.length > 0)
        {
            console.log(newPositions)
            for (let newPosition of newPositions)
            {
                await ApiDocumentpositions.createDocumentposition(newPosition)
            }
        }

        const query = createDocumentsQuery(filtersPanel.getFilters())
        const documents = await getDocuments(query)
        dataGrid.setDataArray(documents)

        modal.clear()
        modal.setModalType(Modal.modalTypes.SUCCESS)
        modal.setModalButtonsType(Modal.modalButtonsType.OK)
        modal.setTitle("Success")
        modal.setText("Changes saved successfully!")
        modal.show()
    }
    catch (error)
    {
        modal.setModalType(Modal.modalTypes.DANGER)
        modal.setModalButtonsType(Modal.modalButtonsType.OK)
        modal.setTitle("Error")
        modal.setText(error.toString())
        modal.show()
    }

    dataForm.close()
}

const createDocumentsQuery = (filters) => {
    let query = { }
    for(let filter of filters)
    {
        query = { ...query, ...filter }
    }
    return query
}

async function getDocuments(query = {}) {
    const documentsRes = await ApiDocuments.getDocuments(query)
    return documentsRes.data.documents.map(x => ({
        iddocument: x.iddocument,
        definition: x.definition.symbol,
        number: x.number,
        idcontractor: x.idcontractor,
        contractor: x.contractor.companyname,
        date: x.date,
        state: x.state,
        description: x.description,
        idwarehouse: x.idwarehouse,
        warehouse: x.warehouse.name,
        idcurrency: x.idcurrency,
        valueNetto: x.valueNetto,
        valueVat: x.valueVat,
        valueGross: x.valueGross,
        positions: x.positions.map(p => ({
            iddocumentposition: p.iddocumentposition,
            commodityName: p.commodity.name,
            commoditySymbol: p.commodity.symbol,
            quantity: p.quantity,
            price: p.price,
            vatratePercent: p.vatrate.percent,
            valueNetto: p.valueNetto,
            valueVat: p.valueVat,
            valueGross: p.valueGross
        }))
    }))
}