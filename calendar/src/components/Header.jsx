import React from 'react';
import { days, monthes, highterItems, header_link } from '../utils/days_helper';
import ModalCalendar from './ModalCalendar';
import { Link } from 'react-router-dom';

export default function Header(props) {
    function miniCalendar() {
        const date = highterItems[0].date;
        props.updateState(<ModalCalendar updateState={props.updateState} date={date}/>, 'calendar', 'top_margin');
    }

    return (
        <header className="header">
            <div className="header-wrapper">
                <div className="first-menu">
                    <div className="month-name">{monthes[new Date().getMonth()]}</div>
                    <div className="month-block">
                        <div className="month-number">
                            {`${new Date().getDate()} ${days[new Date().getDay()]}`}
                        </div>
                        <hr className="header-line" />
                        <div className="month-year">{new Date().getFullYear()}</div>
                    </div>
                </div>
                <div className="header-menu">
                    <button onClick={() => props.updatePageState(null)} className="menu_today d-h grey">Сегодня</button>
                    <div className="menu_day d-h grey">{days[new Date().getDay()]}</div>
                    <div className="menu_number d-h grey">{new Date().getDate()}</div>
                    <div className="menu_full d-h grey">
                        {`${monthes[new Date().getMonth()]} ${new Date().getFullYear()}`}
                    </div>
                    <button onClick={miniCalendar} className="menu_searching-btn grey d-h"></button>
                </div>
                <Link to={header_link}>
                    <div className="header-profil">
                        <div className="header-profil_hex"></div>
                        <div className="inside_lines">
                            <span className="inside_lines-item"></span>
                        </div>
                    </div>
                </Link>
            </div>
        </header>
    )
}

