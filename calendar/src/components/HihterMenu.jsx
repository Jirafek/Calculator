import React, { useState } from 'react';
import { days, dates, avability, highterItems } from '../utils/days_helper';
import RandomKey from './RandomKey';
import { Link } from 'react-router-dom';
import ModalWindow from './ModalWindow';

export default function HihterMenu(params) {
    const [state, setState] = useState({
        modalClass: 'grey'
    });

    function createHighterState() {
        const HIGHTER_STATE_POSITIONS = avability.AVAILIBLE_LINES * 7;
        const array = new Array(HIGHTER_STATE_POSITIONS + 1).fill(0);
        const button = <Link key={RandomKey()} className="high_menu_state_btn" to="/cells"><button className="high_menu_state_btn">Добавить Дополнительные ячейки</button></Link>
        let data_number = -1;

        let newArray = array.map((el, i) => {
            data_number++;
            if (data_number > 6) data_number = 0;
            return <div key={RandomKey()} dataclass={`high-${i}`} day={data_number} className={`${state.modalClass} high_menu-state-item high-${i}`}></div>
        })

        newArray.pop();
        newArray.push(button)

        return newArray;
    }

    function highterStateItems() {
        const day_number = new Date().getDay();

        const newDays = days.map((el, i) => {
            const newDate = new Date();
            const pref = day_number - i;
            newDate.setDate(newDate.getDate() - pref);
            const number = newDate.getDate();

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
        target.classList.add('hard_own');
        const day = +target.getAttribute('day');

        params.updateState(<ModalWindow day={day} updateSatate={params.updateState}/>, 'window', 'left_margin');
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
