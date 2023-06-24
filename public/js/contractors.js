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
            new DataFormField("company name", "companyname", 150, 400, FilterPanelItem.types.TEXT)
        ]
    },
    {
        caption: "",
        section: false,
        dataFields: [
            new DataFormField("pesel", "pesel", 50, 200, FilterPanelItem.types.TEXT),
            new DataFormField("nip", "nip", 50, 200, FilterPanelItem.types.TEXT)
        ]
    },
    {
        caption: "Address",
        section: true,
        dataFields: [
            new DataFormField("city", "city", 50, 200, FilterPanelItem.types.TEXT),
            new DataFormField("street", "street", 100, 100, FilterPanelItem.types.TEXT),
            new DataFormField("zip code", "zipcode", 100, 100, FilterPanelItem.types.TEXT)
        ]
    },
    {
        caption: "",
        section: false,
        dataFields: [
            new DataFormField("home number", "homenumber", 100, 100, FilterPanelItem.types.TEXT),
            new DataFormField("local number", "localnumber", 100, 100, FilterPanelItem.types.TEXT),
        ]
    }
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
    // Grid
    //
    const contractors = await getAllContractors()
    dataGrid = new DataGrid(headers, contractors)

    //
    // Data form
    //
    const dataForm = new DataForm(fields, 70, 70)
    dataForm.setOnSave(async (formDataObject) => {
        try
        {
            await ApiContractors.updateContractor(formDataObject)
            const contractors = await getAllContractors()
            dataGrid.setDataArray(contractors)

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
    })

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
    dataGrid.setOnChecked((dataRow) => {
        console.log(dataRow)
    })

    dataGrid.setOnRowClick((dataRow) =>{
        dataGrid.setOnlyRowChecked(dataRow)
    })

    dataGrid.setOnRowDoubleClick((dataRow) => {
        const dataObject = dataRow.getDataObject()
        console.log(dataObject)

        dataForm.setDataObject(dataObject)
        dataForm.setTitle(dataObject.companyname)
        dataForm.show()
    })

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
        dataForm.setDataObject({})
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
            modal.setTitle("Delete contractors")
            modal.setText("No data selected")
            modal.show()
            return
        }

        modal.setModalType(Modal.modalTypes.WARNING)
        modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
        modal.setTitle("Delete contractors")
        modal.setText("Are you sure you want to delete the selected items ?")
        modal.setOnAction(async (modalType, modalResult) => {
            if(!modalResult.result)
            {
                return
            }

            await ApiContractors.deleteContractors(idsToDelete)

            const contractors = await getAllContractors()
            dataGrid.setDataArray(contractors)
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
            modal.setTitle("Nie wybrano kontrahenta")
            modal.setText("Nie wybrano kontrahenta")
            modal.show()
            return
        }

        dataForm.setDataObject(checkedData[0])
        dataForm.setTitle(checkedData[0].companyname)
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