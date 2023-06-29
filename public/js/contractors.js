const headers = [
    { text: "Company name", width: "60%", fieldName: "companyname" },
    { text: "Pesel", width: "20%", fieldName: "pesel" },
    { text: "Nip", width: "20%", fieldName: "nip" },
]

const fields = [
    {
        caption: "Personal data",
        section: true,
        dataFields: [
            new DataFormField("company name", "companyname", 150, 400, DataFormField.types.TEXT)
        ]
    },
    {
        caption: "",
        section: false,
        dataFields: [
            new DataFormField("pesel", "pesel", 50, 200, DataFormField.types.TEXT),
            new DataFormField("nip", "nip", 50, 200, DataFormField.types.TEXT)
        ]
    },
    {
        caption: "Address",
        section: true,
        dataFields: [
            new DataFormField("city", "city", 50, 200, DataFormField.types.TEXT),
            new DataFormField("street", "street", 100, 100, DataFormField.types.TEXT),
            new DataFormField("zip code", "zipcode", 100, 100, DataFormField.types.TEXT)
        ]
    },
    {
        caption: "",
        section: false,
        dataFields: [
            new DataFormField("home number", "homenumber", 100, 100, DataFormField.types.TEXT),
            new DataFormField("local number", "localnumber", 100, 100, DataFormField.types.TEXT),
        ]
    }
]

// Global variables
let modal
let dataGrid
let filtersPanel
let dataForm

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
            }
        })

        modal.show()
    })

    //
    // Data grid
    //
    const contractors = await getAllContractors()
    dataGrid = new DataGrid(headers, contractors)
    dataGrid.setOnChecked((dataRow) => {

    })

    dataGrid.setOnRowClick((dataRow) =>{
        dataGrid.setOnlyRowChecked(dataRow)
    })

    dataGrid.setOnRowDoubleClick((dataRow) => {
        const dataObject = dataRow.getDataObject()
        dataForm.setDataObject(dataObject)
        dataForm.setTitle(dataObject.companyname)
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
    btnDelete.addEventListener("click", async () => {
        const idsToDelete = dataGrid.getCheckedData().map(x => x.idcontractor)
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

            const res = await ApiContractors.deleteContractors(idsToDelete)
            if(res.ok)
            {
                const contractors = await getAllContractors()
                dataGrid.setDataArray(contractors)
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
        dataForm.setTitle(checkedData[0].companyname)
        dataForm.setOnSave(async (formDataObject) => dataFormSaveUpdate(modal, dataForm, formDataObject))
        dataForm.show()
    })

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
        await ApiContractors.createContractor(formDataObject)
        const commodity = await getAllContractors()
        dataGrid.setDataArray(commodity)

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
        await ApiContractors.updateContractor(formDataObject)
        const commodity = await getAllContractors()
        dataGrid.setDataArray(commodity)

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

async function getAllContractors()
{
    const contractorsRes = await ApiContractors.getAllContractors()
    return contractorsRes.data.contractors.map(x => ({
        idcontractor: x.idcontractor,
        companyname: x.companyname,
        pesel: x.pesel,
        nip: x.nip,
        idaddress: x.idaddress,
        city: x.address.city,
        homenumber: x.address.homenumber,
        localnumber: x.address.localnumber,
        street: x.address.street,
        zipcode: x.address.zipcode
    }))
}