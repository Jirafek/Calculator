const URL_BACKEND = 'calendar';

const nowDate = new Date();
const allMonthName = ['январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь'];
const allWeekName = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];
const nameMonth = allMonthName[nowDate.getMonth()];

function Monday() {
    const date = new Date();
    const monday = new Date();
    if(date.getDay()){monday.setDate(date.getDate() + 1 + 7 - date.getDay())} else {monday.setDate(date.getDate() + 1)}
    return monday.getDate();
}

function getHour(num) {
    if (num >= 10) {
        if (Number.isInteger(num)) {
            return`${num}:00`;
        }
        return `${Math.floor(num)}:30`;
    }
    if (Number.isInteger(num)) {
        return`0${num}:00`;
    }
    return `0${Math.floor(num)}:30`;
}

function renderHtmlEvent(dataHour, dataDay, dataWeek) {
    return `<div class="calendar__hour"
            data-hour="${getHour(dataHour)}"
            data-day="${dataDay}"
            data-week="${dataWeek}"
            style="--hour: '${getHour(dataHour)}';"
            ></div>`
}

function renderHtmlHours(calendar, calendarDay, calendarDaysWeek) {
    let counterHour = -0.5;
    let counterDay = 0;

    if (document.querySelectorAll('.calendar__hour')) {
        document.querySelectorAll('.calendar__hour').forEach(elem => elem.remove());
    }

    for (let i = 0; i < 7*48; i++) {
        
        if (i%7 == 0) {
            counterDay = 0;
            counterHour += 0.5;
        }

        if (i%7 == counterDay + 1) {
            counterDay++;
        }

        calendar.insertAdjacentHTML('beforeend', renderHtmlEvent(counterHour, calendarDay[counterDay].textContent, calendarDaysWeek[counterDay].textContent.trim()));
    }

    clickerHour(document.querySelectorAll('.calendar__hour'), document.querySelector('.event-modal'));
}

function clickerHour(calendarHour, eventModal) {
    calendarHour.forEach((hour) => {
        hour.addEventListener('click', e => {
            eventModal.classList.remove('_invisibility');

            if (hour.getAttribute('data-id')) {
                let data = localStorage.eventsList;
                data = JSON.parse(data);
                data = data.filter(elem => hour.getAttribute('data-id') === elem.event_id);
                data = data[0];

                const eventAdd = document.querySelector('.event-add');
                const eventAddTitle = document.querySelector('.event-add__title > input');
                const eventAddPhone = document.querySelector('.event-add__phone > input');
                const eventAddDescrption = document.querySelector('.event-add__descrption > textarea');

                eventAdd.setAttribute('data-id', hour.getAttribute('data-id'))
                eventAddTitle.value = data.title;
                eventAddPhone.value = data.phone;
                eventAddDescrption.value = data.description;
            }

            const eventAddWeek = document.querySelector('.event-add__week');
            const eventAddday = document.querySelector('.event-add__day');
            const eventAddMonthYear = document.querySelector('.event-add__month-year');
            const eventAddTime = document.querySelector('.event-add__time');

            eventAddWeek.textContent = hour.getAttribute('data-week');
            eventAddday.textContent = hour.getAttribute('data-day');
            eventAddTime.textContent = hour.getAttribute('data-hour');
            return;
        });
    })
}

function getEvents() {
    const eventsList = [];

    fetch(`http://${URL_BACKEND}/http/event.php`)
    .then(res => res.json())
    .then(res => {
        if (Array.isArray(res)) {
            res.forEach(event => {
                document.querySelectorAll('.calendar__hour').forEach(day => {
                    if (day.getAttribute('data-hour') == event.time && day.getAttribute('data-day') == event.day) {
                        
                        day.textContent = event.title.slice(0, 4) + `...`;
                        day.style = `background: #498263`;
                        day.setAttribute('data-id', event.event_id)
                        eventsList.push(event);
                    }
                })
            });
        }
        
        if (localStorage.eventsList) {
            localStorage.removeItem('eventsList');
        }
        localStorage.setItem('eventsList', JSON.stringify(eventsList))
    })
}

// header

