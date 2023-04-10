
class FiltersPanel extends HtmlComponent {
    _items = []

    constructor()
    {
        super()
        this._initFilterPanel()
    }

    addItem = (item) => {
        this._items.push(item)
        this._refresh()
    }

    getFilters = () => {
        const filters = []
        for(let item of this._items)
        {
            filters.push(item.getFilters())
        }
        return filters
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
        DATE_PERIOD: "DATE_PERIOD",
    }

    _labelText
    _fieldNames
    _fieldValues = []
    _type
    _optionsData

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
        this._htmlMain = document.createElement("div")
        this._htmlMain.className = "filters-panel-item"

        // init label
        const label = document.createElement("label")
        this._htmlMain.appendChild(label)
        label.className = "input-text-label"
        label.innerText = this._labelText

        // init input
        this._initInput()

    }

    _initInput = () => {
        switch(this._type)
        {
            case FilterPanelItem.types.SELECT:
                this._initInputSelect()
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
        })

        this._fieldValues = [null]
    }

    _initInputSelect = () => {
        const select = document.createElement("select")
        this._htmlMain.appendChild(select)
        select.classList.add("input-text")
        select.classList.add("input-border")
        select.addEventListener("input", (e) => {
            if(!NumberTools.isNumber(e.target.value))
            {
                this._fieldValues = [ e.target.value ]
                return
            }

            if(NumberTools.isInt(e.target.value))
            {
                this._fieldValues = [ parseInt(e.target.value) ]
                return
            }

            if(NumberTools.isFloat(e.target.value))
            {
                this._fieldValues = [ parseFloat(e.target.value) ]
                return
            }
        })

        for(let optionData of this._optionsData)
        {
            const option = document.createElement("option")
            select.appendChild(option)
            option.value = optionData.value
            option.innerText = optionData.text
        }

        if(this._optionsData.length > 0)
        {
            this._fieldValues = [this._optionsData[0].value]
        }
        else
        {
            this._fieldValues = [null]
        }
    }

    _initInputDatePeriod = () => {
        const inputFrom = document.createElement("input")
        this._htmlMain.appendChild(inputFrom)
        inputFrom.type = "date"
        inputFrom.classList.add("input-text")
        inputFrom.classList.add("input-border")
        inputFrom.addEventListener("input", (e) => {
            this._fieldValues[0] = e.target.value
        })

        const inputTo = document.createElement("input")
        this._htmlMain.appendChild(inputTo)
        inputTo.type = "date"
        inputTo.classList.add("input-text")
        inputTo.classList.add("input-border")
        inputTo.addEventListener("input", (e) => {
            this._fieldValues[1] = e.target.value
        })

        this._fieldValues = [null, null]
    }

    _getFiltersText = () => {
        return { 
            [this._fieldNames[0]]: this._fieldValues[0] 
        }
    }

    _getFiltersSelect = () => {
        return { 
            [this._fieldNames[0]]: this._fieldValues[0] 
        }
    }

    _getFiltersDatePeriod = () => {
        return { 
            [this._fieldNames[0]]: this._fieldValues[0],
            [this._fieldNames[1]]: this._fieldValues[1]
        }
    }
}