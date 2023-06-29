const headersPositions = [
    { text: "Name", width: "20%", fieldName: "commodityName" },
    { text: "Symbol", width: "15%", fieldName: "commoditySymbol" },
    { text: "Quantity", width: "13%", fieldName: "quantity" },
    { text: "Price", width: "13%", fieldName: "price" },
    { text: "% Vat", width: "13%", fieldName: "vatratePercent" },
    { text: "Value netto", width: "13%", fieldName: "valueNetto" },
    { text: "Value gross", width: "13%", fieldName: "valueGross" }
]

class DocumentDataForm extends HtmlComponent  {
    _title = "???"
    _width
    _height
    _dataObject = {}
    _fields
    _positionsEditData = []

    _dataGridPositions
    _dataFormPosition

    _onSave = (dataObject) => { }
    _onClose = () => { }

    _editformBody
    _divEditformContainer
    _h2Title
    _divEditformBodyFieldsContainer
    _divPositionsDataGrid
    _inputValueNetValue
    _inputValueVatValue
    _inputValueGrossValue

    // dataObject = { }
    // fields = [
    //  { caption: string, section: boolean, dataFields: [] }
    // ]
    constructor(fields, width, height){
        super()
        this._fields = fields
        this._width = width
        this._height = height
        this._init()
    }

    async _init() {
        this._htmlMain = document.createElement("div")
        this._htmlMain.id = "documentdataform"
        this._htmlMain.style.display = "none"

        const divOverlay = document.createElement("div")
        this._htmlMain.appendChild(divOverlay)
        divOverlay.className = "overlay"

        this._divEditformContainer = document.createElement("div")
        divOverlay.appendChild(this._divEditformContainer)
        this._divEditformContainer.className = "editform-container"

        this._divEditformContainer.style.width = `${this._width}vw`
        this._divEditformContainer.style.height = `${this._height}vh`

        this._createDocumentDataFormHead()
        await this._createDocumentDataFormBody()
        this._createDataGridPositions()
        this._createDocumentDataFormFooter()
    }

    _createDocumentDataFormHead = () => {
        const editformHead = document.createElement("div")
        this._divEditformContainer.appendChild(editformHead)
        editformHead.className = "editform-head"

        const imgIconClose = document.createElement("img")
        editformHead.appendChild(imgIconClose)
        imgIconClose.id = "iconEditformClose"
        imgIconClose.classList.add("icon")
        imgIconClose.classList.add("icon-clicable")
        imgIconClose.alt = "iconClose"
        imgIconClose.src = "/public/img/svg/close.svg"

        imgIconClose.addEventListener("click", () => {
            // Click X
            this._onClose()
        })

        const btnSave = document.createElement("button")
        editformHead.appendChild(btnSave)
        btnSave.classList.add("button")
        btnSave.classList.add("button-secondary")
        btnSave.innerText = "Save"

        btnSave.addEventListener("click", () => {
            const dataObject = JSON.parse(JSON.stringify({...this._dataObject, positionsEditData: this._positionsEditData}))
            this._onSave(dataObject)
        })

        this._h2Title = document.createElement("h2")
        editformHead.appendChild(this._h2Title)
        this._h2Title.className = "editform-head-title"
        this._h2Title.innerText = "FS/000001/05/2023"
    }

