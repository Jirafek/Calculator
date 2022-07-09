import React from 'react';
import RandomKey from './RandomKey';
import ModalWindow from './ModalWindow';

export default function LowerMenu(params) {

    function setTimeArray() {
        const GORIZONTAL_BLOCKS = 48;
        let hours = 0;
        let minutes = 0;
        const time_array = [];
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
        return time_array;
    }

    function createLowerState() {
        const HIGHTER_STATE_POSITIONS = 336;
        const array = [];
        let default_time = '';
        let data_number = 0;
        const time_array = setTimeArray();

        for (let i=0; i<HIGHTER_STATE_POSITIONS; i++) {
            if (i === 0) {
                const time_div = <div key={RandomKey()} className="time-item">{time_array[0]}</div>;
                array.push(time_div);
                default_time = time_array[0];
            }

            const div = <div key={RandomKey()} dataname={`low-${i}`} day={data_number} time={default_time} className={`grey low_menu-state-item low-${i}`}></div>
            array.push(div);

            if ((i + 1) % 7 === 0 && (i + 1) !== 336) {
                default_time = time_array[(i + 1) / 7];
                const time_div = <div key={RandomKey()} className="time-item">{default_time}</div>;
                array.push(time_div);
            }
            data_number++;
            if (data_number > 6) data_number = 0;
        }

        return array;
    }

    function lowerMenuClick(e) {
        const target = e.target;
        if (target.className.split('').indexOf('_') === -1) return;
        target.classList.remove('grey');
        target.classList.add('hard_own');
        const day = +target.getAttribute('day');
        const time = target.getAttribute('time');

        params.updateState(<ModalWindow day={day} time={time} updateSatate={params.updateState}/>, 'window', 'left_margin');
    }

    return (
        <div className="low_menu">
            <div className="time-state"></div>
            <div onClick={lowerMenuClick}  className="low_menu-state">{createLowerState()}</div>
            <div className="time-block"></div>
        </div>
    )
}
