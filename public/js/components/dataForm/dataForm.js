class DataForm extends HtmlComponent  {
    _title = "???"
    _width
    _height
    _dataObject = {}
    _fields

    _onSave = (dataObject) => { }
    _onClose = () => { }

    _editformBody
    _divEditformContainer
    _h2Title
    _divEditformBodyFieldsContainer

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

    _init = () => {
        this._htmlMain = document.createElement("div")
        this._htmlMain.id = "dataform"
        this._htmlMain.style.display = "none"

        const divOverlay = document.createElement("div")
        this._htmlMain.appendChild(divOverlay)
        divOverlay.className = "overlay"

        this._divEditformContainer = document.createElement("div")
        divOverlay.appendChild(this._divEditformContainer)
        this._divEditformContainer.className = "editform-container"

        this._divEditformContainer.style.width = `${this._width}vw`
        this._divEditformContainer.style.height = `${this._height}vh`

        this._createDataFormHead()
        this._createDataFormBody()
        this._createDataFormFooter()
    }

    _createDataFormHead = () => {
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
            this._onSave(this._dataObject)
        })

        this._h2Title = document.createElement("h2")
        editformHead.appendChild(this._h2Title)
        this._h2Title.className = "editform-head-title"
        this._h2Title.innerText = "FS/000001/05/2023"
    }

    _createDataFormBody = () => {
        this._editformBody = document.createElement("div")
        this._divEditformContainer.appendChild(this._editformBody)
        this._editformBody.className = "editform-body"

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
    }

    _createDataFormFooter = () => {

    }

    _refreshBody() {
        this._divEditformContainer.innerHTML = ""
        this._createDataFormHead()
        this._createDataFormBody()
        this._createDataFormFooter()
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

    setDataObject = (dataObject) => {
        this._dataObject = dataObject
        this._refreshBody()
    }

    setOnSave = (onSave) => {
        this._onSave = onSave
    }

    setOnClose = (onClose) => {
        this._onClose = onClose
    }

}