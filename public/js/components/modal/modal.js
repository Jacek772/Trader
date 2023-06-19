class Modal extends HtmlComponent {
    static modalTypes = {
        DANGER: "DANGER",
        WARNING: "WARNING",
        SUCCESS: "SUCCESS",
        INFO: "INFO"
    }

    static modalButtonsType = {
        EMPTY: "EMPTY",
        OK: "OK",
        YESNO: "YESNO"
    }

    static modalColors = {
        DANGER: "#d9534f",
        WARNING: "#f0ad4e",
        SUCCESS: "#5cb85c",
        INFO: "#5bc0de",
        DEFAULT: "#0275d8"
    }

    static modalBorderColors = {
        DANGER: "#cc0000",
        WARNING: "#ff8800",
        SUCCESS: "#007e33",
        INFO: "#0099CC",
        DEFAULT: "#0099CC"
    }

    _type
    _buttonsType
    _title
    _text
    _blockClosing
    _divModalContainer
    _h1ModalHeadTitle
    _pModalBodyText
    _divModalBodyButtonscontainer

    _onAction = () => { }
    _onClose = () => { }

    constructor() {
        super();
        this._init()
    }

    _init = () => {
        this._htmlMain = document.createElement("div")
        this._htmlMain.id = "modal"
        this._htmlMain.style.display = "none"

        const divOverlay = document.createElement("div")
        this._htmlMain.appendChild(divOverlay)
        divOverlay.className = "overlay"

        this._divModalContainer = document.createElement("div")
        divOverlay.appendChild(this._divModalContainer)
        this._divModalContainer.className = "modal-container"
        this._divModalContainer.style.backgroundColor = this._getBackgroundColor()
        this._divModalContainer.style.borderColor =this._getBorderColor()

        const imgIconCloseModal = document.createElement("img")
        this._divModalContainer.appendChild(imgIconCloseModal)
        imgIconCloseModal.id = "iconCloseModal"
        imgIconCloseModal.classList.add("icon-small")
        imgIconCloseModal.classList.add("icon-clicable")
        imgIconCloseModal.src = "/public/img/svg/close.svg"

        imgIconCloseModal.addEventListener("click", this._handleClickX)

        const divModalHead = document.createElement("div")
        this._divModalContainer.appendChild(divModalHead)
        divModalHead.className = "modal-head"

        this._h1ModalHeadTitle = document.createElement("h1")
        divModalHead.appendChild(this._h1ModalHeadTitle)
        this._h1ModalHeadTitle.className = "modal-head-title"
        this._h1ModalHeadTitle.innerText = this._title

        const divModalBody = document.createElement("div")
        this._divModalContainer.appendChild(divModalBody)
        divModalBody.className = "modal-body"

        this._pModalBodyText = document.createElement("p")
        divModalBody.appendChild(this._pModalBodyText)
        this._pModalBodyText.innerText = this._text

        divModalBody.appendChild(this._getButtons())
    }

    _getBackgroundColor = () => {
        switch (this._type) {
            case Modal.modalTypes.DANGER:
                return Modal.modalColors.DANGER
            case Modal.modalTypes.WARNING:
                return Modal.modalColors.WARNING
            case Modal.modalTypes.SUCCESS:
                return Modal.modalColors.SUCCESS
            case Modal.modalTypes.INFO:
            default:
                return Modal.modalColors.INFO
        }
    }

    _getBorderColor = () => {
        switch (this._type) {
            case Modal.modalTypes.DANGER:
                return Modal.modalBorderColors.DANGER
            case Modal.modalTypes.WARNING:
                return Modal.modalBorderColors.WARNING
            case Modal.modalTypes.SUCCESS:
                return Modal.modalBorderColors.SUCCESS
            case Modal.modalTypes.INFO:
            default:
                return Modal.modalBorderColors.INFO
        }
    }

    _getButtons = () => {
        this._divModalBodyButtonscontainer = document.createElement("div")
        this._divModalBodyButtonscontainer.className = "modal-body-buttonscontainer"

        switch (this._buttonsType)
        {
            case Modal.modalButtonsType.OK:
                const buttonOk = document.createElement("button")
                this._divModalBodyButtonscontainer.appendChild(buttonOk)
                buttonOk.classList.add("button")
                buttonOk.classList.add("button-dark")
                buttonOk.innerText = "Ok"
                buttonOk.addEventListener("click", this._handleClickOk)
                break
            case Modal.modalButtonsType.YESNO:
                const buttonYes = document.createElement("button")
                this._divModalBodyButtonscontainer.appendChild(buttonYes)
                buttonYes.classList.add("button")
                buttonYes.classList.add("button-dark")
                buttonYes.innerText = "Yes"
                buttonYes.addEventListener("click", this._handleClickYes)

                const buttonNo = document.createElement("button")
                this._divModalBodyButtonscontainer.appendChild(buttonNo)
                buttonNo.classList.add("button")
                buttonNo.classList.add("button-dark")
                buttonNo.innerText = "No"
                buttonNo.addEventListener("click", this._handleClickNo)
                break
            case Modal.modalButtonsType.EMPTY:
            default:
                break
        }

        return this._divModalBodyButtonscontainer
    }

    _handleClickX = (e) => {
        this.close()
    }

    _handleClickOk = (e) => {
        this.close()
    }

    _handleClickYes = (e) => {
        if(this._onAction)
        {
            this._onAction(Modal.modalButtonsType.YESNO, { result: true })
        }
        this.close()
    }

    _handleClickNo = (e) => {
        if(this._onAction)
        {
            this._onAction(Modal.modalButtonsType.YESNO, { result: false })
        }
        this.close()
    }

    show = () => {
        this._htmlMain.style.display = ""
    }

    close = () => {
        this._htmlMain.style.display = "none"
    }

    setTitle = (title) => {
        this._title = title
        this._h1ModalHeadTitle.innerText = this._title
    }

    setText = (text) => {
        this._text = text
        this._pModalBodyText.innerText = this._text
    }

    setModalType = (type) => {
        this._type = type
        this._divModalContainer.style.backgroundColor = this._getBackgroundColor()
        this._divModalContainer.style.borderColor = this._getBorderColor()
    }

    setModalButtonsType = (buttonsType) => {
        this._buttonsType = buttonsType
        this._divModalBodyButtonscontainer.innerHTML = ""
        this._divModalBodyButtonscontainer.appendChild(this._getButtons())
    }
    setBlockClosing = (blockClosing) => {
        this._blockClosing = blockClosing
    }

    setOnAction = (onAction) => {
        this._onAction = onAction
    }

    setOnClose = (onClose) => {
        this._onClose = onClose
    }

    reset = () => {
        this._title = ""
        this._text = ""
        this._onAction = () => {}
        this._onClose = () => {}
    }
}