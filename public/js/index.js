document.addEventListener("DOMContentLoaded", () => {
    // const dataGrid = new DataGrid()

})

class DataGrid {
    _htmlMain
    _headers
    _dataArray

    // headers = [ { text } ]
    constructor(headers, dataArray)
    {
        this._headers = headers
        this._dataArray = dataArray
        this.init()
    }

    init() {
        this._htmlMain = document.createElement("div")
        this._htmlMain.className = "data-grid-container"

        this.createDataGridHead()
        this.createDataGridBody()
    }

    createDataGridHead() {
        const dataGridHead = document.createElement("div")
        dataGridHead.className = "data-grid-head"
        this._htmlMain.appendChild(dataGridHead)

        const table = document.createElement("table")
        dataGridHead.appendChild(table)

        const thead = document.createElement("thead")
        table.appendChild(thead)

        // header
        const headRow = new HeadRow(this._headers)
        thead.appendChild(headRow.getHtml())

        // data

    }

    createDataGridBody() {
        const dataGridBody = document.createElement("div")
        dataGridBody.className = "data-grid-body"
    }

    getHtml()
    {
        return this._htmlMain
    }
}


class Row {
    constructor()
    {
        this.initRow()
    }

    initRow() {
        this._htmlMain = document.createElement("tr")
    }

    getHtml()
    {
        return this._htmlMain
    }
}

class HeadRow extends Row {
    _headers

    constructor(headers)
    {
        this._headers = headers
        super()
        this.initHeadRow()
    }

    initHeadRow() {
        // Checkbox column
        const thCheckbox = document.createElement("td")
        this._htmlMain.appendChild(thCheckbox)

        const inputCheckbox = document.createElement("input")
        inputCheckbox.type = "checkbox"
        thCheckbox.appendChild(inputCheckbox)

        // Head columns
        for(let header in this._headers)
        {

        }
    }
}

class DataRow extends Row {
    _dataObject

    constructor(dataObject)
    {
        this._dataObject = dataObject
        super()
        this.initDataRow()
    }

    initDataRow() {
        // Checkbox column
        const tdCheckbox = document.createElement("td")
        this._htmlMain.appendChild(tdCheckbox)

        const inputCheckbox = document.createElement("input")
        inputCheckbox.type = "checkbox"
        tdCheckbox.appendChild(inputCheckbox)
        
        // Data columns
        for(let key of Object.keys(this._dataObject))
        {
            const td = document.createElement("td")
            this._htmlMain.appendChild(td)
            td.innerText = this._dataObject[key]
        }
    }

    getHtml()
    {
        return this._htmlMain
    }
}