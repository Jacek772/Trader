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
    _blockClosing = false
    _divModalContainer
    _divModalBody
    _h1ModalHeadTitle
    _pModalBodyText
    _divModalBodyButtonscontainer
    _imgIconCloseModal

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
        this._divModalContainer.style.borderColor = this._getBorderColor()

        this._imgIconCloseModal = document.createElement("img")
        this._divModalContainer.appendChild(this._imgIconCloseModal)
        this._imgIconCloseModal.id = "iconCloseModal"
        this._imgIconCloseModal.classList.add("icon-small")
        this._imgIconCloseModal.classList.add("icon-clicable")
        this._imgIconCloseModal.src = "/public/img/svg/close.svg"

        this._imgIconCloseModal.addEventListener("click", this._handleClickX)

        const divModalHead = document.createElement("div")
        this._divModalContainer.appendChild(divModalHead)
        divModalHead.className = "modal-head"

        this._h1ModalHeadTitle = document.createElement("h1")
        divModalHead.appendChild(this._h1ModalHeadTitle)
        this._h1ModalHeadTitle.className = "modal-head-title"
        this._h1ModalHeadTitle.innerText = this._title

        this._divModalBody = document.createElement("div")
        this._divModalContainer.appendChild(this._divModalBody)
        this._divModalBody.className = "modal-body"

        this._pModalBodyText = document.createElement("p")
        this._divModalBody.appendChild(this._pModalBodyText)
        this._pModalBodyText.innerText = this._text

        this._divModalBodyButtonscontainer = document.createElement("div")
        this._divModalBody.appendChild(this._divModalBodyButtonscontainer)
        this._divModalBodyButtonscontainer.className = "modal-body-buttonscontainer"

        this._initButtons()
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

    _initButtons = () => {
        this._divModalBodyButtonscontainer.innerHTML = ""

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
        if (this._blockClosing)
        {
            return
        }
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

    clear = () => {
        this._onAction = () => { }
        this._onClose = () => { }

        this._text = ""
        this._title = ""
        this._blockClosing = false
        this._type = Modal.modalTypes.INFO
        this._buttonsType = Modal.modalButtonsType.EMPTY
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
        this._initButtons()
    }
    setBlockClosing = (blockClosing) => {
        if(blockClosing)
        {
            this._imgIconCloseModal.style.display = "none"
        }
        else
        {
            this._imgIconCloseModal.style.display = ""
        }
        this._blockClosing = blockClosing
    }

    setOnAction = (onAction) => {
        this._onAction = onAction
    }

    setOnClose = (onClose) => {
        this._onClose = onClose
    }
}