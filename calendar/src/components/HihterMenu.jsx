import React, { useState, useEffect} from 'react';
import { days, dates, avability, highterItems, getEventsHeader, eventSend } from '../utils/days_helper';
import RandomKey from './RandomKey';
import { Link } from 'react-router-dom';
import ModalWindow from './ModalWindow';

export default function HihterMenu(params) {
    const [dataState, setDataState] = useState(null);

    const [state, setState] = useState({
        modalClass: 'grey'
    });

    useEffect(() => {
        getEventsHeader(highterItems[0].date.getFullYear(), setDataState)
    }, [])

    const [colorState, setColorState] = useState({
        color: ''
    })

    function createHighterState() {
        const year = highterItems[0].date.getFullYear();
        const HIGHTER_STATE_POSITIONS = avability.AVAILIBLE_LINES * 7;
        const array = new Array(HIGHTER_STATE_POSITIONS + 1).fill(0);
        const button = <Link key={RandomKey()} className="high_menu_state_btn" to="/cells"><button className="high_menu_state_btn">Добавить Дополнительные ячейки</button></Link>
        let data_number = -1;

        let newArray = array.map((el, i) => {
            data_number++;
            if (data_number > 6) data_number = 0;

            const date = highterItems[data_number].date;
            const year = date.getFullYear();
            const day = highterItems[data_number].number;
            const month = date.getMonth();

            let div = null;

            if (dataState) {
                dataState.forEach((el, j) => {
                    if (
                        +el.day === day && +el.year === year && +el.month === month && el.time === ''
                    ) {
                        div = <div key={RandomKey()}
                         dataclass={`high-${i}`} 
                         day={data_number} 
                         id={el.event_id}
                         title={el.title}
                         description={el.description}
                         phone={el.phone}
                         className={`${el.color} ${state.modalClass} high_menu-state-item high-${i}`}
                        >
                            {el.title}
                        </div>
                    }
                })
                if (!div) div = <div key={RandomKey()} dataclass={`high-${i}`} day={data_number} className={`${state.modalClass} high_menu-state-item high-${i}`}></div>
            } else {
                div = <div key={RandomKey()} dataclass={`high-${i}`} day={data_number} className={`${state.modalClass} high_menu-state-item high-${i}`}></div>
            }
            return div
        })

        newArray.pop();
        newArray.push(button)

        return newArray;
    }

    function highterStateItems() {
        let day_number = new Date().getDay();

        const curDate = params.date;

        const newDays = days.map((el, i) => {
            let newDate, pref, number;

            if (!params.date) {
                console.log('noob')
                newDate = new Date()
                pref = day_number - i;
                newDate.setDate(newDate.getDate() - pref);
            } else {
                newDate = curDate
                newDate.setDate(newDate.getDate() + 1)
            }

            number = newDate.getDate();

            if (i === 0) dates.firstDate = newDate;
            if (i === 6) dates.lastDate = newDate;
            

            highterItems[i] = {
                name: days[i],
                number: number,
                date: newDate
            }

            return (
                <div key={RandomKey()} className="day_name-item">
                    <div className="grey item_name">{days[i]}</div>
                    <div className="grey item_number">{number}</div>
                </div>
            );
        });

        return newDays;
    }

    function highterMenuClick(e) {
        const target = e.target;
        if (target.className.split('').indexOf('-') === -1) return;
        target.classList.remove('grey');
        target.className = `hard_own ${colorState.color}`;
        const day = +target.getAttribute('day');

        const targetData = {
            description: target.getAttribute('description') || '',
            title: target.getAttribute('title') || '',
            phone: target.getAttribute('phone') || '',
            id: target.getAttribute('id') || '',
        }
        
        eventSend.day = highterItems[day].number;
        eventSend.time = '';
        eventSend.month = highterItems[day].date.getMonth();
        eventSend.year = highterItems[day].date.getFullYear();

        params.updateState(<ModalWindow day={day} targetData={targetData} updateSatate={params.updateState} updateColor={setColorState}/>, 'window', 'left_margin');
    }

    return (
        <main className="main">
            <div className="high_menu">
                <div className="high_menu-logo">
                    <img className="high_menu-logo-img" src="./img/Logo.png" alt="logo" height="167" width="167" />
                </div>
                <div className="high_menu-right">
                    <div className="day_name">{highterStateItems()}</div>
                    <div onClick={highterMenuClick} className="high_menu-state">{createHighterState()}</div>
                </div>
            </div>
        </main>
    )
}
