const URL_BACKEND = 'https://bsspo.store/http';

const days = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];
const color_classes = ['green_back', 'blue_back', 'orange_back', 'red_back', 'brown_back', 'pink_back', 'blur_back', 'yellow_back'];
const monthes = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
const btns_name = ['Отмена', 'Сохранить', 'Удалить'];
const dates = {
    firstDate: new Date(),
    lastDate: null
}
const keyData = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
const avability = {
    AVAILIBLE_LINES: 4,
    AVAILIBLE_PEOPLE: 0
}
const highterItems = {}
let header_link = '/login';
const email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

checkPage()

function checkPage() {
    if (localStorage.getItem('auth')) {
        header_link = '/profile'
    } else header_link = '/login'
}

async function checkSessionFunc(authData) {
    if (!authData) {
        header_link = '/login';
        return;
    }

    header_link = '/profile';

    const authObj = JSON.parse(authData);
    const login = authObj.login;
    const session = authObj.session;

    return await fetch(`${URL_BACKEND}/authorization?type=session`, {
        method: 'POST',
        body: JSON.stringify({login, session})
    })
    .then(res => {
        if (res.status >= 200 && res.status < 300) {
            return;
        } 
        
        throw false;
    })
    .catch(res => {
        localStorage.clear('auth')
    })
}

async function getEventsHeader(year, updateState) {
    if (header_link === '/login') return;
    const log = localStorage.getItem('auth');
    const session = JSON.parse(log).session;

    await fetch(`${URL_BACKEND}/note`, {
        method: "GET",
        headers: {
            'Token': session
        }
    })
    .then(res => {
        if (res.status >= 200 && res.status < 300) {
            return res.json();
        } 

        throw res.json();
    }).then(res => {
        updateState(res)
    })
}

async function getEvents(year, updateState) {
    if (header_link === '/login') return;
    const log = localStorage.getItem('auth');
    const session = JSON.parse(log).session;

    await fetch(`${URL_BACKEND}/event/limit=year=${year}`, {
        method: "GET",
        headers: {
            'Token': session
        }
    })
    .then(res => {
        if (res.status >= 200 && res.status < 300) {
            return res.json();
        } 

        throw res.json();
    }).then(res => {
        console.log(res)
        updateState(res)
    })
}

async function isSectionAlive(auth) {

    const authObj = JSON.parse(auth);
    const session = authObj.session;

    return await fetch(`${URL_BACKEND}/session`, {
        header: {
            'Token': session
        }
    }).then(res => res.json()).then(res => {
        return res;
    })
}

function clearEvent() {
    eventSend = {}
}

let eventSend = {
    title: '',
    description: '',
    phone: '',
    color: '',
    day: null,
    month: null,
    year: null,
    time: ''
}

export { 
        days, color_classes, 
        monthes, 
        dates, 
        avability, 
        keyData, 
        highterItems, 
        btns_name, 
        checkSessionFunc, 
        header_link, 
        URL_BACKEND, 
        email_pattern, 
        checkPage, 
        isSectionAlive,
        eventSend,
        getEvents,
        getEventsHeader,
        clearEvent
    }