(function() {
    const headerDay = document.querySelector('.header__day');
    headerDay.textContent = nowDate.getDate();
    const headerMonthYear = document.querySelector('.header__month-year');
    headerMonthYear.textContent = `${allMonthName[nowDate.getMonth()]} ${nowDate.getFullYear()}`;
    const headerWeek = document.querySelector('.header__week');
    headerWeek.textContent = allWeekName[nowDate.getDay()];
})();

// calendar 

(function() {
    // calendar__day
    const calendar = document.querySelector('.calendar');

    if (calendar) {

    }

    let counterMonth = nowDate.getMonth();
    let counterYear = nowDate.getFullYear();

    const calendarTitle = document.querySelector('.calendar__title');
    calendarTitle.textContent = `${allMonthName[counterMonth]} ${nowDate.getFullYear()}`;

    let dayNumber = Monday();
    let calendarDaysWeek = document.querySelectorAll('.calendar__days_week');
    let calendarDay = document.querySelectorAll('.calendar__day');

    let eventModal = document.querySelector('.event-modal');
    const eventAddButtonCancel = document.querySelector('.event-add__button-cancel');
    const eventAddButtonSave = document.querySelector('.event-add__button-save');
    const eventAddButtonDelete = document.querySelector('.event-add__button-delete');
    
    calendarDay.forEach((day) => {
        day.textContent = dayNumber++
        if (counterMonth == 0 || counterMonth == 2 || counterMonth == 4 || counterMonth == 6 || counterMonth == 7 || counterMonth == 9 || counterMonth == 11) {
            if (dayNumber > 31) {
                dayNumber = 1;
            }
        } else if (counterMonth == 1) {
            if (counterYear%4 == 0) {
                if (dayNumber > 29) {
                    dayNumber = 1;
                }
            } else {
                if (dayNumber > 28) {
                    dayNumber = 1;
                }
            }
        } else {
            if (dayNumber > 30) {
                dayNumber = 1;
            }
        }
    });

    dayNumber = Monday();

    renderHtmlHours(calendar, calendarDay, calendarDaysWeek);

    let calendarHour = document.querySelectorAll('.calendar__hour');
    
    const mainLeftArrow = document.querySelector('.main__left-arrow');
    const mainRightArrow = document.querySelector('.main__right-arrow');
    let firstRightClick = true;

    // transition calendar

    mainLeftArrow.addEventListener('click', e => {
        calendarDaysReversed = [];
        
        if (!firstRightClick) {
            calendarDay.forEach(() => {
                let counter = --dayNumber;
                if (counter <= 1) {
                    counterMonth--;
                    if (counterMonth < 0) {
                        counterMonth = 11;
                        counterYear -= 1;
                    }
                    if (counterMonth == 0 || counterMonth == 2 || counterMonth == 4 || counterMonth == 6 || counterMonth == 7 || counterMonth == 9 || counterMonth == 11) {
                        dayNumber = 31;
                    } else if (counterMonth == 1) {
                        if (counterYear%4 === 0) {
                            dayNumber = 29;
                        } else {
                            dayNumber = 28;
                        }
                    } else {
                        dayNumber = 30;
                    }
                    dayNumber++;
                }
    
                calendarDaysReversed.push(counter);
                calendarTitle.textContent = `${allMonthName[counterMonth]} ${counterYear}`;
            });
            firstRightClick = true;
        }

        calendarDay.forEach(() => {
            let counter = --dayNumber;
            if (counter <= 1) {
                counterMonth--;
                if (counterMonth < 0) {
                    counterMonth = 11;
                    counterYear -= 1;
                }
                if (counterMonth == 0 || counterMonth == 2 || counterMonth == 4 || counterMonth == 6 || counterMonth == 7 || counterMonth == 9 || counterMonth == 11) {
                    dayNumber = 31;
                } else if (counterMonth == 1) {
                    if (counterYear%4 === 0) {
                        dayNumber = 29;
                    } else {
                        dayNumber = 28;
                    }
                } else {
                    dayNumber = 30;
                }
                dayNumber++;
                count = 1;
            }

            calendarDaysReversed.push(counter);
            calendarTitle.textContent = `${allMonthName[counterMonth]} ${counterYear}`;
        });

        calendarDaysReversed.reverse();

        calendarDaysReversed.forEach((text, i) => {
            if (calendarDay[i]) {
                calendarDay[i].textContent = text;
            }
        });

        eventModal = document.querySelector('.event-modal');
        calendarHour = document.querySelectorAll('.calendar__hour');

        renderHtmlHours(calendar, calendarDay, calendarDaysWeek);
        getEvents();
    })

    mainRightArrow.addEventListener('click', e => {

        if (firstRightClick) {
            calendarDay.forEach((day) => {
                let counter = dayNumber++;
                if (counterMonth == 0 || counterMonth == 2 || counterMonth == 4 || counterMonth == 6 || counterMonth == 7 || counterMonth == 9 || counterMonth == 11) {
                    if (counter >= 31) {
                        counterMonth++;
                        dayNumber = 1;
                    }
                } else if (counterMonth == 1) {
                    if (counterYear%4 == 0) {
                        if (counter >= 29) {
                            counterMonth++;
                            dayNumber = 1;
                        }
                    } else {
                        if (counter >= 28) {
                            counterMonth++;
                            dayNumber = 1;
                        }
                    }
                } else {
                    if (counter >= 30) {
                        counterMonth++;
                        dayNumber = 1;
                    }
                }
                if (counterMonth > 11) {
                    counterMonth = 0
                    counterYear += 1;
                }
                calendarTitle.textContent = `${allMonthName[counterMonth]} ${counterYear}`;
                day.textContent = counter;
            });
            firstRightClick = false;
        }

        calendarDay.forEach((day) => {
            let counter = dayNumber++;
            if (counterMonth == 0 || counterMonth == 2 || counterMonth == 4 || counterMonth == 6 || counterMonth == 7 || counterMonth == 9 || counterMonth == 11) {
                if (counter >= 31) {
                    counterMonth++;
                    dayNumber = 1;
                }
            } else if (counterMonth == 1) {
                if (counterYear%4 == 0) {
                    if (counter >= 29) {
                        counterMonth++;
                        dayNumber = 1;
                    }
                } else {
                    if (counter >= 28) {
                        counterMonth++;
                        dayNumber = 1;
                    }
                }
            } else {
                if (counter >= 30) {
                    counterMonth++;
                    dayNumber = 1;
                }
            }
            if (counterMonth > 11) {
                counterMonth = 0
                counterYear += 1;
            }
            calendarTitle.textContent = `${allMonthName[counterMonth]} ${counterYear}`;
            day.textContent = counter;
        });

        renderHtmlHours(calendar, calendarDay, calendarDaysWeek);
        getEvents();
    });

    // modal event

    eventAddButtonCancel.addEventListener('click', e => {
        e.preventDefault();
        eventModal.classList.add('_invisibility');
    })

    eventAddButtonSave.addEventListener('click', e => {
        e.preventDefault();
        let eventAddMonthYear = document.querySelector('.event-add__month-year').textContent;
        let eventAddYear = eventAddMonthYear.trim().slice(-4);
        let eventAddMonth = eventAddMonthYear.trim().slice(0, -5).toLocaleLowerCase();
        eventAddMonth = allMonthName.indexOf(eventAddMonth);
        const eventAddDay = document.querySelector('.event-add__day').textContent;
        const eventAddTime = document.querySelector('.event-add__time').textContent;
        const eventAddTitle = document.querySelector('.event-add__title > input').value;
        const eventAddPhone = document.querySelector('.event-add__phone > input').value;
        const eventAddDescrption = document.querySelector('.event-add__descrption > textarea').value;

        const data = {
            title: eventAddTitle,
            description: eventAddDescrption,
            phone: eventAddPhone,
            color: '#498263',
            day: eventAddDay,
            mouth: eventAddMonth,
            year: eventAddYear,
            time: eventAddTime
        };

        fetch(`http://${URL_BACKEND}/http/event.php`, {
            method: 'POST',
            body: JSON.stringify(data)
        })

        getEvents();
    });

    eventAddButtonDelete.addEventListener('click', e => {
        e.preventDefault();
        let eventAdd = document.querySelector('.event-add');
        eventAdd = eventAdd.getAttribute('data-id');
        console.log(eventAdd);

        fetch(`http://${URL_BACKEND}/http/event.php`, {
            method: 'DELETE',
            body: JSON.stringify(eventAdd)
        })
        

        eventModal.classList.add('_invisibility');
    })

    getEvents();
})();