    _createDocumentDataFormBody = async () => {
        this._editformBody = document.createElement("div")
        this._divEditformContainer.appendChild(this._editformBody)
        this._editformBody.className = "editform-body"

        // fields
        this._divEditformBodyFieldsContainer = document.createElement("div")
        this._editformBody.appendChild(this._divEditformBodyFieldsContainer)
        this._divEditformBodyFieldsContainer.className = "editform-body-fields-container"

        for(let rowFieldsData of this._fields)
        {
            // Section caption
            if(rowFieldsData.section)
            {
                const h2Section = document.createElement("h2")
                this._divEditformBodyFieldsContainer.appendChild(h2Section)
                h2Section.className = "editform-body-fields-row-sectioncaption"
                h2Section.innerText = rowFieldsData.caption
            }

            // Data fields
            const divEditformBodyFieldsRow = document.createElement("div")
            this._divEditformBodyFieldsContainer.appendChild(divEditformBodyFieldsRow)
            divEditformBodyFieldsRow.className = "editform-body-fields-row"

            for(let dataField of rowFieldsData.dataFields)
            {
                dataField.setDataObject(this._dataObject)
                divEditformBodyFieldsRow.appendChild(dataField.getHtml())
            }
        }

        // buttons
        const divActionButtonsContainer = document.createElement("div")
        this._editformBody.appendChild(divActionButtonsContainer)
        divActionButtonsContainer.className = "action-buttons-container"

        const divActionButtonsItemBtnNew = document.createElement("div")
        divActionButtonsContainer.appendChild(divActionButtonsItemBtnNew)
        divActionButtonsItemBtnNew.className = "action-buttons-item"


        const commoditiesRes = await ApiCommodities.getCommodities()
        const commoditiesOptionsData = commoditiesRes.data.commodities.map(x => ({
            value: x.idcommodity,
            text: `(${x.symbol}) ${x.name}`
        }))

        const vatratesRes = await ApiVatrates.getAllVatrates()
        const vatratesOptionsData = vatratesRes.data.vatrates.map(x => ({
            value: x.idvatrate,
            text: x.percent
        }))

        const dataFormPositionFields = [
            {
                caption: "",
                section: false,
                dataFields: [
                    new DataFormField("Commodity", "idcommodity", 100, 300, DataFormField.types.SELECT, commoditiesOptionsData),
                ]
            },
            {
                caption: "",
                section: false,
                dataFields: [
                    new DataFormField("Quantity", "quantity", 100, 100, DataFormField.types.NUMBER),
                    new DataFormField("Price", "price", 100, 100, DataFormField.types.NUMBER),
                    new DataFormField("Vatrate", "idvatrate", 100, 100, DataFormField.types.SELECT, vatratesOptionsData),
                ]
            },
        ]

        this._dataFormPosition = new DataForm(dataFormPositionFields, 70, 70)
        this._htmlMain.appendChild(this._dataFormPosition.getHtml())
        this._dataFormPosition.setOnSave(async (formDataObject) => {

            const commodity = commoditiesRes.data.commodities.find(x => x.idcommodity == formDataObject.idcommodity)
            const vatrate = vatratesRes.data.vatrates.find(x => x.idvatrate == formDataObject.idvatrate)

            const valueNetto = Math.round(formDataObject.quantity * formDataObject.price * 100) / 100
            const valueVat = Math.round(valueNetto * vatrate.percent * 100) / 100
            const valueGross = Math.round((valueNetto + valueVat) * 100) / 100

            const positionEditData = {
                iddocument: this._dataObject.iddocument,
                idcommodity: formDataObject.idcommodity,
                commodityName: commodity.name,
                commoditySymbol: commodity.symbol,
                quantity: formDataObject.quantity,
                price: formDataObject.price,
                idvatrate: formDataObject.idvatrate,
                vatratePercent: vatrate.percent,
                valueNetto: valueNetto,
                valueVat: valueVat,
                valueGross: valueGross,
                new: true
            }

            this._positionsEditData.push(positionEditData)
            this._refreshDataGridPositions()
            this._dataFormPosition.close()
        })

        this._dataFormPosition.setOnClose(() => {
            modal.clear()
            modal.setModalType(Modal.modalTypes.WARNING)
            modal.setModalButtonsType(Modal.modalButtonsType.YESNO)
            modal.setTitle("Closing the form")
            modal.setText("Do you want to abandon changes ?")
            modal.setOnAction((buttonsType, resultData) => {
                if(resultData.result)
                {
                    this._dataFormPosition.close()
                }
            })

            modal.show()
        })

        const btnNew = document.createElement("button")
        divActionButtonsItemBtnNew.appendChild(btnNew)
        btnNew.classList.add("button")
        btnNew.classList.add("button-primary")
        btnNew.innerText = "New"
        btnNew.addEventListener("click", () => {
            this._dataFormPosition.setDataObject({})
            this._dataFormPosition.setTitle("")
            this._dataFormPosition.show()
        })

        const divActionButtonsItemBtnDelete = document.createElement("div")
        divActionButtonsContainer.appendChild(divActionButtonsItemBtnDelete)
        divActionButtonsItemBtnDelete.className = "action-buttons-item"

        const btnDelete = document.createElement("button")
        divActionButtonsItemBtnDelete.appendChild(btnDelete)
        btnDelete.classList.add("button")
        btnDelete.classList.add("button-danger")
        btnDelete.innerText = "Delete"
        btnDelete.addEventListener("click", () => {
            const checkedData = this._dataGridPositions.getCheckedData()
            if(checkedData.length == 0)
            {
                modal.setModalType(Modal.modalTypes.WARNING)
                modal.setModalButtonsType(Modal.modalButtonsType.OK)
                modal.setTitle("Cannot select row")
                modal.setText("Cannot select row")
                modal.show()
                return
            }

            const positionEditData = this._positionsEditData.find(x => x.iddocumentposition == checkedData[0].iddocumentposition)
            if(positionEditData)
            {
                positionEditData.deleted = true
            }
            this._refreshDataGridPositions()
        })

        // Grid
        this._divPositionsDataGrid = document.createElement("div")
        this._editformBody.appendChild(this._divPositionsDataGrid)
        this._divPositionsDataGrid.className = "data-grid-container"
    }

