const highterMenu_name = document.querySelector('.day_name');
const highterMenu_state = document.querySelector('.high_menu-state');
const lowerMenu_state = document.querySelector('.low_menu-state');
const arrowRight = document.querySelector('.arrow_right');
const arrowLeft = document.querySelector('.arrow_left');
const modal_win = document.querySelector('.modal_window');
const time_block = document.querySelector('.time-block');
const today_btn = document.querySelector('.menu_today');
const search_day = document.querySelector('.menu_searching-btn');
const overlay = document.querySelector('.overlay');
const mini_calendar = document.querySelector('.modal_calendar');
const main = document.querySelector('main');
const days = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];
const color_classes = ['green_back', 'blue_back', 'orange_back', 'red_back', 'brown_back', 'pink_back', 'blur_back', 'yellow_back'];
const monthes = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
const date = new Date();
let lastDate = null;
let firstDate = null;
const time_array = [];
const cur_month = monthes[date.getMonth()];
const cur_year = date.getFullYear();
const cur_day = days[date.getDay()];
const cur_date = date.getDate();
let page = 0;
let page_obj = {};
let exe_text_obj = {};

function defaultStart() { // Отрисовка всех блоков
    setTimeArray();
    setHeader();
    createHighterMenu();
    createHighterState();
    createLowerState();
}

search_day.addEventListener('click', () => {
    drawMiniCalendar();
})

today_btn.addEventListener('click', () => {
    defaultStart();
    page = 0;
    changePage();
})

highterMenu_state.addEventListener('click', (e) => {
    const target = e.target;
    if (target.className.split('').indexOf('-') === -1) return;
    drawModalWindow(target);
});

lowerMenu_state.addEventListener('click', (e) => {
    const target = e.target;
    if (target.className.indexOf('low_menu-state-item') === -1) return;
    drawModalWindow(target);
});

function drawMiniCalendar() {
    overlay.classList.add('left_margin');
    mini_calendar.classList.add('top_margin');

    const item_number = document.querySelectorAll('.item_number')[0];
    const date = new Date(
        JSON.parse(item_number.getAttribute('date'))
    );

    setMiniCalendar(date);
}

function setMiniCalendar(date) {
    mini_calendar.innerHTML = '';
    const month = monthes[date.getMonth()];
    const year = date.getFullYear();
    const day = date.getDate();
    const cur_date = +document.querySelector('.menu_number').innerHTML;

    const name_div = document.createElement('div');
    name_div.classList.add('miniC_name');
    name_div.innerHTML = `${month} - ${year}`;

    const data_div = document.createElement('div');
    data_div.classList.add('miniC_data');

    const mini_main = document.createElement('div');
    mini_main.classList.add('miniC-main');

    const span = document.createElement('span');
    span.classList.add('close');

    span.addEventListener('click', () => {
        overlay.classList.remove('left_margin');
        mini_calendar.classList.remove('top_margin');
    });

    mini_main.appendChild(name_div);
    mini_main.appendChild(span);

    const month_arr = generateMonth(date, day);

    month_arr.forEach((el, i) => {
        const div = document.createElement('div');
        div.classList.add('miniC-item');

        if (days.includes(el)) div.classList.add('miniC-day_name');

        if (cur_date === el) div.classList.add('current_date');

        el = String(el);

        if (el.indexOf('prev') !== -1) {
            el = el.split('-')[0];
            div.classList.add('previous-month');
        } else if (el.indexOf('next') !== -1) {
            el = el.split('-')[0];
            div.classList.add('next-month');
        }

        div.innerHTML = el;

        if (!days.includes(el)) {
            const cur_month_week = Math.ceil((i + 1) / 7) - 1;
            div.classList.add(`miniC-${cur_month_week}`);
            div.setAttribute('dataclass', `miniC-${cur_month_week}`);
        }

        if (!days.includes(el) && el !== '') {
            const cur_month = date.getMonth() - 1;
            const cur_month_week = Math.ceil((i + 1) / 7) - 1;
            const cur_year = date.getFullYear();

            if (div.className.includes('previous-month')) {
                div.setAttribute('month', cur_month - 1);
            } else if (div.className.includes('next-month')) {
                div.setAttribute('month', cur_month + 1);
            } else {
                div.setAttribute('month', cur_month);
            }
            div.setAttribute('week', cur_month_week);
            div.setAttribute('year', cur_year);
        }

        div.addEventListener('click', (e) => {
            miniCalendarClick(e.target);
        });

        data_div.appendChild(div);
    })

    mini_main.appendChild(data_div);

    const arrows = document.createElement('div');
    arrows.classList.add('miniC_arrows');
    const left_arr = document.createElement('i');
    left_arr.classList.add('miniC_leftArr');
    const right_arr = document.createElement('i');
    right_arr.classList.add('miniC_rightArr');

    right_arr.addEventListener('click', () => {
        date.setMonth(date.getMonth());
        setMiniCalendar(date);
    });

    left_arr.addEventListener('click', () => {
        date.setMonth(date.getMonth() - 2);
        setMiniCalendar(date);
    });

    arrows.appendChild(left_arr);
    arrows.appendChild(right_arr);

    mini_main.appendChild(arrows);

    mini_calendar.append(mini_main);
}

