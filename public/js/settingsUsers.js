// Configuration
const headers = [
    { text: "login", width: "20%", fieldName: "login" },
    { text: "name", width: "40%", fieldName: "name" },
    { text: "surname", width: "20%", fieldName: "surname" },
    { text: "role", width: "20%", fieldName: "roleName" },
]

// Global variables
let modal
let dataGrid
let filtersPanel
let dataForm

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {
    const rolesRes = await ApiRoles.getAllRoles()
    const rolesOptions = rolesRes.data.roles.map(x => ({
        text: x.name,
        value: x.idRole
    }))

    // Modal
    //
    modal = new Modal()

    //
    // Grid
    //
    const users = await getUsers()
    dataGrid = new DataGrid(headers, users)

    //
    // Filters panel
    //
    filtersPanel = new FiltersPanel()
    filtersPanel.setOnChange(async (filters) => {
        const query = createUsersQuery(filters)
        const users = await getUsers(query)
        dataGrid.setDataArray(users)
    })

    filtersPanel.addItem(new FilterPanelItem("Role", ["idrole"], FilterPanelItem.types.SELECT_WITH_EMPTY, rolesOptions))

    //
    // Data form
    //
    const fields = [
        {
            caption: "Personal data",
            section: true,
            dataFields: [
                new DataFormField("login", "login", 100, 100, DataFormField.types.TEXT),
                new DataFormField("password", "password", 100, 100, DataFormField.types.SECURETEXT),
            ]
        },
        {
            caption: "",
            section: false,
            dataFields: [
                new DataFormField("name", "name", 100, 100, DataFormField.types.TEXT),
                new DataFormField("surname", "surname", 100, 100, DataFormField.types.TEXT)
            ]
        },
        {
            caption: "Role",
            section: true,
            dataFields: [
                new DataFormField("role", "idrole", 100, 200, DataFormField.types.SELECT, rolesOptions)
            ]
        }
    ]

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
        const idsToDelete = dataGrid.getCheckedData().map(x => x.iduser)
        if(idsToDelete.length == 0)
        {
            modal.setModalType(Modal.modalTypes.WARNING)
            modal.setModalButtonsType(Modal.modalButtonsType.OK)
            modal.setTitle("Delete commodities")
            modal.setText("No data selected")
            modal.show()
            return
        }

        modal.setModalType(Modal.modalTypes.WARNING)
        modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
        modal.setTitle("Delete commodities")
        modal.setText("Are you sure you want to delete the selected items ?")
        modal.setOnAction(async (modalType, modalResult) => {
            if(!modalResult.result)
            {
                return
            }

            const res = await ApiUsers.deleteUsers(idsToDelete)
            if(res.ok)
            {
                const filters = filtersPanel.getFilters()
                const query = createUsersQuery(filters)
                const users = await getUsers(query)
                dataGrid.setDataArray(users)
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
    // Data grid
    //
    dataGrid.setOnRowClick((dataRow) => {
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
    // Apend components to html
    //
    const filtersPanelContainer = document.getElementById("filtersPanelContainer")
    filtersPanelContainer.appendChild(filtersPanel.getHtml())

    const divDataGridContainer = document.getElementById("dataGridContainer")
    divDataGridContainer.appendChild(dataGrid.getHtml())

    document.body.appendChild(dataForm.getHtml())
    document.body.appendChild(modal.getHtml())
})

function createUsersQuery(filters) {
    let query = { }
    for(let filter of filters)
    {
        query = { ...query, ...filter }
    }
    return query
}

async function dataFormSaveCreate(modal, dataForm, formDataObject) {
    try
    {
        await ApiUsers.createUser(formDataObject)

        const filters = filtersPanel.getFilters()
        const query = createUsersQuery(filters)
        const users = await getUsers(query)
        dataGrid.setDataArray(users)

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
        await ApiUsers.updateUser(formDataObject)

        const filters = filtersPanel.getFilters()
        const query = createUsersQuery(filters)
        const users = await getUsers(query)
        dataGrid.setDataArray(users)

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

async function getUsers(query = {}){
    const usersAllRes = await ApiUsers.getUsers(query)
    return usersAllRes.data.users.map(x => ({
        iduser: x.iduser,
        login: x.login,
        name: x.name,
        surname: x.surname,
        roleName: x.role.name,
        idrole: x.idrole
    }))
}