    _createDocumentDataFormFooter = () => {
        const divEditformFooter = document.createElement("div")
        this._divEditformContainer.appendChild(divEditformFooter)

        const divEditformFooterRow = document.createElement("div")
        divEditformFooter.appendChild(divEditformFooterRow)
        divEditformFooterRow.className = "editform-footer-row"

        const divEditformFooterTableSumContiner = document.createElement("div")
        divEditformFooterRow.appendChild(divEditformFooterTableSumContiner)
        divEditformFooterTableSumContiner.className = "editform-footer-table-sum-continer"

        const tableEditformFooterTableSum = document.createElement("table")
        divEditformFooterTableSumContiner.appendChild(tableEditformFooterTableSum)
        tableEditformFooterTableSum.className = "editform-footer-table-sum"

        // Value net
        const trValueNet = document.createElement("tr")
        tableEditformFooterTableSum.appendChild(trValueNet)

        const tdValueNetCaption = document.createElement("td")
        trValueNet.appendChild(tdValueNetCaption)

        const pValueNetCaption = document.createElement("p")
        tdValueNetCaption.appendChild(pValueNetCaption)
        pValueNetCaption.className = "editform-footer-table-sum-label"
        pValueNetCaption.innerText = "Value net:"

        const tdValueNetValue = document.createElement("td")
        trValueNet.appendChild(tdValueNetValue)

        this._inputValueNetValue = document.createElement("input")
        tdValueNetValue.appendChild(this._inputValueNetValue)
        this._inputValueNetValue.type = "number"
        this._inputValueNetValue.classList.add("input-text")
        this._inputValueNetValue.classList.add("input-border")
        this._inputValueNetValue.setAttribute("readonly", "readonly")

        // Value VAT
        const trValueVat = document.createElement("tr")
        tableEditformFooterTableSum.appendChild(trValueVat)
        trValueVat.style.borderBottom = "1px solid"

        const tdValueVatCaption = document.createElement("td")
        trValueVat.appendChild(tdValueVatCaption)

        const pValueVatCaption = document.createElement("p")
        tdValueVatCaption.appendChild(pValueVatCaption)
        pValueVatCaption.className = "editform-footer-table-sum-label"
        pValueVatCaption.innerText = "Value VAT:"

        const tdValueVatValue = document.createElement("td")
        trValueVat.appendChild(tdValueVatValue)

        this._inputValueVatValue = document.createElement("input")
        tdValueVatValue.appendChild(this._inputValueVatValue)
        this._inputValueVatValue.type = "number"
        this._inputValueVatValue.classList.add("input-text")
        this._inputValueVatValue.classList.add("input-border")
        this._inputValueVatValue.setAttribute("readonly", "readonly")

        // Value gross
        const trValueGross = document.createElement("tr")
        tableEditformFooterTableSum.appendChild(trValueGross)

        const tdValueGrossCaption = document.createElement("td")
        trValueGross.appendChild(tdValueGrossCaption)

        const pValueGrossCaption = document.createElement("p")
        tdValueGrossCaption.appendChild(pValueGrossCaption)
        pValueGrossCaption.className = "editform-footer-table-sum-label"
        pValueGrossCaption.innerText = "Value gross:"

        const tdValueGrossValue = document.createElement("td")
        trValueGross.appendChild(tdValueGrossValue)

        this._inputValueGrossValue = document.createElement("input")
        tdValueGrossValue.appendChild(this._inputValueGrossValue)
        this._inputValueGrossValue.type = "number"
        this._inputValueGrossValue.classList.add("input-text")
        this._inputValueGrossValue.classList.add("input-border")
        this._inputValueGrossValue.setAttribute("readonly", "readonly")

        this._refreshDocumentSumValues()
    }

