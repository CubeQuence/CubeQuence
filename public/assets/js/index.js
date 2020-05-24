document.addEventListener('DOMContentLoaded', function(){
    M.Sidenav.init(document.querySelectorAll('.sidenav'), {edge:"right"});
    M.Modal.init(document.querySelectorAll('.modal'), {});
});

const delay = ms => new Promise(res => setTimeout(res, ms));
const inputsDisabled = state => document.querySelectorAll('button, input, textarea').forEach(el => {el.disabled = state;});
const reload = () => window.location.reload();
const redirect = to => window.location.assign(to);

const api = axios.create({
    baseURL: '/',
    headers: {
        'Content-Type': 'application/json'
    },
    validateStatus: () => {
        return true;
    },
});

const formDataToJSON = data => {
    const object = {};
    [...data].map((item) => object[item[0]] = item[1]);
    return object;
}

const apiUse = (method, endpoint, data) => {
    inputsDisabled(true);

    api[method](endpoint, data).then(async response => {
        M.toast({html: response.data.message, displayLength: 8000});
        inputsDisabled(false);

        if (response.data.data.redirect) {
            await delay(750);
            redirect(response.data.data.redirect);
        }

        if (response.data.data.reload) {
            await delay(750);
            reload();
        }
    });
}
