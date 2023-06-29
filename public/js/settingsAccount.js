

// Global variables
let pageform
let modal

// DOMContentLoaded
document.addEventListener("DOMContentLoaded", async () => {
    //
    // Modal
    //
    modal = new Modal()

    //
    // Pageform
    //
    const fields = [
        {
            caption: "User data",
            section: true,
            dataFields: [
                new PageformField("login", "login", 150, 300, PageformField.types.TEXT)
            ]
        },
        {
            caption: "",
            section: false,
            dataFields: [
                new PageformField("name", "name", 150, 300, PageformField.types.TEXT)
            ]
        },
        {
            caption: "",
            section: false,
            dataFields: [
                new PageformField("surname", "surname", 150, 300, PageformField.types.TEXT)
            ]
        },
        {
            caption: "Password",
            section: true,
            dataFields: [
                new PageformField("old password", "oldpassword", 150, 300, PageformField.types.TEXT)
            ]
        },
        {
            caption: "",
            section: false,
            dataFields: [
                new PageformField("new password", "newpassword", 150, 300, PageformField.types.TEXT)
            ]
        },
        {
            caption: "",
            section: false,
            dataFields: [
                new PageformField("repeat", "repeatpassword", 150, 300, PageformField.types.TEXT)
            ]
        },
    ]

    pageform = new Pageform(fields)
    const userData = await getUserData(iduser)
    pageform.setDataObject({ ...userData })
    pageform.setOnSave(dataObject => {
        // TODO: Jak zostanie czasu udoskonalić werydikację i walidację

        // validation
        if(dataObject.newpassword && !dataObject.oldpassword)
        {
            modal.setModalType(Modal.modalTypes.DANGER)
            modal.setModalButtonsType(Modal.modalButtonsType.OK)
            modal.setTitle("Bad password")
            modal.setText("Bad old password!")
            modal.show()
            return
        }

        if(dataObject.newpassword != dataObject.repeatpassword)
        {
            modal.setModalType(Modal.modalTypes.DANGER)
            modal.setModalButtonsType(Modal.modalButtonsType.OK)
            modal.setTitle("Bad password")
            modal.setText("Passwords are not equal!")
            modal.show()
            return
        }

        // modal
        modal.setModalType(Modal.modalTypes.WARNING)
        modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
        modal.setTitle("Save")
        modal.setText("Are you sure you want to save changes ?")
        modal.setOnAction(async (modalType, modalResult) => {
            if(!modalResult.result)
            {
                return
            }

            try
            {
                await ApiUsers.updateUser(dataObject)
                const updatedUserData = await getUserData(iduser)
                pageform.setDataObject(updatedUserData)

                modal.setModalType(Modal.modalTypes.SUCCESS)
                modal.setModalButtonsType(Modal.modalButtonsType.OK)
                modal.setTitle("Saved")
                modal.setText("Changes saved.")
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
        })
        modal.show()
    })

    pageform.setOnDiscard(() => {
        modal.setModalType(Modal.modalTypes.WARNING)
        modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
        modal.setTitle("Save")
        modal.setText("Are you sure you want to discard changes ?")
        modal.setOnAction(async (modalType, modalResult) => {
            if(!modalResult.result)
            {
                return
            }

            pageform.setDataObject({ ...userData })
        })

        modal.show()
    })

    //
    // Apend components to html
    //
    const divPageformContainer = document.getElementById("pageformContainerSettingsAccount")
    divPageformContainer.appendChild(pageform.getHtml())

    document.body.appendChild(modal.getHtml())
})

async function getUserData(iduser) {
    const userDataRes = await ApiUsers.getUserById(iduser)
    return  {
        iduser,
        login: userDataRes.data.user.login,
        name: userDataRes.data.user.name,
        surname:userDataRes.data.user.surname,
        oldpassword: "",
        newpassword: "",
        repeatpassword: "",
    }
}