    _createDataGridPositions = () => {
        this._dataGridPositions = new DataGrid(headersPositions, [])

        if(this._positionsEditData)
        {
            const positions = this._positionsEditData.filter(x => !x.deleted)
            this._dataGridPositions.setDataArray(positions)
        }

        this._dataGridPositions.setOnRowClick((dataRow) => {
            this._dataGridPositions.setOnlyRowChecked(dataRow)
        })

        this._divPositionsDataGrid.appendChild(this._dataGridPositions.getHtml())
        this._refreshDocumentSumValues()
    }

    _refreshDataGridPositions()
    {
        this._divPositionsDataGrid.innerHTML = ""
        this._createDataGridPositions()
    }

    _refreshDocumentSumValues()
    {
        if(this._inputValueNetValue)
        {
            const valueNettoSum = this._positionsEditData
                .filter(x => !x.deleted)
                .reduce((acc, x) => acc + x.valueNetto, 0)
            this._inputValueNetValue.value = Math.round(valueNettoSum * 100) / 100
        }

        if(this._inputValueVatValue)
        {
            const valueVatSum = this._positionsEditData
                .filter(x => !x.deleted)
                .reduce((acc, x) => acc + x.valueVat, 0)
            this._inputValueVatValue.value = Math.round(valueVatSum * 100) / 100
        }

        if(this._inputValueGrossValue)
        {
            const valueGrossSum = this._positionsEditData
                .filter(x => !x.deleted)
                .reduce((acc, x) => acc + x.valueGross, 0)
            this._inputValueGrossValue.value = Math.round(valueGrossSum * 100) / 100
        }
    }

    async _refreshBody() {
        this._divEditformContainer.innerHTML = ""
        this._createDocumentDataFormHead()
        await this._createDocumentDataFormBody()
        this._refreshDataGridPositions()
        this._createDocumentDataFormFooter()
    }

    show = () => {
        this._htmlMain.style.display = ""
    }

    close = () => {
        this._htmlMain.style.display = "none"
    }

    setTitle = (title) => {
        this._title = title
        this._h2Title.innerText = this._title
    }

    setDataObject = async (dataObject) => {
        this._dataObject = JSON.parse(JSON.stringify(dataObject))
        this._positionsEditData = [...this._dataObject.positions]
        await this._refreshBody()
    }

    setOnSave = (onSave) => {
        this._onSave = onSave
    }

    setOnClose = (onClose) => {
        this._onClose = onClose
    }
}