function miniCalendarClick(target) {
    const week = target.getAttribute('week') || '';
    let month = target.getAttribute('month') || '';
    const cur_year = target.getAttribute('year') || '';

    const cur_class = target.getAttribute('dataclass');

    const all_numbers = document.querySelectorAll(`.${cur_class}`);
    const item_number = document.querySelectorAll('.item_number');

    item_number.forEach((el, i) => {
        const number = all_numbers[i].innerHTML;
        month = all_numbers[i].getAttribute('month');
        const cur_date = new Date(+cur_year, +month, +number);

        el.innerHTML = number;
        el.setAttribute('date', JSON.stringify(cur_date));

        if (i === 0) firstDate = cur_date;
        if (i === 6) lastDate = cur_date;
    });
}

function generateMonth(date, day) {
    date.setDate(date.getDate() - (day - 1));
    const curDay_num = date.getDay();
    const firstDateDay = firstDate.getDate().toString();
    let month_array = [];
    let prev_array = [];

    const monthDays = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();

    const prev_month = new Date(date.getFullYear(), date.getMonth(), 0);
    const next_month = new Date(date.getFullYear(), date.getMonth() + 2, 1);

    days.forEach(name => {
        month_array.push(name);
    });

    for (let i=0; i<curDay_num; i++) {
        prev_array.push(`${prev_month.getDate()}-prev`);
        prev_month.setDate(prev_month.getDate() - 1);
    }

    prev_array = prev_array.reverse();

    for (let i=0; i<curDay_num; i++) {
        month_array.push(prev_array[i]);
    }

    for (let i=0; i<monthDays; i++) {
        const day = date.getDate();

        month_array.push(day);

        date.setDate(date.getDate() + 1);
    }

    const dop_length = 7 - (month_array.length % 7)

    for (let i=0; i<dop_length; i++) {
        month_array.push(`${next_month.getDate()}-next`);
        next_month.setDate(next_month.getDate() + 1);
    }

    return month_array;
}

function drawModalWindow(target) { // Запуск модалки после клика на меню
    overlay.classList.add('left_margin');
    modal_win.classList.add('left_margin');
    target.classList.remove('grey');
    target.classList.add('hard_own');
    const day = target.getAttribute('day');
    const time = target.getAttribute('time') || '';
    const obj = getDate(day);
    setModalWindow(obj.name, obj.num, new Date(JSON.parse(obj.date)), time, target);
}

function setClickers(elemnts, func) {
    elemnts.forEach(el => {
        el.addEventListener('click', func);
    })
}

