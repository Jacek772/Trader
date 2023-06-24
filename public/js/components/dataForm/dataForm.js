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
                // const divEditformBodyFieldsItem = document.createElement("div")
                // this._divEditformBodyFieldsContainer.appendChild(divEditformBodyFieldsItem)
                //
                // const label = document.createElement("label")
                // divEditformBodyFieldsItem.appendChild(label)
                // label.innerText = fieldData.labelText
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

// TODO: Zrobić uniwersalną klasę do tego typu pól, ponieważ jest wykorzystywanen w panelu filtrowania
// i innych polach
class DataFormField extends HtmlComponent {
    static types = {
        TEXT: "TEXT",
        SELECT: "SELECT",
        SELECT_WITH_EMPTY: "SELECT_WITH_EMPTY",
        DATE_PERIOD: "DATE_PERIOD",
    }

    static eventTypes = {
        ValueEnter: "ValueEnter",
        ValueDiscard: "ValueDiscard"
    }

    // { type, callback }
    _events = []
    _labelText
    _dataKey
    _dataObject
    _labelWidth
    _width
    _type
    _optionsData

    _input

    // Niezbędne dla type.SELECT
    // options = { text, value }
    constructor(labelText, dataKey, labelWidth, width,
                type = FilterPanelItem.types.TEXT, optionsData = [])
    {
        super()
        this._labelText = labelText
        this._dataKey = dataKey
        this._labelWidth = labelWidth
        this._width = width
        this._type = type
        this._optionsData = optionsData

        this._init()
    }

    _init = () => {
        // init container
        this._initInputContainer()

        // init label
        this._initLabel()

        // init input
        this._initInput()
    }

    _initInputContainer = () => {
        this._htmlMain = document.createElement("div")
        this._htmlMain.className = "editform-body-fields-item"
    }

    _initLabel = () => {
        const label = document.createElement("label")
        this._htmlMain.appendChild(label)
        label.className = "input-text-label"
        label.innerText = this._labelText
        label.style.width = `${this._labelWidth}px`
    }

    _initInput = () => {
        switch(this._type)
        {
            case DataFormField.types.SELECT:
                this._initInputSelect()
                break
            case DataFormField.types.DATE:
                this._initInputDate()
                break
            // case DataFormField.types.DATE_PERIOD:
            //     this._initInputDatePeriod()
            //     break
            case DataFormField.types.TEXT:
            default:
                this._initInputText()
                break
        }
    }

    _initInputText = () => {
        this._input = document.createElement("input")
        this._htmlMain.appendChild(this._input)
        this._input.type = "text"
        this._input.classList.add("input-text")
        this._input.classList.add("input-border")
        // this._input.value = this._dataObject[this._dataKey]
        this._input.style.width = `${this._width}px`

        this._input.addEventListener("keydown", (e) => {
            if(e.key == "Enter")
            {
                // Zapis zmian
                this._events
                    .filter(x => x.type == DataFormField.eventTypes.ValueEnter)
                    .forEach(x => x.callback(e.target.value))

                this._dataObject[this._dataKey] = e.target.value
                e.target.blur()
            }

            if(e.key == "Escape")
            {
                // Cofnięcie zmian
                this._events
                    .filter(x => x.type == DataFormField.eventTypes.ValueDiscard)
                    .forEach(x => x.callback())

                e.target.value = this._dataObject[this._dataKey]
                e.target.blur()
            }
        })

        this._input.addEventListener("blur", (e) => {
            // Zapis zmian
            this._events
                .filter(x => x.type == DataFormField.eventTypes.ValueEnter)
                .forEach(x => x.callback(e.target.value))

            this._dataObject[this._dataKey] = e.target.value
        })
    }

