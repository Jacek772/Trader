class Row extends HtmlComponent {
    constructor()
    {
        super()
        this.initRow()
    }

    initRow = () => {
        this._htmlMain = document.createElement("tr")
    }
}

class HeadRow extends Row {
    _headers
    _checked
    _onChecked
    _onSort

    constructor(headers, 
        onChecked = (checked) => {},
        onSort = (direction, field) => {})
    {
        super()
        this._headers = headers
        this._onChecked = onChecked
        this._onSort = onSort
        this.initHeadRow()
    }

    initHeadRow = () => {
        // Checkbox column
        const thCheckbox = document.createElement("th")
        this._htmlMain.appendChild(thCheckbox)

        this._inputCheckbox = document.createElement("input")
        thCheckbox.appendChild(this._inputCheckbox)
        this._inputCheckbox.type = "checkbox"
        this._inputCheckbox.addEventListener("input", (e) => {
            this.setCheckedState(e.target.checked)
        })

        // Head columns
        for(let header of this._headers)
        {
            const th = document.createElement("th")
            this._htmlMain.appendChild(th)
            if(header.width)
            {
                th.style.width = header.width
            }

            const divDataGridHeadItem = document.createElement("div")
            th.appendChild(divDataGridHeadItem)

            divDataGridHeadItem.className = "data-grid-head-item"

            const p = document.createElement("p")
            divDataGridHeadItem.appendChild(p)
            p.innerText = header.text

            const imgIconSettingsArrowUp = document.createElement("img")
            divDataGridHeadItem.appendChild(imgIconSettingsArrowUp)

            imgIconSettingsArrowUp.src="./img/svg/arrow-down-black.svg"
            imgIconSettingsArrowUp.classList.add("icon-small")
            imgIconSettingsArrowUp.classList.add("icon-clicable")
            imgIconSettingsArrowUp.classList.add("rotate-180")
            imgIconSettingsArrowUp.style.display = "none"
            imgIconSettingsArrowUp.addEventListener("click", () => {
                imgIconSettingsArrowDown.style.display = ""
                imgIconSettingsArrowUp.style.display = "none"

                this._onSort("asc", header.fieldName)
            })

            const imgIconSettingsArrowDown = document.createElement("img")
            divDataGridHeadItem.appendChild(imgIconSettingsArrowDown)

            imgIconSettingsArrowDown.src="./img/svg/arrow-down-black.svg"
            imgIconSettingsArrowDown.classList.add("icon-small")
            imgIconSettingsArrowDown.classList.add("icon-clicable")
            imgIconSettingsArrowDown.addEventListener("click", () => {
                imgIconSettingsArrowDown.style.display = "none"
                imgIconSettingsArrowUp.style.display = ""

                this._onSort("desc", header.fieldName)
            })
        }
    }

    setCheckedState = (checked, invokeEvent = true) => {
        this._checked = checked
        this._inputCheckbox.checked = checked

        if(invokeEvent)
        {
            this._onChecked(checked)
        }
    }
}

class DataRow extends Row {
    _headers
    _dataObject
    _inputCheckbox
    _checked
    _width
    _visible = true

    _onChecked
    _onClick

    constructor(headers, dataObject,
        onChecked = (checked) => {},
        onClick = (data) => {})
    {
        super()
        this._headers = headers
        this._dataObject = dataObject
        this._onChecked = onChecked
        this._onClick = onClick
        this.initDataRow()
    }

    initDataRow = () => {
        // Checkbox column
        const tdCheckbox = document.createElement("td")
        this._htmlMain.appendChild(tdCheckbox)
        // tdCheckbox.style.width = "50px";

        this._htmlMain.addEventListener("click", () => {
            this._onClick(this)
        })

        this._inputCheckbox = document.createElement("input")
        tdCheckbox.appendChild(this._inputCheckbox)
        this._inputCheckbox.type = "checkbox"

        this._inputCheckbox.addEventListener("input", (e) => {
            this.setCheckedState(e.target.checked)
        })

        // Data columns
        let index = 0
        for(let key of Object.keys(this._dataObject))
        {
            if(key === "rowId")
            {
                continue
            }

            const td = document.createElement("td")
            this._htmlMain.appendChild(td)

            const header = this._headers[index]
            if(header && header.width)
            {
                td.style.width = header.width
            }
            td.innerText = this._dataObject[key]
            index++
        }
    }

    setVisibility = (visible) => {
        this._visible = visible
        this._htmlMain.style.display = visible ? "" : "none"
    }

    setCheckedState = (checked) => {
        this._checked = checked
        this._inputCheckbox.checked = checked
        this._onChecked(this)
    }

    getHtml = () =>
    {
        return this._htmlMain
    }
}