class NumberTools {
    static isInt = (n) => {
        return this.isNumber(n) && n % 1 === 0;
    }

    static isFloat = (n) => {
        return this.isNumber(n) && n % 1 !== 0;
    }

    static isNumber = (n) => {
        return !isNaN(n)
    }
}