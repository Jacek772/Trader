class Pageform extends HtmlComponent {
    _divPageformContainer
    _divPageformBody
    _divPageformFooter

    _onSave = (dataObject) => { }
    _onDiscard = () => { }

    constructor(fields){
        super()
        this._fields = fields
        this._init()
    }

    _init = () => {
        this._htmlMain = document.createElement("div")
        this._htmlMain.id = "pageform"

        this._divPageformContainer = document.createElement("div")
        this._htmlMain.appendChild(this._divPageformContainer)
        this._divPageformContainer.className = "pageform-container"

        this._createPageformBody()
        this._createPageformFooter()
    }

    _createPageformBody = () => {
        this._divPageformBody = document.createElement("div")
        this._divPageformContainer.appendChild(this._divPageformBody)
        this._divPageformBody.className = "pageform-body"

        for(let rowFieldsData of this._fields)
        {
            // Section caption
            if(rowFieldsData.section)
            {
                const h2Section = document.createElement("h2")
                this._divPageformBody.appendChild(h2Section)
                h2Section.className = "pageform-body-fields-row-sectioncaption"
                h2Section.innerText = rowFieldsData.caption
            }

            // Data fields
            const divPageformBodyFieldsRow = document.createElement("div")
            this._divPageformBody.appendChild(divPageformBodyFieldsRow)
            divPageformBodyFieldsRow.className = "pageform-body-fields-row"

            for(let dataField of rowFieldsData.dataFields)
            {
                dataField.setDataObject(this._dataObject)
                divPageformBodyFieldsRow.appendChild(dataField.getHtml())
            }
        }
    }

    _createPageformFooter = () => {
        this._divPageformFooter = document.createElement("h2")
        this._divPageformContainer.appendChild(this._divPageformFooter)
        this._divPageformFooter.className = "pageform-footer"

        const btnSave = document.createElement("button")
        this._divPageformFooter.appendChild(btnSave)
        btnSave.innerText = "Save"
        btnSave.className = "button button-secondary"
        btnSave.addEventListener("click", () => {
            this._onSave(this._dataObject)
        })

        const btnDiscard = document.createElement("button")
        this._divPageformFooter.appendChild(btnDiscard)
        btnDiscard.innerText = "Discard"
        btnDiscard.className = "button button-dark"
        btnDiscard.addEventListener("click", () => {
            this._onDiscard()
        })

    }

    setDataObject = (dataObject) => {
        this._dataObject = dataObject
        this._refreshBody()
    }

    _refreshBody() {
        this._divPageformContainer.innerHTML = ""
        this._createPageformBody()
        this._createPageformFooter()
    }

    setOnSave = (onSave) => {
        this._onSave = onSave
    }

    setOnDiscard = (onDiscard) => {
        this._onDiscard = onDiscard
    }
}