    _initInputSelect = () => {
        this._input = document.createElement("select")
        this._htmlMain.appendChild(this._input)
        this._input.classList.add("input-text")
        this._input.classList.add("input-border")
        this._input.style.width = `${this._width}px`
        // this._input.value = this._dataObject[this._dataKey]

        this._input.addEventListener("input", (e) => {
            // Zapis zmian
            this._events
                .filter(x => x.type == DataFormField.eventTypes.ValueEnter)
                .forEach(x => x.callback(e.target.value))
            this._dataObject[this._dataKey] = e.target.value
        })

        for(let optionData of this._optionsData)
        {
            const option = document.createElement("option")
            this._input.appendChild(option)
            option.value = optionData.value
            option.innerText = optionData.text
        }
    }

    _initInputDate = () => {
        this._input = document.createElement("input")
        this._htmlMain.appendChild(this._input)
        this._input.type = "date"
        this._input.classList.add("input-text")
        this._input.classList.add("input-border")
        this._input.value = this._dataObject[this._dataKey]
        this._input.style.width = `${this._width}px`

        this._input.addEventListener("keydown", (e) => {
            if(e.key == "Enter")
            {
                // Zapis zmian
                this._events
                    .filter(x => x.type == DataFormField.eventTypes.ValueEnter)
                    .forEach(x => x.callback(e.target.value))

                this._dataObject[this._dataKey] = e.target.value
                e.target.blur()
            }

            if(e.key == "Escape")
            {
                // Cofnięcie zmian
                this._events
                    .filter(x => x.type == DataFormField.eventTypes.ValueDiscard)
                    .forEach(x => x.callback())

                e.target.value = this._dataObject[this._dataKey]
                e.target.blur()
            }
        })

        this._input.addEventListener("blur", (e) => {
            // Zapis zmian
            this._events
                .filter(x => x.type == DataFormField.eventTypes.ValueEnter)
                .forEach(x => x.callback(e.target.value))

            this._dataObject[this._dataKey] = e.target.value
        })
    }

    // this._dataObject = dataObject
    setDataObject = (dataObject) => {
        this._dataObject = dataObject
        if(this._dataObject && JSON.stringify(this._dataObject) != "{}")
        {
            this._input.value = this._dataObject[this._dataKey]
        }
        else
        {
            this._input.value = ""
        }
    }

    // _initInputDatePeriod = () => {
    //     const inputFrom = document.createElement("input")
    //     this._htmlMain.appendChild(inputFrom)

    //     const inputTo = document.createElement("input")
    //     this._htmlMain.appendChild(inputTo)

    //     inputFrom.type = "date"
    //     inputFrom.classList.add("input-text")
    //     inputFrom.classList.add("input-border")
    //     inputFrom.addEventListener("keydown", (e) => {

    //         if(e.key == "Enter")
    //         {
    //             let dateFrom = null
    //             if(e.target.value)
    //             {
    //                 dateFrom = new Date(e.target.value)
    //             }
    
    //             let dateTo = null
    //             if(inputTo.value)
    //             {
    //                 dateTo = new Date(inputTo.value)
    //             }
    
    //             if(dateFrom && dateTo && dateFrom > dateTo)
    //             {
    //                 dateFrom = dateTo
    //                 e.target.value = inputTo.value
    //             }
    //         }

    //         this._fieldValues[0] = dateFrom
    //     })

    //     inputTo.type = "date"
    //     inputTo.classList.add("input-text")
    //     inputTo.classList.add("input-border")
    //     inputTo.addEventListener("input", (e) => {
    //         let dateFrom = null
    //         if(inputFrom.value)
    //         {
    //             dateFrom = new Date(inputFrom.value)
    //         }

    //         let dateTo = null
    //         if(e.target.value)
    //         {
    //             dateTo = new Date(e.target.value)
    //         }

    //         if(dateFrom && dateTo && dateTo < dateFrom)
    //         {
    //             dateTo = dateFrom
    //             e.target.value = inputFrom.value
    //         }

    //         this._fieldValues[1] = e.target.value
    //     })
    // }

    


    // callback = (value) => {  }
    onValueEnter = (callback) => {
        this._events.add({ type : DataFormField.eventTypes.ValueEnter, callback })
    }

    // callback = () => {  }
    onValueDiscard = (callback) => {
        this._events.add({ type : DataFormField.eventTypes.ValueDiscard, callback })
    }
}