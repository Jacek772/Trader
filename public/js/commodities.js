const headers = [
    { text: "Symbol", width: "20%", fieldName: "symbol" },
    { text: "Name", width: "40%", fieldName: "name" },
    { text: "unit symbol", width: "20%", fieldName: "unitSymbol" },
    { text: "vat rate percent", width: "20%", fieldName: "vatratePercent" },
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
    const commodities = await getAllCommodities()
    dataGrid = new DataGrid(headers, commodities)

    //
    // Data form
    //

    const unitsRes = await ApiUnits.getAllUnits()
    const unitsOptionsData = unitsRes.data.units.map(x => ({
        value: x.idunit,
        text: x.symbol
    }))

    const vatratesRes = await ApiVatrates.getAllVatrates()
    const vatratesOptionsData = vatratesRes.data.vatrates.map(x => ({
        value: x.idvatrate,
        text: x.percent
    }))

    const fields = [
        {
            caption: "Commodity data",
            section: true,
            dataFields: [
                new DataFormField("symbol", "symbol", 100, 100, FilterPanelItem.types.TEXT),
                new DataFormField("name", "name", 100, 100, FilterPanelItem.types.TEXT),
                new DataFormField("unit symbol", "idunit", 100, 100, FilterPanelItem.types.SELECT, unitsOptionsData),
                new DataFormField("vat rate percent", "idvatrate", 150, 100, FilterPanelItem.types.SELECT, vatratesOptionsData),
            ]
        },
        {
            caption: "",
            section: false,
            dataFields: [
                new DataFormField("description", "description", 100, 1000, FilterPanelItem.types.TEXT),
            ]
        }
    ]

    const dataForm = new DataForm(fields, 70, 70)
    dataForm.setOnSave(async (formDataObject) => {
        try
        {
            await ApiCommodities.updateCommodity(formDataObject)
            const commodity = await getAllCommodities()
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
        dataForm.setTitle(dataObject.name)
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
        const idsToDelete = dataGrid.getCheckedData().map(x => x.idcommodity)
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

            await ApiCommodities.deleteCommodities(idsToDelete)

            const commodities = await getAllCommodities()
            dataGrid.setDataArray(commodities)
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
        dataForm.setTitle(checkedData[0].name)
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

async function getAllCommodities()
{
    const commoditiesRes = await ApiCommodities.getCommodities({})
    console.log(commoditiesRes)
    return commoditiesRes.data.commodities.map(x => ({
        idcommodity: x.idcommodity,
        symbol: x.symbol,
        name: x.name,
        description: x.description,
        idunit: x.unit.idunit,
        unitSymbol: x.unit.symbol,
        idvatrate: x.vatrate.idvatrate,
        vatratePercent: x.vatrate.percent
    }))
}
