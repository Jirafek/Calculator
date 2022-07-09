import React, { useState } from 'react';
import { days, monthes, highterItems } from '../utils/days_helper';
import RandomKey from './RandomKey';

export default function ModalCalendar(props) {
    const [state, setState] = useState({
        month: monthes[props.date.getMonth()],
        year: props.date.getFullYear(),
        day: props.date.getDate(),
        cur_date: new Date().getDate()
    });

    function createCalendarDates() {
        const month_arr = generateMonth(props.date, state.day);

        const newArray = month_arr.map((el, i) => {
            let className = 'miniC-item';

            if (days.includes(el)) className += ' miniC-day_name';
            if (state.cur_date === el) className += ' current_date';

            el = String(el);
    
            if (el.indexOf('prev') !== -1) {
                el = el.split('-')[0];
                className += ' previous-month';
            } else if (el.indexOf('next') !== -1) {
                el = el.split('-')[0];
                className += ' next-month';
            }


            if (!days.includes(el)) {
                const cur_month_week = Math.ceil((i + 1) / 7) - 1;
                className += ` miniC-${cur_month_week}`;
            }

            // if (!days.includes(el)) {
            //     const cur_month_week = Math.ceil((i + 1) / 7) - 1;
            //     div.dataclass = `miniC-${cur_month_week}`;
            // }
    
            // if (!days.includes(el) && el !== '') {
            //     const cur_month = props.date.getMonth() - 1;
            //     const cur_month_week = Math.ceil((i + 1) / 7) - 1;
            //     const cur_year = props.date.getFullYear();
    
            //     if (div.className.includes('previous-month')) {
            //         div.month = cur_month - 1;
            //     } else if (div.className.includes('next-month')) {
            //         div.month = cur_month + 1;
            //     } else {
            //         div.month = cur_month;
            //     }
            //     div.week = cur_month_week;
            //     div.year = cur_year;
            // }
            return <div key={RandomKey()} className={className}>{el}</div>;
        })

        return newArray;
    }

    function generateMonth(date, day) {
        date.setDate(date.getDate() - (day - 1));
        const curDay_num = date.getDay();
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

    function closeCalendar() {
        props.updateState(<ModalCalendar date={props.date}/>, 'calendar', '');
    }

    return (
        <div className="miniC-main">
            <div className="miniC_name">{`${state.month} - ${state.year}`}</div>
            <span onClick={closeCalendar} className="close"></span>
            <div className="miniC_data">{createCalendarDates()}</div>
        </div>
    )
}
