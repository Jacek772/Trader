class DataFormField extends HtmlComponent {
    static types = {
        TEXT: "TEXT",
        NUMBER: "NUMBER",
        SECURETEXT: "SECURETEXT",
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
            case DataFormField.types.SECURETEXT:
                this._initInputText(true)
                break
            case DataFormField.types.NUMBER:
                this._initInputNumber()
                break
            case DataFormField.types.TEXT:
            default:
                this._initInputText()
                break
        }
    }

    _initInputText = (secure = false) => {
        this._input = document.createElement("input")
        this._htmlMain.appendChild(this._input)

        if(secure)
        {
            this._input.type = "password"
        }
        else
        {
            this._input.type = "text"
        }
        this._input.classList.add("input-text")
        this._input.classList.add("input-border")
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

    _initInputNumber = () => {
        this._input = document.createElement("input")
        this._htmlMain.appendChild(this._input)
        this._input.type = "number"
        this._input.classList.add("input-text")
        this._input.classList.add("input-border")
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

    // callback = (value) => {  }
    onValueEnter = (callback) => {
        this._events.add({ type : DataFormField.eventTypes.ValueEnter, callback })
    }

    // callback = () => {  }
    onValueDiscard = (callback) => {
        this._events.add({ type : DataFormField.eventTypes.ValueDiscard, callback })
    }
}