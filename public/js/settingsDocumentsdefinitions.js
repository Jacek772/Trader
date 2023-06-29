const headers = [
    { text: "Symbol", width: "20%", fieldName: "symbol" },
    { text: "Name", width: "30%", fieldName: "name" },
    { text: "Description", width: "30%", fieldName: "description" },
    { text: "Direction", width: "10%", fieldName: "directionName" },
    { text: "Type", width: "10%", fieldName: "typeName" },
]

const fields = [
    {
        caption: "",
        section: false,
        dataFields: [
            new DataFormField("symbol", "symbol", 100, 200, DataFormField.types.TEXT),
            new DataFormField("name", "name", 100, 200, DataFormField.types.TEXT)
        ]
    },
    {
        caption: "",
        section: false,
        dataFields: [
            new DataFormField("type", "type", 100, 200, DataFormField.types.SELECT, [
                { text: "offer", value: 1 },
                { text: "sale", value: 2 },
                { text: "warehouse", value: 3 },
                { text: "order", value: 4 },
            ]),
            new DataFormField("direction", "direction", 100, 200, DataFormField.types.SELECT, [
                { text: "", value: 1 },
                { text: "income", value: 2 },
                { text: "expenditure", value: 3 }
            ]),
        ]
    },
    {
        caption: "",
        section: false,
        dataFields: [
            new DataFormField("description", "description", 100, 800, DataFormField.types.TEXT),
        ]
    },
]

// Global variables
let modal
let dataGrid

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {
    //
    // Modal
    //
    modal = new Modal()

    //
    // Data form
    //
    dataForm = new DataForm(fields, 70, 70)
    dataForm.setOnSave(async (formDataObject) => dataFormSaveUpdate(modal, dataForm, formDataObject))
    dataForm.setOnClose(() => dataFormClose(modal, dataForm))

    //
    // Data grid
    //
    const documentsdefinitions = await getAllDocumentsdefinitions()
    dataGrid = new DataGrid(headers, documentsdefinitions)

    dataGrid.setOnRowClick((dataRow) =>{
        dataGrid.setOnlyRowChecked(dataRow)
    })

    dataGrid.setOnRowDoubleClick((dataRow) => {
        const dataObject = dataRow.getDataObject()
        dataForm.setDataObject(dataObject)
        dataForm.setTitle(dataObject.name)
        dataForm.setOnSave(async (formDataObject) => dataFormSaveUpdate(modal, dataForm, formDataObject))
        dataForm.show()
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
    // Action buttons
    //
    const btnNew = document.getElementById("btnNew")
    btnNew.addEventListener("click", () => {
        dataForm.setDataObject({})
        dataForm.setOnSave(async (formDataObject) => dataFormSaveCreate(modal, dataForm, formDataObject))
        dataForm.setTitle("???")
        dataForm.show()
    })

    const btnDelete = document.getElementById("btnDelete")
    btnDelete.addEventListener("click", async () => await dataGridDelete(dataGrid, modal))

    const btnOpenForm = document.getElementById("btnOpenForm")
    btnOpenForm.addEventListener("click", async () => await dataGridOpenForm(dataGrid, modal))

    //
    // Apend components to html
    //
    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())

    document.body.appendChild(dataForm.getHtml())
    document.body.appendChild(modal.getHtml())
})

async function dataFormSaveCreate(modal, dataForm, formDataObject) {
    try
    {
        await ApiDocumentsdefinitions.createDocumentdefinition(formDataObject)
        const documentsdefinitions = await getAllDocumentsdefinitions()
        dataGrid.setDataArray(documentsdefinitions)

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
        console.log(formDataObject)
        await ApiDocumentsdefinitions.updateDocumentdefinition(formDataObject)
        const documentsdefinitions = await getAllDocumentsdefinitions()
        dataGrid.setDataArray(documentsdefinitions)

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

async function dataFormClose(modal, dataForm) {
    modal.clear()
    modal.setModalType(Modal.modalTypes.WARNING)
    modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
    modal.setTitle("Closing the form")
    modal.setText("Do you want to abandon changes ?")
    modal.setOnAction((buttonsType, resultData) => {
        if(resultData.result)
        {
            dataForm.close()
        }
    })

    modal.show()
}

async function dataGridDelete(dataGrid, modal) {
    const idsToDelete = dataGrid.getCheckedData().map(x => x.iddocumentdefinition)
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

        const res = await ApiDocumentsdefinitions.deleteDocumentsdefinitions(idsToDelete)
        if(res.ok)
        {
            const documentsdefinitions = await getAllDocumentsdefinitions()
            dataGrid.setDataArray(documentsdefinitions)
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
}

function dataGridOpenForm(dataGrid, modal) {
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
    dataForm.setTitle(checkedData[0].name)
    dataForm.setOnSave(async (formDataObject) => dataFormSaveUpdate(modal, dataForm, formDataObject))
    dataForm.show()
}

async function getAllDocumentsdefinitions()
{
    const documentsdefinitionsRes = await ApiDocumentsdefinitions.getAllDocumentsdefinitions()
    return documentsdefinitionsRes.data.documentsdefinitions.map(x => {
        return {
            iddocumentdefinition: x.iddocumentdefinition,
            symbol: x.symbol,
            name: x.name,
            description: x.description,
            direction: x.direction,
            directionName: x.directionName,
            type: x.type,
            typeName: x.typeName
        }
    })
}