class DataForm extends HtmlComponent  {
    _dataObject

    constructor(dataObject){
        super()
        this._dataObject = dataObject
        this._init()
    }

    _init = () => {
        this._htmlMain = document.createElement("div")
        this._htmlMain.className = "editform-container"

        this._createDataFormHead()
        this._createDataFormBody()
        this._createDataFormFooter()
    }

    _createDataFormHead = () => {
        const editformHead = document.createElement("div")
        this._htmlMain.appendChild(editformHead)
        editformHead.className = "editform-head"

        const imgIconClose = document.createElement("img")
        editformHead.appendChild(imgIconClose)
        imgIconClose.classList.add("icon")
        imgIconClose.classList.add("icon-clicable")
        imgIconClose.alt = "iconClose"

        imgIconClose.addEventListener("click", () => {
            // Click X
        })

       const btnSave = document.createElement("button")
       editformHead.appendChild(btnSave)
       btnSave.classList.add("button")
       btnSave.classList.add("button-secondary")
       btnSave.innerText = "Save"

       btnSave.addEventListener("click", () => {
            // Click X
       })

       const h2Title = document.createElement("h2")
       editformHead.appendChild(h2Title)
       h2Title.innerText = "FS/000001/05/2023"
    }

    _createDataFormBody = () => {
        const editformBody = document.createElement("div")
        this._htmlMain.appendChild(editformBody)
        editformBody.className = "editform-body"

        const editformBodyFieldsContainer = document.createElement("div")
        editformBody.appendChild(editformBodyFieldsContainer)
        editformBodyFieldsContainer.className = "editform-body-fields-container"


        // First row
        const fieldsRowFirst = document.createElement("div")
        editformBodyFieldsContainer.appendChild(fieldsRowFirst)

        // const dataFormFieldState = new DataFormField("State", )
    }

    _createDataFormFooter = () => {

    }
}

// TODO: Zrobić uniwersalną klasę do tego typu pól, ponieważ jest wykorzystywanen w panelu filtrowania
// i innych polach
class DataFormField extends HtmlComponent {
    static types = {
        TEXT: "TEXT",
        SELECT: "SELECT",
        DATE: "DATE",
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
    _type
    _optionsData

    // Niezbędne dla type.SELECT
    // options = { text, value }
    constructor(labelText, dataKey, dataObject, type = FilterPanelItem.types.TEXT, optionsData = [])
    {
        super()
        this._labelText = labelText
        this._dataKey = dataKey
        this._dataObject = dataObject
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
        const input = document.createElement("input")
        this._htmlMain.appendChild(input)
        input.type = "text"
        input.classList.add("input-text")
        input.classList.add("input-border")
        input.value = this._dataObject[this._dataKey]

        input.addEventListener("keydown", (e) => {
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

        input.addEventListener("blur", (e) => {
            // Zapis zmian
            this._events
                .filter(x => x.type == DataFormField.eventTypes.ValueEnter)
                .forEach(x => x.callback(e.target.value))

            this._dataObject[this._dataKey] = e.target.value
        })
    }

    _initInputSelect = () => {
        const select = document.createElement("select")
        this._htmlMain.appendChild(select)
        select.classList.add("input-text")
        select.classList.add("input-border")
        // select.value = 

        select.addEventListener("input", (e) => {
            // Zapis zmian
            this._events
                .filter(x => x.type == DataFormField.eventTypes.ValueEnter)
                .forEach(x => x.callback(e.target.value))
            this._dataObject[this._dataKey] = e.target.value
        })

        for(let optionData of this._optionsData)
        {
            const option = document.createElement("option")
            select.appendChild(option)
            option.value = optionData.value
            option.innerText = optionData.text
        }
    }

    _initInputDate = () => {
        const input = document.createElement("input")
        this._htmlMain.appendChild(input)
        input.type = "date"
        input.classList.add("input-text")
        input.classList.add("input-border")
        input.value = this._dataObject[this._dataKey]

        input.addEventListener("keydown", (e) => {
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

        input.addEventListener("blur", (e) => {
            // Zapis zmian
            this._events
                .filter(x => x.type == DataFormField.eventTypes.ValueEnter)
                .forEach(x => x.callback(e.target.value))

            this._dataObject[this._dataKey] = e.target.value
        })
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