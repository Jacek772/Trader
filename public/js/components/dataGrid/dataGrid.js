
class DataGrid extends HtmlComponent {
    _dataGridHead
    _dataGridBody
    _headers
    _dataArray
    _headRow
    _dataRows = []

    _onClick = (row) => {}
    _onChecked = (row) => {}

    // headers = [ { text, width } ]
    // dataArray = [ { ... } ]
    constructor(headers, dataArray = [],
        onClick = (row) => {},
        onChecked = (row) => {})
    {
        super()
        this._headers = headers
        this._dataArray = this.prepareDataArray(dataArray)

        this._onClick = onClick
        this._onChecked = onChecked

        this.init()
    }

    prepareDataArray = (dataArray) => {
        let rowId = 1
        return dataArray.map(dataObject => {
            dataObject.rowId = rowId
            return dataObject
        })
    }

    init = () => {
        this._htmlMain = document.createElement("div")

        this._dataGridHead = document.createElement("div")
        this._htmlMain.appendChild(this._dataGridHead)
        this._dataGridHead.className = "data-grid-head"
        this._dataGridHead.addEventListener("scroll", (e) => {
            this._dataGridBody.scrollTo(e.target.scrollLeft, this._dataGridBody.scrollTop)
        })

        this._dataGridBody = document.createElement("div")
        this._htmlMain.appendChild(this._dataGridBody)
        this._dataGridBody.className = "data-grid-body"
        this._dataGridBody.addEventListener("scroll", (e) => {
            this._dataGridHead.scrollTo(e.target.scrollLeft, this._dataGridHead.scrollTop)
        })

        this.createDataGridHead()
        this.createDataGridBody()
    }

    createDataGridHead = () => {
        const tableHeader = document.createElement("table")
        tableHeader.className = "data-grid"
        this._dataGridHead.appendChild(tableHeader)

        // head
        const thead = document.createElement("thead")
        tableHeader.appendChild(thead)

        this._headRow = new HeadRow(this._headers,
            this.onCheckedHead,
            this.sortData
        )
        thead.appendChild(this._headRow.getHtml())
    }

    onCheckedHead = (checked) => {
        for(let dataRow of this._dataRows)
        {
            dataRow.setCheckedState(checked)
        }
    }

    createDataGridBody = () => {
        this._dataGridBody.innerHTML = ""

        const tableBody = document.createElement("table")
        tableBody.className = "data-grid"
        this._dataGridBody.appendChild(tableBody)

        // body
        const tbody = document.createElement("tbody")
        tableBody.appendChild(tbody)

        this._dataRows = []
        for(let dataObject of this._dataArray)
        {
            const dataRow = new DataRow(this._headers, 
                dataObject,
                this.onCheckedDataRow,
                this._onClick)
            dataRow._dataObject
            this._dataRows.push(dataRow)
            tbody.appendChild(dataRow.getHtml())
        }

    }
    
    onCheckedDataRow = (row) => {
        if(this._dataRows.every(x => x._checked))
        {
            this._headRow.setCheckedState(true, false)
        }
        else if(this._dataRows.some(x => !x._checked))
        {
            this._headRow.setCheckedState(false, false)
        }

        this._onChecked(row)
    }

    // direction = "asc", "desc"
    sortData = (direction, field) => {
        this._dataRows = this._dataRows.sort((a, b) => {
            if(a._dataObject[field] < b._dataObject[field])
            {
                return direction === "asc" ? 1 : -1
            }

            if(a._dataObject[field] > b._dataObject[field])
            {
                return direction === "asc" ? -1 : 1
            }
            return 0
        })
        this.refreshDataGridBody()
    }

    filterData = (filterCallback = (dataObject) => {}) => {
        this._dataRows = this._dataRows.map((dataRow) => {
            const visible = filterCallback(dataRow._dataObject)
            dataRow.setVisibility(visible)
            return dataRow
        })
    }

    resetDatafilter = () => {
        this._dataRows = this._dataRows.map((dataRow) => {
            dataRow.setVisibility(true)
            return dataRow
        })
    }

    refreshDataGridBody = () => {
        this._dataGridBody.innerHTML = ""

        const tableBody = document.createElement("table")
        tableBody.className = "data-grid"
        this._dataGridBody.appendChild(tableBody)

        // body
        const tbody = document.createElement("tbody")
        tableBody.appendChild(tbody)

        for(let dataRow of this._dataRows)
        {
            tbody.appendChild(dataRow.getHtml())
        }

        const tdLast = document.createElement("td")
        tbody.appendChild(tdLast)
    }

    getCheckedData = () => {
        return this._dataRows
            .filter(x => x._checked)
            .map(x => x._dataObject)
    }
}