function setModalWindow(name, number, date, time, target) {
    const modal_main_div = document.createElement('div');
    const btns_name = ['Отмена', 'Сохранить', 'Удалить'];
    const modal_name = document.createElement('div');
    const modal_number = document.createElement('div');
    const modal_time = document.createElement('div');
    const modal_month = document.createElement('div');
    const modal_input = document.createElement('input');
    modal_input.type = 'text';
    modal_input.maxLength = 15;
    modal_input.placeholder = 'Добавьте название';
    modal_input.value = target.innerHTML;
    const modal_inputPhone = document.createElement('input');
    modal_inputPhone.type = 'text';
    modal_inputPhone.placeholder = '+7';
    const modal_textArea = document.createElement('textarea');
    modal_textArea.placeholder = 'Добавьте описание';

    searchSavedText(target, modal_textArea, modal_inputPhone);

    modal_textArea.addEventListener('change', (e) => {
        modal_textArea.setAttribute('inputdata', e.target.value);
        saveExeText(target, modal_inputPhone.value, e.target.value);
    })

    modal_inputPhone.addEventListener('change', (e) => {
        modal_inputPhone.setAttribute('inputdata', e.target.value);
        saveExeText(target, e.target.value, modal_textArea.value);
    })

    const month = monthes[date.getMonth()];
    const year = date.getFullYear();

    modal_main_div.classList.add('modal-wrapper');
    modal_name.className = 'modal-name grey';
    modal_number.className = 'modal-number grey';
    modal_time.className = 'modal-time grey';
    modal_month.className = 'modal-month grey';
    modal_input.classList.add('modal-head_input');
    modal_inputPhone.className = 'modal-phone_inp grey';
    modal_textArea.className = 'modal-textArea grey';

    modal_name.innerHTML = name;
    modal_number.innerHTML = number;
    modal_time.innerHTML = time;
    modal_month.innerHTML = `${month} ${year}`;

    const head_div = document.createElement('div');
    const name_div = document.createElement('div');
    const color_div = document.createElement('div');
    const btns_div = document.createElement('div');

    head_div.classList.add('modal-head_div'); 
    name_div.classList.add('modal-name_div');
    color_div.classList.add('modal-color_div');
    btns_div.classList.add('modal-btns_div');
    
    head_div.appendChild(modal_name);
    head_div.appendChild(modal_number);
    head_div.appendChild(modal_month);

    name_div.appendChild(modal_input);
    name_div.appendChild(modal_time);

    color_classes.forEach(name => {
        const div = document.createElement('div');
        div.className = `${name} modal-squere`;
        color_div.appendChild(div);

        div.addEventListener('click', () => {
            setModalColor(target, name);
        })
    });

    btns_name.forEach((name, i) => {
        const btn = document.createElement('button');
        btn.innerHTML = name;
        btn.className = 'grey modal_btn';

        btn.addEventListener('click', () => {
            setModalButton(i, target, modal_input, modal_inputPhone, modal_textArea, number, date);
        })

        btns_div.appendChild(btn);
    })

    modal_main_div.appendChild(head_div);
    modal_main_div.appendChild(name_div);
    modal_main_div.appendChild(modal_inputPhone);
    modal_main_div.appendChild(color_div);
    modal_main_div.appendChild(modal_textArea);
    modal_main_div.appendChild(btns_div);

    modal_win.innerHTML = '';
    modal_win.append(modal_main_div);
}

function searchSavedText(target, area_inp, phone_inp) {
    const name = target.getAttribute('dataclass');

    if (exe_text_obj[page]) {
        exe_text_obj[page].forEach(el => {
            if (el.className === name ) {
                area_inp.value = el.area;
                phone_inp.value = el.phone;
            }
        })
    }
}

function saveExeText(target, phoneText, areaText) {
    let isNameInObj = false;
    let id = null;
    const name = target.getAttribute('dataclass');

    if (exe_text_obj[page]) {
        exe_text_obj[page].forEach((el, i) => {
            if (el.className === name ) {
                isNameInObj = true;
                id = i;
            }
        })
        if (isNameInObj) {
            exe_text_obj[page][id].phone = phoneText
            exe_text_obj[page][id].area = areaText;
        } else {
            exe_text_obj[page] = [ ...exe_text_obj[page], { phone: phoneText, area: areaText, className: name }];
        }

    } else {
        exe_text_obj[page] = [];
    }
}

function setModalColor(target, colorName) {
    deleteColor(target);
    target.classList.add(colorName);
    target.setAttribute('colorData', colorName);
}

