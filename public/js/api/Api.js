class Api{
    static baseUrl = "http://localhost:8080/api"

    static async get(url, query = {}, headers = {}) {
        if (query && JSON.stringify(query) !== "{}") {
            url += `?${new URLSearchParams(query).toString()}`
        }

        if (!headers) {
            headers = {}
        }

        let res
        try {
            res = await fetch(url, {
                method: "GET",
                headers: { ...headers },
            })
        }
        catch (error) {
            throw new Error(`ERROR: fetch GET\n${url}`)
        }

        if (!res.ok)
            return {
                ok: res.ok,
                status: res.status,
                message: `Error: ${res.status}`
            }

        let data
        try {
            data = await res.json()
        } catch {
            data = {}
        }

        return {
            ok: res.ok,
            status: res.status,
            message: res.status,
            data
        }
    }

    static async post(url, body = {}, headers = {}) {
        if (!headers) {
            headers = {}
        }

        const formData = new FormData()
        if(body)
        {
            for(let key in body)
            {
                formData.append(key, body[key])
            }
        }

        let res
        try {
            res = await fetch(url, {
                headers: { ...headers },
                method: "POST",
                body: formData
                // body: json ? JSON.stringify(body) : body
            })
        }
        catch (error) {
            throw new Error(`ERROR: fetch POST\n${url}`)
        }

        let data
        try {
            data = await res.json()
        }
        catch {
            data = {}
        }

        if (!res.ok)
        {
            return {
                ok: res.ok,
                status: res.status,
                message: `Error: ${res.status}`,
                data
            }
        }

        return {
            ok: res.ok,
            status: res.status,
            message: res.status,
            data
        }
    }

    static async put(url, body = {}, headers = {}) {
        if (!headers) {
            headers = {}
        }

        const formData = new FormData()
        if(body)
        {
            for(let key in body)
            {
                formData.append(key, body[key])
            }
        }

        let res
        try {
            res = await fetch(url, {
                headers: { ...headers },
                method: "PUT",
                body: formData
            })
        }
        catch (error) {
            throw new Error(`ERROR: fetch PUT\n${url}`)
        }

        let data
        try {
            data = await res.json()
        }
        catch {
            data = {}
        }

        if (!res.ok)
        {
            return {
                ok: res.ok,
                status: res.status,
                message: `Error: ${res.status}`,
                data
            }
        }

        return {
            ok: res.ok,
            status: res.status,
            message: res.status,
            data
        }
    }

    static async delete(url, body = {}, headers = {}) {
        if (!headers) {
            headers = {}
        }

        const formData = new FormData()
        if(body)
        {
            for(let key in body)
            {
                formData.append(key, body[key])
            }
        }

        let res
        try {
            res = await fetch(url, {
                headers: { ...headers },
                method: "DELETE",
                body: formData
            })
        }
        catch (error) {
            throw new Error(`ERROR: fetch DELETE\n${url}`)
        }

        let data
        try {
            data = await res.json()
        }
        catch {
            data = {}
        }

        if (!res.ok)
        {
            return {
                ok: res.ok,
                status: res.status,
                message: `Error: ${res.status}`,
                data
            }
        }

        return {
            ok: res.ok,
            status: res.status,
            message: res.status,
            data
        }
    }
}