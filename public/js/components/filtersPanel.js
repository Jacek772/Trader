
class FiltersPanel extends HtmlComponent {
    _items = []
    _onChange = (filters) => { }

    constructor()
    {
        super()
        this._initFilterPanel()
    }

    addItem = (item) => {
        this._items.push(item)
        item.setOnChange(() => {
            this._onChange(this.getFilters())
        })
        this._refresh()
    }

    getFilters = () => {
        const filters = []
        for(let item of this._items)
        {
            const filter = item.getFilters()
            if(!filter)
            {
                continue
            }

            filters.push(item.getFilters())
        }
        return filters
    }

    setOnChange = (onChange) => {
        this._onChange = onChange
    }

    _initFilterPanel = () => {
        this._htmlMain = document.createElement("div")
        this._htmlMain.className = "filters-panel-container"
    }
 
    _refresh = () => {
        for(let item of this._items)
        {
            this._htmlMain.appendChild(item.getHtml())
        }
    }
}

class FilterPanelItem extends HtmlComponent {
    static types = {
        TEXT: "TEXT",
        SELECT: "SELECT",
        SELECT_WITH_EMPTY: "SELECT_WITH_EMPTY",
        DATE_PERIOD: "DATE_PERIOD",
    }

    _labelText
    _fieldNames
    _fieldValues = []
    _type
    _optionsData
    _onChange = (fieldValues) => {}

    // Niezbędne dla type.SELECT
    // options = { text, value }
    constructor(labelText, fieldNames, type = FilterPanelItem.types.TEXT, optionsData = [])
    {
        super()
        this._labelText = labelText
        this._fieldNames = fieldNames
        this._type = type
        this._optionsData = optionsData

        this._initFilterPanelItem()
    }

    
    getFilters = () => {
        switch(this._type)
        {
            case FilterPanelItem.types.SELECT:
            case FilterPanelItem.types.SELECT_WITH_EMPTY:
                return this._getFiltersSelect()
            case FilterPanelItem.types.DATE_PERIOD:
                return this._getFiltersDatePeriod()
            case FilterPanelItem.types.TEXT:
            default:
                return this._getFiltersText()
        }
    }

    _initFilterPanelItem = () => {
        // init container
        this._initInputContainer()

        // init label
        this._initLabel()

        // init input
        this._initInput()
    }

    _initInputContainer = () => {
        this._htmlMain = document.createElement("div")
        this._htmlMain.className = "filters-panel-item"
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
            case FilterPanelItem.types.SELECT:
                this._initInputSelect()
                break
            case FilterPanelItem.types.SELECT_WITH_EMPTY:
                this._initInputSelectWithEmpty()
                break
            case FilterPanelItem.types.DATE_PERIOD:
                this._initInputDatePeriod()
                break
            case FilterPanelItem.types.TEXT:
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
        input.addEventListener("input", (e) => {
            this._fieldValues = [ e.target.value ]
            this._onChange(this._fieldValues)
        })

        this._fieldValues = [null]
    }

    _initInputSelectWithEmpty = () => {
        this._initInputSelect(true)
    }

    _initInputSelect = (withEmpty = false) => {
        const select = document.createElement("select")
        this._htmlMain.appendChild(select)
        select.classList.add("input-text")
        select.classList.add("input-border")
        select.addEventListener("input", (e) => {
            if(NumberTools.isInt(e.target.value))
            {
                this._fieldValues = [ parseInt(e.target.value) ]
            }
            else if(NumberTools.isFloat(e.target.value))
            {
                this._fieldValues = [ parseFloat(e.target.value) ]
            }
            else
            {
                this._fieldValues = [ e.target.value ]
            }

            this._onChange(this._fieldValues)
        })

        if(withEmpty)
        {
            const option = document.createElement("option")
            select.appendChild(option)
            option.value = ""
            option.innerText = ""
        }

        for(let optionData of this._optionsData)
        {
            const option = document.createElement("option")
            select.appendChild(option)
            option.value = optionData.value
            option.innerText = optionData.text
        }

        if(withEmpty || !this._optionsData || this._optionsData.length == 0)
        {
            this._fieldValues = [null]
        }
        else
        {
            this._fieldValues = [this._optionsData[0].value]
        }
    }

    _initInputDatePeriod = () => {
        const inputFrom = document.createElement("input")
        this._htmlMain.appendChild(inputFrom)

        const inputTo = document.createElement("input")
        this._htmlMain.appendChild(inputTo)

        inputFrom.type = "date"
        inputFrom.classList.add("input-text")
        inputFrom.classList.add("input-border")
        inputFrom.addEventListener("input", (e) => {
            let dateFrom = null
            if(e.target.value)
            {
                dateFrom = new Date(e.target.value)
            }

            let dateTo = null
            if(inputTo.value)
            {
                dateTo = new Date(inputTo.value)
            }

            if(dateFrom && dateTo && dateFrom > dateTo)
            {
                dateFrom = dateTo
                e.target.value = inputTo.value
            }

            this._fieldValues[0] = dateFrom ? this._formatDate(dateFrom) : null
            this._onChange(this._fieldValues)
        })

        inputTo.type = "date"
        inputTo.classList.add("input-text")
        inputTo.classList.add("input-border")
        inputTo.addEventListener("input", (e) => {
            let dateFrom = null
            if(inputFrom.value)
            {
                dateFrom = new Date(inputFrom.value)
            }

            let dateTo = null
            if(e.target.value)
            {
                dateTo = new Date(e.target.value)
            }

            if(dateFrom && dateTo && dateTo < dateFrom)
            {
                dateTo = dateFrom
                e.target.value = inputFrom.value
            }

            this._fieldValues[1] = dateTo ? this._formatDate(dateTo) : null
            this._onChange(this._fieldValues)
        })

        this._fieldValues = [null, null]
    }

    _formatDate = (date) => {
        const dateTimeStringSplited = date.toLocaleString().split(", ")
        const dateString = dateTimeStringSplited[0]
        const splitedDateString = dateString.split(".")
        return `${splitedDateString[2]}-${splitedDateString[1]}-${splitedDateString[0]}`
    }

    _getFiltersText = () => {
        if(!this._fieldValues[0])
        {
            return null
        }

        return { 
            [this._fieldNames[0]]: this._fieldValues[0] 
        }
    }

    _getFiltersSelect = () => {
        if(!this._fieldValues[0])
        {
            return null
        }

        return { 
            [this._fieldNames[0]]: this._fieldValues[0] 
        }
    }

    _getFiltersDatePeriod = () => {
        if(!this._fieldValues[0] && !this._fieldValues[1])
        {
            return null
        }

        const filters = {}
        if(this._fieldValues[0])
        {
            filters[this._fieldNames[0]] = this._fieldValues[0]
        }

        if(this._fieldValues[1])
        {
            filters[this._fieldNames[1]] = this._fieldValues[1]
        }
        return filters
    }

    setOnChange(onChange) {
        this._onChange = onChange
    }
}