function setModalButton(number, target, input_name, phone, text_area, date_number, date) { // Запоминаем отмеченные кнопки
    if (number === 0) {
        if (target.innerHTML === '') deleteColor(target);
        modal_win.classList.remove('left_margin');
        overlay.classList.remove('left_margin');
        target.classList.remove('hard_own');
        target.classList.add('grey');
        deleteObject(target, 'null');
    } else if (number === 1) {
        modal_win.classList.remove('left_margin');
        overlay.classList.remove('left_margin');
        target.classList.add('grey');
        target.classList.remove('hard_own');
        target.innerHTML = input_name.value;
        saveCheckedPins(target, phone, text_area);
        sendSavedData(target, input_name.value, phone.value, text_area.value, date_number, date.getMonth(), date.getFullYear());
    } else {
        deleteColor(target);
        modal_win.classList.remove('left_margin');
        overlay.classList.remove('left_margin');
        target.classList.add('grey');
        target.classList.remove('hard_own');
        target.innerHTML = '';
        deleteObject(target, '');
    }
}

function sendSavedData(target, name, phone, text_area, date_number, month, year) { // Отправлять дфнные в бд
    const color = target.getAttribute('colordata') || '';
    let toSend = {
       title: name,
       description: text_area,
       phone: phone,
       color: color,
       day: date_number,
       month: month,
       year: year
    }
    toSend = JSON.stringify(toSend);
    console.log(toSend);
}

function deleteObject(target, indx) { // Удаляет объект менюшки
    const className = target.getAttribute('dataclass');

    if (exe_text_obj[page]) {
        exe_text_obj[page].forEach((el, i) => {
            if (className === el.className) {
                exe_text_obj[page].splice(i, 1);
            }
        });
    }

    if (indx === 'null') return;

    page_obj[page].forEach((el, i) => {
        if (className === el.className) {
            page_obj[page].splice(i, 1);
        }
    });
}

function changePage() { // Смена страницы
    const low_bracets = document.querySelectorAll('.low_menu-state-item');
    const high_bracets = document.querySelectorAll('.high_menu-state-item');
    deleteAllColorClasses(low_bracets);
    deleteAllColorClasses(high_bracets);
    if (!page_obj[page]) return;
    page_obj[page].forEach(el => {
        const element = document.querySelector(`.${el.className}`);
        element.innerHTML = el.text;
        element.classList.add(el.color);
        element.setAttribute('phone', el.phone);
        element.setAttribute('textArea', el.text_area);
    })
}

function deleteAllColorClasses(elements) {
    elements.forEach(el => {
        deleteColor(el);
        el.innerHTML = '';
    })
}

function saveCheckedPins(target, phone, text_area) { // Сохраняет объект выбранной менюшки
    const obj = {
        color: target.getAttribute('colordata'),
        className: target.getAttribute('dataclass'),
        text: target.innerHTML,
        phone: phone.getAttribute('inputdata') || '',
        text_area: text_area.getAttribute('inputdata') || '',
    }

    if (page_obj[page]) {
        page_obj[page].push(obj);
    } else {
        page_obj[page] = [obj]
    }
}

function deleteColor(target) { // Удаляем цвет у менюшки
    color_classes.forEach(name => {
        target.classList.remove(name);
    })
}

function getDate(number) {
    const item_name = document.querySelectorAll('.item_name');
    const item_number = document.querySelectorAll('.item_number');
    return {
        name: item_name[+number].innerHTML,
        num: item_number[+number].innerHTML,
        date: item_number[+number].getAttribute('date'),
    }
}

arrowRight.onclick = () => {arrowR()}
arrowLeft.onclick = () => {arrowL()}

function arrowR() { // Следующая неделя
    const number_items = document.querySelectorAll('.item_number');
    number_items.forEach((el, i) => {
        lastDate.setDate(lastDate.getDate() +  1);
        const number = lastDate.getDate();
        el.innerHTML = number;
        el.setAttribute('date', JSON.stringify(lastDate));
        if (i === 0) {
            firstDate.setDate(lastDate.getDate());
        }
    })
    page++;
    changePage();
}

