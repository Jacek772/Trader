class ApiDocumentsdefinitions extends Api
{
    static baseRoute = "documentsdefinitions"

    static async getAllDocumentsdefinitions()
    {
        return await this.get(`${this.baseUrl}/${this.baseRoute}`)
    }
}