function setTimeArray() {
    const GORIZONTAL_BLOCKS = 48;
    let hours = 0;
    let minutes = 0;
    for (let i=0; i<GORIZONTAL_BLOCKS; i++) {
        const time = `${hours === 0 ? '00' : hours}:${minutes === 0 ? '00' : minutes}`;
        time_array.push(time);
        minutes += 30;
        if (minutes === 60) {
            minutes = 0;
            hours += 1;
            if (hours === 24) hours = 0;
        }
    }
}

function arrowL() { // Предыдущая неделя
    let number_items = document.querySelectorAll('.item_number');
    number_items = Array.from(number_items).reverse();
    number_items.forEach((el, i) => {
        firstDate.setDate(firstDate.getDate() -  1);
        const number = firstDate.getDate();
        el.innerHTML = number;
        el.setAttribute('date', JSON.stringify(firstDate));
        if (i === 0) {
            lastDate.setDate(firstDate.getDate());
        }
    })
    page--;
    changePage();
}

function createHighterState() { // Создание верхних шкал
    const HIGHTER_STATE_POSITIONS = 28;
    highterMenu_state.innerHTML = '';
    let data_number = 0;
    for (let i=0; i<HIGHTER_STATE_POSITIONS; i++) {
        const div = document.createElement('div');
        div.classList.add('grey');
        div.classList.add('high_menu-state-item');
        div.setAttribute('dataClass', `high-${i}`);
        div.classList.add(`high-${i}`);
        div.setAttribute('day', data_number);

        highterMenu_state.append(div);

        data_number++;
        if (data_number > 6) data_number = 0;
    }
}

function createLowerState() { // Создание всех временных шкал
    const HIGHTER_STATE_POSITIONS = 336;
    lowerMenu_state.innerHTML = '';
    let default_time = '';
    let data_number = 0;
    for (let i=0; i<HIGHTER_STATE_POSITIONS; i++) {
        if (i === 0) {
            const time_div = document.createElement('div');
            time_div.innerHTML = time_array[0];
            time_div.classList.add('time-item');
            lowerMenu_state.appendChild(time_div);
            default_time = time_array[0];
        }

        const div = document.createElement('div');
        div.classList.add('grey');
        div.classList.add('low_menu-state-item');
        div.classList.add(`low-${i}`);
        div.setAttribute('dataClass', `low-${i}`);
        div.setAttribute('day', data_number);
        div.setAttribute('time', default_time)
        lowerMenu_state.appendChild(div);

        if ((i + 1) % 7 === 0 && (i + 1) !== 336) {
            const time_div = document.createElement('div');
            time_div.innerHTML = time_array[(i + 1) / 7];
            default_time = time_array[(i + 1) / 7];
            time_div.classList.add('time-item');
            lowerMenu_state.appendChild(time_div);
        }
        data_number++;
        if (data_number > 6) data_number = 0;
    }
}

function createHighterMenu() { // Создание высшего меню
    const day_number = date.getDay();
    highterMenu_name.innerHTML = '';
    for (let i=0; i<days.length; i++) {
        const newDate = new Date();
        const pref = day_number - i;
        newDate.setDate(newDate.getDate() - pref);
        const number = newDate.getDate();

        if (i === 0) firstDate = newDate;
        if (i === 6) lastDate = newDate;

        const div = document.createElement('div');
        div.classList.add('day_name-item');

        const number_div = document.createElement('div');
        const day_div = document.createElement('div');

        number_div.classList.add('grey');
        number_div.classList.add('item_number');
        day_div.classList.add('grey');
        day_div.classList.add('item_name');

        day_div.innerHTML = days[i];
        number_div.innerHTML = number;
        number_div.setAttribute('date', JSON.stringify(newDate));

        div.appendChild(day_div);
        div.appendChild(number_div);

        highterMenu_name.append(div);
    }
}

function setHeader() { // Добавляет данные в хедер
    const header_number = document.querySelector('.menu_number');
    const header_day = document.querySelector('.menu_day');
    const header_full = document.querySelector('.menu_full');

    header_number.innerHTML = cur_date;
    header_full.innerHTML = `${cur_month} ${cur_year}`;
    header_day.innerHTML = cur_day;

}

defaultStart();
